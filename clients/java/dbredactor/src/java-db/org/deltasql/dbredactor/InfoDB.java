package org.deltasql.dbredactor;

import java.io.IOException;
import java.sql.SQLException;

public class InfoDB extends SynchronizeDB {
	

	public static void main(String[] args) throws IOException, InterruptedException, SQLException {
    	System.out.println("dbsync info");
    	System.out.println("");
		InfoDB idb = new InfoDB();
    	idb.cleanUp();
		idb.retrieveProjectDetails();
    	System.out.println("");
        idb.printProjectDetails();
        
        int currentVersion = idb.getConfiguration().getProjectVersion();
        int deltasqlVersion = idb.retrieveCurrentProjectVersionOnDeltasql();
        idb.isUpdateNeeded(currentVersion, deltasqlVersion); 
    }
    

}
