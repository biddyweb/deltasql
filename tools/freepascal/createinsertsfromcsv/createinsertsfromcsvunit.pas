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
    edtSeparator: TEdit;
    edtFilename: TEdit;
    lblFilename: TLabel;
    lblSeparator: TLabel;
    lblOutput: TLabel;
    lblInfo: TLabel;
    lblOutputLink: TLabel;
    dlgOpen: TOpenDialog;
    procedure btnGenerateClick(Sender: TObject);
    procedure btnSelectFileNameClick(Sender: TObject);
    procedure lblOutputLinkClick(Sender: TObject);
  private
    outputFile : AnsiString;
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
              begin
               generateInserts;
              end
            else
              ShowMessage('ERROR: could not locate the filename! ('+edtFileName.Text+')');
        end
     else ShowMessage('Please select an input filename first with "..."');
end;


procedure TfrmCreateInserts.generateInserts;
var F, G : TextFile;
begin
  outputFile := ChangeFileExt(edtFileName.Text, '.sql');
  ShowMessage(outputFile);

  AssignFile(F, edtFileName.Text);
  AssignFile(G, outputFile);
  try
    Reset(F);
    Rewrite(G);

  finally
    CloseFile(F);
    CloseFile(G);
  end;
end;

procedure TfrmCreateInserts.lblOutputLinkClick(Sender: TObject);
begin
  //
end;

end.

