unit settingsunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  ExtCtrls, StdCtrls, configurations;

type

  { TSettingsForm }

  TSettingsForm = class(TForm)
    btnSelectEditor: TButton;
    btnOk: TButton;
    btnCancel: TButton;
    cbShowHidden: TCheckBox;
    cbLoadOnClipboard: TCheckBox;
    edtUrl: TLabeledEdit;
    edtProxy: TLabeledEdit;
    edtPort: TLabeledEdit;
    edtEditor: TLabeledEdit;
    edtUser: TLabeledEdit;
    openDialog: TOpenDialog;
    procedure btnCancelClick(Sender: TObject);
    procedure btnOkClick(Sender: TObject);
    procedure btnSelectEditorClick(Sender: TObject);
    procedure changeRequiresRestart(Sender: TObject);
  private
  public
    okPressed,
    requiresRestart : Boolean;
    procedure loadSettingsFromConfiguration;
    procedure saveSettingsToConfiguration;
  end;

var
  SettingsForm: TSettingsForm;

implementation

procedure TSettingsForm.btnOkClick(Sender: TObject);
begin
  visible := false;
  saveSettingsToConfiguration;
  conf.saveToIniFile();
  okPressed := true;

  if requiresRestart then ShowMessage('You need to restart deltasql in order for the change to take effect.');
end;

procedure TSettingsForm.btnSelectEditorClick(Sender: TObject);
begin
  if openDialog.Execute then
   begin
     edtEditor.Text := openDialog.Filename;
   end;
end;

procedure TSettingsForm.changeRequiresRestart(Sender: TObject);
begin
  requiresRestart := true;
end;

procedure TSettingsForm.btnCancelClick(Sender: TObject);
begin
  visible := false;
  okPressed := false;
end;

procedure TSettingsForm.loadSettingsFromConfiguration;
begin
 edtUrl.Text := conf.url;
 edtProxy.Text := conf.Proxy;
 edtPort.Text := conf.Port;
 edtEditor.Text := conf.editor;
 cbShowHidden.checked := conf.showHidden;
 cbLoadOnClipboard.Checked := conf.copyScriptToClipboard;
 edtUser.Text := conf.user;

 requiresRestart := false;
 okPressed := false;
end;

procedure TSettingsForm.saveSettingsToConfiguration;
begin
  conf.url := edtUrl.Text;
  conf.Proxy := edtProxy.Text;
  conf.Port := edtPort.Text;
  conf.editor := edtEditor.Text;
  conf.showHidden := cbShowHidden.Checked;
  conf.copyScriptToClipboard := cbLoadOnClipboard.Checked;
  conf.user := edtUser.Text;
end;

initialization
  {$I settingsunit.lrs}

end.

