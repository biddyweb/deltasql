<?php session_start();
include("utils/utils.inc.php");
include("conf/config.inc.php");
include("utils/copypaste.inc.php");


if(isset($_SESSION['username'])) {
 $updateuser=$_SESSION["username"];
} else $updateuser="Not logged in";

if (isset($_POST['frmprojectid'])) $projectid  = $_POST['frmprojectid'];       else $projectid="";
if (isset($_POST['lastversionnr'])) $lastversionnr = $_POST['lastversionnr'];  else $lastversionnr="";
if (isset($_POST['frombranchid'])) $frombranchid = $_POST['frombranchid'];     else $frombranchid="";
if (isset($_POST['tobranchid'])) $tobranchid = $_POST['tobranchid'];           else $tobranchid="";
if (isset($_POST['frmdbtype'])) $dbtype = $_POST['frmdbtype'];                 else $dbtype="";
if (isset($_POST['formatgroup'])) $formatgroup = $_POST['formatgroup'];        else $formatgroup="";
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
    <head>
    <title>
    deltasql - Synchronization script
    </title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"deltasql.css\">
	<link rel=\"shortcut icon\" href=\"pictures/favicon.ico\" />
    </head>
    <body>";
	include('head.inc.php'); 
    
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
