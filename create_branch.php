<?php session_start(); ?>
<html>
<title>deltasql - Insert a new database branch</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
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

echo "<h2>Insert a New Branch for Project $projectname</h2>";
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
<input type="Submit" value="Create branch">
</form>
<?php include("bottom.inc.php"); ?>
<?php
if (isset($_POST['name'])) $frm_name=$_POST['name']; else exit;
$frm_description=$_POST['description'];
$frm_projectid=$_POST['frmprojectid'];
$frm_versionnr=$_POST['frmversionnr'];

if ($frm_name=="HEAD") die ("<b>Not possible to create a branch named HEAD!</b>");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr = get_and_increase_global_version();
$headid    = retrieve_head_id();
$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible,sourcebranch,istag,sourcebranch_id) VALUES('','$frm_name','$frm_description',NOW(),$frm_versionnr, $frm_projectid, 1, 'HEAD',0,$headid);";
mysql_query($query);

mysql_close();
js_redirect("list_projects.php");
?>

</body>
</html>
