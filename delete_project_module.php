<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete Project Module</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<2) die("<b>Not enough rights to delete a project module.</b>");

$moduleid = $_GET['moduleid'];
$projectid = $_GET['projectid'];
$projectname = $_GET['name'];
if ($moduleid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="DELETE FROM tbmoduleproject WHERE module_id=$moduleid and project_id=$projectid;";
mysql_query($query);

mysql_close();
js_redirect("list_project_modules.php?id=$projectid&name=$projectname");
?>

</body>
</html>