<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head> 
    <title>deltasql - Insert a new database module</title>
    <link rel="stylesheet" type="text/css" href="deltasql.css">
  </head>
  <body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to insert a new database module.</b>");
?>
<h2>Insert a new database module</h2>
<form action="create_module.php" method="post">
Name:<br> 
<input type="text" name="name" size="60"><br>
Description:<br>
<textarea name="description" rows="10" cols="70">
</textarea>
<br>
<input type="Submit" value="Create module">
</form>
<hr>
<a href="index.php"><img src="icons/home.png"> Back to main page</a>
<?php
if (isset($_POST['name']))  $frm_name=$_POST['name']; else exit;
$frm_description=$_POST['description'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr=get_and_increase_global_version();
$query="INSERT INTO tbmodule (id, name, description,create_dt,lastversionnr) VALUES('','$frm_name','$frm_description',NOW(),$versionnr);";
mysql_query($query);

mysql_close();
js_redirect("list_modules.php");
?>

</body>
</html>
