<?php session_start(); ?>
<html>
<head>
<title>deltasql - Change Password</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php include ("head.inc.php");?>
<h1>deltasql Change Password</h1>
<br />

<form name="tlogin" id="tlogin" method="post" action="change_password.php">
<table align="center" width="300">
	<tr align="left">
		<td align="left">
			Old Password:
		</td>	
		<td align="left">
			<input type="password" name="oldpwd" />
		</td>
	</tr>
	<tr align="left">
		<td align="left">
			New Password
		</td>	
		<td align="left">
			<input type="password" name="newpwd" />
		</td>
	</tr>
	<tr align="left">
		<td align="left">
			Confirm New Password
		</td>	
		<td align="left">
			<input type="password" name="confirmnewpwd" />
		</td>
	</tr>

	<tr>
		<td>&nbsp;
			
		</td>
		<td>&nbsp;
			
		</td>
	</tr>
	<tr>
		<td>
			<input type="submit" value="Change"/>
		</td>
		<td>&nbsp;
			
		</td>
	</tr>	
</table>
</form>
<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");

if (isset($_POST['oldpwd'])) $frm_oldpwd=$_POST['oldpwd']; else exit;
$frm_newpwd=mysql_real_escape_string($_POST['newpwd']);
$frm_confirmnewpwd=mysql_real_escape_string($_POST['confirmnewpwd']);

if ($frm_newpwd=="") die("<b><font color=\"red\">The new password can not be empty!</font></b>");
if ($frm_newpwd!=$frm_confirmnewpwd)
  die("<b><font color=\"red\">The new passwords do not match!</font></b>");

$user=$_SESSION['username'];
$userid = $_SESSION["userid"];
if ($frm_newpwd==$user) die("<b><font color=\"red\">The new password can not be equal to the username!</font></b>");
 
  // same test as in the login process first
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$salt = retrieve_salt();
$hash_oldpwd = salt_and_hash($frm_oldpwd, $salt);
$hash_newpwd = salt_and_hash($frm_newpwd, $salt);

$query="SELECT * from tbuser WHERE id=$userid AND password='$frm_oldpwd' AND encrypted=0 LIMIT 1"; 
$result=mysql_query($query); 
$nums=mysql_numrows($result);

if ($nums==0) {
  
  $query3="SELECT * from tbuser WHERE id=$userid AND passwhash='$hash_oldpwd' AND encrypted=1 LIMIT 1"; 
  $result3=mysql_query($query3); 
  $nums3=mysql_numrows($result3);
  
  if ($nums3==0) {
     mysql_close();
     die("<b>The old password is wrong. Could not change password.</b>");
  }	 
}

 
$query2="UPDATE tbuser SET password='****',passwhash='$hash_newpwd',encrypted=1 WHERE id=$userid"; 
$result2=mysql_query($query2); 

mysql_close();
echo ("Password changed!");
 
js_redirect("index.php");

?>

