unit uploadutils;

interface

uses
  sysutils, strutils, httpsend, downloadutils, Classes, loggers, synautil;

const
  HTTP_UPLOAD_TIMEOUT = 60000; // 60 seconds

function uploadFromFile(url : AnsiString; sourcePath, sourceFile, proxy, port, logHeader : String; var logger : TLogger) : Boolean;
function uploadFromStream(url : AnsiString; proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
function uploadFromFileOrStream(url : AnsiString; sourcePath, sourceFile, proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;

implementation

function uploadFromFile(url : AnsiString; sourcePath, sourceFile, proxy, port, logHeader : String; var logger : TLogger) : Boolean;
var dummy : TMemoryStream;
begin
 dummy := nil;
 Result := uploadFromFileOrStream(url, sourcePath, sourceFile, proxy, port, logHeader, logger, dummy);
end;

function uploadFromStream(url : AnsiString; proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
begin
 Result := uploadFromFileOrStream(url, '', '', proxy, port, logHeader, logger, stream);
end;

function uploadFromFileOrStream(url : AnsiString; sourcePath, sourceFile, proxy, port, logHeader : String; var logger : TLogger; var stream : TMemoryStream) : Boolean;
// taken from HTTP Demo Unit1.pas::ProxyHttpPostFile(const URL, FieldName, FileName: string; const Data: TStream; const ResultData: TStrings): Boolean;
const
  CRLF = #$0D + #$0A;

var
    Http        : THTTPSend;
    fromFile    : Boolean;
    temp        : TMemoryStream;
    Bound, s,
    FieldName   : AnsiString;
    ResultData  : TStringList;
    i           : Longint;
begin
  Result   := false;
  fromFile := (stream = nil);
  logger.log(LVL_DEBUG, logHeader+'Execute method started.');
  fieldName := 'myfile';  // on PHP use then
                          // $_FILES['myfile']['type'], $_FILES['myfile']['size'],$_FILES['myfile']['tmp_name'], etc...

  if fromFile then
    logger.log(LVL_INFO, logHeader+'Pushing file '+sourcePath+sourceFile+' to URL: '+url)
  else
    logger.log(LVL_INFO, logHeader+'Pushing memory stream to URL: '+url);

  HTTP := THTTPSend.Create;
  HTTP.Timeout   := HTTP_UPLOAD_TIMEOUT;
  HTTP.UserAgent := HTTP_USER_AGENT;

  if Trim(proxy)<>'' then HTTP.ProxyHost := proxy;
  if Trim(port)<>'' then HTTP.ProxyPort := port;
  logger.log(LVL_DEBUG, logHeader+'User agent is '+HTTP.UserAgent);

  try
   temp  := TMemoryStream.Create();
   ResultData := TStringList.Create;
   Bound := IntToHex(Random(MaxInt), 8) + '_Synapse_boundary';

   if fromFile then
     temp.LoadFromFile(sourcePath+sourceFile)
   else
     temp.LoadFromStream(stream);
    temp.Position := 0;

    s := '--' + Bound + CRLF;
    s := s + 'content-disposition: form-data; name="' + FieldName + '";';
    s := s + ' filename="' + sourceFile +'"' + CRLF;
    s := s + 'Content-Type: application/octet-string' + CRLF + CRLF;

    WriteStrToStream(HTTP.Document, s);
    HTTP.Document.CopyFrom(temp, 0);
     s := CRLF + '--' + Bound + '--' + CRLF;
    WriteStrToStream(HTTP.Document, s);
    HTTP.MimeType := 'multipart/form-data, boundary=' + Bound;
    Result := HTTP.HTTPMethod('POST', URL);

   if not Result then
      begin
	logger.log(LVL_SEVERE, 'HTTP Error '+logHeader+IntToStr(Http.Resultcode)+' '+Http.Resultstring);
        Result := false;
      end
     else
       begin
         logger.log(LVL_DEBUG, logHeader+'Result data is:');
         HTTP.Document.Position := 0;
         ResultData.LoadFromStream(HTTP.Document);

         for i:=0 to ResultData.Count-1 do
           logger.log(LVL_DEBUG, logHeader+IntToStr(i)+': '+ResultData.Strings[i]);

         if (ResultData.Count=1) and (ResultData.Strings[0]='OK') then
              begin
                logger.log(LVL_INFO, logHeader+'Upload succesful');
                Result := true;
              end
            else
              begin
                logger.log(LVL_SEVERE, logHeader+'Upload failed!');
                Result := false;
              end;

       end;

  except
    on E : Exception do
      begin
       Result := false;
       logger.log(LVL_SEVERE, logHeader+'Exception '+E.Message+' thrown.');
      end;
  end;

  temp.Free;
  HTTP.Free;
  ResultData.Free;
  logger.log(LVL_DEBUG, logHeader+'Execute method finished.');
end;


end.
