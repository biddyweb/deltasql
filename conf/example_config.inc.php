<?php

// [mySQL Settings]
// User Settings
$username="deltasqluser";
$password="deltapass";
$database="deltasql";

// computer, on which the mySQL instance runs
$dbserver = "localhost";

// [Apache Settings]
// on which DNS name the Apache deltasql server is published (no SLASH at the end)
$dns_name="http://127.0.0.1/deltasql";

// if all contents of deltasql are available only if logged in
$keep_private=false;

// [Email Settings]
// The following settings are used, if users need to be notified by email
// of new scripts entered in deltasql
// email settings (all other settings are configured in sendmail)
$emails_enable=true;
$emails_sender="admin@deltasql.org";
$emails_subject_identifier="[deltasql]";
//for Unix
//$sendmail_command="/usr/bin/sendmail -t <";
//$deltasql_path="/var/www/deltasql/";
//for XAMPP under Windows
$sendmail_command="D:\\xampplite\\sendmail\\sendmail.exe -t <";
$deltasql_path="D:\\xampplite\\htdocs\\deltasql\\";


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

// disables the top ten statistics 
$disable_topten_submitters=false;

// enables server statistics
$enable_server_stats=true;

// default script title when submitting a new script
$default_script_title="db update";

// if the copy&paste functionality is enabled by default or not
$default_copypaste = 1;

//script prefix and suffix when outputting scripts as single files
$script_prefix    = "script_";
$script_extension = ".sql";

?>
