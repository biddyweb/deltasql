unit parsers;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils; 

function retrieveProjectVersionFromFile(filename : String) : Longint;

implementation

function retrieveProjectVersionFromFile(filename : String) : Longint;
var F : TextFile;
    Str : String;
begin
  Result := 0;
  if not FileExists(filename) then Exit;
try
  Assignfile(F, filename);
  Reset(F);
  while not EOF(F) do
    begin
      ReadLn(F, Str);
      if Pos('project.version = ', Str)=1 then
         begin
            Delete(Str,1,18);
            Result := StrToIntDef(Str,0);
         end;
    end;
finally
  CloseFile(F);
end;
end;

end.

