<?php session_start();
include("utils/utils.inc.php");
include("conf/config.inc.php");
include("utils/copypaste.inc.php");


if(isset($_SESSION['username'])) {
 $updateuser=$_SESSION["username"];
} else $updateuser="Not logged in";

$projectid  = $_POST['frmprojectid'];
$lastversionnr = $_POST['lastversionnr'];
$frombranchid = $_POST['frombranchid'];
$tobranchid = $_POST['tobranchid'];
$dbtype = $_POST['frmdbtype']; 
$formatgroup = $_POST['formatgroup'];
$debug = isset($_POST['frmdebug']);

$htmlformatted=0;
$xmlformatted=0;
$singlefiles=0;
if ($formatgroup=="html") $htmlformatted=1; else
if ($formatgroup=="xml") $xmlformatted=1; else
if ($formatgroup=="singlefiles") $singlefiles=1;

// unused variables
$excludeviews=0;
$excludepackages=0;
$commitcomment="";
$schemaname="";


if ($htmlformatted) {
    echo "
    <html> 
    <title>
    deltasql - Synchronization script
    </title>
    <body>
	<div>";
	
	if (!isset($default_copypaste)) $default_copypaste=1;
	printCopyPasteJS($default_copypaste);
}

include("dbsync_update.inc.php");

dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid,  $htmlformatted, $excludeviews, $excludepackages, 
             $updateuser, 'deltasql-server', $commitcomment, $schemaname, $dbtype, $xmlformatted, $singlefiles, $debug);

$_SESSION['dbsync_projectid']   = $projectid;
			 
if ($htmlformatted) {
   echo "
   </body>
   </html>";
}   
?>
