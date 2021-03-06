<?php session_start(); ?>
<html>
<head>
<title>deltasql - Manual</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
include("utils/timing.inc.php");
$startwatch=start_watch();

echo "<h2>Manual for deltasql $deltasql_version</h2>";
?>
<h3>Summary</h3>
<ul>
<li><a href="#db-evolution">Database Evolution Under Control</a></li>
<li><a href="#purpose">Purpose</a></li>
<li><a href="#install-guides">Install Guides</a></li>
<ul>
	<li><a href="#install-server">How to install deltasql Server</a></li>
	<li><a href="#install-deltaclient-windows">How to install deltaclient on Windows (optional)</a></li>
        <li><a href="#install-deltaclient-linux">How to install deltaclient on Linux (optional)</a></li>
        <li><a href="#install-deltaclient">How to install deltaclient (general steps)</a></li>
	<li><a href="#install-dbredactor-client">How to install dbredactor client (optional)</a></li>
    <li><a href="#install-ant-client">How to install the ant client into Eclipse (optional)</a></li>
	<li><a href="#install-bash">How to install the bash client to achieve continouus integration (optional)</a></li>
        <li><a href="#install-pyclient">How to install the Python deltasql client (optional)</a></li>
</ul>
<li><a href="#usage">Usage</a></li>
<ul>
	<li><a href="#usermanagement">User Management</a></li>
	<li><a href="#quickguide">Quick Guide</a></li>
	<li><a href="#projectsandmodules">How to define projects and modules</a></li>
	<li><a href="#whentobranch">When should one branch?</a></li>
	<li><a href="#whentotag">When should one tag?</a></li>
	<li><a href="#syncworks">How synchronization works</a></li>
    <li><a href="#concepts">deltasql Concepts</a></li>
	<li><a href="#tips">Tips</a></li>
    <ul>
       <li><a href="#maintenance">Define script's collections for maintenance tasks</a></li>
       <li><a href="#filter">Filter script - output particular synchronization scripts</a></li>
    </ul>
</ul>
<li><a href="#advanced">Advanced Topics</a></li>
    <ul>
        <li><a href="#insights">Insights into the deltasql Algorithm</a></li>
        <li><a href="#write-client">How to write your own client</a></li>
		<ul>
		  <li><a href="#client-parameters">Client URL parameters</a></li>
		  <li><a href="#xml-examples">XML examples</a></li>
		</ul>
        <li><a href="#structure">Directory structure of the deltasql_1.x.y package</a></li>
        <li><a href="#errors">List of error codes from deltasql Server</a></li>
		<li><a href="#codewalkthrough">Source code walkthrogh</a></li>
        <li><a href="#compiledeltaclient">How to compile deltaclient on Linux, Windows or MacOSX</a></li>
    </ul>
<li><a href="#feedback">Feedback on this document</a></li>	
</ul>


<h2><a name="db-evolution"></a>Database Evolution Under Control</h2>
<h6>(how deltasql works)</h6>
<p>
A strong version control system for databases saves time to developers, who would like to keep their schema updated while developing with minimal effort. 
With a version control for databases, the number of mistakes dued to different schemas or missing scripts is considerably reduced. Critical errors in production due to schema
 inconsistencies disappear, too.
</p>
<p>
deltasql is an Open Source tool to synchronize databases with source code.
While developing middle size or big applications, developers undertake changes to the data model which go along with changes to the source code. From time
  to time, branches of source code are done to stabilize the code which will go to production. A sort of data model branch is also needed.
</p>
<p>  
deltasql provides a simple set of php scripts to be executed on an apache server backed by a mySQL database to collect all scripts which change the data model, and means to handle 
data model branches. The trick is to number the sql scripts and to create on each database instance a table which keeps the number of the latest executed script 
(the table deltasql uses is named TBSYNCHRONIZE). 
</p>
<p> 
 A <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">form</a> allows the user to enter data from the synchronization table and thereafter the needed chain of datamodel updates is computed and shown to the user. The user
 has to manually execute all scripts. It is possible to update development schemas (the HEADs) and production schemas (the branches), to transform a production schema into a development schema and
 vice versa. Also in case of a schema dumped and imported into another database, it is still upgradeable as the synchronization table
 is contained into the copyed schema. However, it is not possible to downgrade a schema back to a previous version. 
</p>
<p> 
 There are deltasql clients (listed in the table above), which automatically collect synchronization data from a given database schema.
 Though deltasql works best with Oracle, PostgreSQL and mySQL schemas, any other database type can use most of deltasql functionality.
</p>

<h2><a name="purpose"></a>Purpose</h2>

