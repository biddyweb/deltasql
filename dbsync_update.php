<?php session_start();
include("utils/utils.inc.php");

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

include("dbsync_update.inc.php");
if ($htmlformatted) {
    echo "
    <html> 
    <title>
    deltasql - Synchronization script
    </title>
    <body>";
	
	echo "
	<script type=\"text/javascript\" src=\"utils/js/jquery-1.7.2.min.js\"></script>
    <script type=\"text/javascript\" src=\"utils/js/jquery.zclip.min.js\"></script>
    <script>
	$(document).ready(function(){
    $('a#copy-description').zclip({
        path:'utils/js/ZeroClipboard.swf',
        copy:$('p#description').text()
    });
    $('a#copy-dynamic').zclip({
        path:'utils/js/ZeroClipboard.swf',
        copy:function(){return $('input#dynamic').val();}
    });
	});
	</script>
	";
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
