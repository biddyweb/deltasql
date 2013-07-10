unit createinsertsfromcsvunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls;

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
          if firstLine then
                begin
                    constructInsertStatement(str);
                    firstLine := false;
                end;
        end;

  finally
    CloseFile(F);
    CloseFile(G);
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
   ShowMessage(insertStatement);
end;

procedure TfrmCreateInserts.lblOutputLinkClick(Sender: TObject);
begin


end;

end.