<p>deltasql Server allows developers to submit their SQL scripts in a central place. Each time a script is submitted, deltasql assigns 
 a number to it (the script's version). Database administrators can check at which version the database table is, by checking the last inserted row
  in the table TBSYNCHRONIZE. They also can look at the project name in this table. They can then <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">ask</a> the deltasql Server 
  for the currently missing scripts.</p>

<center>
<img src="docs/devel-with-deltasql.jpg" border="0"><br>
<p><i>With deltasql:</i> A developer sends the script to the deltasql server only, 
the exact database state is always known and can be synchronized to any state.</p><br>
</center>

  
<p>When scripts are sent, a database module has to be chosen. A project can consist of one or several modules, as in some companies, they tipically
 use a three-level structure for their source code modules. The first database module is the lowest level and represents
tables which are common for all projects in a company. The middle database module represents the tables of the application which is sold.
 The highest level module contains tables which are needed for the customization of one particular customer, and which are not
needed for other customers.</p>
 
<p>For simple applications, it is enough to specify one module for each project, although deltasql was developed as help in a 
much more complex development environment.</p>

<p>deltasql also supports database branches, which are similar to source code branches. It is possible to choose,
 if a script belongs also to a particular branch. And it is possible to update a branch database to a newer branch, or to the
  development schema represented by the branch named <tt>HEAD</tt>.

<p>deltasql Server is written in such a way, that clients can interface to it and query the database automatically.
 Deltasql is shipped with several clients which easy the interface to database schemas and sql clients, which show latest
  available scripts and which can perform continouus database integration tasks. People in the Open Source community are encouraged to write their own clients, or to partecipate in
  improvements of the server itself.</p>  

<center>
<img src="docs/devel-no-deltasql.jpg" border="0"><br>
<p><i>Without deltasql:</i> A developer has to send his/her scripts to everyone, 
the exact database state is known only to the database owner.</p><br>
</center>

  
<?php  

 if (file_exists($configurationfile)) {
    include("conf/config.inc.php");
 }   
 if ($enterprise_edition==false) {
	echo "<p>If you find the project useful, or if you use deltasql for managing your Open Source project, ";
	echo "you are encouraged to add this button <img src=\"pictures/deltasql-button.jpg\" border=0> to your homepage. Link it to ";
	echo "the project page at <a href=\"http://deltasql.sourceforge.net\">http://deltasql.sourceforge.net</a>."; 
	echo "This might bring some additional traffic and maybe involve others in the project who will improve the quality of ";
	echo "this software. Thanks! </p>";
 }	
?>
  
<h2><a name="install-guides"></a>Install Guides</a></h2>
  
<h3><a name="install-server"></a>Install steps for the Server</h3>

<p>deltasql runs on Apache webserver with the PHP module backed by a mySQL database.</p>

<p>
If you want to run it on windows, you should first download from the Apachefriends.org website <a href="http://www.apachefriends.org/en/xampp.html">XAMPP</a>,
a package which bundles Apache, mySQL and phpMyAdmin (and more... :-) for Linux and Windows. deltasql was developed with XAMPP 3.0.12, but any newer
version might work as well. Then you should install XAMPP. Using the <i>XAMPP Control Panel</i> start Apache and mySQL.
</p>

<p>Of course, XAMPP is not a strict requirement, just a good entry point for people who would like to get the software stack required by deltasql installed in few minutes. 
Almost all Linux distributions come with options to install Apache, Apache PHP module and a mySQL database. deltasql works with them as well.</p>

<p>
As next step, download the <a href="http://sourceforge.net/projects/deltasql">deltasql PHP scripts</a>, unzip them and copy
them to the <code>htdocs</code> directory created by XAMPP or by your Linux distribution, so that you get a <code>htdocs/deltasql</code> directory
full of PHP scripts. 
</p>

<p>
If you visit the main page index.php, there is a link called <b>Please Setup Deltasql...</b>. Click on this link and follow the instructions there.
Set a password for the <b>admin</b> user of deltasql. If you installed XAMPP, you do not need to define a mySQL password for the root account,
 as XAMPP sets the empty password for root by default. Else please use the correct root password of mySQL. Pressing the "Submit" button will
  install everything you need to run your deltasql server.
</p>

<p>If after installing deltasql, you receive <b>Undefined index</b> errors, please read through this <a href="faq.php#undefinedindex">FAQ question</a>.</p>
<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/000_deltasql_how_to_install_server_11min.avi/download"><img src="pictures/movie.jpg" border="0"></a> shows the steps described above, too.</p>

<p>If something should go wrong, you can read also through the next section.</p>


<h4>Manual install steps for the server</h4>

<p>
Go to the directory <code>deltasql/conf</code>, take <tt>example_config.inc.php</tt>, copy it to
 <tt>config.inc.php</tt>. Edit the variables in <tt>config.inc.php</tt> depending on your hardware 
 and network configuration.
</p>

<p>
As next step, you should visit <a href="http://localhost/phpmyadmin">http://localhost/phpmyadmin</a>, to access phpMyAdmin,
an interface that speaks with the mySQL database. In phpMyAdmin, create a user <code>delta_user</code> with a password you can set in <code>htdocs/deltasql/conf/config.inc.php</code>.
If the deltasql server is published on the Internet, you should also modify the constant <code>$dns_name</code> with the IP number of your
 computer or with its DNS name.</p>
</p>

<p>Now take <code>deltasql/db/script.sql</code> and go back to 
<a href="http://localhost/phpmyadmin">http://localhost/phpmyadmin</a>. 
Execute the SQL script with the phpMyAdmin interface. It will create a <code>deltasql</code> database.</p>.

<p>If you did all steps right, you should get a working deltasql Server as in <a href="http://deltasql.sourceforge.net/deltasql">this webpage</a> if you visit
<a href="http://localhost/deltasql">http://localhost/deltasql</a>
</p>

<p>
Log as <i>Administrator</i> with username <b><?php echo "$admin_user"; ?></b> and password <b><?php echo "$admin_pwd"; ?></b>, so that you can create your own users.
Do not forget to change the <b>admin</b> password shortly after with the <b>Change password</b> form.
</p>

<h3><a name="install-deltaclient-windows"></a>Install steps for the deltaclient on Windows (optional step)</h3>

Download first <tt>deltaclient_windows.zip</tt> from the main page and unzip it in some directory. Locate <tt>deltaclient.exe</tt> in the <tt>bin</tt> subfolder and launch it. Continue with the steps described <a href="manual.php#install-deltaclient">here</a>.

<center>
<img src="pictures/deltaclient-1.png" border="0">
<p><i>Picture:</i> deltaclient running on Windows 7.</p><br>
</center>


<h3><a name="install-deltaclient-linux"></a>Install steps for the deltaclient on Linux (optional step)</h3>

Download first <tt>deltaclient_linux.tar.gz</tt> for Gnome or Unity and unpack it with <tt>gunzip deltaclient_linux.tar.gz</tt> and <tt>tar -xf deltaclient_linux.tar</tt>. Change in the bin subfolder with <tt>cd bin</tt> and launch deltaclient with <tt>./deltaclient</tt>. 
<center>
<img src="pictures/deltaclient-linux.png" border="0">
<p><i>Picture:</i> deltaclient running on Ubuntu Unity.</p><br>
</center>

If deltaclient launches as in the screenshot above, you can read the next section. If you get an error message about missing libraries, you can try to <a href="manual.php#compiledeltaclient">compile deltaclient on Linux</a>.

<h3><a name="install-deltaclient"></a>Install steps for the deltaclient (general steps)</h3>

<p>Deltaclient can copy to clipboard the query to retrieve the current schema version and the generated script as well. 
 The user still needs to paste the queries and the generation script into his/her own SQL client (TOAD, SQL Developer, SQL Server Management Studio, SquirrelSQL etc.).

<p>
At startup, deltaclient will download all projects and branches which are currently available on Deltasql Server.</p>
<p>Based on the Project selection, deltaclient will show only branches which belong to the selected project. 
 Similarly, when selecting the From: field, it will show only valid branches and tags into the To: field.
</p>

<p>The version field should be filled with the result retrieved from the query which gets copyed when pressing the 'Copy SQL script to retrieve version number' button.
  Please note that the query works only on a <a href="faq.php#table">prepared database</a>.

<p>The branches and tags checkboxes are useful to filter branches and tags from the From: and To: comboboxes. The special branch HEAD will always appear, even if the branches checkbox is unchecked.</p>

<p>When running the first time,
 click on 'Settings...' button and configure the communication settings. The proxy parameter is important, if you run deltaclient in an enterprise behind a proxy.
  If the proxy parameter is set incorrectly, deltasql will hang the next time is running. In such a case, launch <tt>restart.bat</tt> on Windows (or <tt>restart.sh</tt> on Linux) and correct the proxy parameter.</p>

<center>
<img src="pictures/deltaclient-2.png" border="0">
</center>

<p>The url setting should point to your inhouse deltasql server. In such case, you should leave the proxy parameter empty. For testing purposes, you can leave the predefined "deltasql.sourceforge.net/deltasql" value, just to see how deltaclient behaves.</p>

<p>Instead of notepad, you can also define another editor to view SQL scripts such as <a href="http://notepad-plus-plus.org/">Notepad++</a>, Ultraedit or similar.

<p>The deltaclient user parameter is not very important: it is used by deltasql server to collect statistics on how many times deltaclient was used to retrieve the synchronization script.</p>

<h3><a name="install-dbredactor-client"></a>Install steps for the dbredactor client (optional step)</h3>

<p>The dbredactor client is a deltasql client which can retrieve from the database the current schema version, and using
 this information it retrieves from deltasql server the synchronization script. Said script is shown to the user either
  in pretty printed HTML format or in text format on your editor of choice.</p>

<p>Download first dbredactor.zip from the deltasql main page (at the bottom!). Unzip the file in the Eclipse workspace. Add the build.xml
 into the Ant window by right clicking and choosing 'Add build files...'. Copy sample-build.properties to build.properties and set the correct URL for the deltasql server in the
  <tt>deltasql.server.url</tt> property.
 Create in the <tt>/config</tt> directory a configuration for the database schema as they are done under <tt>/config/examples</tt>.
 Next, update <tt>config.set</tt> with the path to the directory you created.
 </p>
<center>
<img src="pictures/ant-dbredactor.png" border="0"><br>
<i>Picture: </i>the two Ant targets of dbredactor
</center>
 <p>
 If everything is configured correctly, you'll be able to check if a schema update is needed with a double click on the ant target
  <tt>dbsync info</tt> and to get the script needed to update with <tt>dbsync update</tt>.
 </p>
 
<h3><a name="install-ant-client"></a>Install steps for the ant client into Eclipse (optional step)</h3>
<p>The dbredactor client is a lightweight deltasql client like dbredactor. It integrates best into your <tt>build.xml</tt> script
 for the Eclipse/Java development environment.</p>

<p>
Download first ant-client.zip from the deltasql main page (at the bottom!) and unzip it somewhere. This zip file contains only two tiny files:
 deltasql-build.xml and sample-deltasql.properties. 
</p>
<center>
<img src="pictures/ant-client.png" border="0"><br>
<i>Picture: </i>the target of the Ant Client
</center>


<p>
Copy deltasql-build.xml into the Eclipse
 project where you are working (at best in the root directory of the Eclipse project).  Add the deltasql-build.xml file
 into the Ant window by right clicking and choosing 'Add build files...'. Copy sample-deltasql.properties to deltasql.properties. Read through
  deltasql properties and adjust all properties. Create a lib folder in the Eclipse project (if not already there) and copy all the .jars you can find in the 
  clients\java\dbredactor\lib directory of this package (or only the ones you enabled in deltasql.properties, at your wish).
</p>
<p>
Et voil\E0, now you should have a working ant client. By pressing on "RetrieveUpdates" you will receive the script with the latest db updates. The ant client
 is also easy to integrate in an existing build.xml!
</p>

<h3><a name="install-bash"></a>How to install the bash client (optional)</h3>

<center>
<img src="pictures/bash-client-2.png" border="0" alt="Bash client 
performing database sync" />
<p><i>Picture:</i> Bash client performing a database synchronization. Automating the bash client leads to continouus database integration!</p><br>
</center>

<p>The bash client allows in combination with deltasql server to setup a <a href="faq.php#continouus">continouus database integration</a>.

<p>Download first the Bash client (bash_client.tar.gz) from the deltasql 
main page (at the bottom!) onto your favourite GNU/Linux server.</p>
<p>Unpack it with <tt>gunzip bash_client.tar.gz</tt> and <tt>tar -xf 
bash_client.tar</tt>. Make sure all shell scripts (also in 
subdirectories) have
 executable rights with <tt>chmod 775 *.sh</tt>. Open <tt>deltasql.conf</tt>, and configure each variable of the file.</p>

 <p>You can test the connection to the deltasql server by running <tt>./deltaclient.sh 1</tt>. To test the full cycle (retrieving schema version,
  contacting deltasql server and retrieving synchronization script, executing the synchronization script) please launch <tt>./continouusintegration.sh</tt>.
 </p>
 
 <p>
 Then with
  <tt>crontab -e</tt> register <tt>continouusintegration.sh</tt> as a cron job. From time to time, read the logfile <tt>sync.log</tt> to
   check that everything is running as expected. <tt>syncscript.log</tt> contains the concatenation of all scripts executed on the database schema</tt>.
</p>


<h3><a name="install-pyclient"></a>How to install the Python deltasql client (optional)</h3>

<p>The Python client is a simple deltasql client which helps to synchronize mySQL databases. Unlike other clients, it does not support other database types.

<p>Download first the Python client (pyclient.tar.gz) from the deltasql 
main page (at the bottom!) onto your favourite GNU/Linux server.</p>
<p>Unpack it with <tt>gunzip pyclient.tar.gz</tt> and <tt>tar -xf 
pyclient.tar</tt>. Make sure all Python scripts  have
 executable rights with <tt>chmod 775 *.py</tt>. Open <tt>config.ini</tt>, and configure each variable of the file.</p>
 
<p>Python does not come with a preconfigured mysql connector. To get pyclient working, you need either to install <a href="http://sourceforge.net/projects/mysql-python/">MySQLdb</a> or <a href="http://dev.mysql.com/downloads/connector/python/">Oracle's mysql connector</a>. Then select the connector you installed in the variable <tt>pydbadapter</tt> of the <tt>config.ini</tt> file.

<p>Depending on the option <tt>executeupdate</tt> in <tt>config.ini</tt>, the Python client will either show the script into your editor of choice for later execution, or it will execute it directly into the database schema. The output of the last execution is stored in <tt>script.out</tt>, and you should monitor this file for possible errors. The concatenated output of all executions is stored in <tt>fullscript.out</tt>.
</p>

<p>The script itself is robust and does several checks before automatically executing an update in the database schema.</p>

 <p>To test the full cycle (retrieving schema version,
  contacting deltasql server and retrieving synchronization script, executing the synchronization script) please launch <tt>./pyclient.py</tt>.
 </p>
 

<h2><a name="usage"></a>Usage</h2>

<h3><a name="usermanagement"></a>User Management</h3>
<p>
There are four types of users: <i>Guests</i>, <i>Developers</i>, <i>Project Managers</i> and <i>Administrators</i>. 
<i>Guests</i> can only browse through project's scripts, search among them and compute synchronizations for schemas.
<i>Developers</i> can do everything <i>Guests</i> can do, but they also can submit new scripts, and edit old ones.
 <i>Project Managers</i> can create projects and add modules. They can create branches and tags as well. <i>Administrators</i>
 are Project Managers which can add new users to the deltasql database. They manage permissions as well.
</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/050_deltasql_user_management_7min.avi/download"><img src="pictures/movie.jpg" border="0"></a> shows how user management works, too.</p>



<h3><a name="quickguide"></a>Quick Guide</h3>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/010_deltasql_how_synchronization_works_14min.avi/download"><img src="pictures/movie.jpg" border="0"></a> should be a good introduction tutorial.</p>


<p>Login first with a user which has 'Project Manager' or 'Administrator' rights.</p>
<p>Define a module 'mymodule' with <a href="http://deltasql.sourceforge.net/deltasql/create_module.php">Create DB Module</a>. Then define 
a project 'myproject' with  <a href="http://deltasql.sourceforge.net/deltasql/create_module.php">Create a project</a>. Under <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List projects</a>
 it is possible to add the module 'mymodule' to the project 'myproject' with the link 'Add Module'.</p>

<p>Now choose 'Table' under  <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List projects</a>. Specify your database type. This will
 generate a table which needs to be created in all involved database schemas, you would like to keep under version control
  with deltasql. Create this table in these database schemas with a sql client.</p>
  
<p>Developers can now submit scripts with this <a href="http://deltasql.sourceforge.net/deltasql/submit_script.php">form</a>. They have to choose to which module
 the script belongs. If branches are created, they can also choose if a script is
 only a script for development schemas (a <tt>HEAD</tt> script), or if it needs to be applied to a previously created branch. 
 They can list all <a href="http://deltasql.sourceforge.net/deltasql/list_scripts.php">previously submitted scripts</a>. In this list,
  they can also modify a submitted script, if it contains errors, or if it is incomplete.
</p> 

<p>To update a database schema with the submitted scripts, you should first query the database schema with
 <tt>SELECT * FROM TBSYNCHRONIZE ORDER BY VERSIONNR DESC</tt>. Retrieve in the first row the project name (in <tt>PROJECTNAME</tt> column), its current version
 (in <tt>VERSIONNR</tt>) and its source branch value (in <tt>BRANCHNAME</tt>). The source branch value <tt>HEAD</tt> 
  is used for development schemas. For production databases (typically installed to a customer), the source
   branch value can be the value set when a branch is created. Just look at the first row and disregard
    the other rows, they are kept so that you have a little bit history of what happened to that database schema (it can be helpful
     in case you run a script intended for another schema by mistake).
</p>

<p>Once the three parameters are retrieved from the database schema, it is possible to ask for a database synchronization
 with the form <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronize database schema</a>. The field 'From:' should be filled with the value found
  in TBSYNCHRONIZE.BRANCHNAME. The field 'To:' (the so called target branch) should be decided as follows: choose
   <tt>HEAD</tt> if you would like to update a development schema (= 'From: HEAD') or if you would like to turn
    a production schema (= 'From:'= name of a created branch) into a development schema. Choose defined branch name for
	 the 'To:' field, if you would like to update a production schema with scripts sent to the production branch, or if 
	  you would like to update an older development schema to a newer production branch.
</p>

<p><a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronize database schema</a> will return a page with the missing SQL scripts for that given
 database schema. Choose 'Edit->Select All' from your browser and then 'Edit->Copy'. Paste the script into your
  favourite SQL client, which is connected to the database schema and execute it.
</p>

<p>The script from <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronize database schema</a> will create at the end an UPDATE statement,
 which will update the information in TBSYNCHRONIZE for the next time.</p>
 
 <p>
 Please note, that if something goes wrong, deltasql server reports an error according to the following <a href="http://deltasql.sourceforge.net/deltasql/manual_errormessages.php">list</a>.
 </p>
 <p>This is deltasql in short. Have fun!</p>

<h3><a name="projectsandmodules"></a>How to define projects and modules</h3>

<p>Modules are collections of scripts and projects are collections of modules.
 On the main page of deltasql, you can create a module and a project. Linking modules to projects is done on the <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List Projects</a> page
  by using the <b>Add module</b> link.</p>
</p>
<p>At best you should model your projects and modules to follow your source code structure. If your source code is simple, you can start with one project containing one module.
 It is not enough to define the deltasql module alone, as the synchronization works only at project level.</p>

<p>Deltasql is known to work best if you use it in this configuration: assume your company sells software A to customer X and Y and software B to customer Z.</p>

<p>You should define three projects called Project_X, Project_Y and Project_Z as in the table below:</p>

<center>
<table>
<tr><th>Project_X</th><th>Project_Y</th><th>Project_Z</th></tr>
<tr><td><tt>module_utils</tt></td><td><tt>module_utils</tt></td><td><tt>module_utils</tt></td></tr>
<tr><td><tt>module_A</tt></td><td><tt>module_A</tt></td><td><tt>module_B</tt></td></tr>
<tr><td><tt>module_Cust_X</tt></td><td><tt>module_Cust_Y</tt></td><td><tt>module_Cust_Z</tt></td></tr>
</table>
</center>

<i>
<p><tt>module_utils</tt> contains scripts which are of support of all applications. Typically, scripts which relate to tables for user management, groups and roles belong here.</p>
<p><tt>module_A</tt> contains scripts which belong to software A. All scripts which belong to the core of sotware A belong here.</p>
<p><tt>module_B</tt> contains scripts which belong to software B. All scripts which belong to the core of sotware B belong here.</p>
<p><tt>module_Cust_X</tt> contains scripts which belong to software A, and are of use only for customer X. This is a customization module.</p>
<p><tt>module_Cust_Y</tt> contains scripts which belong to software A, and are of use only for customer Y. This is a customization module.</p>
<p><tt>module_Cust_Z</tt> contains scripts which belong to software B, and are of use only for customer Z. This is a customization module.</p>
</i>

<p>This is just an example on how deltasql works in some companies where their source code is modeled as in the table above.</p>
<p>Other ways to define a project might be to separate scripts which alter database structure and scripts which change content in tables.</p>
<p> Additionally,
 it is possible to define modules without linking them to a project, so that they can be used as <a href="#maintenance">collections for maintenance tasks</a>.
</p>
<p>On projects and modules, there is also <a href="faq.php#modules">a FAQ</a>.</p>

<h3><a name="#whentobranch"></a>When should one branch?</h3>
<p>
Branching is something difficult and powerful. In the beginning, do not branch any project. Just submit all scripts to HEAD and learn how
 deltasql synchronizes in this scenario.
</p>
<p> 
Later on, you can branch a project in the <a href="http://deltasql.sourceforge.net/deltasql/list_projects.php">List Projects</a> page, if you click on the <b>Branch</b> link (visible only if your user has at least <i>Project manager</i> permissions). 
</p>
<p>
In general, you should branch a project at the
 same time when the source code is branched. You can then submit scripts both to HEAD and to the branch you created, only to HEAD or only to the new branch,
 according to how the source code HEAD and branch were modified. 
</p>	
<p>If you master deltasql, you will then be able to transform a developer schema into a production schema or to dump an existing production schema and upgrade
 it to the latest HEAD for further development.</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/020_deltasql_branching_and_transforming_schema_to_production_10min.avi/download"><img src="pictures/movie.jpg" border="0"></a> explains how branching works.</p>
  
<h3><a name="#whentotag"></a>When should one tag?</h3>

<p>Tagging is easier than branching. Simply create a new tag in the <a href="list_branches.php">List Branches and Tags</a> page, when the software
 you are developing is packed into a new release. Just be careful to tag the correct branch: If the release is for development (or if you are not using branches
  at all) simply tag HEAD. If the release is on a production schema, you must tag the branch which is followed by the production schema.</p>
  
<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/040_deltasql_tagging_7min.avi/download"><img src="pictures/movie.jpg" border="0"></a> explains how tagging works.</p>  
 
<h2><a name="syncworks"></a>How synchronization works</h2>

<p>Synchronization can get difficult if branches are involved. To warm up, imagine the following scenario:</p>

<h3>Scenario 1: all scripts are submitted to HEAD</h3>
<pre>
   Submit script 1 to HEAD to deltasql server
   Submit script 2 to HEAD to deltasql server
   Submit script 3 to HEAD to deltasql server
   Submit script 4 to HEAD to deltasql server
   Submit script 5 to HEAD to deltasql server
   Submit script 6 to HEAD to deltasql server
</pre>

<h4>Example 1.1</h4>
<p>Imagine we have an old database schema used for development, if we launch the <a href="faq.php#query">query to retrieve the database version</a>, it returns 3 for the version, 
and HEAD for branchname. The fact that the field branchname is set to HEAD indicates that the old database is a <b>development</b> database.</p>
<p>Please make sure you know the <a href="faq.php#devprod">difference between a production and development database</a> in deltasql before continuing to read.</p>

</p>
<p>If we ask deltasql to synchronize with the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">form</a> where we enter version=3 and branchname=HEAD, deltasql will generate a
 synchronization script as follows:</p>
<pre>
   Synchronization scripts contains scripts 4, 5, 6 and updates version of old database schema to 6
</pre>

<p>This example is very easy to understand. If your project is simple and if you do not need to switch between development and production environments, 
then you do not need to branch.</p>

<h3>Scenario 2: scripts are submitted to HEAD and/or BRANCH_1</h3>
<p>Here, we have a more complex scenario. A branch is created, and some scripts belong to the branch, or to the branch and the HEAD</p>

<pre>
   Submit script 1 to HEAD
   Submit script 2 to HEAD
   Create new branch BRANCH_1
   Submit script 3 to HEAD
   Submit script 4 to BRANCH_1
   Submit script 5 to HEAD and BRANCH_1
   Submit script 6 to HEAD
</pre>

<h4>Example 2.1</h4>

<pre>
   Version in old database schema: 1 
   Branch name in old database schema: HEAD 
   Update to: HEAD in synchronization form
</pre>

<p>This example is very similar to example 1.1. The old database is still a development database.
Only the branch complicates it a little bit.</p>

<pre>
   Synchronization scripts contains scripts 2, 3, 5, 6 and updates version of old database schema to 6
</pre>

<p>Script 4 is missing because it belongs to the branch only.</p>

<h4>Example 2.2</h4>

<pre>
   Version in old database schema: 2 
   Branch name in old database schema: BRANCH_1 
   Update to: BRANCH_1 in synchronization form
</pre>


<p>This time, the old database is a <b>production</b> database, as branchname is set to BRANCH_1.
 We just would like deltasql to update the database and to keep it in production. Therefore, we
  say in the synchronization form to update to BRANCH_1.</p>

<pre>
   Synchronization scripts contains scripts 4, 5 and updates version of old database schema to 6
</pre>

<p>The synchronization mechanism considered only scripts which were flagged with BRANCH_1.</p>


<h4>Example 2.3</h4>

<pre>
   Version in old database schema: 2 
   Branch name in old database schema: BRANCH_1 
   Update to: HEAD in synchronization form
</pre>

<p>The old database is a production database. We would like deltasql to transform it into a <b>development</b>
 database.  Therefore we set Update to: HEAD into the synchronization form.

<pre>
    Synchronization scripts contains scripts 3, 4, 5, 6 and updates version of old database schema to 6
	Additionally the synchronization script updates branchname to HEAD
</pre>

<p>The synchronization script executed all missing scripts to create a development schema and also changed the definition of the database
 from BRANCH_1 to HEAD, making it effectively a <b>development</b> schema.</p>

<p>This movie <a href="http://sourceforge.net/projects/deltasql/files/tutorials%20%28movies%29/010_deltasql_how_synchronization_works_14min.avi/download"><img src="pictures/movie.jpg" border="0"></a> is an introduction tutorial on how synchronization works.</p>

 
<h3><a name="concepts"></a>deltasql Concepts</h3>

<p>Developers submit scripts which belong to a module. A project consists of one or several modules. 
A database schema is always related to a single project. To each script a unique version number is assigned. 
If a database shows a given version in TBSYNCHRONIZE, deltasql can compute which scripts are necessary to
 reach another version.</p>
 
<p>Normally, database schemas and in particular development ones, need the entire chain of module-related scripts
 to be updated. This chain, as in the everywhere known Control Version System (cvs), is called <tt>HEAD</tt>.
 However, deltasql allows to create and name branches for a project. Once a branch is created, developers can choose if a particular
  scripts belongs only to <tt>HEAD</tt>, or if it belongs also to the newly created branch. Internally, deltasql
   simply stores the version number when the branch was created.
 </p>
 
 <p>
 When updating with the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">form</a>, one has to choose the target branch. The target branch can be
  <tt>HEAD</tt>, if all scripts need to be executed, and therefore if the database schema has to get a development one.
 Specifying a new target branch which is not <tt>HEAD</tt> will update the database schema to the version number assigned
  to this branch (by inserting a new row in TBSYNCHRONIZE with the version number), 
  no matter if the source branch is the same branch, or if it is a previous one. In principle,
   it is also possible to update a long forgotten development schema (source branch = <tt>HEAD</tt>), to another target branch.
 </p>

 
<h3><a name="tips"></a>Tips</h3>

<h4><a name="maintenance"></a>Define script's collections for maintenance tasks</h4>

<p>
 With deltasql it is also possible to keep a collection of scripts which are occasionally used for maintenance tasks.
 It is sufficient to create a database module with a name like <b>collection of my scripts</b> without adding
  the module to any project. 
</p>
<p>  
  Modules which are not added to a project do not partecipate in the synchronization process.
  So you can submit maintenace scripts to this module without fear that they will appear in the synchronization sequence. 
  Typically, you will change the default title <i>db update</i> to what the script effectively does. deltasql underlines titles which are not default
  and allows to search also in the title field of a script.
</p>
<p>By using the function <a href="http://deltasql.sourceforge.net/deltasql/search_scripts.php"><img src="icons/search.png">  Search among scripts</a>, you can then specifically select the special module
  to search among the maintenance SQL scripts.
</p>  
<p>
You can see how your scripts improve over time in the <b><img alt="Show" src="icons/show.png"> Show Script</b> page, if you click on the <b><img alt="History" src="icons/history.png"> History button</b>. You will be presented with
 a history of revisions. You can see how old revisions looked like or diff them to see what changed between them.
</p>

<h4><a name="filter"></a>Filter script - output particular synchronization scripts</h4>
<p>
When listing scripts (in <a href="http://deltasql.sourceforge.net/deltasql/list_scripts.php">List Scripts</a>), it is possible to filter the scripts (e.g. by date, module, author and more)
 by using the command <a href="http://deltasql.sourceforge.net/deltasql/search_scripts.php">Search among scripts</a> on top of the page. Normally, the scripts are filtered and shown
  as a list. By checking the checkbox <b>Output as text list</b> before clicking on Submit, the scripts will be shown as a normal text file
   that can be copy pasted into your SQL client of choice. This can be sometimes useful, if you need to repair a database schema by applying
    some subset of the recorded scripts.
</p> 
<p>There are also users that like this feature as substitution to the database synchronization form.</p>
 
<h2><a name="advanced"></a>Advanced Topics</h2>

<h3><a name="insights"></a>Insights into the deltasql Algorithm</h3>

<center>
<img src="pictures/timeline.png" border="0"><br>
<i>Picture: </i>Deltasql timeline with source and target
</center>

<ul>
<li>
<p>
The answer to this <a href="faq.php#algo">FAQ question</a> describes in general the steps performed by the deltasql algorithm.</li>
</p>
<li>
<p>
The main synchronization logic is contained in the file <tt>dbsync_update.inc.php</tt>. If you want to gain complete understanding of what deltasql does, you could study this file.
</p>
</li>
<li>
<p>
The first algorithm step is to traverse back from target to source the pictured tree of development, and to record each segment of the traversal in a table called
 TBSCRIPTGENERATION. In case there is no direct backward path from target to source, Deltasql summons <a href="http://deltasql.sourceforge.net/deltasql/manual_errormessages.php#13">error 13</a>. 
</p>
<p> 
 If you want to see the content
  of the table TBSCRIPTGENERATION, you can enable the checkbox 'Include debug information' in the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronization form</a>.
</p>
</li>
<li>
<p>
With the information in TBSCRIPTGENERATION, deltasql walks now from source to target, and in each segment of its walk, it issues the standard query explained in the next point.
</p>
</li>
<li>
<p>
The main query that drives the collection of scripts on a tree segment is: (we call it the "standard query")
<pre>
      SELECT DISTINCT s.* from tbscript s, tbscriptbranch sb where 
       (s.versionnr>$fromversionnr) and (s.versionnr<=$toversionnr) and 
       (s.module_id in 
              (select module_id from tbmoduleproject where project_id=$projectid) 
               and (s.id=sb.script_id) and (sb.branch_id =$tobranchid)))
