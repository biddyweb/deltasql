<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Duplicate Branch</title>
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

<h2>Duplicate Branch <?php echo "$name"; ?></h2>
<form action="duplicate_branch.php" method="post">
Name:<br>
<input type="text" name="newname" value="<?php echo "$name"; echo "_copy"; ?>" size="30"><br>
Description:<br>
<textarea name="newdescription" rows="10" cols="70">
<?php echo "This branch is a duplicate of $name.";  ?>
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
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible) VALUES('','$frm_newname','$frm_newdescription',NOW(),$frm_versionnr, $frm_projectid, 1);";
mysql_query($query);

// retrieve now the new branch id
$query2="SELECT id from tbbranch where name='$frm_newname'";
$result2=mysql_query($query2);
$newbranchid=mysql_result($result2,0,"id");

// go through the table tbscriptbranch and insert new entries with the new branch
$query3="SELECT * from tbscriptbranch where branch_id=$frm_oldbranchid";
$result3=mysql_query($query3);
$num=mysql_numrows($result3);

$i=0;
while ($i<$num) {   
    
    $scriptid=mysql_result($result3,$i,"script_id");
    $query4="INSERT INTO tbscriptbranch (id, script_id, branch_id) VALUES ('', $scriptid, $newbranchid);";
    mysql_query($query4);

    $i++;
}

mysql_close();
js_redirect("list_branches.php");

?>
</body>
</html>