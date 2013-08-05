unit sqlfactories;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, csvtables, utils;

const QUOTE = 39;

type TSQLFactory = class(TObject)
    public
      constructor Create(var table : TCSVTable; includePKinInsert : Boolean);
      function    createDeleteStatement(pk : AnsiString; enabled : Boolean) : AnsiString;
      function    createUpdateStatement(pk, strBefore, strAfter : AnsiString; enabled : Boolean) : AnsiString;
      function    createInsertStatement(pk, strAfter : AnsiString; enabled : Boolean) : AnsiString;


    private
      table_ : TCSVTable;

      insert_,
      update_,
      delete_,
      where_    : AnsiString;

      includePKinInsert_ : Boolean;

      procedure prepareSQLStatements;
      function  createWhereClause(pk : AnsiString) : AnsiString;

end;

implementation

constructor TSQLFactory.Create(var table : TCSVTable; includePKinInsert : Boolean);
begin
  inherited Create;

  table_ := table;
  includePKinInsert_ := includePKinInsert;
  prepareSQLStatements;
end;

procedure TSQLFactory.prepareSQLStatements;
var i : Longint;
begin
  delete_ := 'DELETE FROM '+table_.tablename_;
  where_  := ' WHERE '+table_.fields_[table_.primaryKeyIdx_]+'=';
  update_ := 'UPDATE '+table_.tablename_+' SET ';
  insert_ := 'INSERT INTO '+table_.tablename_+' (';
  // adding all fields but the primary key
  for i:=1 to table_.totalfields_ do
      begin
        if (not includePKinInsert_) and (i=table_.primaryKeyIdx_) then continue;
        insert_ := insert_ +table_.fields_[i]+',';
      end;
  Delete(insert_, length(insert_), 1);
  insert_ := insert_ + ') '{+#13#10}+'VALUES(';
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
    paramBefore, paramAfter,
    escapedparam : AnsiString;
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
             // escape single quotes ' with twice a quote '' (works for sure in SQL sever and Oracle)
            escapedparam := StringReplace(paramAfter, Chr(QUOTE), Chr(QUOTE)+Chr(QUOTE), [rfReplaceAll, rfIgnoreCase]);
             if table_.isNumeric_[count] or (paramAfter='NULL') then
             begin
                if escapedparam = '' then escapedparam := 'NULL';
                Result := Result + escapedparam
             end
             else
                Result := Result + Chr(QUOTE) + escapedparam + Chr(QUOTE);
             Result := Result + ',';
             changed := true;
           end;

     end;

  if not changed then raise Exception.Create('Internal error in createUpdateStatement III: No changes detected for pk '+pk);
  Delete(Result, length(Result), 1);
  Result := Result + createWhereClause(pk);
end;

function TSQLFactory.createInsertStatement(pk, strAfter : AnsiString; enabled : Boolean) : AnsiString;
var i : Longint;
    param, escapedparam : AnsiString;
begin
 if enabled then Result := '' else Result := '-- ';
 Result := Result + insert_;

  for i:=1 to table_.totalfields_ do
      begin
        param := ExtractParamLong(strAfter, table_.separator_);
        if i=table_.primaryKeyIdx_ then
            begin
              if (param<>pk) then
                   raise Exception.Create('Internal error in createInsertStatement I '+param+'/'+pk+#13#10+StrAfter);
              if (not includePKinInsert_) then continue;
            end;
        // escape single quotes ' with twice a quote '' (works for sure in SQL sever and Oracle)
        escapedparam := StringReplace(param, Chr(QUOTE), Chr(QUOTE)+Chr(QUOTE), [rfReplaceAll, rfIgnoreCase]);
        if table_.isNumeric_[i] or (param='NULL') then
              begin
               if escapedparam = '' then escapedparam := 'NULL';
               Result := Result + escapedparam
              end
             else
                Result := Result + Chr(QUOTE) + escapedparam + Chr(QUOTE);
             Result := Result + ',';
      end;

 Delete(Result, length(Result), 1);
 Result := Result + ');';
end;

end.