</pre>
</p>
<p>The query shows that the table tbscriptbranch contains a relation between a given script (stored in tbscript) and the branches 
 (stored in tbbranch) to which it was submitted. tbbranch contains a particular row named HEAD, too. Therefore also the HEAD is represented
  as a row in tbbranch and can be considered logically as a branch. </p>
   
<p><tt>$fromversionnr</tt> is the value as it is retrieved in the table TBSYNCHRONIZE, and represents the current synchronization point of the database schema.
 <tt>$toversionnr</tt> is the version number of the latest script on a tree segment.</p>

<p>
The queries issued by deltasql to retrieve scripts can be inspectioned as well by enabling the checkbox 'Include debug information' in the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronization form</a>.
</p> 
 </li>
<li>
<p>
The generated scripts for each segment are collated together in what becomes the synchronization script.
</p>
</li>
<li>
<p>
Upgrades from production schemas (following branches) to development schemas (following HEAD) are handled by dividing the algorithm in two steps with the division set to the current schema version number: a tree traversal back to the root of the
 entire tree on which a modified query is launched (can be seen by enabling 'Include debug information' in the <a href="http://deltasql.sourceforge.net/deltasql/dbsync.php">Synchronization form</a>), so that scripts belonging to HEAD
 but not to the branch are retrieved for the backward part, and a HEAD to HEAD upgrade for the forward part. The two steps can be seen looking at the table TBSCRIPTGENERATION included in the
  debug information. <tt>exclbranch</tt> is set to 1 in the backward part, and set to 0 in the forward part. The value in <tt>exclbranch</tt> drives deltasql to launch the standard query if set to 0,
   and the modified query if set to 1.
