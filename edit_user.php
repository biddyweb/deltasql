<?php session_start(); ?>
<html>
<head>
<title>deltasql - Edit user</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
	include("head.inc.php");
	$id       = $_GET['id'];
	$username = $_GET['username'];
	$first    = $_GET['first'];
	$last     = $_GET['last'];
	$email 	  = $_GET['email'];
	$rights   = $_GET['rights'];
?>
<h2>Edit user</h2>
<form action="edit_user.php" method="post">
<table>
<tr><td>Username:</td><td> <input type="text" name="username" value="<?php echo "$username"; ?>"></td></tr>
<tr><td>First:</td><td> <input type="text" name="first" value="<?php echo "$first"; ?>"></td></tr>
<tr><td>Last: </td><td><input type="text" name="last"  value="<?php echo "$last"; ?>"></td></tr>
<tr><td>Email: </td><td> <input type="text" name="email" value="<?php echo "$email"; ?>"></td></tr>
<?php echo "<input type=\"hidden\" name=\"thisuserid\"  value=\"$id\">"; ?>
<tr><td>
Rights:
</td><td>
<select NAME="rights">
<option <?php if ($rights==1) echo "SELECTED"; ?> VALUE="1">Developer
<option <?php if ($rights==2) echo "SELECTED"; ?> VALUE="2">Project Manager
<option <?php if ($rights==3) echo "SELECTED"; ?> VALUE="3">Administrator
</select>
</td></tr>
</table>
<input type="Submit">
</form>

<?php

include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$myrights = $_SESSION["rights"];
if ($myrights<3) die("<b>Not enough rights to edit a user.</b>");

$frm_username=$_POST['username'];
$first=$_POST['first'];
$last=$_POST['last'];
$email=$_POST['email'];
$rights=$_POST['rights'];
$thisuserid=$_POST['thisuserid'];
if ($frm_username=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="UPDATE tbuser SET username='$frm_username',first='$first',last='$last',email='$email',rights=$rights WHERE id=$thisuserid";
mysql_query($query);
mysql_close();

js_redirect("list_users.php");

?>
<a href="index.php">Back to main menu</a>
</body>
</html>