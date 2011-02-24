<?php session_start(); ?>
<html>
<head>
<title>deltasql - Edit database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
show_user_level();
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to edit a database script.</b>");

$paramscriptid=$_GET['id'];
// retrieve the script information
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

if ($paramscriptid!="") {
	$query10="SELECT * from tbscript where id=$paramscriptid"; 
	$result10=mysql_query($query10); 

	$ptitle=mysql_result($result10,0,"title");           
	$pcomments=mysql_result($result10,0,"comments");
	$pcreate_dt=mysql_result($result10,0,"create_dt");
	$pversionnr=mysql_result($result10,0,"versionnr");
	$pmoduleid=mysql_result($result10,0,"module_id");
	$pscriptuserid=mysql_result($result10,0,"user_id");
	$pscript=mysql_result($result10,0,"code");
	$pisaview=mysql_result($result10,0,"isaview");
	$pisapackage=mysql_result($result10,0,"isapackage");
}

?>
<h2>Edit database script</h2>
<form action="edit_script.php" method="post">
<table>
<tr>
<td>Title:</td>
<td><input type="text" name="title" value="<?php echo "$ptitle"; ?>" size="100"></td>
</tr>
<tr>
<td>Author:</td> 
<?php
 echo "<td><b>$user</b></td>";
?>
</tr>
<tr>
<td>Module:</td>
<td>
<?php
 echo "<select NAME=\"frmmoduleid\">";
 $query6="SELECT * FROM tbmodule ORDER BY name ASC";
 $result6=mysql_query($query6);
 $num6=mysql_numrows($result6); 
 
 $i=0;
 while ($i<$num6) { 
   $moduleid=mysql_result($result6,$i,"id");
   $modulename=mysql_result($result6,$i,"name");
   echo "<option ";
   if ($moduleid==$pmoduleid) echo "SELECTED ";
   echo "VALUE=\"$moduleid\">$modulename";
   $i++;
 }
 echo "</select></td></tr>";
 echo "<tr><td>Version:</td><td><b>$pversionnr</b></td></tr>";
 
 echo "<td>Apply script to:</td><td>";
 
 $query7="SELECT * FROM tbbranch WHERE visible=1 and istag=0 order by id 
ASC";
 $result7=mysql_query($query7);
 $num7=mysql_numrows($result7); 
 
 $i=0;
 while ($i<$num7) { 
   $branchid=mysql_result($result7,$i,"id");
   $branchname=mysql_result($result7,$i,"name");
   echo "<input name=\"BRANCH_$branchid\" type=\"checkbox\" value=\"1\"";
   
   // check if the script belongs to this branch in the while loop
   $query9="SELECT * FROM tbscriptbranch WHERE script_id=$paramscriptid AND branch_id=$branchid";
   $result9=mysql_query($query9);
   if ($result9!="") {
     $num9=mysql_numrows($result9);
     if ($num9>0) echo "checked=\"checked\"";
   }
   echo "/>$branchname |";
   $i++;
 }
 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td>Particular script (optional):</td>";
 echo "<td><input name=\"frmisaview\" type=\"checkbox\" value=\"1\"";
 if ($pisaview==1) echo "checked=\"checked\"";
 echo "/>View";
 echo "<input name=\"frmisapackage\" type=\"checkbox\" value=\"1\"";
 if ($pisapackage==1) echo "checked=\"checked\"";
 echo "/>Package</td>";
 echo "</tr>";

 mysql_close();
?>

</table>
Script:<br>
<textarea name="script" rows="20" cols="100">
<?php echo "$pscript"; ?>
</textarea><br>
Comments:<br>
<textarea name="comment" rows="2" cols="100">
<?php echo "$pcomments"; ?>
</textarea>
<br>
<?php
echo "<input type=\"hidden\" name=\"scriptid\"  value=\"$paramscriptid\" />";
// Feature dropped
// echo "<input name=\"frmincversion\" type=\"checkbox\" value=\"1\" />Gives latest version number to the edited script (use with care!)";
?>
<br>
<br>
<input type="Submit" value="Save script">
</form>
<a href="list_scripts.php">Back to list scripts</a>

<?php
$frm_script=$_POST['script'];
$frm_comment=$_POST['comment'];
$frm_moduleid=$_POST['frmmoduleid'];
$frm_title=$_POST['title'];
$frm_scriptid=$_POST['scriptid'];
$frm_isaview=$_POST['frmisaview'];
$frm_isapackage=$_POST['frmisapackage'];
$frm_incversion=$_POST['frmincversion'];
if ($frm_isaview=="") $frm_isaview=0;
if ($frm_isapackage=="") $frm_isapackage=0;

if ($frm_script=="") exit;
//echo "<p>";
// echo "*$frm_script* *$frm_comment* *$frm_moduleid* *$frm_title* *$userid* *$version*";
//echo "</p>";
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");


// 1. Update script
$query="UPDATE tbscript set code='$frm_script', title='$frm_title', comments='$frm_comment', module_id=$frm_moduleid,isaview=$frm_isaview,isapackage=$frm_isapackage, update_dt=NOW(), update_user='$user' where id=$frm_scriptid;";
mysql_query($query);

if ($frm_incversion==1) {
   $version = get_and_increase_global_version();
   $query5="UPDATE tbscript set versionnr=$version where id=$frm_scriptid;";
   mysql_query($query5);
} 

// 2. we delete the entries in tbscriptbranch
$query2="DELETE FROM tbscriptbranch WHERE script_id=$frm_scriptid";
$result2=mysql_query($query2);

// 3. and create new ones
// we repeat the previous query to add the tbscriptbranch
$query3="SELECT * FROM tbbranch order by id ASC";
$result3=mysql_query($query3);
$num3=mysql_numrows($result3); 

$i=0;
while ($i<$num3) { 
   $branchid=mysql_result($result3,$i,"id");
   $branchname=mysql_result($result3,$i,"name");
   
   $branchnamepost = $_POST["BRANCH_$branchid"];
   if ($branchnamepost=="1") {
      //echo "<b>$scriptid $branchid $branchname</b> ";
      $query4="INSERT INTO tbscriptbranch (id, script_id, branch_id) VALUES ('', $frm_scriptid, $branchid);";
      mysql_query($query4);
   }
   $i++;
}

mysql_close();
js_redirect("list_scripts.php");
?>

</body>
</html>