</p>
</li>
</ul>
<p>If you install deltasql with the option <tt>Test System with Test data set</tt>, you can verify the deltasql correctness with this 
<a href="docs/Tests_To_Verify_deltasql_correctness.txt">file</a>.
</p>

<h3><a name="write-client"></a>How to write your own deltasql client</h3>

<p>deltasql Server is written in PHP and can run whenever Apache runs. You might want to write your own deltasql client
 that integrates better into your own development environment. There are already several client available. 
 They can be downloaded at the bottom of the <a href="http://deltasql.sourceforge.net/deltasql/index.php">main page</a>.</p>

<p>A deltasql client should perform the following operations:</p>

<ul>
<li>0. Retrieve the valid project and branches currently defined on the deltasql server. 
<p>To perform this step, the deltasql client
 will touch the following two scripts: <tt>dbsync_list_projects.php</tt> and <tt>dbsync_list_branches.php</tt>. The format of these
  files is a comma separated text value. The header line describes the retrieved columns. Advanced deltasql clients can adjust
   dynamically the branches based on the project name, as it is done with the freepascal deltaclient.</p>
<pre>
Examples:
http://deltasql.sourceforge.net/deltasql/dbsync_list_projects.php
http://deltasql.sourceforge.net/deltasql/dbsync_list_branches.php
</pre>   
</li>
<li>1. Connect to the database schema and retrieve project name, version and branch</li>
<p>This can be simply done by executing the query <tt>SELECT * FROM TBSYNCHRONIZE ORDER BY VERSIONNR DESC</tt>. The query is so simple
 as the table has one row per update which was already done. The latest database update has the highest version number. The important columns in this row are <tt>PROJECTNAME</tt>, <tt>VERSIONNR</tt> 
 and <tt>BRANCHNAME</tt>. As you can imagine, <tt>PROJECTNAME</tt> is the name of the project of this database
 schema and <tt>VERSIONNR</tt> is the number of the latest script executed in this database schema. <tt>BRANCHNAME</tt>
  tells if the database schema is a development schema (if the value is <tt>HEAD</tt>), or if it is a production branch.
   If it is a production branch, the value will be the name of the branch.</p>
   
  <p>If you prefer a query that returns only the row of interest, you might use this one:
