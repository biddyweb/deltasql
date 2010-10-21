<html>
<head>
<title>deltasql - Installing ...</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

$debug_output_script=false;

echo "<br><br>Collecting data... <br>";

$mysqlrootuser = $_POST['mysqlrootuser'];
if ($mysqlrootuser=="") die("<b>Please enter the mySQL root user</b> <a href=\"install.php\">Back</a>");

$mysqlrootpassword = $_POST['mysqlrootpassword'];
/*
// we do not check for empty mySQL root password as XAMPP installs mySQL with empty
// root password by default
if ($mysqlrootpassword=="") die("<b>Please enter the mySQL root password</b> <a href=\"install.php\">Back</a>");
*/
  

$deltasqladminpassword = $_POST['deltasqladminpassword'];
if ($deltasqladminpassword=="") die("<b>Please enter the deltasql admin password</b> <a href=\"install.php\">Back</a>");

$dnsname = $_POST['dnsname'];

$mysqlhost = $_POST['mysqlhost'];
if ($mysqlhost=="") die("<b>Please enter the mySQL host</b> <a href=\"install.php\">Back</a>");

$deltasqlschemaname = $_POST['deltasqlschemaname'];
if ($deltasqlschemaname=="") die("<b>Please enter the deltasql schema name</b> <a href=\"install.php\">Back</a>");

$deltasqlschemapassword = $_POST['deltasqlschemapassword'];
if ($deltasqlschemapassword=="") die("<b>Please enter the deltasql schema password</b> <a href=\"install.php\">Back</a>");

$deltasqlschemauser = $_POST['deltasqlschemauser'];                     
if ($deltasqlschemauser=="") die("<b>Please enter the deltasql schema user</b> <a href=\"install.php\">Back</a>");

$dbdefault = $_POST['frmdbtype'];
$enterpriselogo = $_POST['enterpriselogo'];
$enterpriselinktext = $_POST['enterpriselinktext'];
$enterpriselinkurl = $_POST['enterpriselinkurl'];

$testgroup=$_POST['testgroup'];
$sqlgroup=$_POST['sqlgroup'];
$clientsgroup=$_POST['clientsgroup'];
$editiongroup =  $_POST['editiongroup'];
$toptengroup =  $_POST['toptengroup'];
$usagestatsgroup = $_POST['usagestatsgroup'];


$testsystem="false";
$disablesqlhighlightning="false";
$disable_clients_table_on_main_page="false";
$enterpriseedition="false";
$disable_topten_submitters="false";
$submit_usage_stats="true";

if ($testgroup=="testsystemyes") $testsystem="true";
if ($sqlgroup=="donotusesqlhighlighting") $disablesqlhighlightning="true"; 
if ($clientsgroup=="clientstableno") $disable_clients_table_on_main_page="true";
if ($editiongroup=="enterpriseedition") $enterpriseedition = "true";
if ($toptengroup=="yes") $disable_topten_submitters = "true";
if ($usagestatsgroup=="statsno") $submit_usage_stats="false";

