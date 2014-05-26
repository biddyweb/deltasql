unit configurations;

{$mode objfpc}{$H+}
{ $DEFINE LINUX_CONF}

interface

uses
  Classes, SysUtils, iniFiles;

type TConfiguration = class(TObject)
   public
      url,
      proxy,
      port,
      editor,
      user,
      defaultProject,
      defaultFrom,
      defaultTo  : String;

      showHidden,
      copyScriptToClipboard : Boolean;

      constructor Create(filename : String);
      destructor destroy;
      procedure loadFromIniFile();
      procedure saveToIniFile();

   private
      filename_ : String;
      ini_      : TIniFile;
end;

var conf : TConfiguration;

implementation

constructor TConfiguration.Create(filename : String);
begin
  filename_ := filename;
  ini_ := TIniFile.Create(filename_);
  loadFromIniFile();
end;

destructor TConfiguration.destroy;
begin
 ini_.Free;
end;

procedure TConfiguration.loadFromIniFile();
begin
  url   := ini_.ReadString('Communication','URL', 'http://deltasql.sourceforge.net/deltasql');
  proxy := ini_.ReadString('Communication','Proxy', '');
  port  := ini_.ReadString('Communication','Port', '');

  {$IFDEF LINUX_CONF}
  editor := ini_.ReadString('General', 'Editor', 'gedit');
  {$ELSE}
  editor := ini_.ReadString('General', 'Editor', 'notepad');
  {$ENDIF}
  showHidden := ini_.ReadBool('General', 'ShowHidden', false);
  copyScriptToClipboard := ini_.ReadBool('General', 'CopyScriptToClipboard', true);

  user := ini_.ReadString('Credentials','User','deltauser');

  defaultProject := ini_.ReadString('Default', 'Project', '');
  defaultFrom    := ini_.ReadString('Default', 'From', '');
  defaultTo      := ini_.ReadString('Default', 'To', '');
end;

procedure TConfiguration.saveToIniFile();
begin
  ini_.WriteString('Communication', 'URL', url);
  ini_.WriteString('Communication', 'Proxy', proxy);
  ini_.WriteString('Communication', 'Port', port);

  ini_.WriteString('General', 'Editor', editor);
  ini_.WriteBool('General', 'ShowHidden', showHidden);
  ini_.WriteBool('General', 'CopyScriptToClipboard', CopyScriptToClipboard);

  ini_.WriteString('Credentials','User', user);

  ini_.WriteString('Default', 'Project', defaultProject);
  ini_.WriteString('Default', 'From', defaultFrom);
  ini_.WriteString('Default', 'To', defaultTo);
end;

end.