<pre>
 select * from TBSYNCHRONIZE where versionnr = (select max (versionnr) from TBSYNCHRONIZE);
</pre>  
</p>
<li>2. Check on deltasql Server if there is a newer version for this project</li>
<p>
The client should touch the URL below and store the resulting page in a file called <tt>projectversion.properties</tt>.
The parameter <tt>project</tt> in the URL is the value <tt>PROJECTNAME</tt> retrieved in step one.
</p>
<pre>
 <?php
 echo "$dns_name/dbsync_automated_currentversion.php?project=TestProject";
?>
</pre>
<p>
In the <tt>projectversion.properties</tt> file, there will be a line <tt>project.version=</tt> which contains the current
latest version on deltasql server for this project. The client should now compare the latest version on deltasql
 and the <tt>VERSIONNR</tt> value in the database schema and decide if it is necessary to continue with step 3.
  If not, the user should be informed that there is no new version, that the datamodel did not change since last time.
</p>
<li>3. Retrieve Script from deltasql Server</li>
<p>
The client should now ask the deltasql server for the script to be executed in the database schema. It should touch
 the URL below and store the result as text in a file <tt>script.sql</tt>, for example.
</p>
<pre>
 <?php
 echo "$dns_name/dbsync_automated_update.php?project=TestProject&version=22&frombranch=TST1&tobranch=HEAD";
