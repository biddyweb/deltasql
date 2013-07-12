unit loggers;
{
 A simple, but functional logger

 This unit is released under GNU Public License (GPL)
 (c) 2002-2010 by the GPU Development Team
 (c) 2010 by HB9TVM

}
interface

uses SysUtils, {FileUtil,} syncobjs;

const
   LVL_FATAL    = 60;
   LVL_SEVERE   = 50;
   LVL_ERROR    = 40;
   LVL_WARNING  = 30;
   LVL_INFO     = 20;
   LVL_DEBUG    = 10;

   LVL_DEFAULT = LVL_DEBUG;

type TLogger = class(TObject)
  public
    constructor Create(path, filename : String); overload;
    constructor Create(path, filename : String; loglevel : Longint); overload;
    constructor Create(path, filename, filebkp : String; loglevel, maxfilesize : Longint); overload;
    destructor Destroy;

    procedure setLogLevel(loglevel : Longint);
    function  getLogLevel : Longint;
    function  logLvlToStr(level : Longint) : String;
    procedure log(severity : Longint; logStr : AnsiString); overload;
    procedure log(logStr : AnsiString); overload;
    procedure logCR;

  private
    current_log_level_ : Longint;
    filename_,
    filename_backup_,
    path_,
    full_name_ : String;
    max_filesize_  : Longint;

    F_  : TextFile;

    CS_ : TCriticalSection;

end;

implementation

constructor TLogger.Create(path, filename : String); overload;
begin
  Create(path, filename, LVL_DEFAULT);
end;

constructor TLogger.Create(path, filename : String; loglevel : Longint); overload;
begin
  Create(path, filename, filename+'.bkp', LVL_DEFAULT, 1024*1024);
end;

constructor TLogger.Create(path, filename, filebkp : String; loglevel, maxfilesize : Longint); overload;
begin
  inherited Create();
  CS_ := TCriticalSection.Create;

  current_log_level_ := loglevel;
  filename_        := filename;
  filename_backup_ := filebkp;
  path_ := path;
  max_filesize_ := maxfilesize;
  full_name_ := path+ PathDelim + filename;

  if not DirectoryExists(path_) then
    MkDir(path_);

  if not FileExists(full_name_) then
    begin
     AssignFile(F_, full_name_);
     Rewrite(F_);
     CloseFile(F_);
    end;
end;

destructor  TLogger.Destroy;
begin
  CS_.Free;
end;

procedure TLogger.setLogLevel(loglevel : Longint);
begin
  current_log_level_ := loglevel;
end;

function TLogger.getLogLevel : Longint;
begin
  Result := current_log_level_;
end;


function TLogger.logLvlToStr(level : Longint) : String;
begin
  case level of
   LVL_FATAL   : Result := 'FATAL  ';
   LVL_SEVERE  : Result := 'SEVERE ';
   LVL_ERROR   : Result := 'ERROR  ';
   LVL_WARNING : Result := 'WARNING';
   LVL_INFO    : Result := 'INFO   ';
   LVL_DEBUG   : Result := 'DEBUG  ';
   else
    raise Exception.Create('Undefined log level in logLvlToStr');
  end;
end;

procedure TLogger.log(logStr : AnsiString); overload;
begin
  log(LVL_DEFAULT, logStr);
end;

procedure TLogger.log(severity : Longint; logStr : AnsiString); overload;
var backup : Boolean;
begin
  if severity<current_log_level_ then Exit;
  CS_.Enter;

  backup := false;
  //backup := FileSize(full_name_)>max_filesize_;
  //if backup then
  //     CopyFile(full_name_, path_+PathDelim+filename_backup_);

  try
   AssignFile(F_, full_name_);
   if backup then Rewrite(F_) else Append(F_);
   WriteLn(F_, DateToStr(now)+' '+TimeToStr(now)+' '+logLvlToStr(severity)+'| '+logStr);
  finally
    CloseFile(F_);
  end;
  CS_.Leave;
end;

procedure TLogger.logCR;
begin
  CS_.Enter;
  try
   AssignFile(F_, full_name_);
   Append(F_);
   WriteLn(F_);
  finally
    CloseFile(F_);
  end;

  CS_.Leave;
end;

end.

