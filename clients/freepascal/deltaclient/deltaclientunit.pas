unit deltaclientunit;
{ (c) by 2011 HB9TVM }
// algorithm explanation at http://www.deltasql.org/deltasql/manual.php#write-client
// Source code is under GPL
{$mode objfpc}{$H+}
interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  StdCtrls, configurations, downloadutils, loggers, datastructure, Clipbrd,
  synacode, deltautils;

type

  { TDeltaForm }

  TDeltaForm = class(TForm)
    btnSettings: TButton;
    btnGenerateScript: TButton;
    btnPasteScript: TButton;
    cbProject: TComboBox;
    cbFromBranch: TComboBox;
    cbToBranch: TComboBox;
    cbBranches: TCheckBox;
    cbTags: TCheckBox;
    edtVersion: TEdit;
    lblTo: TLabel;
    lblFrom: TLabel;
    lblVersion: TLabel;
    lblProject: TLabel;
    procedure btnGenerateScriptClick(Sender: TObject);
    procedure btnPasteScriptClick(Sender: TObject);
    procedure btnSettingsClick(Sender: TObject);
    procedure cbBranchesOnChange(Sender: TObject);
    procedure cbFromChange(Sender: TObject);
    procedure cbProjectChange(Sender: TObject);
    procedure cbTagOnChange(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    appPath_ : String;
    logger_  : TLogger;

    procedure reloadProjectsAndBranchesFromServer();
    procedure reloadFromAndToBranch();
    procedure reloadToBranch();
  public
    { public declarations }
  end; 

var
  DeltaForm: TDeltaForm;

implementation

{ TDeltaForm }

procedure TDeltaForm.FormCreate(Sender: TObject);
begin
  appPath_ := ExtractFilePath(ParamStr(0));
  logger_ := TLogger.Create(appPath_, 'log.txt');
  conf := TConfiguration.Create();

  reloadProjectsAndBranchesFromServer;
end;

procedure TDeltaForm.reloadProjectsAndBranchesFromServer;
var i  : Longint;
    ok : Boolean;
begin
  ok:=downloadToFile(conf.url+'/dbsync_list_projects.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'projects.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
  if ok then
   ok:=downloadToFile(conf.url+'/dbsync_list_branches.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'branches.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);

  if ok and FileExists('projects.conf') and FileExists('branches.conf') then
     begin
      if Assigned(projC) then projC.Free;
      if Assigned(branC) then branC.Free;
      projC := TProjectController.Create(appPath_+PathDelim+'projects.conf');
      branC := TBranchController.Create(appPath_+PathDelim+'branches.conf');

      cbProject.Enabled := true;
      cbProject.Clear;
      for i:=1 to projC.con_.nbprojects do
        cbProject.AddItem(projC.con_.projects[i].name, nil);
      edtVersion.Enabled := true;
     end;
end;

procedure TDeltaForm.cbProjectChange(Sender: TObject);
begin
 reloadFromAndToBranch;
end;

procedure TDeltaForm.cbTagOnChange(Sender: TObject);
begin
 reloadFromAndToBranch;
end;

procedure TDeltaForm.cbFromChange(Sender: TObject);

begin
 reloadToBranch();
end;

procedure TDeltaForm.cbBranchesOnChange(Sender: TObject);
begin
 reloadFromAndToBranch();
end;

procedure TDeltaForm.btnPasteScriptClick(Sender: TObject);
begin
  Clipboard.AsText := 'select * from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);';
end;

procedure TDeltaForm.btnGenerateScriptClick(Sender: TObject);
var param1, param2 : String;
    ok             : Boolean;
    versionServer,
    versionSchema  : Longint;
begin
  // algorithm explanation at http://www.deltasql.org/deltasql/manual.php#write-client
  if (cbProject.Text='') then
       begin
          ShowMessage('Please define a project name before hitting the button!');
          Exit;
       end;

  if (cbFromBranch.Text='') or (cbToBranch.Text='') then
        begin
          ShowMessage('Please set both From: and To: fields before hitting the button!');
          Exit;
        end;

  param1 := '?project='+encodeURL(cbProject.Text)+'&seed='+IntToStr(Trunc(Random*1000));
  ok := downloadToFile(conf.url+'/dbsync_automated_currentversion.php'+param1, appPath_, 'projectversion.properties', conf.proxy, conf.port, 'deltaclient> ', logger_);
  if ok then
     begin
       versionServer := retrieveProjectVersionFromFile(appPath_+'projectversion.properties');
       versionSchema := StrToIntDef(edtVersion.Text, 0);
       if versionSchema>=versionServer then
          begin
             ShowMessage('No need to update this schema as version on server is '+IntToStr(versionServer)+'.');
             Exit;
          end;
       param2 := '?project='+cbProject.Text+'&version='+edtVersion.Text+'&frombranch='+cbFromBranch.Text+'&tobranch='+cbToBranch.Text;
       param2 := param2+'&seed='+IntToStr(Trunc(Random*1000));
       ok := downloadToFile(conf.url+'/dbsync_automated_update.php'+param2, appPath_, 'script.txt', conf.proxy, conf.port, 'deltaclient> ', logger_);
       if ok then
          begin
            convertLFtoCRLF(appPath_+PathDelim+'script.txt',appPath_+PathDelim+'script.sql', logger_);
            DeleteFile(appPath_+PathDelim+'script.txt');
            copyTextFileToClipboard(appPath_+PathDelim+'script.sql');
          end;
     end;
end;

procedure TDeltaForm.btnSettingsClick(Sender: TObject);
begin
  //
end;

procedure TDeltaForm.FormDestroy(Sender: TObject);
begin
  projC.Free;
  branC.Free;
  logger_.Free;
  conf.Free;
end;

procedure TDeltaForm.reloadFromAndToBranch();
var con : TBranchContainer;
    i   : Longint;
begin
  branC.retrieveBranches(cbProject.Text, 0, cbBranches.Checked, cbTags.Checked, con);
  cbFromBranch.Clear;
  cbToBranch.Clear;
  for i:=1 to con.nbbranches do
    begin
      cbFromBranch.AddItem(con.branches[i].name, nil);
      cbToBranch.AddItem(con.branches[i].name, nil);
      cbFromBranch.Enabled := true;
      cbToBranch.Enabled := true;
      btnGenerateScript.Enabled := true;
    end;
end;

procedure TDeltaForm.reloadToBranch();
var versionnr,i  : Longint;
    con          : TBranchContainer;
begin
  versionnr := branC.retrieveBranchVersion(cbFromBranch.Text);
  branC.retrieveBranches(cbProject.Text, versionnr, cbBranches.Checked, cbTags.Checked, con);
  cbToBranch.Clear;
  for i:=1 to con.nbbranches do
      cbToBranch.AddItem(con.branches[i].name, nil);
end;

initialization
  {$I deltaclientunit.lrs}

end.

