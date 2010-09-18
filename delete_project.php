<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete project</title>
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
if ($rights<3) die("<b>Not enough rights to delete a project.</b>");

$projectid = $_GET['id'];
if ($projectid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="DELETE FROM tbproject where id=$projectid;";
mysql_query($query);

$query2="DELETE FROM tbmoduleproject where project_id=$projectid;";
mysql_query($query2);
mysql_close();

js_redirect("list_projects.php");
?>

</body>
</html>