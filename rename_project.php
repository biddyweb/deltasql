<?php session_start(); ?>
<html>
<head>
<title>deltasql - Rename project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to rename a project.</b>");

$projectid = $_GET['id'];
if ($projectid=="") exit;
$projectname = $_GET['name'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="UPDATE tbproject SET name=$projectname where id=$projectid;";
mysql_query($query);

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>