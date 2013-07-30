unit sqlfactories;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, csvtables, utils;

const QUOTE = 39;

type TSQLFactory = class(TObject)
    public
      constructor Create(var table : TCSVTable);
      function    createDeleteStatement(pk : AnsiString; enabled : Boolean) : AnsiString;
      function    createUpdateStatement(pk, strBefore, strAfter : AnsiString; enabled : Boolean) : AnsiString;


    private
      table_ : TCSVTable;

      insert_,
      update_,
      delete_,
      where_    : AnsiString;

      procedure prepareSQLStatements;
      function  createWhereClause(pk : AnsiString) : AnsiString;

end;

implementation

constructor TSQLFactory.Create(var table : TCSVTable);
begin
  inherited Create;

  table_ := table;
  prepareSQLStatements;
end;

procedure TSQLFactory.prepareSQLStatements;
var i : Longint;
begin
  delete_ := 'DELETE FROM '+table_.tablename_;
  where_  := ' WHERE '+table_.fields_[table_.primaryKeyIdx_]+'=';
  update_ := 'UPDATE '+table_.tablename_+' SET ';
  insert_ := 'INSERT '+table_.tablename_+' (';
  // adding all fields but the primary key
  for i:=1 to table_.totalfields_ do
      begin
        if i=table_.primaryKeyIdx_ then continue;
        insert_ := insert_ +table_.fields_[i]+',';
      end;
  Delete(insert_, length(insert_), 1);
  insert_ := insert_ + ')'+#13#10+'VALUES(';
end;

function TSQLFactory.createWhereClause(pk : AnsiString) : AnsiString;
begin
  Result := where_;
  if table_.isNumeric_[table_.primaryKeyIdx_] then
     Result := Result + pk
  else
     Result := Result + Chr(QUOTE) + pk + Chr(QUOTE);

  Result := Result +';';
end;

function TSQLFactory.createDeleteStatement(pk : AnsiString; enabled : Boolean) : AnsiString;
begin
  if enabled then Result := '' else Result := '-- ';
  Result := Result + delete_ + createWhereClause(pk);
end;


function TSQLFactory.createUpdateStatement(pk, strBefore, strAfter : AnsiString; enabled : Boolean) : AnsiString;
var count : Longint;
    paramBefore, paramAfter : AnsiString;
    changed  : Boolean;
begin
  if enabled then Result := '' else Result := '-- ';
  Result := Result + update_;

  // this is the most difficult part, we need to find changed fields
  count := 0;
  changed := false;

  while (count<=table_.totalfields_) do
     begin
       Inc(count);
       paramBefore := ExtractParamLong(strBefore, table_.separator_);
       paramAfter  := ExtractParamLong(strAfter, table_.separator_);
       if count=table_.primaryKeyIdx_ then
             begin
               if (paramBefore<>paramAfter) then
                   raise Exception.Create('Internal error in createUpdateStatement I: the PK is different!! '+paramBefore+'/'+paramAfter);
               if (paramBefore<>pk) then
                   raise Exception.Create('Internal error in createUpdateStatement II '+paramBefore+'/'+pk+#13#10+StrBefore+#13#10+StrAfter);
               continue;
             end;
       if paramBefore<>paramAfter then
           begin
             Result := Result + table_.fields_[count]+'=';
             if table_.isNumeric_[count] then
                Result := Result + paramAfter
             else
                Result := Result + Chr(QUOTE) + paramAfter + Chr(QUOTE);
             Result := Result + ',';
             changed := true;
           end;

     end;

  if not changed then raise Exception.Create('Internal error in createUpdateStatement III: No changes detected for pk '+pk);
  Delete(Result, length(Result), 1);
  Result := Result + createWhereClause(pk);
end;

end.

