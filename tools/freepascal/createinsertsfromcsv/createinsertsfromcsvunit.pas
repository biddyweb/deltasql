unit createinsertsfromcsvunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls;

type
  TfrmCreateInserts = class(TForm)
    btnSelectFileName: TButton;
    btnGenerate: TButton;
    cbHeader: TCheckBox;
    edtFilename: TEdit;
    lblFilename: TLabel;
    lblOutput: TLabel;
    lblInfo: TLabel;
    lblOutputLink: TLabel;
    dlgOpen: TOpenDialog;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectFileNameClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
  private
    procedure generateInserts;
  end;

var
  frmCreateInserts: TfrmCreateInserts;

implementation

{$R *.lfm}

procedure TfrmCreateInserts.btnSelectFileNameClick(Sender: TObject);
begin
  if dlgOpen.Execute then
     begin
          edtFileName.Text := dlgOpen.FileName;
          edtFileName.Enabled := true;
     end;
end;

procedure TfrmCreateInserts.btnGenerateClick(Sender: TObject);
begin
     if Trim(edtFileName.Text)<>'' then
        begin
            if FileExists(edtFileName.Text) then
               generateInserts
            else
              ShowMessage('ERROR: could not locate the filename! ('+edtFileName.Text+')');
        end
     else ShowMessage('Please select an input filename first with "..."');
end;


procedure TfrmCreateInserts.generateInserts;
begin
end;

procedure TfrmCreateInserts.lblOutputLinkClick(Sender: TObject);
begin
  //
end;

end.

