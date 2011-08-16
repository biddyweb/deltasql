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
      con_ : TProjectContainer;
      constructor Create(filename : String);
end;

type TBranch = record
  projectid : Longint;
  istag,
  visible   : Boolean;
  versionnr : Longint;
  name      : String;
end;

type TBranchContainer = record
    branches   : Array[1..MAX_BRANCHES] of TBranch;
    nbbranches : Longint;
end;


type TBranchController = class(TObject)
   public
     con_ : TBranchContainer;
     constructor Create(filename : String);
     procedure retrieveBranches(projname : String; versionnr : Longint;
                                branches, tags : Boolean; var tocon : TBranchContainer);
     function  retrieveBranchVersion(branchname : String) : Longint;
end;


var
  projC    : TProjectController;
  branC    : TBranchController;

implementation

constructor TProjectController.Create(filename : String);
var i   : Longint;
    str : ShortString;
    F   : TextFile;
begin
  i := 0;
  AssignFile(F, filename);
  Reset(F);
  ReadLn(F); // header
  while (not Eof(F)) and (i<=MAX_PROJECTS) do
     begin
       Inc(i);
       ReadLn(F, Str);
       con_.projects[i].projectid := StrToInt(ExtractParam(Str,';'));
       con_.projects[i].name := ExtractParam(Str,';');
     end;
  con_.nbprojects := i;
end;

constructor TBranchController.Create(filename : String);
var i   : Longint;
    str : ShortString;
    F   : TextFile;
begin
  i := 0;
  AssignFile(F, filename);
  Reset(F);
  ReadLn(F); // header
  while (not Eof(F)) and (i<=MAX_BRANCHES) do
     begin
       Inc(i);
       ReadLn(F, Str);
       con_.branches[i].projectid := StrToInt(ExtractParam(Str,';'));
       con_.branches[i].istag   :=  (1 = StrToInt(ExtractParam(Str,';')));
       con_.branches[i].visible :=  (1 = StrToInt(ExtractParam(Str,';')));
       con_.branches[i].versionnr := StrToInt(ExtractParam(Str,';'));
       con_.branches[i].name := ExtractParam(Str,';');
     end;
  con_.nbbranches := i;

end;

procedure TBranchController.retrieveBranches(projname : String; versionnr : Longint;
                                             branches, tags : Boolean; var tocon : TBranchContainer);
var projectid, i : Longint;
begin
  projectid := -2;
  // retrieve first id of project
  for i:=1 to projC.con_.nbprojects do
     if (projC.con_.projects[i].name=projname) then
        begin
          projectid := projC.con_.projects[i].projectid;
        end;

  tocon.nbbranches:=0;
  for i:=1 to con_.nbbranches do
     begin
       if (con_.branches[i].projectid=-1) or ((con_.branches[i].projectid=projectid)
           and (con_.branches[i].versionnr>versionnr))  then
             begin
               if not (con_.branches[i].visible) then continue;
               if (con_.branches[i].name<>'HEAD') and (con_.branches[i].istag) and (not tags) then continue;
               if (con_.branches[i].name<>'HEAD') and (not con_.branches[i].istag) and (not branches) then continue;

               Inc(tocon.nbbranches);
               tocon.branches[tocon.nbbranches].name := con_.branches[i].name;
               tocon.branches[tocon.nbbranches].versionnr:= con_.branches[i].versionnr;
               tocon.branches[tocon.nbbranches].projectid:= con_.branches[i].projectid;
               tocon.branches[tocon.nbbranches].visible:= con_.branches[i].visible;
               tocon.branches[tocon.nbbranches].istag:= con_.branches[i].istag;
             end;
     end;
end;

function  TBranchController.retrieveBranchVersion(branchname : String) : Longint;
var i : Longint;
begin
  Result := -2;
  if branchname = 'HEAD' then Exit;
  for i:=1 to con_.nbbranches do
    if (con_.branches[i].name=branchname) then Result := con_.branches[i].versionnr;
end;

end.