?>
</pre>
<p>
<tt>project</tt> is the <tt>PROJECTNAME</tt> column retrieved in step one and <tt>version</tt> is the column
 <tt>VERSIONNR</tt>. <tt>frombranch</tt> is the value stored in <tt>BRANCHNAME</tt>. <tt>tobranch</tt> should be <tt>HEAD</tt>
  if you want to upgrade a schema (branch or development) to the latest development schema. It should be set to the
   value contained in <tt>BRANCHNAME</tt> if the production schema is updated without becoming a development schema.
If the parameters <tt>frombranch</tt> or <tt>tobranch</tt> are not specified, they default to <tt>HEAD</tt>.
</p>
<p>The parameters described in the previous paragraph are the most important ones, but there are more described in the next paragraph, to allow customization
 and even XML export. If something goes wrong, deltasql server reports an error according to the following <a href="http://deltasql.sourceforge.net/deltasql/manual_errormessages.php">list</a>.</p>
<li>4. Visualize or execute script in database schema</li>
<p>Depending if your client includes drivers that are capable of executing complex scripts like packages
 and stored procedures (JDBC drivers are not), you can either directly execute <tt>script.sql</tt> in the database schema
 or show the script to the user and ask him/her to execute it.
</p>
<p>
The script always contains an UPDATE statement, that sets the new version and branch into the table queried in step one.
</p> 
</ul>

