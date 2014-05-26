<?php session_start(); ?>
<html>
<title>deltasql - Insert a new Project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
include("utils/components.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to insert a new project.</b>");
?>
<h2>Insert a New Project</h2>
<form action="create_project.php" method="post">
<table border="0">
<tr>
<td>Name:</td> 
<td><input type="text" name="name" size="30"></td>
<td></td>
</tr>
<tr>
<td>Description:</td>
<td><textarea name="description" rows="10" cols="70"></textarea></td>
</tr>
<?php
 echo "<tr><td><b>Database Type:</b></td><td>";
 printDatabaseComboBox("");
 echo "</td><td></td></tr>";

 echo "<tr><td><b>USE clause (database name):</b> </td>";
 echo "<td><input type=\"text\" name=\"frmuseclause\" value=\"\"></td><td><i>optional database name, for Microsoft SQL server only</i></td></tr>";
?>
</table>
 <input type="Submit" value="Create project">
</form>
<?php include("bottom.inc.php"); ?>

<?php
if (isset($_POST['name'])) $frm_name=$_POST['name']; else exit;
$frm_description=$_POST['description'];
$frm_useclause=$_POST['frmuseclause'];
$frm_dbtype=$_POST['frmdbtype'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr=get_and_increase_global_version();
$query="INSERT INTO tbproject (id, name, description,create_dt,dbtype,useclause) VALUES('','$frm_name','$frm_description',NOW(),'$frm_dbtype','$frm_useclause');";
mysql_query($query);

$query2="SELECT * FROM tbproject WHERE name='$frm_name';";
$result2 = mysql_query($query2);
$projectid=mysql_result($result2,0,"id");

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>
