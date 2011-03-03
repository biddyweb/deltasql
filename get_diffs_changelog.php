<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Show differences</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

$scriptid = $_POST['scriptid'];
$version  = $_POST['version'];
$fromdiff = $_POST['fromdiff'];
$todiff   = $_POST['todiff'];
if ($scriptid=="") exit;
if ($fromdiff==$todiff) die("<b>There is no difference, both scripts are the same!</b>");

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$queryfrom="SELECT * from tbscriptchangelog where id=$fromdiff";
$resultfrom=mysql_query($queryfrom);
$scriptfrom  =mysql_result($resultfrom,0,"code");
$commentsfrom=mysql_result($resultfrom,0,"comments");
$titlefrom=mysql_result($resultfrom,0,"title");

if ($todiff!="latest") {
   $queryto="SELECT * from tbscriptchangelog where id=$todiff";
} else {
   $queryto="SELECT * from tbscript where id=$scriptid";
}
$resultto=mysql_query($queryto);
$scriptto  =mysql_result($resultto,0,"code");
$commentsto=mysql_result($resultto,0,"comments");
$titleto=mysql_result($resultto,0,"title");


mysql_close();
?>
</body>
</html>