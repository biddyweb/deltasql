package org.deltasql.dbredactor;


public class Configuration {
	
	// deltasql server
	private String deltaServerUrl;
	private String dbredactorUser;
    
	// connection properties
    private String name ;
    private String database ;
    private String username ;
    private String password ;
    private String synctable;
    
    // project properties
    private int projectVersion;
    private String projectName;
    private String source;
    private String target;
    
    private String databaseType;
    
    
    public String getDatabase() {
        return database;
    }
    public void setDatabase(String database) {
        this.database = database;
    }
    public String getPassword() {
        return password;
    }
    public void setPassword(String password) {
        this.password = password;
    }
    public String getUsername() {
        return username;
    }
    public void setUsername(String username) {
        this.username = username;
    }
  
    public String getName() {
        return name;
    }
    public void setName(String name) {
        this.name = name;
    }
	public String getTarget() {
		return target;
	}

	public void setTarget(String target) {
		this.target = target;
	}

	public String getSynctable() {
		return synctable;
	}
	public void setSynctable(String synctable) {
		this.synctable = synctable;
	}
	public String getProjectName() {
		return projectName;
	}
	public void setProjectName(String projectName) {
		this.projectName = projectName;
	}
	public int getProjectVersion() {
		return projectVersion;
	}
	public void setProjectVersion(int projectVersion) {
		this.projectVersion = projectVersion;
	}
	public String getSource() {
		return source;
	}
	public void setSource(String source) {
		this.source = source;
	}
	public String getDeltaServerUrl() {
		return deltaServerUrl;
	}
	public void setDeltaServerUrl(String deltaServerUrl) {
		this.deltaServerUrl = deltaServerUrl;
	}
	public String getDatabaseType() {
		return databaseType;
	}
	public void setDatabaseType(String databaseType) {
		this.databaseType = databaseType;
	}
	/**
	 * @return the dbredactorUser
	 */
	public String getDbredactorUser() {
		return dbredactorUser;
	}
	/**
	 * @param dbredactorUser the dbredactorUser to set
	 */
	public void setDbredactorUser(String dbredactorUser) {
		this.dbredactorUser = dbredactorUser;
	}
     

}