<h3><a name="client-parameters"></a>Client URL parameters</h3>

<p>These are all possible parameters which can be passed by a client to the <tt>dbsync_automated_update.php</tt> script. String values need to be URL encoded.</p>

<ul>
<li><tt>project=</tt> the Project name as retrieved from the colum PROJECTNAME in TBSYNCHRONIZE</li>
<li><tt>version=</tt> the version number as retrieved from the colum VERSIONNR in TBSYNCHRONIZE</li>
<li><tt>frombranch=</tt> the current branch as retrieved from the colum BRANCHNAME in TBSYNCHRONIZE</li>
<li><tt>tobranch=</tt> the target branch that will be reached after applying the synchronization script</li>
<li><tt>user=</tt> the user name that requested the synchronization script</li>
<li><tt>client=</tt> the name of the deltasql client that requests the synchronization script</li>
<li><tt>htmlformatted=</tt> set to 1 to get a pretty printed HTML version of the synchronization script 
(usually it is a text file without any particular formatting)</li>
<li><tt>xmlformatted=</tt> set to 1 to get an XML version of the synchronization script, see below for the schema definition</li>
<li><tt>dbtype=</tt> the type of the database, it should be one of the constants defined in utils/constants.inc.php</li>
</ul>

<h3><a name="xml-examples"></a>XML examples as retrieved from clients</a></h3>

