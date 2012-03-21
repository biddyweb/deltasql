<?php
//version
$deltasql_version="1.5.0";
$ds_schema_version="1.5.0";

$dbredactor_version="1.0.2";
$antclient_version="1.0.3";
$bashclient_version="1.2.1";
$gadget_version="1.0.7";
$deltaclient_version="1.4.1";

// number of scripts on a page
$default_scriptsperpage=15;
// if help links should be displayed
$default_displayhelplinks=1;
// if rows need to be colored
$default_colorrows=1;

// number of scripts on RSS feed
$scriptsonrssfeed=20;

// number of scripts on
// wide of textarea field in chars in submit_script.php and edit_script.php
$wide_textarea_chars=140;

// administrator login for test instance
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

// after how many scripts usage stats are stored into tbsyncstats
$store_usage_stats_each = 1;
?>
