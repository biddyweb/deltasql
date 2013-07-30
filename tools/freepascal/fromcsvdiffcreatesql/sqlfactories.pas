unit sqlfactories;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, csvtables;

type TSQLFactory = class(TObject)
    public
      constructor Create(var table : TCSVTable);


    private
      table_ : TCSVTable;

      insert_,
      update_,
      delete_,
      where_    : AnsiString;

      procedure prepareSQLStatements;

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
  Delete(insert_, length(insert_)-1, 1);
  insert_ := insert_ + ')'+#13#10+'VALUES(';
end;

end.

