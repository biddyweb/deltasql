package org.deltasql.dbredactor;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;


public class DBAccess {
    
    protected Configuration conf;
    Connection connection;
    
    public DBAccess(Configuration conf){
        this.conf = conf;
    }
    
    protected void finalize() throws Throwable
    {
      //do finalization here
      close();
      super.finalize(); //not necessary if extending Object.
    } 
    
    
    public void open() throws SQLException{
        if(connection  == null) connection = getConnection();
    }
    
    public void close(){
        if(connection != null)
        try{ connection.close(); }catch (Exception e) { }
        connection = null;
    }

    public Connection getConnection() throws SQLException {
            return this.getConnection(conf.getDatabase(), conf.getUsername(), conf.getPassword());
    }

    public Connection getConnection(String database, String username, String password) throws SQLException {
    	 if (conf.getDatabaseType().equals("oracle")) {
      	   DriverManager.registerDriver(new oracle.jdbc.driver.OracleDriver());
         } else 
         if (conf.getDatabaseType().equals("mysql")) {
             DriverManager.registerDriver(new com.mysql.jdbc.NonRegisteringDriver());	
         } else
         if (conf.getDatabaseType().equals("postgresql")) {
                 DriverManager.registerDriver(new org.postgresql.Driver());	
         } else 
    	 if (conf.getDatabaseType().equals("sqlserver")) {
             DriverManager.registerDriver(new net.sourceforge.jtds.jdbc.Driver());	
         } else
         if (conf.getDatabaseType().equals("sybase")) {
                 DriverManager.registerDriver(new net.sourceforge.jtds.jdbc.Driver());	
         } 
         else 
      	   throw new IllegalArgumentException("Unknown or unsupported database type ("+conf.getDatabaseType()+")");
       return  DriverManager.getConnection(database, username, password);
    }
    
    
    public boolean retrieveProjectDetailsFromSchema(){
        PreparedStatement projectVersion = null;
        ResultSet rs = null;
        try {
            open();
            
            projectVersion = connection.prepareStatement("SELECT * FROM "+conf.getSynctable()+" ORDER BY versionnr DESC");
            
            rs = projectVersion.executeQuery();
            if (rs.next()) {
                conf.setProjectVersion(rs.getInt("versionnr"));
                conf.setProjectName(rs.getString("projectname"));
                conf.setSource(rs.getString("branchname"));
            }
            return true;
        }catch (SQLException e) {
            System.out.println(e);
            return false;
        }finally {
            if (projectVersion != null) try {projectVersion.close();} catch (SQLException e) { /* nothing we can do */ }
            if (rs != null) try { rs.close(); } catch (SQLException e) { /* nothing we can do */ }
        }
        
    }
    
    
    public void updateProjectVersion(String projectName, int version){
        PreparedStatement projectVersion = null;
        try {
            open();
            
            projectVersion = connection.prepareStatement("update TBSYNCHRONIZE set version = ? where projectName = ? ");
            projectVersion.setInt(1, version);
            projectVersion.setString(2, projectName);
            projectVersion.executeUpdate();
            
        }catch (SQLException e) {
            System.out.println(e);
        }finally {
            if (projectVersion != null) try {projectVersion.close();} catch (SQLException e) { /* nothing we can do */ }
        }
        
    }
    
    public void insertProjectVersion(String projectName, int version){
        PreparedStatement projectVersion = null;
        try {
            open();
            
            projectVersion = connection.prepareStatement("insert into TBSYNCHRONIZE (version, projectName) values(?,?) ");
            projectVersion.setInt(1, version);
            projectVersion.setString(2, projectName);
            projectVersion.executeUpdate();
            
        }catch (SQLException e) {
            System.out.println(e);
        }finally {
            if (projectVersion != null) try {projectVersion.close();} catch (SQLException e) { /* nothing we can do */ }
        }
        
    }
    
    
    public void executeScript(String fileName) throws IOException, SQLException{
        File file = new File(fileName);
        if(!file.exists()) {
            System.out.println("file "+fileName+ " does not exists!");
            return;
        }
        
        System.out.println("exec "+fileName);
        Statement stat = null;
        try {
            stat = loadScript(file);
            execute(stat);
        }catch (IOException e) {
            System.out.println(e);
            throw e;
        }catch (SQLException e) {
            System.out.println(e);
            throw e;
        }finally {
            if (stat != null) try {stat.close();} catch (SQLException e) { /* nothing we can do */ }
        }
        
    }
    


    

    public final static char QUERY_ENDS = ';';

    protected Statement loadScript(File script) throws IOException, SQLException {
        open();
        Statement stat = connection.createStatement();
        BufferedReader reader = new BufferedReader(new FileReader(script));
        String line;
        StringBuffer query = new StringBuffer();
        boolean queryEnds = false;

        while ((line = reader.readLine()) != null) {
//            if (isComment(line))
//                continue;
//            queryEnds = checkStatementEnds(line);
            query.append(line);
//            if (queryEnds) {
//                stat.addBatch(query.toString());
//                query.setLength(0);
//            }
        }
//        stat.addBatch(query.toString());
        connection.prepareCall(query.toString()).executeUpdate();
        return stat;
    }

    private boolean isComment(String line) {
        if ((line != null) && (line.length() > 0))
            return (line.charAt(0) == '#');
        return false;
    }

    public void execute(Statement stat) throws IOException, SQLException {
        stat.executeBatch();
    }

    private boolean checkStatementEnds(String s) {
        return (s.indexOf(QUERY_ENDS) != -1);
    }

}
