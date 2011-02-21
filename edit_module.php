<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Edit database module</title>
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
if ($rights<2) die("<b>Not enough rights to edit modules</b>");
?>
<a href="list_modules.php">Back to List Modules</a>

<?php
include("conf/config.inc.php");
$id=$_GET['id'];

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
}    
?>

<h2>Edit database module</h2>
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
<a href="list_modules.php">Back to List Modules</a>

<?php
$frm_name=$_POST['name'];
$frm_description=$_POST['description'];
$frm_moduleid=$_POST['moduleid'];
if ($frm_name=="") exit;
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="UPDATE `tbmodule` SET name='$frm_name', description='$frm_description' WHERE id=$frm_moduleid;";
mysql_query($query2);

mysql_close();
js_redirect("list_modules.php");
?>
</body>
</html>
