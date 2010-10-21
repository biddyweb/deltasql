<?php session_start();
//include("head.inc.php");
include("utils/utils.inc.php");
//$rights = $_SESSION["rights"];
$updateuser=$_SESSION["username"];
if ($updateuser=="") $updateuser="Not logged in";
//if ($rights<1) die("<b>Not enough rights to update database schema</b>");

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
    deltasql - Update
    </title>
    <body>";
}

dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid,  $htmlformatted, $excludeviews, $excludepackages, 
             $updateuser, 'deltasql-server', $commitcomment, $schemaname, $dbtype, $xmlformatted, $singlefiles);

if ($htmlformatted) {
   echo "
   </body>
   </html>";
}   
?>
