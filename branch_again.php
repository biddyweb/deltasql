<?php session_start(); ?>
<html> 
<head>
<title>deltasql - Create branch or create tag</title>
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
if (!isset($_GET['id'])) $id=''; else $id=$_GET['id'];
if (!isset($_GET['tag']))$tag=''; else $tag=$_GET["tag"];

if ($id!="") {
    // on the second call ID is empty and this block is not executed
    mysql_connect($dbserver, $username, $password);
    @mysql_select_db($database) or die("Unable to select database");

    $query="SELECT * from `tbbranch` WHERE id=$id"; 
    $result7=mysql_query($query);  

    $branchid=mysql_result($result7,0,"id");
    $projectid=mysql_result($result7,0,"project_id");
	if ($projectid=="") $projectid="NULL";
    $name=mysql_result($result7,0,"name");  
    $description=mysql_result($result7,0,"description");
	
	$versionnr = get_and_increase_global_version(); 
	
   if ($tag==0) 
      echo "<h2>Branch again $name</h2>";
   else {
      echo "<h2> Tag on Branch $name at Version $versionnr</h2>";
   }
   mysql_close();   

}    
?>


<form action="branch_again.php" method="post">
Name:<br>
<input type="text" name="newname" value="<?php 
  if ($id!='')
  if ($tag==0)  {
    echo "BRANCH_$name.$versionnr"; 
  } else {
    echo "TAG_$name.$versionnr";
  }  
?>" size="30"><br>
Description:<br>
<textarea name="newdescription" rows="10" cols="70">
<?php 
  if ($id!='')
  if ($tag==0) {
   echo "This is a branch of $name.";
  } else {
   echo "This is a tag on branch $name at version $versionnr.";
  }  
?>
</textarea>
<br>
<?php
if ($id!="") {
    // on the second call ID is empty and this block is not executed
	echo "<input type=\"hidden\" name=\"branchid\"  value=\"$branchid\">";
	if ($projectid!="NULL") {
		echo "<input type=\"hidden\" name=\"projectid\"  value=\"$projectid\">";
	} else {
	// plotting project combobox
	mysql_connect($dbserver, $username, $password);
	@mysql_select_db($database) or die("Unable to select database");

	echo "Project: <select NAME=\"projectid\">";
	$query="SELECT * FROM tbproject ORDER BY name";
	$result=mysql_query($query);
	$num=mysql_numrows($result); 
	$i=0;
	while ($i<$num) { 
		$projectid=mysql_result($result,$i,"id");
		$projectname=mysql_result($result,$i,"name");
		echo "<option ";
		echo "VALUE=\"$projectid\">$projectname";
		$i++;
	}
	echo "</select><br><br>";
	mysql_close();
	}  
	echo "<input type=\"hidden\" name=\"versionnr\"  value=\"$versionnr\">";
	echo "<input type=\"hidden\" name=\"oldname\"  value=\"$name\">";
	echo "<input type=\"hidden\" name=\"istag\"  value=\"$tag\">";
}
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
if (isset($_POST['istag'])) $frm_istag=$_POST['istag']; else $frm_istag="";
if (($frm_oldbranchid=="") && ($frm_istag==0)) exit;
if (($frm_newname==$frm_oldname) || ($frm_newname=="")) {
    js_redirect("list_branches.php");
    exit;
}
if ($frm_newname=="HEAD") {
  die ("<b>Not possible to create a branch named HEAD!</b>");
}
// exception for tags on HEAD
if (($frm_projectid=="") || ($frm_projectid=="NULL")) die("<b><font color='red'>You need to assign a project to the tag!</font></b>");;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible,sourcebranch,istag,sourcebranch_id) VALUES('','$frm_newname','$frm_newdescription',NOW(), $frm_versionnr, $frm_projectid, 1, '$frm_oldname',$frm_istag,$frm_oldbranchid);";
mysql_query($query);

mysql_close();

js_redirect("list_branches.php");
?>
</body>
</html>
