unit downloadutils;


interface

uses
  sysutils, strutils, httpsend, Classes, loggers;

const
  HTTP_DOWNLOAD_TIMEOUT = 10000; // 10 seconds
  HTTP_USER_AGENT = 'Mozilla/4.0 (compatible; Synapse for GPU at http://gpu.sourceforge.net)';


function downloadToFile(url : AnsiString; targetPath, targetFile, proxy, port, logHeader : String; var logger : TLogger) : Boolean;
function downloadToStream(url : AnsiString; proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
function downloadToFileOrStream(url : AnsiString; targetPath, targetFile, proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;

procedure convertLFtoCRLF(var instream, outstream : TMemoryStream; var logger : TLogger); overload;
procedure convertLFtoCRLF(filein, fileout : String; var logger : TLogger); overload;
function getProxyArg(noargs : Boolean) : String;
function parseHttpResult(var HTTP : THTTPSend; var logger : TLogger; logHeader : String) : Boolean;

implementation

function downloadToFile(url : AnsiString; targetPath, targetFile, proxy, port, logHeader : String; var logger : TLogger) : Boolean;
var dummy : TMemoryStream;
begin
 dummy := nil;
 Result := downloadToFileOrStream(url, targetPath, targetFile, proxy, port, logHeader, logger, dummy);
end;

function downloadToStream(url : AnsiString; proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
begin
 Result := downloadToFileOrStream(url, '', '', proxy, port, logHeader, logger, stream);
end;


function parseHttpResult(var HTTP : THTTPSend; var logger : TLogger; logHeader : String) : Boolean;
begin
  Result := true;
  logger.log(LVL_DEBUG, logHeader+'HTTP Result was '+IntToStr(Http.Resultcode)+' '+Http.Resultstring);
  logger.log(LVL_DEBUG, logHeader+'HTTP Header is ');
  logger.log(LVL_DEBUG, Http.headers.text);
  if (Http.Resultcode<>200) then
         begin
           if (Http.Resultcode=404) then logger.log(LVL_SEVERE, 'Page not found.')
           else
           if (Http.Resultcode=403) then logger.log(LVL_SEVERE, 'Access to page forbidden.')
           else
           if (Http.Resultcode=503) then logger.log(LVL_SEVERE, 'Service unavailable. Server overloaded')
           else
             logger.log(LVL_SEVERE, 'Strange HTTP result code, unusual!!!! ('+Http.Resultstring+')');
           Result := false;
         end
end;

function downloadToFileOrStream(url : AnsiString; targetPath, targetFile, proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
var
    Http        : THTTPSend;
    saveFile    : Boolean;
    temp        : TMemoryStream;
begin
  Result   := false;
  saveFile := (stream = nil);
  logger.log(LVL_DEBUG, logHeader+'Execute method started.');
  logger.log(LVL_INFO, logHeader+'Retrieving data from URL: '+url);

  HTTP := THTTPSend.Create;
  HTTP.Timeout   := HTTP_DOWNLOAD_TIMEOUT;
  HTTP.UserAgent := HTTP_USER_AGENT;

  if Trim(proxy)<>'' then HTTP.ProxyHost := proxy;
  if Trim(port)<>'' then HTTP.ProxyPort := port;

  logger.log(LVL_DEBUG, logHeader+'User agent is '+HTTP.UserAgent);

  try
    if not HTTP.HTTPMethod('GET', url) then
      begin
	logger.log(LVL_SEVERE, 'HTTP Error '+logHeader+IntToStr(Http.Resultcode)+' '+Http.Resultstring);
        Result := false;
      end
    else
      begin
        Result := parseHttpResult(Http, logger, logHeader);
        if Result then
         begin
           if saveFile then
            begin
               HTTP.Document.SaveToFile(targetPath+targetFile);
               logger.log(LVL_INFO, logHeader+'New file created at '+targetPath+targetFile);
            end
           else
            begin
               HTTP.Document.SaveToStream(stream);
               logger.log(LVL_DEBUG, logHeader+'New stream created');
            end;
        end; // if Result
      end; // if not HTTPMethod

  except
    on E : Exception do
      begin
       Result := false;
       logger.log(LVL_SEVERE, logHeader+'Exception '+E.Message+' thrown.');
      end;
  end;

  HTTP.Free;
end;


procedure convertLFtoCRLF(var instream, outstream : TMemoryStream; var logger : TLogger);  overload;
var i, size : Int64;
    by      : Byte;
    str     : AnsiString;
begin
  logger.log(LVL_DEBUG, 'Performing LFtoCRLF conversion');
  size := instream.getSize;
  logger.log(LVL_DEBUG, 'Stream size: '+IntToStr(size));
  instream.Position := 0;

  i:=0;
  while(i<size) do
     begin
       by := instream.readByte();
       if (by=10) then
          begin
            outstream.writeByte(13); // CR
            outstream.writeByte(10);  // LF
          end
       else
          outstream.WriteByte(by);
       i := i + 1;
     end;

  outstream.Position := 0;
  logger.log(LVL_DEBUG, 'LFtoCRLF conversion over');
end;

procedure convertLFtoCRLF(filein, fileout : String; var logger : TLogger); overload;
var F, G : Textfile;
    str  : AnsiString;
begin
logger.log(LVL_DEBUG, 'Performing LFtoCRLF conversion');
try
  AssignFile(F, filein);
  AssignFile(G, fileout);
  Reset(F);
  Rewrite(G);
  while not Eof(F) do
    begin
      ReadLn(F, str);
      WriteLn(G, str);
    end;
 logger.log(LVL_DEBUG, 'LFtoCRLF conversion over');
finally
  CloseFile(F);
  CloseFile(G);
end;

end;

function getProxyArg(noargs : Boolean) : String;
begin
 if noargs then
   Result := '?randomseed='+IntToStr(Trunc(Random*10000))
 else
   Result := '&randomseed='+IntToStr(Trunc(Random*10000));
end;

end.
