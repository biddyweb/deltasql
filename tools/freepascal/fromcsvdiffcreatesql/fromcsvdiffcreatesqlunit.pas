unit fromcsvdiffcreatesqlunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ComCtrls;

type

  { TfromCSVtoSQL }

  TfromCSVtoSQL = class(TForm)
    btnGenerateSync: TButton;
    btnSelectCSVFileBefore: TButton;
    btnSelectCSVFileAfter: TButton;
    dlgOpenCSV: TOpenDialog;
    edtFilenameBefore: TEdit;
    edtFilenameAfter: TEdit;
    edtSeparator: TEdit;
    edtTablename: TEdit;
    lblHeaderRequired: TLabel;
    lblFilenameBefore: TLabel;
    lblFilenameAfter: TLabel;
    lblInfo: TLabel;
    lblInfo2: TLabel;
    lblOutput: TLabel;
    lblOutputLink: TLabel;
    lblSeparator: TLabel;
    lblTablename: TLabel;
    rbSeparatorEdit: TRadioButton;
    rbSeparatorTab: TRadioButton;
    statusbar: TStatusBar;
    procedure btnGenerateSyncClick(Sender: TObject);
  private
    { private declarations }
  public
    { public declarations }
  end;

var
  fromCSVtoSQL: TfromCSVtoSQL;

implementation

{$R *.lfm}

{ TfromCSVtoSQL }

procedure TfromCSVtoSQL.btnGenerateSyncClick(Sender: TObject);
begin

end;

end.

