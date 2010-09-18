<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to delete a database script.</b>");

$scriptid = $_GET['id'];
if ($scriptid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="DELETE FROM tbscript where id=$scriptid;";
mysql_query($query);

$query2="DELETE FROM tbscriptbranch where script_id=$scriptid;";
mysql_query($query2);

mysql_close();
js_redirect("list_scripts.php");
?>

</body>
</html>