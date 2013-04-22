<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Branch from existing tag</title>
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
if ($rights<2) die("<b>Not enough rights to create a branch or a tag</b>");
?>
<?php
include("conf/config.inc.php");
if (isset($_GET['id'])) $id=$_GET['id']; else $id="";

if ($id!="") {
    // on the second call ID is empty and this block is not executed
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbbranch` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $branchid=mysql_result($result7,0,"id");
    $projectid=mysql_result($result7,0,"project_id");
	$name=mysql_result($result7,0,"name");  
    $description=mysql_result($result7,0,"description");
	
	$sourcebranchid=mysql_result($result7,0,"sourcebranch_id");
	$sourcebranch  =mysql_result($result7,0,"sourcebranch");
	
	$versionnr = mysql_result($result7,0,"versionnr");; 
	
    echo "<h2>Branch from Existing Tag: $name</h2>";
 
    mysql_close();   
}    
?>


<form action="branch_from_existing_tag.php" method="post">
Name:<br>
<input type="text" name="newname" value="<?php 
    echo "BRANCH_from_tag_$name"; 
?>" size="30"><br>
Description:<br>
<textarea name="newdescription" rows="10" cols="70">
<?php 
   echo "This is a branch from the existing tag $name.";
?>
</textarea>
<br>
<?php
echo "<input type=\"hidden\" name=\"branchid\"  value=\"$branchid\">";
echo "<input type=\"hidden\" name=\"projectid\"  value=\"$projectid\">";

echo "<input type=\"hidden\" name=\"versionnr\"  value=\"$versionnr\">";
echo "<input type=\"hidden\" name=\"oldname\"  value=\"$name\">";

echo "<input type=\"hidden\" name=\"sourcebranchid\"  value=\"$sourcebranchid\">";
echo "<input type=\"hidden\" name=\"sourcebranch\"  value=\"$sourcebranch\">";

?>
<input type="Submit" value="Insert">
</form>
<?php include("bottom.inc.php"); ?>

<?php
if (isset($_POST['newname'])) $frm_newname=$_POST['newname']; else $frm_newname="";
if (isset($_POST['oldname'])) $frm_oldname=$_POST['oldname']; else $frm_oldname="";
if (isset($_POST['newdescription'])) $frm_newdescription=$_POST['newdescription']; else $frm_description="";
if (isset($_POST['branchid'])) $frm_oldbranchid=$_POST['branchid']; else $frm_oldbranchid="";
if (isset($_POST['projectid'])) $frm_projectid=$_POST['projectid']; else $frm_projectid="";
if (isset($_POST['versionnr'])) $frm_versionnr=$_POST['versionnr']; else $frm_versionnr="";
if (isset($_POST['sourcebranchid'])) $frm_sourcebranchid=$_POST['sourcebranchid']; else $frm_sourcebranchid="";
if (isset($_POST['sourcebranch'])) $frm_sourcebranch=$_POST['sourcebranch']; else $frm_sourcebranch="";
if ($frm_sourcebranchid=="")  exit;
if (($frm_newname==$frm_oldname) || ($frm_newname=="")) {
   js_redirect("list_branches.php");
   //die ("<b>Not possible to create a branch named exactly the same as the existing tag!</b>");
}

if ($frm_newname=="HEAD") {
  js_redirect("list_branches.php");
  //die ("<b>Not possible to create a branch named HEAD!</b>");
}

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible,sourcebranch,istag,sourcebranch_id) VALUES('','$frm_newname','$frm_newdescription',NOW(), $frm_versionnr, $frm_projectid, 1, '$frm_sourcebranch',0,$frm_sourcebranchid);";
mysql_query($query);

mysql_close();

js_redirect("list_branches.php");
?>
</body>
</html>
