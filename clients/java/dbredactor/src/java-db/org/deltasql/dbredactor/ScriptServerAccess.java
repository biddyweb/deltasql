package org.deltasql.dbredactor;

import java.io.BufferedReader;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

public class ScriptServerAccess {
	public final static String DEFAULT_SCRIPT = "script.sql";
	public final static String DEFAULT_VERSION_PROPERTY_FILE = "projectversion.properties";
	
	Configuration conf;
	private String scriptFileName = null;
	
		
	ScriptServerAccess(Configuration conf) {
		this.conf = conf;
	}
	
    //  Download page at given URL to a given filename
    private void downloadPage(URL pageUrl, String filename) {
      
      PrintStream pDefault = null;
      FileOutputStream outStreamDefault = null;
      
      try {
        // Open connection to URL for reading.
        BufferedReader reader = new BufferedReader(new InputStreamReader(
            pageUrl.openStream()));
        
        outStreamDefault = new FileOutputStream(filename);
        pDefault = new PrintStream(outStreamDefault);
        
        // Read page into buffer.
        String line;
        while ((line = reader.readLine()) != null) {
          pDefault.println(line);
        }
      } catch (Exception e) {
      } finally {
    	  if (pDefault!=null) pDefault.close();
    	  if (outStreamDefault!=null)
			try {
				outStreamDefault.close();
			} catch (IOException e) {
				// nothing we can do
			}
      }
    }    
    
    public void downloadScriptPage() throws MalformedURLException {	
    	String projectVersion = String.valueOf(conf.getProjectVersion());
    	
    	String urlStr = conf.getDeltaServerUrl();
    	if (!urlStr.endsWith("/")) urlStr += "/";
    	
    	urlStr += "dbsync_automated_update.php?client=dbredactor-client";
    	urlStr += "&user=";
    	urlStr += URLEncoder.encode(conf.getDbredactorUser());
    	urlStr += "&project=";
    	urlStr += URLEncoder.encode(conf.getProjectName());
    	urlStr += "&version=";
    	urlStr += projectVersion;
    	urlStr += "&frombranch=";
        urlStr += URLEncoder.encode(conf.getSource());
        urlStr += "&tobranch=";
        urlStr += URLEncoder.encode(conf.getTarget());
        urlStr += "&comment=";
        urlStr += URLEncoder.encode("This update is for "+conf.getName());
        urlStr += "&dbtype=";
        urlStr += URLEncoder.encode(conf.getDatabaseType());
        urlStr += "&schemaname=";
        urlStr += URLEncoder.encode(conf.getName());
        
    	this.scriptFileName = "scripts/"+conf.getUsername().replace(" ", "_")+"@"+conf.getName().replace(" ", "_")+"_from_"+conf.getProjectVersion()+"_"+conf.getSource()+".sql";
        
        URL url = new URL(urlStr);
    	downloadPage(url, DEFAULT_SCRIPT);
    	downloadPage(url, this.scriptFileName);  	
    }
    
    public void downloadCurrentVersionPage() throws MalformedURLException {
    	String urlStr = conf.getDeltaServerUrl();
    	if (!urlStr.endsWith("/")) urlStr += "/";
    	
    	urlStr += "dbsync_automated_currentversion.php?project=";
    	urlStr += conf.getProjectName();
    	URL url = new URL(urlStr);
    	downloadPage(url, DEFAULT_VERSION_PROPERTY_FILE);
    }

	/**
	 * @return the scriptFileName
	 */
	public String getScriptFileName() {
		return scriptFileName;
	}
   

}
