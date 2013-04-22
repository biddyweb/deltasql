<?php

function printVerificationScript($dbtype, $htmlformatted, $projectname, $lastversionnr, $frombranchname, $xmlformatted) {
include('constants.inc.php');

// we use strToLower as deltasql clients might use other names for the dbtype parameter
$dbtype=strtolower(trim($dbtype));
$commentscript = "-- this verifies that the present script is executed in the correct schema";

if ($dbtype==strtolower($db_oracle)) {
$verificationscript = "CALL DELTASQL_VERIFY_SCHEMA($lastversionnr, '$frombranchname', '$projectname');\n"; 
} else if ($dbtype==strtolower($db_pgsql)) {
$verificationscript = "SELECT DELTASQL_VERIFY_SCHEMA($lastversionnr, '$frombranchname', '$projectname');\n";  
} else if ($dbtype==strtolower($db_sqlserver)) {
$verificationscript = "EXEC deltasql_verify_schema $lastversionnr, '$frombranchname', '$projectname';\n";
}
else if ($dbtype!="") {
	$commentscript = "-- Please make sure this script is executed on the correct schema!!";
	$verificationscript = "";
}

if ($htmlformatted==1) {
      include_once('utils/geshi/geshi.php');
 	  geshi_highlight("$commentscript\n$verificationscript", 'sql');
      echo '<br/>';
} else
if ($xmlformatted) {
    printXmlScript($verificationscript, $commentscript, "" /*module*/, "" /*versionnr*/, "verification", "" /*date*/);
} else {
  echo "$commentscript\n$verificationscript\n";
}

  return "$commentscript\n$verificationscript\n\n";
}
?>
