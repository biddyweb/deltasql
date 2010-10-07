<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete Module</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to delete a module.</b>");

$moduleid = $_GET['id'];
if ($moduleid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query4="DELETE FROM tbscriptbranch where script_id in (SELECT id FROM tbscript where module_id=$moduleid;";
mysql_query($query4);

$query2="DELETE FROM tbscript where module_id=$moduleid;";
mysql_query($query2);

$query3="DELETE FROM tbmoduleproject where module_id=$moduleid;";
mysql_query($query3);

$query="DELETE FROM tbmodule where id=$moduleid;";
mysql_query($query);

mysql_close();
js_redirect("list_modules.php");
?>

</body>
</html>