unit deltaclientunit;
{ (c) by 2011 HB9TVM }
// algorithm explanation at http://www.deltasql.org/deltasql/manual.php#write-client
// Source code is under GPL
{$mode objfpc}{$H+}
interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  StdCtrls, configurations, downloadutils, loggers, datastructure, Clipbrd,
  synacode, deltautils, settingsunit, Process, LazHelpHTML;

type

  { TDeltaForm }

  TDeltaForm = class(TForm)
    btnSettings: TButton;
    btnGenerateScript: TButton;
    btnPasteScript: TButton;
    cbDbType: TComboBox;
    lblDbType: TLabel;
    srvButton: TButton;
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
    procedure srvButtonClick(Sender: TObject);
  private
    appPath_ : String;
    logger_  : TLogger;
    BrowserPath_,
    BrowserParams_: string;

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
var idx : Longint;
    v   : THTMLBrowserHelpViewer;
begin
  appPath_ := ExtractFilePath(ParamStr(0));
  logger_ := TLogger.Create(appPath_, 'log.txt');
  conf := TConfiguration.Create(appPath_+PathDelim+'deltaclient.ini');

  if not FileExists(appPath_+PathDelim+'deltaclient.ini') then
    begin
      ShowMessage('Please define the communication parameters in Settings window first!');
    end
   else
    reloadProjectsAndBranchesFromServer;

  // defaults
  if conf.defaultProject <> '' then
       begin
        idx :=  cbProject.Items.IndexOf(conf.defaultProject);
        cbProject.ItemIndex := idx;
        reloadFromAndToBranch;
       end;
  if conf.defaultFrom<>'' then
       begin
         idx := cbFromBranch.Items.IndexOf(conf.defaultFrom);
         cbFromBranch.ItemIndex := idx;
         reloadToBranch;
       end;
  if conf.defaultTo<>'' then
       begin
         idx := cbToBranch.Items.IndexOf(conf.defaultTo);
         cbToBranch.ItemIndex := idx;
       end;
  if conf.dbType<>'' then
      begin
         idx := cbDbType.Items.IndexOf(conf.dbType);
         cbDbType.ItemIndex := idx;
      end;
 try
    v:=THTMLBrowserHelpViewer.Create(nil);
    v.FindDefaultBrowser(BrowserPath_,BrowserParams_);
 finally
    v.Free;
 end;
end;


procedure TDeltaForm.reloadProjectsAndBranchesFromServer;
var i  : Longint;
    ok : Boolean;
begin
  ok:=downloadToFile(conf.url+'/dbsync_list_projects.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'projects.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
  if ok then
   ok:=downloadToFile(conf.url+'/dbsync_list_branches.php?seed='+IntToStr(Trunc(Random*1000)), appPath_, 'branches.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);

  if ok and FileExists(appPath_+PathDelim+'projects.conf') and FileExists(appPath_+PathDelim+'branches.conf') then
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
  if not ok then ShowMessage('Error when retrieving script from deltasql server! Please check settings and log.txt');
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
    aProcess       : TProcess;
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
       param2 := '?project='+encodeUrl(cbProject.Text)+'&version='+encodeUrl(edtVersion.Text)+'&frombranch='+encodeUrl(cbFromBranch.Text)+'&tobranch='+cbToBranch.Text;
       param2 := param2+'&client=deltaclient&user='+encodeUrl(conf.user)+'&dbtype='+encodeUrl(cbDbType.Text);
       param2 := param2+'&seed='+IntToStr(Trunc(Random*1000));
       ok := downloadToFile(conf.url+'/dbsync_automated_update.php'+param2, appPath_, 'script.txt', conf.proxy, conf.port, 'deltaclient> ', logger_);
       if ok then
          begin
            convertLFtoCRLF(appPath_+PathDelim+'script.txt',appPath_+PathDelim+'script.sql', logger_);
            DeleteFile(appPath_+PathDelim+'script.txt');
            if conf.copyScriptToClipboard then copyTextFileToClipboard(appPath_+PathDelim+'script.sql');

            AProcess := TProcess.Create(nil);
            try
               AProcess.CommandLine := '"'+conf.editor+'" "'+appPath_+PathDelim+'script.sql'+'"';
               AProcess.Options := AProcess.Options - [poWaitOnExit];
               AProcess.Execute;
            finally
               AProcess.Free;
            end;
          end;
     end;
  if not ok then ShowMessage('Error when retrieving script from deltasql server! Please check settings and log.txt');
end;

procedure TDeltaForm.btnSettingsClick(Sender: TObject);
begin
  SettingsForm.loadSettingsFromConfiguration;
  SettingsForm.Visible := true;
end;

procedure TDeltaForm.FormDestroy(Sender: TObject);
begin
  conf.defaultProject:=cbProject.Text;
  conf.defaultFrom := cbFromBranch.Text;
  conf.defaultTo:=cbToBranch.Text;
  conf.dbType:=cbDbType.Text;
  conf.saveToIniFile();

  projC.Free;
  branC.Free;
  logger_.Free;
  conf.Free;
end;

procedure TDeltaForm.srvButtonClick(Sender: TObject);
var BrowserProcess: TProcess;
    p             : Longint;
    params        : String;
begin
    params := BrowserParams_;
    p:=System.Pos('%s', params);
    System.Delete(params,p,2);
    System.Insert(conf.url,params,p);
    BrowserProcess:=TProcess.Create(nil);
    try
      BrowserProcess.CommandLine:='"'+BrowserPath_+'" '+params;
      BrowserProcess.Options := BrowserProcess.Options - [poWaitOnExit];
      BrowserProcess.Execute;
    finally
      BrowserProcess.Free;
    end;
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

