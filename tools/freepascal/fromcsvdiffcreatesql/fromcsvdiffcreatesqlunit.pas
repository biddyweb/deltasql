unit fromcsvdiffcreatesqlunit;
{(c) by 2013 HB9TVM an the deltasql team. Source code is under GPL}
{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ComCtrls, csvtables, utils;

type

  { TfromCSVtoSQL }

  TfromCSVtoSQL = class(TForm)
    btnGenerateSync: TButton;
    btnSelectCSVFileBefore: TButton;
    btnSelectCSVFileAfter: TButton;
    cbPrimaryKey: TComboBox;
    cbInsert: TCheckBox;
    cbUpdate: TCheckBox;
    cbDelete: TCheckBox;
    dlgOpenCSV: TOpenDialog;
    edtFilenameBefore: TEdit;
    edtFilenameAfter: TEdit;
    edtSeparator: TEdit;
    edtTablename: TEdit;
    lblGenerateStatements: TLabel;
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
    tableBefore : TCSVTable;
    tableAfter  : TCSVTable;

    procedure fillCBPrimaryKey(filename : String);
    function  readMyHeader(myfilename : String) : AnsiString;
    function  getSeparator() : AnsiString;
    function  checkForEqualHeader(myfilename : String) : Boolean;
    procedure enableControls(value : Boolean);
    procedure createSyncScriptLogic;
  end;

var
  fromCSVtoSQL: TfromCSVtoSQL;

implementation

{$R *.lfm}

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
   if not checkForEqualHeader(edtFileNameAfter.Text) then
             begin
                ShowMessage('ERROR: the two headers are different!');
                edtFileNameAfter.Text := '';
                Exit;
             end;

  enableControls(false);
  createSyncScriptLogic;
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
  cbInsert.Checked := value;
  cbDelete.Checked := value;
  cbUpdate.Checked := value;
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

procedure TfromCSVtoSQL.createSyncScriptLogic;
var i : Longint;
begin
  try
     //filename, tablename, primarykey, separator
     tableBefore := TCSVTable.Create(edtFileNameBefore.Text, edtTableName.Text, cbPrimaryKey.Text, getSeparator() );
     tableAfter  := TCSVTable.Create(edtFileNameAfter.Text, edtTableName.Text, cbPrimaryKey.Text, getSeparator() );

     if tableBefore.totalfields_<>tableAfter.totalfields_ then
           begin
              ShowMessage('Internal error: field numbers differ');
              tableBefore.Free; tableAfter.Free;
              Exit;
           end;

     screen.Cursor := crHourGlass;
     statusBar.SimpleText:='Inferring field type for table before changes...';
     tableBefore.inferFieldsFromData;
     Application.ProcessMessages;
     statusBar.SimpleText:='Inferring field type for table after changes...';
     tableAfter.inferFieldsFromData;
     Application.ProcessMessages;


     // adjust isnumeric fields
     for i:=1 to tableBefore.totalfields_ do
       if tableBefore.isnumeric_[i]<>tableAfter.isnumeric_[i] then
             begin
                // we set both to false, being non numeric
                tableBefore.isnumeric_[i] := false;
                tableAfter.isnumeric_[i] := false;
             end;

     // now here we should create the indexes on the primary key
     statusBar.SimpleText:='Creating index for table before changes...';
     tableBefore.createIndex();
     Application.ProcessMessages;

     statusBar.SimpleText:='Creating index for table after changes...';
     tableAfter.createIndex();
     Application.ProcessMessages;

     if tableBefore.useIndex then
          begin
               statusBar.SimpleText:='Quickorting index for table before changes...';
               tableBefore.sortIndex();
               Application.ProcessMessages;

               statusBar.SimpleText:='Quicksorting index for table after changes...';
               tableAfter.sortIndex();
               Application.ProcessMessages;

               // after indexes are created, we should do a uniqueness check
               // if in the index the same value is contigouus, the uniqueness is broken!
               if tableBefore.checkIndexForUniqueness() and
               tableAfter.checkIndexForUniqueness() then
               begin
                    ShowMessage('Proceding');
               end
               else
               begin
                    ShowMessage('ERROR: the primary key is not unique at least on one of the two tables!');
                    tableBefore.DisposeIndex;
                    tableAfter.DisposeIndex;
                    tableBefore.Free;
                    tableAfter.Free;
                    screen.Cursor := crArrow;
                    statusBar.SimpleText:='Ready.';
                    Exit;
               end;
        end;

  finally

    if Assigned(tableBefore) then
      begin
         tableBefore.DisposeIndex;
         tableBefore.Free;
      end;
    if Assigned(tableAfter) then
      begin
        tableAfter.disposeIndex;
        tableAfter.Free;
      end;
    screen.Cursor := crArrow;
  end;

   statusBar.SimpleText:='Ready.';
end;

end.



