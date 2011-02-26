<?php session_start();
include("utils/utils.inc.php");
$updateuser=$_SESSION["username"];
if ($updateuser=="") $updateuser="Not logged in";

$projectid  = $_POST['frmprojectid'];
$lastversionnr = $_POST['lastversionnr'];
$frombranchid = $_POST['frombranchid'];
$tobranchid = $_POST['tobranchid'];
$excludeviews = $_POST['frmexcludeviews'];
$excludepackages = $_POST['frmexcludepackages'];
$commitcomment = $_POST['frmcommitcomment'];
$dbtype = $_POST['frmdbtype']; 
$schemaname = $_POST['frmschemaname'];
$formatgroup = $_POST['formatgroup'];
$debug       = $_POST['frmdebug'];

$htmlformatted=0;
$xmlformatted=0;
$singlefiles=0;
if ($formatgroup=="html") $htmlformatted=1; else
if ($formatgroup=="xml") $xmlformatted=1; else
if ($formatgroup=="singlefiles") $singlefiles=1;

if ($excludeviews=="") $excludeviews=0;
if ($excludepackages=="") $excludepackages=0;

include("dbsync_update.inc.php");
if ($htmlformatted) {
    echo "
    <html> 
    <title>
    deltasql - Synchronization script
    </title>
    <body>";
}

dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid,  $htmlformatted, $excludeviews, $excludepackages, 
             $updateuser, 'deltasql-server', $commitcomment, $schemaname, $dbtype, $xmlformatted, $singlefiles, $debug);

$_SESSION['dbsync_projectid']   = $projectid;
			 
if ($htmlformatted) {
   echo "
   </body>
   </html>";
}   
?>
