unit configurations;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils; 

type TConfiguration = class(TObject)
   public
      constructor Create();

      url,
      proxy,
      port,
      editor : String;

      showHidden,
      copyScriptToCliboard : Boolean;
end;

var conf : TConfiguration;

implementation

constructor TConfiguration.Create();
begin
  url := 'http://www.deltasql.org/deltasql';
  proxy := 'proxy.ads.regroup.net';
  port := '8080';
  editor := 'notepad';
  showHidden := false;
  copyScriptToCliboard := true;
end;

end.

