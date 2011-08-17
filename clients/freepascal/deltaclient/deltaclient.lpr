program deltaclient;

{$mode objfpc}{$H+}

uses
  {$IFDEF UNIX}{$IFDEF UseCThreads}
  cthreads,
  {$ENDIF}{$ENDIF}
  Interfaces, // this includes the LCL widgetset
  Forms, deltaclientunit, LResources
  { you can add units after this }, configurations, datastructure, parsers;

{$IFDEF WINDOWS}{$R deltaclient.rc}{$ENDIF}

begin
  {$I deltaclient.lrs}
  Application.Initialize;
  Application.CreateForm(TDeltaForm, DeltaForm);
  Application.Run;
end.

