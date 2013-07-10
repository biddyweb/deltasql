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
    cbHeader: TCheckBox;
    dlgOpenSQL: TOpenDialog;
    edtTablename: TEdit;
    edtSeparator: TEdit;
    edtFilename: TEdit;
    lblInfo2: TLabel;
    lblInfo: TLabel;
    lblTablename: TLabel;
    lblFilename: TLabel;
    lblSeparator: TLabel;
    lblOutput: TLabel;
    lblOutputLink: TLabel;
    dlgOpenCSV: TOpenDialog;
    statusbar: TStatusBar;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectCSVFileClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
  private
    outputFile,
    insertStatement : AnsiString;
    isNumeric : Array[1..MAX_FIELDS] of Boolean;

    procedure generateInserts;
    procedure constructInsertStatement(header : AnsiString);
    function  fillInsertStatement(values : AnsiString) : AnsiString;

    procedure initFieldTypes;
    procedure inferFieldsFromData;
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

procedure TfrmCreateInserts.btnSelectCSVFileClick(Sender: TObject);
begin
  if dlgOpenCSV.Execute then
     begin
          edtFileName.Text := dlgOpenCSV.FileName;
          edtFileName.Enabled := true;
          edtTableName.Text := ExtractFileName(changeFileExt(ExtractFileName(dlgOpenCSV.FileName), ''));
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
  edtTableName.Enabled := false;

  outputFile := ChangeFileExt(edtFileName.Text, '.sql');
  //ShowMessage(outputFile);
  initFieldTypes;
  inferFieldsFromData;

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
    edtTableName.Enabled := true;

    statusbar.SimpleText:='Ready.';
  end;


end;

procedure TfrmCreateInserts.constructInsertStatement(header : AnsiString);
var column : AnsiString;
begin
   //ShowMessage('Tablename is '+tableName);

   if not cbHeader.Checked then
         begin
             insertStatement := 'INSERT INTO '+edtTableName.Text+' VALUES(';
         end
   else
         begin
             insertStatement := 'INSERT INTO '+edtTableName.Text+' (';
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
        if isnumeric[i] or (column='NULL') then
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


procedure TfrmCreateInserts.initFieldTypes;
var i : Longint;
begin
  for i:=1 to MAX_FIELDS do isnumeric[i] := true;
end;

procedure TfrmCreateInserts.inferFieldsFromData;
var F : TextFile;
    str : AnsiString;
    firstLine : Boolean;

    procedure scanFieldsForNumeric(str : AnsiString);
    var column : AnsiString;
        i      : Longint;
    begin

      column:=Trim(extractParamLong(str, edtSeparator.Text));
      i := 1;
      while column<>'' do
           begin
             if isnumeric[i] and (column<>'NULL') then
                begin
                  // test if this column is really numeric
                     try
                        StrToFloat(column);
                     except
                           on E : EConvertError do
                              isnumeric[i] := false;
                     end;
                end;

             // go to next column
             column:=Trim(extractParamLong(str, edtSeparator.Text));
             i := i+1;
           end;
    end;

begin
 statusbar.SimpleText:='Inferring field type based on input data...';

 firstLine := true;
 AssignFile(F, edtFileName.Text);

  try
    Reset(F);

    while not EOF(F) do
        begin
          Readln(F, str);

          if cbHeader.Checked then
              begin
                if not firstline then scanFieldsForNumeric(str);
              end
          else
              scanFieldsForNumeric(str);

          if firstLine then firstLine := false;
          Application.ProcessMessages;
        end;

  finally
    CloseFile(F);
  end;
end;


end.

