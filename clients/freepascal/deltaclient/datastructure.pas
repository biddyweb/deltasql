unit datastructure;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, utils;

const MAX_PROJECTS = 256;
      MAX_BRANCHES = 1024;

type TProject = record
    projectid   : Longint;
    name        : String;
end;

type TProjectContainer = record
    projects   : Array[1..MAX_PROJECTS] of TProject;
    nbprojects : Longint;
end;

type TProjectController = class(TObject)
   public
      constructor Create(filename : String);
   private
      con : TProjectContainer;
end;

type TBranch = record
  projectid : Longint;
  istag,
  visible   : Boolean;
  name      : String;
end;

type TBranchContainer = record
    branches   : Array[1..MAX_BRANCHES] of TBranch;
    nbbranches : Longint;
end;


type TBranchController = class(TObject)
   public
     constructor Create(filename : String);
   private
     con : TBranchContainer;
end;

implementation

constructor TProjectController.Create(filename : String);
var i   : Longint;
    str : ShortString;
    F   : TextFile;
begin
  i := 0;
  AssignFile(F, filename);
  while (not Eof(F)) and (i<=MAX_PROJECTS) do
     begin
       Inc(i);
       ReadLn(F, Str);
       con.projects[i].projectid := StrToInt(ExtractParam(Str,';'));
       con.projects[i].name := ExtractParam(Str,';');
     end;
  con.nbprojects := i;
end;

constructor TBranchController.Create(filename : String);
var i   : Longint;
    str : ShortString;
    F   : TextFile;
begin
  i := 0;
  AssignFile(F, filename);
  while (not Eof(F)) and (i<=MAX_BRANCHES) do
     begin
       Inc(i);
       ReadLn(F, Str);
       con.branches[i].projectid := StrToInt(ExtractParam(Str,';'));
       con.branches[i].istag   :=  (1 = StrToInt(ExtractParam(Str,';')));
       con.branches[i].visible :=  (1 = StrToInt(ExtractParam(Str,';')));
       con.branches[i].name := ExtractParam(Str,';');
     end;
  con.nbbranches := i;

end;



end.

