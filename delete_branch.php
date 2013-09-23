<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete Project Branch</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to delete a project branch.</b>");

$branchid = $_GET['id'];
if ($branchid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="DELETE FROM tbscriptbranch where branch_id=$branchid;";
mysql_query($query2);

$query="DELETE FROM tbbranch where id=$branchid;";
mysql_query($query);

mysql_close();
js_redirect("list_branches.php");
?>

</body>
</html>