<html>
<head>
<title>deltasql - Install Page</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/constants.inc.php");
include("utils/utils.inc.php");

// check if deltasql is already installed
if (file_exists($configurationfile)) {
    echo "<h2>WARNING: deltasql is already installed!</h2> <p>Do not use this page but modify <i>$configurationfile</i> instead!</p>";

   include("conf/config.inc.php");
}

?>
<h2>Install Page</h2>
<form action="install_execution.php" method="post">

<h3>deltasql Settings</h3>
<p>
In this section you specify the password for the <b>admin</b> user of deltasql. This user is needed to create all other users, and to setup deltasql
 in the beginning. <b>Please remember the password you set here.</b> After this page, if everything went okay, you can login with the user admin into deltasql and start to work.
</p>
<table>
<tr><td>Administrator Password for deltasql (user <b>admin</b>):</td><td> <input type="text" name="deltasqladminpassword" value="" size="17"></td></tr>
</table>

<h3>Apache Settings</h3>
<p>Here you should set the URL where deltasql is published. <b>Please do not add a SLASH at the end</b>.</p>.
<table>
<tr><td>Published on:</td><td> <input type="text" name="dnsname" value="http://localhost/deltasql" size="50"></td></tr>
</table>

<h3>mySQL Settings</h3>
<p>
deltasql is backed by a mySQL database. Here you are required to specify information about the mySQL database.
<i>mySQL host</i> is the computer where deltasql runs. If the Apache Webserver runs on the same machine as mySQL,
 you can leave the default <i>localhost</i>. <i>mySQL Root Password</i> is the main password of the mySQL database.
 This install page uses the root password to create the mySQL schema (the mySQL user has the same name as the mySQL schema)
 which will have the password as you define in this table. 
</p>
<table>
<tr><td>mySQL host:</td><td> <input type="text" name="mysqlhost" value="localhost"></td></tr>
<tr><td>mySQL Root User:</td><td> <input type="text" name="mysqlrootuser" value="root"></td></tr>
<tr><td>mySQL Root Password:</td><td> <input type="text" name="mysqlrootpassword"></td></tr>
</table>
<p>The database user will be created by the mySQL root user and used for connections between deltasql and mySQL. <b>Please note:</b> Setting the mySQL root user and database user as the same user is supported by the install routines, but it is not recommended.</p>
<table>
<tr><td>Database name:</td><td> <input type="text" name="deltasqlschemaname" value="deltasql"></td></tr>
<tr><td>Database user:</td><td> <input type="text" name="deltasqlschemauser" value="deltasqluser"></td></tr>
<tr><td>Database Password:</td><td> <input type="text" name="deltasqlschemapassword" value="deltapass"></td></tr>
</table>

<br><br>
<h3>Customization Settings</h3>
<p>
In this section, you can choose which default database type deltasql will manage and which edition of deltasql you would like to run. The Open Source Edition has a link to the
 Official Wiki of deltasql and the deltasql logo is shown on most pages. If you would like to customize deltasql with the logo
  of your company, you can put a picture in the <i>pictures</i> subfolder of deltasql and adapt the name below. You can also
   define a link here, which will be shown on the entry page of deltasql.
</p>
<table>
<tr><td>Which database type will be managed with deltasql:</td><td><?php printDatabaseComboBox($dbdefault); ?></td></tr>
<tr><td>Which Edition:</td>
<td> 
<input type="radio" name="editiongroup" value="enterpriseedition"> Enterprise Edition 
<input type="radio" name="editiongroup" value="openedition" checked> Open Source Edition
</td></tr>
<tr><td>Enterprise Logo (if Enterprise Edition): </td><td><input type="text" name="enterpriselogo" value="pictures/enterprise_logo.jpg" size="40"></td></tr>
<tr><td>Enterprise Link Text (if Enterprise Edition): </td><td><input type="text" name="enterpriselinktext" value="Enterprise Wiki"></td></tr>
<tr><td>Enterprise Link Url (if Enterprise Edition): </td><td><input type="text" name="enterpriselinkurl" value="http://"></td></tr>
</table>

<h3>Further Options</h3>

<p>
Here, most people can probably leave with the defaults. You can disable SQL highlighting if your deltasql will have more than 10000 SQL scripts, or
 if deltasql runs on an old server with poor performance. SQL highlighting is only disable in the synchronization script generation, but not for browsing scripts,
  as it helps the eye. 
</p>
<p>
You can choose to show the table with the deltasql clients on the main page as well. And you can have a system with test data, and where the admin password is displayed at login,
 for users to experiment with deltasql, or to check deltasql correctness.
</p>
<table>
<tr><td>Use SQL highlighting: </td>
<td>
<input type="radio" name="sqlgroup" value="usesqlhighlighting" checked> Yes
<input type="radio" name="sqlgroup" value="donotusesqlhighlighting"> No
</td></tr>

<tr><td>Disable Top Ten Submitters Statistics: </td>
<td>
<input type="radio" name="toptengroup" value="yes"> Yes
<input type="radio" name="toptengroup" value="no" checked> No
</td></tr>

<tr><td>Show deltasql clients on main page: </td>
<td>
<input type="radio" name="clientsgroup" value="clientstableyes" checked> Yes
<input type="radio" name="clientsgroup" value="clientstableno"> No
</td></tr>
<tr><td>Test System (with Test Data): </td>
<td>
<input type="radio" name="testgroup" value="testsystemyes"> Yes
<input type="radio" name="testgroup" value="testsystemno" checked> No
</td></tr>
<tr><td>Allow deltasql to send usage statistics to deltasql.org: </td>
<td>
<input type="radio" name="usagestatsgroup" value="statsyes" checked> Yes
<input type="radio" name="usagestatsgroup" value="statsno"> No
</td></tr>
</table>
<br></br>

<p>
Pressing on the <b>Submit</b> button will generate the configuration file under <i><?php echo "$configurationfile"; ?></i> and create a schema on your mySQL instance.
 If all settings are correct, deltasql is ready to use. If not, you need to change <i><?php echo "$configurationfile"; ?></i> manually.
</p>
<input type="Submit" value="Setup deltasql">  <a href="index.php">Cancel</a>
</form>

</body>
</html>
