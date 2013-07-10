unit createinsertsfromcsvunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  Process;

type
  TfrmCreateInserts = class(TForm)
    btnSelectFileName: TButton;
    btnGenerate: TButton;
    cbHeader: TCheckBox;
    edtSeparator: TEdit;
    edtFilename: TEdit;
    lblFilename: TLabel;
    lblSeparator: TLabel;
    lblOutput: TLabel;
    lblInfo: TLabel;
    lblOutputLink: TLabel;
    dlgOpen: TOpenDialog;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectFileNameClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
  private
    outputFile,
    tableName,
    insertStatement : AnsiString;
    procedure generateInserts;
    procedure constructInsertStatement(header : AnsiString);
    function  fillInsertStatement(values : AnsiString) : AnsiString;
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

procedure TfrmCreateInserts.btnSelectFileNameClick(Sender: TObject);
begin
  if dlgOpen.Execute then
     begin
          edtFileName.Text := dlgOpen.FileName;
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
  btnSelectFileName.Enabled := false;

  outputFile := ChangeFileExt(edtFileName.Text, '.sql');
  //ShowMessage(outputFile);

  firstLine := true;
  AssignFile(F, edtFileName.Text);
  AssignFile(G, outputFile);
  try
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
    btnSelectFileName.Enabled := True;
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
begin
  Result := '';
  column:=Trim(extractParamLong(values, edtSeparator.Text));
  while column<>'' do
      begin
        Result := Result + column + ',';
        column:=Trim(extractParamLong(values, edtSeparator.Text));
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

end.

