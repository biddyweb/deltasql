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
    F : Textfile;

    procedure fillCBPrimaryKey(filename : String);
    function  readMyHeader(myfilename : String) : AnsiString;
    function  getSeparator() : AnsiString;
    function  checkForEqualHeader(myfilename : String) : Boolean;
    procedure enableControls(value : Boolean);
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
  if Trim(edtTableName.Text)='' then
         begin
           ShowMessage('ERROR: please fill the tablename first!');
           Exit;
         end;
  if Trim(cbPrimaryKey.Text)='' then
         begin
           ShowMessage('ERROR: please fill the primary key column first!');
           Exit;
         end;
  if not FileExists(edtFileNameBefore.Text) then
         begin
           ShowMessage('ERROR: the first .csv file does not exist on the file system!');
           Exit;
         end;
  if not FileExists(edtFileNameAfter.Text) then
         begin
           ShowMessage('ERROR: the second .csv file does not exist on the file system!');
           Exit;
         end;

  enableControls(false);
  // add here the logic that creates the sync script.
  enableControls(true);
end;

procedure TfromCSVtoSQL.enableControls(value : Boolean);
begin
  edtFileNameBefore.Enabled := value;
  edtFileNameAfter.Enabled := value;
  btnSelectCSVFileBefore.Enabled := value;
  btnSelectCSVFileAfter.Enabled := value;
  edtTableName.Enabled := value;
  rbSeparatorEdit.Enabled := value;
  rbSeparatorTab.Enabled := value;
  edtSeparator.Enabled := value;
  cbPrimaryKey.Enabled := value;
  btnGenerateSync.Enabled := value;
end;

procedure TfromCSVtoSQL.btnSelectCSVFileBeforeClick(Sender: TObject);
begin
  if dlgOpenCSV.Execute then
     begin
        edtFileNameBefore.Text := dlgOpenCSV.FileName;
        fillCBPrimaryKey(edtFileNameBefore.Text);
     end;
end;

procedure TfromCSVtoSQL.btnSelectCSVFileAfterClick(Sender: TObject);
begin
  if Trim(edtFileNameBefore.Text)='' then
     begin
        ShowMessage('ERROR: please fill first the other .csv file!');
        Exit;
     end;

  if dlgOpenCSV.Execute then
     begin
        edtFileNameAfter.Text := dlgOpenCSV.FileName;
        if Trim(edtFileNameAfter.Text) = Trim(edtFileNameBefore.Text) then
           begin
              ShowMessage('ERROR: you are using the same file!');
              edtFileNameAfter.Text := '';
              Exit;
           end;

        if not checkForEqualHeader(edtFileNameAfter.Text) then
             begin
                ShowMessage('ERROR: the two headers are different!');
                edtFileNameAfter.Text := '';
                Exit;
             end;
     end;

end;


function TfromCSVtoSQL.readMyHeader(myfilename : String) : AnsiString;
var str : AnsiString;
begin
  Result := '';
  if Trim(myFilename)='' then Exit;
  if not FileExists(myfilename) then
     begin
        ShowMessage('ERROR: filename '+myfilename+' does not exist!');
        Exit;
     end;

  str := '';
  AssignFile(F, myfilename);
  try
    Reset(F);
    ReadLn(F, Str);
  finally
    CloseFile(F);
  end;

  Result := Trim(Str);
end;

procedure TfromCSVtoSQL.fillCBPrimaryKey(filename : String);
var header,
    column : AnsiString;
begin
   cbPrimaryKey.Clear;
   header := readMyHeader(filename);
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

function TfromCSVtoSQL.checkForEqualHeader(myfilename : String) : Boolean;
var headerFrom, HeaderTo : AnsiString;
begin
  headerFrom:=readMyHeader(edtFileNameBefore.Text);
  headerTo:=readMyHeader(myFileName);
  Result:= (headerFrom=headerTo)
end;

end.



