unit csvtables;
{(c) by 2013 HB9TVM an the deltasql team. Source code is under GPL}
{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, utils, quicksort;

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
     isNumeric_,
     isFloat_        : Array[1..MAX_COLUMNS] of Boolean;

     idxvalues       : Array of Longint;
     idxvaluesF      : Array of Extended;
     idxvaluesS      : Array of AnsiString;
     idxpos          : Array of Longint;

     tablemem_       : Array of AnsiString;

     useIndex       : Boolean;

     constructor Create(filename, tablename, primarykey, separator  : String);
     destructor  Destroy;
     function    readHeader() : AnsiString;
     function    countRows() : Longint;
     procedure   inferFieldsFromData;
     procedure   createIndex();
     procedure   sortIndex();
     function    checkIndexForUniqueness() : Boolean;
     procedure   disposeIndex();
     function    retrievePosFromKey(key : AnsiString) : Longint;
     function    retrievePrimaryKey(row : AnsiString) : AnsiString;
     function    retrieveNFieldValue(Str : AnsiString; pos : Longint) : AnsiString;
     function    retrieveRow(pos : Longint) : AnsiString;
     procedure   loadInMemory;

   private
     F : TextFile;
     loadedInMemory_ : Boolean;
     procedure initFieldTypes;
     function    retrievePosFromKeyBinary(key : Longint; keyF : Extended; keyS : AnsiString) : Longint;
     function    retrievePosFromKeyLinear(key : Longint; keyF : Extended; keyS : AnsiString) : Longint;


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
 useIndex   := false;
 loadedInMemory_ := false;

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

 initFieldTypes;
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
  for i:=1 to MAX_COLUMNS do
   begin
     isnumeric_[i] := true;
     isfloat_[i] := false;
   end;
end;

procedure TCSVTable.inferFieldsFromData;
var
    str : AnsiString;

    procedure scanFieldsForNumeric(str : AnsiString);
    var column     : AnsiString;
        i          : Longint;
        val        : Extended;
        singleTest : Boolean;
    begin
      singleTest := true;

      column:=Trim(extractParamLong(str, separator_));
      i := 1;
      while column<>'' do
           begin
             if isnumeric_[i] and (column<>'NULL') then
                begin
                  // test if this column is really numeric
                     try
                        val := StrToFloat(column);
                        if singletest then
                           begin
                                if Frac(val)<>0 then
                                   begin
                                      isfloat_[i] := true;
                                      singleTest := false;
                                   end;
                           end;
                     except
                           on E : EConvertError do
                             begin
                              isnumeric_[i] := false;
                              isfloat_[i]   := false;
                              singleTest := false;
                             end;
                     end;
                end;

             // go to next column
             column:=Trim(extractParamLong(str, separator_));
             i := i+1;
           end;
    end;

begin
 AssignFile(F, filename_);

  try
    Reset(F);
    ReadLn(F, Str); // skip header
    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue; // we skip blank lines completely

          scanFieldsForNumeric(str);
        end;

  finally
    CloseFile(F);
  end;
end;


function TCSVTable.retrievePrimaryKey(row : AnsiString) : AnsiString;
begin
  Result := retrieveNFieldValue(row, primaryKeyIdx_);
end;

function TCSVTable.retrieveNFieldValue(Str : AnsiString; pos : Longint) : AnsiString;
var i : Longint;
    value : AnsiString;
begin
  for i:=1 to pos do
     begin
       value := ExtractParamLong(Str, separator_);
     end;
  Result := value;
end;

procedure   TCSVTable.createIndex();
var i   : Longint;
    str, pkfield : AnsiString;
    isFloat, isNumeric : Boolean;
begin
   isFloat := isfloat_[primarykeyIdx_];
   isNumeric := isnumeric_[primarykeyIdx_];

   setLength(idxpos, totalrows_);
   if isFloat then
     setLength(idxvaluesF, totalrows_)
   else
   if isNumeric then
      setLength(idxvalues, totalrows_)
   else
     setLength(idxvaluesS, totalrows_);

   AssignFile(F, filename_);

  try
    Reset(F);
    Readln(F, str); // skip header

    i:=0;
    while not EOF(F) do
        begin
          Readln(F, str);
          if Trim(str)='' then continue; // we skip blank lines completely

          if str='NULL' then raise Exception.Create('Internal error: Primary key can not contain NULL values');

          pkfield := retrieveNFieldValue(Str, primaryKeyIdx_);
          if isFloat then
             idxvaluesF[i] := StrToFloat(pkfield)
          else
          if isNumeric then
             idxvalues[i] := StrToInt(pkfield)
          else
             idxvaluesS[i] := pkfield;

          idxpos[i] := i;
          Inc(i);
        end;

  finally
    CloseFile(F);
  end;

  //TODO: add index creation for floats and strings
  useIndex := isNumeric and (not isFloat);
end;

procedure TCSVTable.sortIndex();
begin
  if useIndex then QuickSortRelations(idxvalues, idxpos, 0, totalrows_-1);
end;

function    TCSVTable.checkIndexForUniqueness() : Boolean;
var i : Longint;
begin
  Result := true;
  for i:=1 to totalrows_-1 do
     begin
       if idxvalues[i]=idxvalues[i-1] then
          begin
               Result := false;
               Exit;
          end;
     end;
end;

procedure   TCSVTable.disposeIndex();
var i : Longint;
begin
 setLength(idxvalues, 0);
 setLength(idxvaluesF, 0);
 setLength(idxvaluesS, 0);
 setLength(idxpos, 0);
end;


function TCSVTable.retrievePosFromKey(key : AnsiString) : Longint;
var isFloat, isNumeric : Boolean;
begin
  isFloat := isfloat_[primarykeyIdx_];
  isNumeric := isnumeric_[primarykeyIdx_];

  if key='NULL' then raise Exception.Create('Internal error: Primary key can not contain NULL values');

  if useIndex then
     Result := retrievePosFromKeyBinary(StrToInt(key), 0, '')
  else
    begin
      if isFloat then
       Result := retrievePosFromKeyLinear(0, StrToFloat(key), '')
      else
       Result := retrievePosFromKeyLinear(0, 0, key);
    end;
end;


function TCSVTable.retrievePosFromKeyLinear(key : Longint; keyF : Extended; keyS : AnsiString) : Longint;
var i : Longint;
    isFloat, isNumeric : Boolean;
begin
  if key<>0 then raise Exception.Create('Internal error in retrievePosFromKeyLinear');

  isFloat := isfloat_[primarykeyIdx_];
  isNumeric := isnumeric_[primarykeyIdx_];

  for i:=0 to totalrows_-1 do
     begin
       if isFloat then
           begin
             if (idxvaluesF[i]=keyF) then
                begin
                     Result := idxpos[i];
                     Exit;
                end;
           end
       else
       if isNumeric then
          begin
             if (idxvalues[i]=key) then
                 begin
                      Result := idxpos[i];
                      Exit;
                 end;
          end
       else
       if idxvaluesS[i]=keyS then
          begin
              Result := idxpos[i];
              Exit;
          end;
     end;

  Result := -1;
end;

function    TCSVTable.retrievePosFromKeyBinary(key : Longint; keyF : Extended; keyS : AnsiString) : Longint;
var val, pos, low, high : Longint;
begin
    // binary search in a sorted array, iterative, from scratch
    if keyF<>0 then raise Exception.Create('Internal error 1 in retrievePosFromKeyBinary');
    if keyS<>'' then raise Exception.Create('Internal error 2 in retrievePosFromKeyBinary');

    low := 0;
    high := totalrows_-1;

    while (high>=low) do
      begin
        pos := (low+high) div 2;
        val := idxvalues[pos];

        if val<key then
           begin
              low:=pos+1;
           end
        else
        if val>key then
           begin
              high := pos-1;
           end
        else
           begin
              Result := idxpos[pos];
              Exit;
           end;

      end; // while

   Result := -1; // not found
end;

function TCSVTable.retrieveRow(pos : Longint) : AnsiString;
var i : Longint;
    str : AnsiString;
begin
    // much faster random access if table is loaded in memory
    if loadedInMemory_ then
        begin
           Result := tablemem_[pos];
           Exit;
        end;


    AssignFile(F, filename_);

    try
      Reset(F);
      ReadLn(F, Str); // skip header

      i := 0;
      while not EOF(F) do
          begin
            Readln(F, str);
            if Trim(str)='' then continue; // we skip blank lines completely

            if i=pos then
                 begin
                    Result := Str;
                    Exit;  // Exit will call the CloseFile in the finally block!
                 end;
            Inc(i);
          end;

    finally
      CloseFile(F);
    end;


    raise Exception.Create('Internal error: Row '+IntToStr(pos)+' in filename '+filename_+' not found!');
end;

procedure TCSVTable.loadInMemory;
var i : Longint;
    str : AnsiString;
begin
  setLength(tablemem_, totalrows_+1); // we store also the header

  AssignFile(F, filename_);

    try
      Reset(F);
      ReadLn(F, Str); // skip header

      i := 0;
      while not EOF(F) do
          begin
            Readln(F, str);
            if Trim(str)='' then continue; // we skip blank lines completely

            tablemem_[i] := Str;
            Inc(i);
          end;

    finally
      CloseFile(F);
    end;

  loadedInMemory_ := true;
end;


destructor TCSVTable.Destroy;
begin
  disposeIndex;
  if loadedInMemory_ then setLength(tablemem_, 0);
  inherited Destroy;
end;

end.

