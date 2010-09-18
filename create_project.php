<?php session_start(); ?>
<html>
<title>deltasql - Insert a new Project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to insert a new project.</b>");
?>
<h2>Insert a new Project</h2>
<form action="create_project.php" method="post">
Name:<br> 
<input type="text" name="name" size="30"><br>
Description:<br>
<textarea name="description" rows="10" cols="70">
</textarea>
<br>
<input type="Submit">
</form>
<a href="index.php">Back to main menu</a>

<?php
$frm_name=$_POST['name'];
$frm_description=$_POST['description'];
if ($frm_name=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr=get_and_increase_global_version();
$query="INSERT INTO tbproject (id, name, description,create_dt) VALUES('','$frm_name','$frm_description',NOW());";
mysql_query($query);

$query2="SELECT * FROM tbproject WHERE name='$frm_name';";
$result2 = mysql_query($query2);
$projectid=mysql_result($result2,0,"id");

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>