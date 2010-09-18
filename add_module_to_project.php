<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>deltasql - Add module to project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>

<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to add a module to the project.</b>");

$projectid = $_GET['id'];
$projectname = $_GET['name'];

?>
<h2>Insert a new database module to the project <?php echo "$projectname";?></h2>
<form action="add_module_to_project.php" method="post">
<?php
 echo "<select NAME=\"frmmoduleid\">";
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT * FROM tbmodule";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 
 $i=0;
 while ($i<$num) { 
   $moduleid=mysql_result($result,$i,"id");
   $modulename=mysql_result($result,$i,"name");
   echo "<option VALUE=\"$moduleid\">$modulename";
   $i++;
 }
 echo "</select></td></tr>";
 echo "<input type=\"hidden\" name=\"frmprojectid\"  value=\"$projectid\">";
 echo "<input type=\"hidden\" name=\"frmprojectname\"  value=\"$projectname\">";
 mysql_close();
?>

<input type="Submit">
</form>
<a href="index.php">Back to main menu</a>

<?php
$frm_moduleid=$_POST['frmmoduleid'];
$frm_projectid=$_POST['frmprojectid'];
$frm_projectname=$_POST['frmprojectname'];

if ($frm_moduleid=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="INSERT INTO tbmoduleproject (id, module_id, project_id) VALUES('',$frm_moduleid, $frm_projectid);";
mysql_query($query);

mysql_close();
js_redirect("list_project_modules.php?id=$frm_projectid&amp;name=$frm_projectname");
?>

</body>
</html>