unit createinsertsfromcsvunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ComCtrls, Process;

const MAX_FIELDS = 1024;
      QUOTE      = 39; //ASCII char for '

type

  { TfrmCreateInserts }

  TfrmCreateInserts = class(TForm)
    btnSelectCSVFile: TButton;
    btnGenerate: TButton;
    btnSelectSQLFile: TButton;
    cbHeader: TCheckBox;
    dlgOpenSQL: TOpenDialog;
    edtTableDefinition: TEdit;
    edtSeparator: TEdit;
    edtFilename: TEdit;
    lblFilename: TLabel;
    lblFilename1: TLabel;
    lblSeparator: TLabel;
    lblOutput: TLabel;
    lblInfo: TLabel;
    lblOutputLink: TLabel;
    dlgOpenCSV: TOpenDialog;
    rbInfer: TRadioButton;
    rbTableDefinition: TRadioButton;
    statusbar: TStatusBar;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectSQLFileClick(Sender: TObject);
    procedure btnSelectCSVFileClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
    procedure rbTableDefinitionChange(Sender: TObject);
  private
    outputFile,
    tableName,
    insertStatement : AnsiString;
    isNumeric : Array[1..MAX_FIELDS] of Boolean;

    procedure generateInserts;
    procedure constructInsertStatement(header : AnsiString);
    function  fillInsertStatement(values : AnsiString) : AnsiString;

    procedure initFieldTypes;
    procedure inferFieldsFromData;
    procedure inferFieldsFromTableDefinition;
  end;

var
  frmCreateInserts: TfrmCreateInserts;

implementation

{$R *.lfm}

function ExtractParamLong(var S: AnsiString; Separator: string): AnsiString;
var
  i: Longint;
begin
  i := Pos(Separator, S);
  if i > 0 then
  begin
    Result := Copy(S, 1, i - 1);
    Delete(S, 1, i-1);
    Delete(S, 1, length(Separator));
  end
  else
  begin
    Result := S;
    S      := '';
  end;
end;

procedure TfrmCreateInserts.btnSelectSQLFileClick(Sender: TObject);
begin
  if dlgOpenSQL.Execute then
     begin
          edtTableDefinition.Text := dlgOpenSQL.FileName;
          edtTableDefinition.Enabled := true;
     end;
end;


procedure TfrmCreateInserts.btnSelectCSVFileClick(Sender: TObject);
begin
  if dlgOpenCSV.Execute then
     begin
          edtFileName.Text := dlgOpenCSV.FileName;
          edtFileName.Enabled := true;
     end;
end;

procedure TfrmCreateInserts.btnGenerateClick(Sender: TObject);
begin
     if Trim(edtFileName.Text)<>'' then
        begin
            if FileExists(edtFileName.Text) then
              begin
               generateInserts;
              end
            else
              ShowMessage('ERROR: could not locate the filename! ('+edtFileName.Text+')');
        end
     else ShowMessage('Please select an input filename first with "..."');
end;


procedure TfrmCreateInserts.generateInserts;
var F, G : TextFile;
    str  : Ansistring;
    firstLine : Boolean;
begin
  screen.cursor:=crHourglass;
  edtFileName.Enabled := false;
  edtSeparator.Enabled := false;
  btnGenerate.Enabled := false;
  btnSelectCSVFile.Enabled := false;
  rbInfer.Enabled := false;
  rbTableDefinition.Enabled := false;
  edtTableDefinition.Enabled := false;
  btnSelectSQLFile.Enabled := false;

  outputFile := ChangeFileExt(edtFileName.Text, '.sql');
  //ShowMessage(outputFile);
  initFieldTypes;
  if rbInfer.Checked then inferFieldsFromData else inferFieldsFromTableDefinition;


  firstLine := true;
  AssignFile(F, edtFileName.Text);
  AssignFile(G, outputFile);

  try
    statusbar.SimpleText:='Generating inserts...';
    Reset(F);
    Rewrite(G);

    while not EOF(F) do
        begin
          Readln(F, str);
          if firstLine then constructInsertStatement(str);

          if cbHeader.Checked then
              begin
                if not firstline then WriteLn(G, fillInsertStatement(str));
              end
          else
            WriteLn(G, fillInsertStatement(str));


          if firstline then firstline := false;
          Application.ProcessMessages;
        end;

    lblOutputLink.Caption := ExtractFileName(outputFile);
  finally
    CloseFile(F);
    CloseFile(G);

    screen.cursor:=crArrow;
    edtFileName.Enabled := True;
    edtSeparator.Enabled := True;
    btnGenerate.Enabled := True;
    btnSelectCSVFile.Enabled := True;
    rbInfer.Enabled := true;
    rbTableDefinition.Enabled := true;
    edtTableDefinition.Enabled := rbTableDefinition.Checked;
    btnSelectSQLFile.Enabled := rbTableDefinition.Checked;

    statusbar.SimpleText:='Ready.';
  end;


end;

procedure TfrmCreateInserts.constructInsertStatement(header : AnsiString);
var column : AnsiString;
begin
   tableName := ExtractFileName(changeFileExt(outputFile, ''));
   //ShowMessage('Tablename is '+tableName);

   if not cbHeader.Checked then
         begin
             insertStatement := 'INSERT INTO '+tableName+' VALUES(';
         end
   else
         begin
             insertStatement := 'INSERT INTO '+tableName+' (';
             // we need to retrieve first the column names
             column:=Trim(extractParamLong(header, edtSeparator.Text));
             while column<>'' do
                 begin
                   insertStatement := insertStatement + column + ',';
                   column:=Trim(extractParamLong(header, edtSeparator.Text));
                 end;
             Delete(insertStatement, length(insertStatement), 1);
             insertStatement := insertStatement+') VALUES(';
         end;
   //ShowMessage(insertStatement);
end;


function TfrmCreateInserts.fillInsertStatement(values : AnsiString) : AnsiString;
var column : AnsiString;
    i      : Longint;
begin
  Result := '';
  column:=Trim(extractParamLong(values, edtSeparator.Text));
  i:=1;
  while column<>'' do
      begin
        if isnumeric[i] then
           Result := Result + column + ','
        else
           Result := Result + Chr(QUOTE) + column + Chr(QUOTE) + ',';

        column:=Trim(extractParamLong(values, edtSeparator.Text));
        i:=i+1;
      end;
  Delete(Result, length(Result), 1);

  Result := insertStatement + Result + ');';
end;

procedure TfrmCreateInserts.lblOutputLinkClick(Sender: TObject);
var aProcess : TProcess;
begin
   AProcess := TProcess.Create(nil);
   try
               AProcess.CommandLine := '"notepad" "'+outputFile+'"';
               AProcess.Options := AProcess.Options - [poWaitOnExit];
               AProcess.Execute;
   finally
     AProcess.Free;
   end;

end;


procedure TfrmCreateInserts.rbTableDefinitionChange(Sender: TObject);
begin
  btnSelectSQLFile.Enabled := rbTableDefinition.Checked;
  edtTableDefinition.Enabled := rbTableDefinition.Checked;
end;

procedure TfrmCreateInserts.initFieldTypes;
var i : Longint;
begin
  for i:=1 to MAX_FIELDS do isnumeric[i] := true;
end;

procedure TfrmCreateInserts.inferFieldsFromData;
begin
end;

procedure TfrmCreateInserts.inferFieldsFromTableDefinition;
begin
end;

end.

