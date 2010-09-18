<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>deltasql - Login</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

include("conf/config.inc.php");
?>

<h1>deltasql Login</h1>
<br />

<form name="tlogin" id="tlogin" method="post" action="login_2.php">
<table align="center" width="300">
	<tr align="left">
		<td align="left">Username</td>
		<td align="left"><input type="text" name="name" /></td>
	</tr>
	<tr align="left">
		<td align="left">Password</td>
		<td align="left"><input type="password" name="pwd" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="submit" value="login" /></td>
		<td>&nbsp;</td>
	</tr>
</table>
</form>

<?php
if ($test_system) {
	mysql_connect($dbserver, $username, $password);
	@mysql_select_db($database) or die("Unable to select database");

	$query="SELECT * from tbuser where username='$admin_user'";
	$result=mysql_query($query);
	$admin_pwd=mysql_result($result,0,"password");

	echo "<p>This is a test system. Login with user <b>$admin_user</b> with password <b>$admin_pwd</b> to test all functionality.</p>";
	mysql_close();
}
?>
<a href="index.php">Back to main page</a>
</body>
</html>
