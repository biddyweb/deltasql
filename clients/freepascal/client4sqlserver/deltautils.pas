unit deltautils;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, ClipBrd;

function  retrieveProjectVersionFromFile(filename : String) : Longint;
procedure copyTextFileToClipboard(filename : String);

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

procedure copyTextFileToClipboard(filename : String);
var F : TextFile;
    content, str : AnsiString;
begin
content := '';
try
  Assignfile(F, filename);
  Reset(F);
  while not EOF(F) do
    begin
      ReadLn(F, Str);
      content := content + Str + #13#10;
    end;
  ClipBoard.AsText := content;
finally
  CloseFile(F);
end;
end;

end.

