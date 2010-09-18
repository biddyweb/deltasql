package org.deltasql.dbredactor;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.sql.SQLException;
import java.util.Properties;


public class SynchronizeDB {
    
    private Configuration conf;
    private DBAccess dbaccess;
    private ScriptServerAccess scriptServer;
    
    public SynchronizeDB(){
        init();
    }

    
    private void init() {
        conf = createConfiguration();
        //log info
  
        System.out.println("db name :"+conf.getName());
        System.out.println("username:"+conf.getUsername());
        System.out.println("passwd  :"+conf.getPassword());
        
        dbaccess = new DBAccess(conf);
        scriptServer = new ScriptServerAccess(conf);
    }

    /**
     * Retrieve info source from configuration file
     */
    public Configuration createConfiguration() {
    	Configuration conf = new Configuration();
        
    	String resource = null;
        try {
            Properties buildProperties = new Properties();
            buildProperties.load(new FileInputStream("build.properties"));
            String configSet = buildProperties.getProperty("config.set", "sample");
            resource = "src/config/"+configSet +"/deltasql.properties";
            conf.setDeltaServerUrl(buildProperties.getProperty("deltasql.server.url", "http://127.0.0.1/deltabase"));
            conf.setDbredactorUser(buildProperties.getProperty("dbredactor.user", ""));
        	
    	} catch (Exception e) {
            throw new RuntimeException(e.getMessage(), e);
        }
        try {
            Properties datasourceProperties = new Properties();
            datasourceProperties.load(new FileInputStream(resource));
            String name   = datasourceProperties.getProperty("connection.name", "");
            String databaseType = datasourceProperties.getProperty("connection.database.type", "");
            String database  = datasourceProperties.getProperty("connection.database.url", "");
                	
            String username  = datasourceProperties.getProperty("connection.username", "");
            String password  = datasourceProperties.getProperty("connection.password", "");
            String target    = datasourceProperties.getProperty("project.target", "");
            String synctable = datasourceProperties.getProperty("project.synctable", "TBSYNCHRONIZE");
           
            conf.setDatabaseType(databaseType.toLowerCase());
            conf.setDatabase(database);
            conf.setUsername(username);
            conf.setPassword(password);
            conf.setName(name);
            conf.setTarget(target);
            conf.setSynctable(synctable);
            
            System.out.println("DeltaSQL Server Url: "+conf.getDeltaServerUrl());
            System.out.println("Database: "+database);
            System.out.println("Username: "+username);
            
    	} catch (Exception e) {
            throw new RuntimeException(e.getMessage(), e);
        }
    	return conf;
    }
    
    public Configuration getConfiguration() {
    	return conf;
    }
    

    public void retrieveProjectDetails() {
    	dbaccess.retrieveProjectDetailsFromSchema();
    }
    
    public int retrieveCurrentProjectVersionOnDeltasql() throws FileNotFoundException, IOException {
    	scriptServer.downloadCurrentVersionPage();
    	
    	int version = -1;
    	try {
    		Properties versionProperties = new Properties();
    		versionProperties.load(new FileInputStream(ScriptServerAccess.DEFAULT_VERSION_PROPERTY_FILE));
    		String configSet = versionProperties.getProperty("project.version", "0");
       
            version = Integer.parseInt(configSet);
    	}
    	catch (FileNotFoundException e) {
    		System.out.println("Could not access DeltaSQL Server.");
    		System.out.println("Please verify DeltaSQL URL ("+conf.getDeltaServerUrl()+").");
    	}
        return version;
    }
    
    public void printProjectDetails() {
    	System.out.println("Project Name: "+conf.getProjectName());
        System.out.println("Currently at version "+conf.getProjectVersion());
        System.out.println("Branch Name is "+conf.getSource());
    }
    
    public boolean isUpdateNeeded(int currentVersion, int deltasqlVersion) {
    	System.out.println("Version on DeltaSQL is: "+deltasqlVersion);
    	System.out.println("Version on schema is: "+currentVersion);
    	if (deltasqlVersion>currentVersion) {
    		if (conf.getSource().equals("HEAD")) {
    			System.out.println("A dbsync update is needed");
    		} else {
    			System.out.println("A dbsync update might be needed");	
    		}
    		return true;
    	} else 
    	if (deltasqlVersion==currentVersion) {
    		System.out.println("No updates are needed");
    		return false;
    	} else {
    	    System.out.println("Internal error deltabaseVersion<currentVersion");
    		return false;
    	}
    }
    
    public void cleanUp() {
    	File f = new File(ScriptServerAccess.DEFAULT_SCRIPT);
    	f.delete();
    	File f2 = new File(ScriptServerAccess.DEFAULT_VERSION_PROPERTY_FILE);
    	f2.delete();
    }
    
    public void synchronizeProject() throws IOException, InterruptedException, SQLException{
        
    	cleanUp();
        System.out.println("dbsync update");
        System.out.println();
        retrieveProjectDetails();
        printProjectDetails();
        System.out.println();
        
        int currentVersion = conf.getProjectVersion();
        // if the target branch is not specified, we set
        // target=source
        if (conf.getTarget().equals("")) {
        	conf.setTarget(conf.getSource());
        }
        
        int deltasqlVersion = retrieveCurrentProjectVersionOnDeltasql();
        if (!isUpdateNeeded(currentVersion, deltasqlVersion)) return; 
        
        System.out.println();
        System.out.println("Downloading Script from Deltabase Server for project "+conf.getProjectName()+"...");
        // now we need to touch the deltasql url
        scriptServer.downloadScriptPage();
        
        /*
        // Following code does not work, I think the JDBC driver cannot execute
        // complex queries
        
        System.out.println();
        System.out.println("Executing Script into Schema "+conf.getUsername()+":"+conf.getTnsName());
        System.out.println("Script path and name are "+scriptServer.getScriptFileName()+"...");
        dbaccess.executeScript(scriptServer.getScriptFileName());
        
        System.out.println();
        retrieveProjectDetails();
        int newVersion = conf.getProjectVersion();
        if (newVersion>currentVersion) {
        	System.out.println("Schema Update succesful");
        	System.out.println("New schema version is "+newVersion);
        	System.out.println("New source branch is "+conf.getSource());
        } else
        if (newVersion==currentVersion) {
        	System.out.println("No Schema Update necessary");
        	System.out.println("Current schema version is "+newVersion);
        	System.out.println("Current source branch is "+conf.getSource());
        } else {
        	System.out.println("Internal error: newVersion<currentVersion");
        }
        */
        
    }
    
    
    public static void main(String[] args) throws IOException, InterruptedException, SQLException {
    	SynchronizeDB sdb = new SynchronizeDB();
        sdb.synchronizeProject();
    }

}
