<?php session_start(); ?>
<html>
<title>deltasql - Insert a new database module</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to insert a new branch.</b>");

$projectid   = $_GET['id'];
$projectname = $_GET['name'];

echo "<h2>Insert a new branch for project $projectname</h2>";
?>

<form action="create_branch.php" method="post">
<b>Name:</b><br> 
<input type="text" name="name" size="30"><br>
<b>Description:</b><br>
<textarea name="description" rows="5" cols="70">
</textarea><br>
<b>Version Number:</b><br>
<input type="text" name="frmversionnr" value="<?php 
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $versionnr=get_global_version(); 
 echo "$versionnr";
 mysql_close();
?>"><br>
<br>

<?php
echo "<input type=\"hidden\" name=\"frmprojectid\"  value=\"$projectid\">";
?>
<input type="Submit">
</form>
<a href="index.php">Back to main menu</a>

<?php
$frm_name=$_POST['name'];
$frm_description=$_POST['description'];
$frm_projectid=$_POST['frmprojectid'];
$frm_versionnr=$_POST['frmversionnr'];
if ($frm_name=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr=get_global_version();
$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible) VALUES('','$frm_name','$frm_description',NOW(),$frm_versionnr, $frm_projectid, 1);";
mysql_query($query);

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>