<p>deltasql Server answers with two XML types, either an Error message or a synchronization script, if the option <tt>xmlformatted=1</tt>
is set. Click on the links below to see examples</p>

<p>
<a href="docs/xml-synchro-example.xml" target=_blank>Synchronization Script XML example ...</a><br>
<a href="docs/xml-error-example.xml" target=_blank>Error Message XML example...</a><br>
</p>

<h3><a name="errors"></a>List of error codes for deltasql server</h3>

<p>The entire list is <a href="manual_errormessages.php">here</a>.</p>


<h3><a name="structure"></a>Directory structure of the deltasql_1.x.y  package</h3>

<p>The structure itself is described in this <a href="docs/directory_structure_for_this_package.txt">text file</a>.</p>

<h3><a name="codewalkthrough"></a>Source code walkthrogh</h3>

<p>While most of the .php files deal with creating, inserting, updating or deleting data, there are some units which
 lie outside this schema and that are worth a look:</p>
 <ul>
 <li><tt>synchronization_table.php</tt>: contains the preparation script for any database schema which will be put under deltasql version control</li>
 <li><tt>dbsync_update.inc.php</tt>: contains the logic of retrieving scripts for the synchronization step. The heart of deltasql is here. Everything is built around this unit. </li>
 <li><tt>dbsync.php</tt>: synchronization via Form.</li>
 <li><tt>dbsync_automated_update.php</tt>: synchronization for deltasql clients.</li>
 <li><tt>utils/verification_scripts.inc.php</tt>: calls to the verification script for the different database types.</li>
 </ul>
 
<h3><a name="compiledeltaclient"></a>How to compile deltaclient on Linux, Windows or MacOSX</h3>
<p>
To compile deltaclient, you need a working copy of Lazarus, an IDE for fast software prototyping in Pascal, installed on your operating system. You can download the lazarus package from the <a href="http://lazarus.freepascal.org">Lazarus Homepage</a>. Lazarus is packaged to run on several architectures, including Linux, Windows and MacOSX. If you run Linux, you can also try to install it via your packet manager, e.g. <tt>apt-get install lazarus</tt> on Debian, <tt>emerge -av lazarus</tt> on Gentoo, <tt>yum install lazarus</tt> on Red Hat, etc.
</p>

<p>
Once Lazarus is installed, launch it. Choose File -> Open from the menu, navigate to the directory <tt>clients/freepascal/deltaclient</tt> and open the file <tt>deltaclient.lpr</tt>. Once you opened the file, simply click on the green play button. This will compile deltaclient on your favorite operating system. You will find the deltaclient executable in the <tt>clients/freepascal/bin</tt> subfolder. 
</p>

<center>
<img src="pictures/lazarus-deltaclient.png" border="0" alt="Bash client 
performing database sync" />
<p><i>Picture:</i> Press the green play button to get deltaclient compiled on your favourite operating system!</p><br>
</center>
 
<p>If you should run into trouble, please contact us on the forum.</p>
 
<h2><a name="feedback"></a>Feedback on this document</h2>
<p>
If you need help in setting up your own deltasql server,
 you can contact us at the <a href="mailto:gpu-world@lists.sourceforge.net">deltasql mailing list</a>.
 We appreciate your feedback.
</p>

<p>Have fun!</p>

<?php include("bottom-with-navbar.inc.php"); ?>
<?php echo "<h6>"; stop_watch($startwatch); echo "</h6>"; ?>
</body>
</html>
