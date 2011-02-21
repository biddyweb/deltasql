<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Edit Project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to edit projects</b>");
?>
<a href="list_projects.php">Back to List Projects</a>

<?php
include("conf/config.inc.php");
$id=$_GET['id'];

if ($id!="") {
    // on the second call ID is empty
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbproject` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $projectid=mysql_result($result7,0,"id");
    $name=mysql_result($result7,0,"name");          
    $description=mysql_result($result7,0,"description");

    mysql_close();
}    
?>

<h2>Edit Project <?php echo "$name"; ?></h2>
<form action="edit_project.php" method="post">
Description:<br>
<textarea name="description" rows="10" cols="70">
<?php echo "$description";  ?>
</textarea>
<br>
<?php
echo "<input type=\"hidden\" name=\"projectid\"  value=\"$projectid\">";
?>
<input type="Submit" value="Save project">
</form>
<a href="list_projects.php">Back to List Projects</a>

<?php
$frm_description=$_POST['description'];
$frm_projectid=$_POST['projectid'];
if ($frm_description=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="UPDATE `tbproject` SET description='$frm_description' WHERE id=$frm_projectid;";
mysql_query($query2);

mysql_close();
js_redirect("list_projects.php");
?>
</body>
</html>
