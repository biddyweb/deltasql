unit deltaclientunit;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, FileUtil, LResources, Forms, Controls, Graphics, Dialogs,
  StdCtrls;

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
  private
    { private declarations }
  public
    { public declarations }
  end; 

var
  DeltaForm: TDeltaForm;

implementation

initialization
  {$I deltaclientunit.lrs}

end.

