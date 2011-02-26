<?php
//version
$deltasql_version="1.3.4";
$dbredactor_version="1.3.4";
$antclient_version="1.3.4";
$bashclient_version="1.3.4";

//number of scripts on a page
$scriptsperpage=15;

//administrator login
$admin_user="admin";
$admin_pwd="testdbsync";

//database types
$db_oracle    = 'Oracle';
$db_pgsql     = 'PostgreSQL';
$db_mysql     = 'mySQL';
$db_sqlserver = 'MS SQL Server';
$db_sybase    = 'Sybase';
$db_sqlite    = 'sqlite';
$db_other     = 'Other';
// if you want to add an additional database types:
// 1) add a new constant $db_... here
// 2) modify the combobox in
// utils/utils.inc.php::printDatabaseComboBox();
// 3) The files synchronization_table.php and
// utils/verification_scripts.inc.php 
// are database specific
// and should be modified to include the new
// database type

$configurationfile = "conf/config.inc.php";
$dbschemafile      = "db/script.sql";
$dbtestdatafile    = "db/script-test-data.sql";

$installmessage="<h2><a href=\"install.php\">Please setup Deltasql...</a></h2>";

// after how many scripts usage stats are sent to deltasql.org
$send_usage_stats_each = 100;
?>
