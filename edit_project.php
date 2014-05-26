<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Edit Project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("utils/components.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to edit projects</b>");
?>
<?php
include("conf/config.inc.php");
if (isset($_GET['id'])) $id=$_GET['id']; else $id="";

if ($id!="") {
    // on the second call ID is empty
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbproject` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $projectid=mysql_result($result7,0,"id");
    $name=mysql_result($result7,0,"name");          
    $description=mysql_result($result7,0,"description");
	$dbtype=mysql_result($result7,0,"dbtype");
	$useclause=mysql_result($result7,0,"useclause");

    mysql_close();
} else {
    $projectid=$id;
	$name="";
	$description="";
	$dbtype="";
	$useclause="";
}   
?>

<h2>Edit Project <?php echo "$name"; ?></h2>
<form action="edit_project.php" method="post">
<table>
<tr>
<td>Description:</td>
<td><textarea name="description" rows="10" cols="70">
<?php echo "$description";  ?>
</textarea></td>
<td></td>
</tr>
<?php
 echo "<tr><td><b>Database Type:</b></td><td>";
 printDatabaseComboBox($dbtype);
 echo "</td><td></td></tr>";

 echo "<tr><td><b>USE clause (database name):</b> </td>";
 echo "<td><input type=\"text\" name=\"frmuseclause\" value=\"$useclause\"></td><td><i>optional database name, for Microsoft SQL server only</i></td></tr>";
 echo "</table>";
 echo "<input type=\"hidden\" name=\"projectid\"  value=\"$projectid\">";
?>

<input type="Submit" value="Save project">
</form>
<?php include("bottom.inc.php"); ?>
<?php
if (isset($_POST['description'])) $frm_description=$_POST['description']; else exit;
$frm_projectid=$_POST['projectid'];
$frm_dbtype=$_POST['frmdbtype'];
$frm_useclause=$_POST['frmuseclause'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="UPDATE `tbproject` SET description='$frm_description', dbtype='$frm_dbtype', useclause='$frm_useclause' WHERE id=$frm_projectid;";
mysql_query($query2);

mysql_close();
js_redirect("list_projects.php");
?>
</body>
</html>
