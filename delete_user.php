<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete User</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<3) die("<b>Not enough rights to delete a user.</b>");

$deleteid = $_GET['id'];
if ($deleteid=="") exit;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="DELETE FROM tbuser where id=$deleteid;";
mysql_query($query);


mysql_close();
js_redirect("list_users.php");
?>

</body>
</html>