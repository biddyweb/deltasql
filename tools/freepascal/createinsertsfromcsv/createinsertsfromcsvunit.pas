unit createinsertsfromcsvunit;
{ (c) 2013 by HB9TVM and the deltasql team. This source code is under the GPL}
{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ComCtrls, Process;

const MAX_FIELDS = 2056; // if a table has more than this number of columns, then
                        // it might need refactoring ;-)
      QUOTE      = 39; //ASCII char for '
      TAB        = 9; //ASCII char for TAB
      EDITOR     = 'notepad'; // the default editor to use the file
      UPDATE_STATS_EACH = 1000; // after how many rows percentage stats are updated

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
    rbSeparatorTab: TRadioButton;
    rbSeparatorEdit: TRadioButton;
    statusbar: TStatusBar;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectCSVFileClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
  private
    outputFile,
    insertStatement : AnsiString;
    isNumeric : Array[1..MAX_FIELDS] of Boolean;
    totalLines : Longint;

    procedure countLines;
    procedure generateInserts;
    procedure constructInsertStatement(header : AnsiString);
    function  fillInsertStatement(values : AnsiString) : AnsiString;
    function  getSeparator(): AnsiString;

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
    if Trim(edtTableName.Text)='' then
        begin
             ShowMessage('ERROR: please define a tablename!');
             Exit;
        end;

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
    count : Longint;
begin
  screen.cursor:=crHourglass;
  edtFileName.Enabled := false;
  edtSeparator.Enabled := false;
  btnGenerate.Enabled := false;
  btnSelectCSVFile.Enabled := false;
  edtTableName.Enabled := false;
  rbSeparatorTab.Enabled := false;
  rbSeparatorEdit.Enabled := false;

  outputFile := ChangeFileExt(edtFileName.Text, '.sql');

  countLines;
  initFieldTypes;
  inferFieldsFromData;

  firstLine := true;
  AssignFile(F, edtFileName.Text);
  AssignFile(G, outputFile);

  try
    statusbar.SimpleText:='Generating inserts...';
    Reset(F);
    Rewrite(G);

    count := 0;
    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue; // we skip blank lines completely

          if firstLine then constructInsertStatement(str);

          if cbHeader.Checked then
              begin
                if not firstline then WriteLn(G, fillInsertStatement(str));
              end
          else
            WriteLn(G, fillInsertStatement(str));

          Inc(count);
          if (count mod UPDATE_STATS_EACH)=0 then
               statusbar.SimpleText:='Generating inserts... ('+FormatFloat('0.00',100*count/totalLines)+'%)';
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
    rbSeparatorTab.Enabled := true;
    rbSeparatorEdit.Enabled := true;

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
             column:=Trim(extractParamLong(header, getSeparator()));
             while column<>'' do
                 begin
                   insertStatement := insertStatement + column + ',';
                   column:=Trim(extractParamLong(header, getSeparator));
                 end;
             Delete(insertStatement, length(insertStatement), 1);
             insertStatement := insertStatement+') VALUES(';
         end;
   //ShowMessage(insertStatement);
end;


function TfrmCreateInserts.fillInsertStatement(values : AnsiString) : AnsiString;
var column, escapedStr : AnsiString;
    i      : Longint;
begin
  Result := '';
  column:=Trim(extractParamLong(values, getSeparator()));
  i:=1;
  while column<>'' do
      begin
        if isnumeric[i] or (column='NULL') then
          begin
           if column='' then column:='NULL';
           Result := Result + column + ','
          end
        else
          begin
            // escape single quotes ' with twice a quote '' (works for sure in SQL sever and Oracle)
            escapedstr := StringReplace(column, Chr(QUOTE), Chr(QUOTE)+Chr(QUOTE), [rfReplaceAll, rfIgnoreCase]);
            Result := Result + Chr(QUOTE) + escapedStr + Chr(QUOTE) + ',';
          end;

        column:=Trim(extractParamLong(values, getSeparator()));
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
               AProcess.CommandLine := '"'+EDITOR+'" "'+outputFile+'"';
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
    count     : Longint;

    procedure scanFieldsForNumeric(str : AnsiString);
    var column : AnsiString;
        i      : Longint;
    begin

      column:=Trim(extractParamLong(str, getSeparator()));
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
             column:=Trim(extractParamLong(str, getSeparator()));
             i := i+1;
           end;
    end;

begin
 statusbar.SimpleText:='Inferring field type based on input data...';

 firstLine := true;
 AssignFile(F, edtFileName.Text);

 count := 0;
  try
    Reset(F);

    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue; // we skip blank lines completely

          if cbHeader.Checked then
              begin
                if not firstline then scanFieldsForNumeric(str);
              end
          else
              scanFieldsForNumeric(str);

          if firstLine then firstLine := false;

          Inc(count);
          if (count mod UPDATE_STATS_EACH)=0 then
               statusbar.SimpleText:='Inferring field type based on input data... ('+FormatFloat('0.00',100*count/totalLines)+'%)';

          Application.ProcessMessages;
        end;

  finally
    CloseFile(F);
  end;
end;

procedure TfrmCreateInserts.countLines;
var F : TextFile;
    str : AnsiString;
begin
 statusbar.SimpleText:='Counting lines for percentage stats...';

 AssignFile(F, edtFileName.Text);

 totalLines := 0;
 try
    Reset(F);

    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue;

          Inc(totalLines);
          Application.ProcessMessages;
        end;

  finally
    CloseFile(F);
  end;
end;

function TfrmCreateInserts.getSeparator(): AnsiString;
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

