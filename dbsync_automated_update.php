<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("dbsync_update.inc.php");

if (isset($_GET['project'])) $projectname  = $_GET['project']; else $projectname="";
if (isset($_GET['version'])) $lastversionnr = $_GET['version']; else $lastversionnr="";
if (isset($_GET['frombranch'])) $frombranchname = $_GET['frombranch']; else $frombranchname="";
if (isset($_GET['tobranch'])) $tobranchname = $_GET['tobranch']; else $tobranchname="";
if (isset($_GET['user'])) $updateuser = $_GET['user']; else $updateuser="Unknown User";
if (isset($_GET['client'])) $updateclient = $_GET['client']; else $updateclient="Unknown Client";
if (isset($_GET['htmlformatted'])) $htmlformatted = $_GET['htmlformatted']; else $htmlformatted=0;
if (isset($_GET['xmlformatted'])) $xmlformatted = $_GET['xmlformatted']; else $xmlformatted=0;
if (isset($_GET['dbtype'])) $dbtype = $_GET['dbtype']; else $dbtype="Other";

// XML formatted is stronger than html formatted. Both are not allowed
if ($xmlformatted==1) $htmlformatted=0;

if ($frombranchname=="") $frombranchname="HEAD";
if ($tobranchname=="") $tobranchname="HEAD";

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
// retrieve project id
$query="SELECT * from tbproject where name='$projectname';"; 
$result=mysql_query($query); 
$numrows=mysql_numrows($result);  
if ($numrows!="") $projectid  = mysql_result($result,0,'id');

$query2="SELECT * from tbbranch where name='$frombranchname';"; 
$result2=mysql_query($query2);
$numrows2=mysql_numrows($result2);   
if ($numrows2!="") $frombranchid =  mysql_result($result2,0,'id');

$query3="SELECT * from tbbranch where name='$tobranchname';"; 
$result3=mysql_query($query3); 
$numrows3=mysql_numrows($result3);  
if ($numrows3!="") $tobranchid = mysql_result($result3,0,'id');
mysql_close();
if ($projectid=="")  errormessage(1, "The project name was not found ($projectname)", $xmlformatted, $htmlformatted);
if ($frombranchid=="") errormessage(2, "The source branch was not found ($frombranchname)", $xmlformatted, $htmlformatted);
if ($tobranchid=="") errormessage(3, "The target branch was not found ($tobranchname)", $xmlformatted, $htmlformatted);


dbsyncupdate($projectid, $lastversionnr, $frombranchid, $tobranchid, $htmlformatted, 0 /*excludeviews*/, 0 /*exclude packages*/, 
             $updateuser, $updateclient, /*$comment*/ "", /*$schemaname*/ "", $dbtype, $xmlformatted, /*singlefiles*/ 0, /*debug*/ 0);

?>