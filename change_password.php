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
<?php
include("conf/config.inc.php");
include("utils/utils.inc.php");

$frm_oldpwd=$_POST['oldpwd'];
$frm_newpwd=$_POST['newpwd'];
$frm_confirmnewpwd=$_POST['confirmnewpwd'];
if ($frm_oldpwd=="") exit;
if ($frm_newpwd!=$frm_confirmnewpwd)
  die("<b>The new passwords do not match!</b>");

$userid = $_SESSION["userid"];
  
  // same test as in the login process first
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbuser WHERE id=$userid AND password='$frm_oldpwd' LIMIT 1"; 
$result=mysql_query($query); 
$nums=mysql_numrows($result);

if ($nums==0) {
  mysql_close();
  die("<b>The old password is wrong. Could not change password.</b>");
}
else {
 
 $query2="UPDATE tbuser SET password='$frm_newpwd' WHERE id=$userid"; 
 $result2=mysql_query($query2); 

 mysql_close();
 echo ("Password changed!");
 
 $_SESSION['password'] = $frm_newpwd;
 js_redirect("index.php");
}


?>
<a href="index.php">Back to main page</a>
</body>
</html>