if (!$debug_output_script) {
if ($deltasqlschemauser!=$mysqlrootuser) {
  echo  "Creating mySQL user '$deltasqlschemauser'... <br>";

  mysql_connect($mysqlhost, $mysqlrootuser, $mysqlrootpassword);

  $queryuseranddb="CREATE USER '$deltasqlschemauser' IDENTIFIED BY '$deltasqlschemapassword';";
  $result=mysql_query($queryuseranddb);
  if ($result==1) echo "<b>User created</b><br>"; else die("<b>Not possible to create the user '$deltasqlschemauser' (does the user '$deltasqlschemauser' already exist?)</b>");
  mysql_close();
}

echo "Creating database schema '$deltasqlschemaname'...<br>";
mysql_connect($mysqlhost, $mysqlrootuser, $mysqlrootpassword);
$queryuseranddb="CREATE DATABASE `$deltasqlschemaname` ;";
$result=mysql_query($queryuseranddb);
if ($result==1) echo "<b>Database created</b><br>"; else die("<b>Not possible to create database '$deltasqlschemaname' (does the schema already exist?)</b>");

echo "Grant usage on $deltasqlchemaname to $deltasqlschemauser ...<br>";
$queryuseranddb="GRANT USAGE ON * . * TO '$deltasqlschemauser'@'$mysqlhost' IDENTIFIED BY '$deltasqlschemapassword' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;";
$result=mysql_query($queryuseranddb);
if ($result==1) echo "<b>Usage grants to user '$deltasqlschemauser' assigned</b><br>";
else die("<b>Not possible to assign user grants to '$deltasqlschemauser'</b>");

echo "Grant all privileges on '$deltasqlschemaname' to'$deltasqlschemauser'@'$mysqlhost' ...<br>";
$queryuseranddb="GRANT ALL PRIVILEGES ON `$deltasqlschemaname` . * TO '$deltasqlschemauser'@'$mysqlhost';";
$result=mysql_query($queryuseranddb);
if ($result==1) echo "<b>All privileges granted to the user</b><br>";
else die("<b>Not possible to assign all privileges to '$deltasqlschemauser'</b>");

echo "Flush privileges...";
$queryprivileges = "FLUSH PRIVILEGES;";
$result = mysql_query($queryprivileges);
if ($result==1) echo "<b>Privileges assigned</b><br>"; else die("<b>Not possible to flush privileges</b>");


mysql_close();

echo "mySQL user and database created. <br>";


echo "mySQL schema creation... <br>";
mysql_connect($mysqlhost, $mysqlrootuser, $mysqlrootpassword);
@mysql_select_db($deltasqlschemaname) or die("Unable to select user database for schema creation with user '$mysqlrootuser'");

executeScripts("db/tables", "table_", 10);
executeScripts("db/data", "data_", 4);

if ($testgroup=="testsystemyes") {
    executeScripts("db/test-data", "data_", 53);
}

// update admin password
$query4="UPDATE tbuser SET password='$deltasqladminpassword' WHERE username='admin';";
mysql_query($query4);

mysql_close();
echo "mySQL schema created. <br>";
}

// Creating the configuration file :-)
$fh = fopen($configurationfile, 'w') or die("Can't open file $configurationfile");
fwrite($fh, "<?php\n");
fwrite($fh, "
// Configuration file generated with install.php

// [mySQL Settings]

\$username=\"$deltasqlschemauser\";
\$password=\"$deltasqlschemapassword\";
\$database=\"$deltasqlschemaname\";

// computer, on which the mySQL instance runs
\$dbserver = \"$mysqlhost\";



// [Apache Settings]

// on which DNS name the Apache deltasql server is published (no SLASH at the end)
\$dns_name=\"$dnsname\";



// [Edition Settings]

\$dbdefault=\"$dbdefault\";             				
// If set to true, the wiki and mailing lists are disabled
// The \$enterprise_logo is used as logo				
\$enterprise_edition=$enterpriseedition;
\$enterprise_name=\"$enterpriselinktext\";
\$enterprise_website=\"$enterpriselinkurl\";
\$enterprise_logo=\"$enterpriselogo\";


// [Options]

// for performance reason, you might want disable SQL highlighting in the
// synchronization form
\$disable_sql_highlighting=$disablesqlhighlightning;

// if your clients are preinstalled, you might want to disable the table
// with external clients like dbredactor and ant-client on the main page
\$disable_clients_table_on_main_page=$disable_clients_table_on_main_page;


// disables the top ten submitters link
\$disable_topten_submitters=$disable_topten_submitters;


\$test_system=$testsystem; 
// set to false in production
// else it will display admin password on login.

// default script title when submitting a new script
\$default_script_title=\"db update\";

//allow deltasql to submit usage statistics to deltasql.org
\$submit_usage_stats=$submit_usage_stats;

//script prefix and suffix when outputting scripts as single files
\$script_prefix    = \"script_\";
\$script_extension = \".sql\";
");

fwrite($fh, "?>\n");
fclose($fh);

echo "Configuration script created. <br>";

js_redirect("index.php");

?>
</body>
</html>
