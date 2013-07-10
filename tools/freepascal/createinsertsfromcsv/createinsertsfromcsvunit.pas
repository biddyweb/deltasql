unit createinsertsfromcsvunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls;

type

  { TfrmCreateInserts }

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
    { private declarations }
  public
    { public declarations }
  end;

var
  frmCreateInserts: TfrmCreateInserts;

implementation

{$R *.lfm}

{ TfrmCreateInserts }

procedure TfrmCreateInserts.btnGenerateClick(Sender: TObject);
begin
    //
end;

procedure TfrmCreateInserts.btnSelectFileNameClick(Sender: TObject);
begin
  //
end;

procedure TfrmCreateInserts.lblOutputLinkClick(Sender: TObject);
begin
  //
end;

end.

