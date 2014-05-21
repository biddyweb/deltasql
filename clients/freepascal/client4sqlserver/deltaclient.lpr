program deltaclient;

{$mode objfpc}{$H+}

uses
  {$IFDEF UNIX}{$IFDEF UseCThreads}
  cthreads,
  {$ENDIF}{$ENDIF}
  Interfaces, // this includes the LCL widgetset
  Forms, deltaclientunit, configurations, datastructure, deltautils,
  settingsunit;

begin
  Application.Initialize;
  Application.CreateForm(TDeltaForm, DeltaForm);
  Application.CreateForm(TSettingsForm, SettingsForm);
  Application.Run;
end.

