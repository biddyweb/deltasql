unit deltaclientunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  StdCtrls, configurations, downloadutils, loggers, datastructure, Clipbrd;

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

    procedure reloadFromAndToBranch();
    procedure reloadToBranch();
  public
    { public declarations }
  end; 

var
  DeltaForm: TDeltaForm;
  conf     : TConfiguration;

implementation

{ TDeltaForm }

procedure TDeltaForm.FormCreate(Sender: TObject);
var ok : Boolean;
    i  : Longint;
begin
  appPath_ := ExtractFilePath(ParamStr(0));
  logger_ := TLogger.Create(appPath_, 'log.txt');
  conf := TConfiguration.Create();
  downloadToFile(conf.url+'/dbsync_list_projects.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'projects.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
  downloadToFile(conf.url+'/dbsync_list_branches.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'branches.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
  projC := TProjectController.Create(appPath_+PathDelim+'projects.conf');
  branC := TBranchController.Create(appPath_+PathDelim+'branches.conf');

  cbProject.Clear;
  for i:=1 to projC.con_.nbprojects do
     cbProject.AddItem(projC.con_.projects[i].name, nil);

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
begin
  //
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

