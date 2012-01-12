<?php

// [mySQL Settings]
// User Settings
$username="delta_user";
$password="deltapass";
$database="deltasql";

// computer, on which the mySQL instance runs
$dbserver = "localhost";

// [Apache Settings]
// on which DNS name the Apache deltasql server is published (no SLASH at the end)
$dns_name="http://127.0.0.1/deltasql";


// [Email Settings]
// The following settings are used, if users need to be notified by email
// of new scripts entered in deltasql
// email settings (all other settings are configured in sendmail)
$emails_enable=true;
$emails_sender="admin@deltasql.org";
$emails_subject_identifier="[deltasql]";

// [Edition Settings]

// if set to true, it disables the database consistency check in index.php
$test_system=true; 

// default database type for schemas managed by deltasql
$dbdefault="Oracle";               
				
// If set to true, the wiki and mailing lists are disabled
// The $enterprise_logo is used as logo				
$enterprise_edition=false;
$enterprise_name="LogObject";
$enterprise_website="http://www.logobject.ch";
$enterprise_logo="pictures/enterprise_logo.jpg";

// [Options]
// for performance reason, you might want disable SQL highlighting in the
// synchronization form
$disable_sql_highlighting=false;

// disables the top ten submitters link
$disable_topten_submitters=false;

// if your clients are preinstalled, you might want to disable the table
// with external clients like dbredactor and ant-client on the main page
$disable_clients_table_on_main_page=false;

// default script title when submitting a new script
$default_script_title="db update";

//allow deltasql to submit usage statistics to deltasql.org
$submit_usage_stats=false;

//script prefix and suffix when outputting scripts as single files
$script_prefix    = "script_";
$script_extension = ".sql";

?>
