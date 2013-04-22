<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Edit Branch or Tag</title>
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
if ($rights<2) die("<b>Not enough rights to edit a branch</b>");
?>
<?php
include("conf/config.inc.php");
if (!isset($_GET['id'])) $id=''; else $id=$_GET['id'];

if ($id!="") {
    // on the second call ID is empty
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbbranch` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $branchid=mysql_result($result7,0,"id");
    $name=mysql_result($result7,0,"name");          
    $description=mysql_result($result7,0,"description");

    mysql_close();
}    
?>

<h2>Edit Branch or Tag "<?php if (isset($name)) echo "$name"; ?>"</h2>
<form action="edit_branch.php" method="post">
Description:<br>
<textarea name="description" rows="10" cols="70">
<?php if (isset($description)) echo "$description";  ?>
</textarea>
<br>
<?php
 if (isset($branchid)) echo "<input type=\"hidden\" name=\"branchid\"  value=\"$branchid\">";
?>
<input type="Submit" value="Save">
</form>
<?php include("bottom.inc.php"); ?>

<?php
if (isset($_POST['description'])) $frm_description=$_POST['description']; else exit;
$frm_branchid=$_POST['branchid'];

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query2="UPDATE `tbbranch` SET description='$frm_description' WHERE id=$frm_branchid;";
mysql_query($query2);

mysql_close();
js_redirect("list_branches.php");
?>
</body>
</html>
