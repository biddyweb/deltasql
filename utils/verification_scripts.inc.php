<?php

function printVerificationScript($dbtype, $htmlformatted, $projectname, $lastversionnr, $frombranchname, $xmlformatted) {
include_once('constants.inc.php');

// we use strToLower as deltasql clients might use other names for the dbtype parameter
$dbtype=strtolower(trim($dbtype));
$commentscript = "\n-- this verifies that the present script is executed in the correct schema";

if ($dbtype==strtolower($db_oracle)) {
$verificationscript = "CALL DELTASQL_VERIFY_SCHEMA($lastversionnr, '$frombranchname', '$projectname');
"; 
} else if ($dbtype==strtolower($db_pgsql)) {
$verificationscript = "SELECT DELTASQL_VERIFY_SCHEMA($lastversionnr, '$frombranchname', '$projectname');
";  
} else if ($dbtype==strtolower($db_sqlserver)) {
$verificationscript = "EXEC deltasql_verify_schema $lastversionnr, '$frombranchname', '$projectname';";
}
else if ($dbtype!="") {
	$commentscript = "-- for this database type ($dbtype) there still is no verification step";
	$verificationscript = "$verificationscript-- you could define one in synchronization_table.php\n";
}

if ($htmlformatted==1) {
      include_once('utils/geshi/geshi.php');
 	  geshi_highlight("$commentscript\n$verificationscript", 'sql');
      echo '<br/><br/>';
} else
if ($xmlformatted) {
    printXmlScript($verificationscript, $commentscript, "" /*module*/, "" /*versionnr*/, "verification", "" /*date*/);
} else {
  echo "$commentscript\n$verificationscript\n\n";
}

}
?>
