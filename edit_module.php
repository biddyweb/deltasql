<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Edit database module</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

show_user_level();
$rights = $_SESSION["rights"];
if ($rights<2) die("<b>Not enough rights to edit modules</b>");
?>

<?php
include("conf/config.inc.php");
if (isset($_GET['id'])) $id=$_GET['id']; else $id="";

if ($id!="") {
    // on the second call ID is empty
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbmodule` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $moduleid=mysql_result($result7,0,"id");
    $name=mysql_result($result7,0,"name");          
    $description=mysql_result($result7,0,"description");

    mysql_close();
} else {
	$name="";
	$description="";
}   
?>

<h2>Edit Database Module</h2>
<form action="edit_module.php" method="post">
Name:<br> 
<input type="text" name="name" size="60" value="<?php echo "$name"; ?>"><br>
Description:<br>
<textarea name="description" rows="10" cols="70">
<?php echo "$description";  ?>
</textarea>
<br>
<?php
echo "<input type=\"hidden\" name=\"moduleid\"  value=\"$moduleid\">";
?>
<input type="Submit" value="Save module">
</form>
<?php include("bottom.inc.php"); ?>
<?php
if (isset($_POST['name'])) $frm_name=$_POST['name']; else exit;
$frm_description=$_POST['description'];
$frm_moduleid=$_POST['moduleid'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="UPDATE `tbmodule` SET name='$frm_name', description='$frm_description' WHERE id=$frm_moduleid;";
mysql_query($query2);

mysql_close();
js_redirect("list_modules.php");
?>
</body>
</html>
