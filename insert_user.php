<?php session_start(); ?>
<html>
<head>
<title>deltasql - Insert a new user</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
?>
<h2>Insert a new user</h2>
<form action="insert_user.php" method="post">
<table>
<tr><td>Username:</td><td> <input type="text" name="username"></td></tr>
<tr><td>Password:</td><td> <input type="password" name="password"></td></tr>
<tr><td>First:</td><td> <input type="text" name="first"></td></tr>
<tr><td>Last: </td><td><input type="text" name="last"></td></tr>
<tr><td>Email: </td><td> <input type="text" name="email"></td></tr>
<tr><td>
Rights:
</td><td>
<select NAME="rights">
<option VALUE="1">Developer
<option VALUE="2">Project Manager
<option VALUE="3">Administrator
</select>
</td></tr>
</table>
<input type="Submit" value="Insert user">
</form>
<?php include("bottom.inc.php"); ?>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
if ($rights<3) die("<b>Not enough rights to insert a new user.</b>");
if (!isset($_POST['username'])) exit;
if (!isset($_POST['password'])) die("<b><font color=\"red\">The password can not be empty!</font></b>");
$first=$_POST['first'];
$last=$_POST['last'];
$email=$_POST['email'];
$rights=$_POST['rights'];
$frm_username=$_POST['username'];
$frm_password=$_POST['password'];

if ($frm_password==$frm_username) die("<b><font color=\"red\">The password can not be equal to the username!</font></b>");
$link=mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$frm_username=mysql_real_escape_string($frm_username, $link);
$frm_password=mysql_real_escape_string($frm_password, $link);

$hashpwd=salt_and_hash($frm_password, retrieve_salt());
$query="INSERT INTO tbuser (id, username, password, passwhash, first,last,email,rights,encrypted) VALUES('','$frm_username','****','$hashpwd','$first','$last','$email',$rights,1);";
mysql_query($query);
mysql_close();

js_redirect("list_users.php");
?>
</body>
</html>
