unit csvtables;
{(c) by 2013 HB9TVM an the deltasql team. Source code is under GPL}
{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, utils;

const
     MAX_COLUMNS = 2048; // if a table has so many columns, consider
                         // refactoring :-D

type TCSVTable = class(TObject)
   public // we know what we are doing with our datastructure anyway
     filename_,
     tablename_,
     header_,
     separator_   : String;

     fields_      : Array[1..MAX_COLUMNS] of AnsiString;
     totalfields_ : Longint;

     totalrows_      : Longint;
     primarykeyIdx_  : Longint;
     isNumeric_      : Array[1..MAX_COLUMNS] of Boolean;

     constructor Create(filename, tablename, primarykey, separator  : String);
     function    readHeader() : AnsiString;
     function    countRows() : Longint;
     procedure   inferFieldsFromData;

   private
     F : TextFile;
     procedure initFieldTypes;

end;

implementation

constructor TCSVTable.Create(filename, tablename, primarykey, separator  : String);
var column : AnsiString;
    i      : Longint;
begin
 filename_  := filename;
 tablename_ := tablename;
 separator_ := separator;
 header_    := readHeader();

 i:=0;
 column := Trim(ExtractParamLong(header_, separator_));
 while column<>'' do
         begin
           Inc(i);
           fields_[i] := column;
           column := Trim(ExtractParamLong(header_, separator_));
         end;
 totalfields_ := i;

 primarykeyIdx_:=-1;
 for i:=1 to totalfields_ do
        if fields_[i]=primarykey then primarykeyIdx_:=i;
 if (primarykeyIdx_=-1) then raise Exception.Create('ERROR: Could not locate primary key!');

 totalrows_ := countRows();
end;

function TCSVTable.readHeader() : AnsiString;
var str : AnsiString;
begin
  Result := '';
  if Trim(filename_)='' then Exit;
  if not FileExists(filename_) then
        raise Exception.Create('ERROR: filename '+filename_+' does not exist!');

  str := '';
  AssignFile(F, filename_);
  try
    Reset(F);
    ReadLn(F, Str);
  finally
    CloseFile(F);
  end;

  Result := Trim(Str);
end;

function TCSVTable.countRows() : Longint;
var count : Longint;
    str   : AnsiString;
begin
  count := 0;
  AssignFile(F, filename_);
  try
    Reset(F);
    ReadLn(F);  // skip header

    while not EOF(F) do
        begin
          ReadLn(F, Str);
          if Trim(Str)='' then continue;
          Inc(count);
        end;
  finally
    CloseFile(F);
  end;

  Result := count;
end;

procedure TCSVTable.initFieldTypes;
var i : Longint;
begin
  for i:=1 to MAX_COLUMNS do isnumeric_[i] := true;
end;

procedure TCSVTable.inferFieldsFromData;
var
    str : AnsiString;
    firstLine : Boolean;

    procedure scanFieldsForNumeric(str : AnsiString);
    var column : AnsiString;
        i      : Longint;
    begin

      column:=Trim(extractParamLong(str, separator_));
      i := 1;
      while column<>'' do
           begin
             if isnumeric_[i] and (column<>'NULL') then
                begin
                  // test if this column is really numeric
                     try
                        StrToFloat(column);
                     except
                           on E : EConvertError do
                              isnumeric_[i] := false;
                     end;
                end;

             // go to next column
             column:=Trim(extractParamLong(str, separator_));
             i := i+1;
           end;
    end;

begin
 firstLine := true;
 AssignFile(F, filename_);

  try
    Reset(F);

    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue; // we skip blank lines completely

          if not firstline then scanFieldsForNumeric(str);

          if firstLine then firstLine := false;
        end;

  finally
    CloseFile(F);
  end;
end;


end.

