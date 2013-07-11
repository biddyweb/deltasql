unit fromcsvdiffcreatesqlunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ComCtrls;

type

  { TfromCSVtoSQL }

  TfromCSVtoSQL = class(TForm)
    btnGenerateSync: TButton;
    btnSelectCSVFileBefore: TButton;
    btnSelectCSVFileAfter: TButton;
    cbPrimaryKey: TComboBox;
    dlgOpenCSV: TOpenDialog;
    edtFilenameBefore: TEdit;
    edtFilenameAfter: TEdit;
    edtSeparator: TEdit;
    edtTablename: TEdit;
    lblPKInfo: TLabel;
    lblHeaderRequired: TLabel;
    lblFilenameBefore: TLabel;
    lblFilenameAfter: TLabel;
    lblInfo: TLabel;
    lblInfo2: TLabel;
    lblOutput: TLabel;
    lblOutputLink: TLabel;
    lblSeparator: TLabel;
    lblTablename: TLabel;
    lblPrimaryKey: TLabel;
    rbSeparatorEdit: TRadioButton;
    rbSeparatorTab: TRadioButton;
    statusbar: TStatusBar;
    procedure btnGenerateSyncClick(Sender: TObject);
    procedure btnSelectCSVFileAfterClick(Sender: TObject);
    procedure btnSelectCSVFileBeforeClick(Sender: TObject);
  private
    procedure fillCBPrimaryKey(filename : String);
    function  readHeader(filename : String) : AnsiString;
    function  getSeparator() : AnsiString;
  end;

var
  fromCSVtoSQL: TfromCSVtoSQL;

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

procedure TfromCSVtoSQL.btnGenerateSyncClick(Sender: TObject);
begin

end;

procedure TfromCSVtoSQL.btnSelectCSVFileBeforeClick(Sender: TObject);
begin
  if dlgOpenCSV.Execute then
     begin
        edtFileNameBefore.Text := dlgOpenCSV.FileName;
        fillCBPrimaryKey(edtFileNameAfter.Text);
     end;
end;

procedure TfromCSVtoSQL.btnSelectCSVFileAfterClick(Sender: TObject);
begin
  if dlgOpenCSV.Execute then
     begin
        edtFileNameAfter.Text := dlgOpenCSV.FileName;
        fillCBPrimaryKey(edtFileNameAfter.Text);
     end;

end;


function TfromCSVtoSQL.readHeader(filename : String) : AnsiString;
var F : TextFile;
begin
  Result := '';
  AssignFile(F, filename);
  try
    Reset(F);
    ReadLn(F, Result);
  finally
    CloseFile(F);
  end;
end;

procedure TfromCSVtoSQL.fillCBPrimaryKey(filename : String);
var header,
    column : AnsiString;
begin
   cbPrimaryKey.Clear;
   header := readHeader(filename);
   column := Trim(ExtractParamLong(header, getSeparator()));
   while column<>'' do
         begin
           cbPrimaryKey.AddItem(column, nil);
           column := Trim(ExtractParamLong(header, getSeparator()));
         end;
end;

function TfromCSVtoSQL.getSeparator(): AnsiString;
begin
  if rbSeparatorEdit.Checked then
      Result := edtSeparator.Text
  else
  if rbSeparatorTab.Checked then
      Result := Chr(9)
  else
    ShowMessage('Internal error: undefined radio box');
end;

end.



