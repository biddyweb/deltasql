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
<a href="list_branches.php">Back to List Branches or Tags</a>

<?php
include("conf/config.inc.php");
$id=$_GET['id'];
$tag=$_GET["tag"];

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
      echo "<h2> Tag on branch $name at version $versionnr</h2>";
   }
   mysql_close();   

}    
?>


<form action="branch_again.php" method="post">
Name:<br>
<input type="text" name="newname" value="<?php 
  if ($tag==0) {
    echo "BRANCH_$name.$versionnr"; 
  } else {
    echo "TAG_$name.$versionnr";
  }  
?>" size="30"><br>
Description:<br>
<textarea name="newdescription" rows="10" cols="70">
<?php 
  if ($tag==0) {
   echo "This is a branch of $name.";
  } else {
   echo "This is a tag on branch $name at version $versionnr.";
  }  
?>
</textarea>
<br>
<?php
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
?>
<input type="Submit" value="Insert">
</form>
<a href="list_branches.php">Back to List Branches or Tags</a>

<?php
$frm_newname=$_POST['newname'];
$frm_oldname=$_POST['oldname'];
$frm_newdescription=$_POST['newdescription'];
$frm_oldbranchid=$_POST['branchid'];
$frm_projectid=$_POST['projectid'];
$frm_versionnr=$_POST['versionnr'];
$frm_istag=$_POST['istag'];
if (($frm_oldbranchid=="") && ($frm_istag==0)) exit;
if (($frm_newname==$frm_oldname) || ($frm_newname=="")) {
    js_redirect("list_branches.php");
    exit;
}
if ($frm_newname=="HEAD") {
  die ("<b>Not possible to create a branch named HEAD!</b>");
}
// exception for tags on HEAD
if ($frm_projectid=="") die("<b>You need to assign a project to the tag!</b>");;

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="INSERT INTO tbbranch (id, name, description,create_dt,versionnr,project_id,visible,sourcebranch,istag,sourcebranch_id) VALUES('','$frm_newname','$frm_newdescription',NOW(), $frm_versionnr, $frm_projectid, 1, '$frm_oldname',$frm_istag,$frm_oldbranchid);";
mysql_query($query);

mysql_close();

js_redirect("list_branches.php");
?>
</body>
</html>
