unit deltaclientunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  StdCtrls, configurations, downloadutils, loggers, datastructure;

type

  { TDeltaForm }

  TDeltaForm = class(TForm)
    btnSettings: TButton;
    btnGenerateScript: TButton;
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
    procedure FormCreate(Sender: TObject);
    procedure FormDestroy(Sender: TObject);
  private
    appPath_ : String;
    logger_  : TLogger;
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
begin
  appPath_ := ExtractFilePath(ParamStr(0));
  logger_ := TLogger.Create(appPath_, 'log.txt');
  conf := TConfiguration.Create();
  downloadToFile(conf.url+'/dbsync_list_projects.php', appPath_, 'projects.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
  downloadToFile(conf.url+'/dbsync_list_branches.php', appPath_, 'branches.conf', conf.proxy, conf.port, 'deltaclient> ', logger_);
end;

procedure TDeltaForm.FormDestroy(Sender: TObject);
begin
  logger_.Free;
  conf.Free;
end;

initialization
  {$I deltaclientunit.lrs}

end.

