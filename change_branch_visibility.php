<?php session_start(); ?>
<html>
<head>
<title>deltasql - Change Visibility</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<2) die("<b>Not enough rights to change visibility of a project branch.</b>");

$branchid = $_GET['id'];
$show = $_GET['show'];
if ($branchid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="UPDATE tbbranch SET visible=$show where id=$branchid;";
mysql_query($query);

mysql_close();
js_redirect("list_branches.php");
?>

</body>
</html>