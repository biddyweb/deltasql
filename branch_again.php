<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Branch Again</title>
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
if ($rights<2) die("<b>Not enough rights to duplicate a branch</b>");
?>
<a href="list_branches.php">Back to List Branches</a>

<?php
include("conf/config.inc.php");
$id=$_GET['id'];

if ($id!="") {
    // on the second call ID is empty
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbbranch` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $branchid=mysql_result($result7,0,"id");
    $projectid=mysql_result($result7,0,"project_id");
    $versionnr=mysql_result($result7,0,"versionnr");
    $name=mysql_result($result7,0,"name");  
    $description=mysql_result($result7,0,"description");

    mysql_close();
}    
?>

<h2>Branch again <?php echo "$name"; ?></h2>
<form action="branch_again.php" method="post">
Name:<br>
<input type="text" name="newname" value="<?php echo "$name"; echo "_copy"; ?>" size="30"><br>
Description:<br>
<textarea name="newdescription" rows="10" cols="70">
<?php echo "This is a branch of $name.";  ?>
</textarea>
<br>
<?php
echo "<input type=\"hidden\" name=\"branchid\"  value=\"$branchid\">";
echo "<input type=\"hidden\" name=\"projectid\"  value=\"$projectid\">";
echo "<input type=\"hidden\" name=\"versionnr\"  value=\"$versionnr\">";
echo "<input type=\"hidden\" name=\"oldname\"  value=\"$name\">";
?>
<input type="Submit">
</form>
<a href="list_branches.php">Back to List Branches</a>

<?php
$frm_newname=$_POST['newname'];
$frm_oldname=$_POST['oldname'];
$frm_newdescription=$_POST['newdescription'];
$frm_oldbranchid=$_POST['branchid'];
$frm_projectid=$_POST['projectid'];
$frm_versionnr=$_POST['versionnr'];
if ($frm_oldbranchid=="") exit;
if (($frm_newname==$frm_oldname) || ($frm_newname=="")) {
    js_redirect("list_branches.php");
    exit;
}
if ($frm_newname=="HEAD") {
  die ("<b>Not possible to create a branch named HEAD!</b>");
}

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$versionnr = get_and_increase_global_version();
$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible,sourcebranch,istag,sourcebranch_id) VALUES('','$frm_newname','$frm_newdescription',NOW(), $versionnr, $frm_projectid, 1, '$frm_oldname',0,$frm_oldbranchid);";
mysql_query($query);

mysql_close();
js_redirect("list_branches.php");

?>
</body>
</html>