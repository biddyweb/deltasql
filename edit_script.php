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
include("utils/constants.inc.php");
include("utils/sendmail.inc.php");
include("changelog.inc.php");

show_user_level();
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to edit a database script.</b>");

if (isset($_GET['id'])) $paramscriptid=$_GET['id']; else $paramscriptid="";
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
<td><input type="text" name="title" value="<?php if (!isset($_POST['script'])) echo "$ptitle"; ?>" size="120"></td>
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
 if (!isset($_POST['script']))  {
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
 } //!isset
?>

</table>
Script:<br>
<textarea name="script" rows="20" cols="<?php echo "$wide_textarea_chars"; ?>">
<?php if (!isset($_POST['script'])) echo "$pscript"; ?>
</textarea><br>
Comments:<br>
<textarea name="comment" rows="2" cols="<?php echo "$wide_textarea_chars"; ?>">
<?php if (!isset($_POST['script'])) echo "$pcomments"; ?>
</textarea>
<br>
<?php
if (!isset($_POST['script'])) {
	echo "<input type=\"hidden\" name=\"scriptid\"  value=\"$paramscriptid\" />";
	echo "<input name=\"frmincversion\" type=\"checkbox\" value=\"1\" />Give latest version number to the edited script (use with care!)";
}
?>
<br>
<br>
<input type="Submit" value="Save script">
</form>
<?php
include("bottom-with-navbar.inc.php");
?>

<?php
if (isset($_POST['script'])) $frm_script=$_POST['script']; else exit;

if (isset($_POST['comment'])) $frm_comment=$_POST['comment']; else $frm_comment="";
if (isset($_POST['frmmoduleid'])) $frm_moduleid=$_POST['frmmoduleid']; else $frm_moduleid="";
if (isset($_POST['title'])) $frm_title=$_POST['title']; else $frm_title="";
if (isset($_POST['scriptid'])) $frm_scriptid=$_POST['scriptid']; else $frm_scriptid="";
if (isset($_POST['frmisaview'])) $frm_isaview=$_POST['frmisaview']; else $frm_isaview="";
if (isset($_POST['frmisapackage'])) $frm_isapackage=$_POST['frmisapackage']; else $frm_isapackage="";
if (isset($_POST['frmincversion'])) $frm_incversion=$_POST['frmincversion']; else $frm_incversion="";
if ($frm_isaview=="") $frm_isaview=0;
if ($frm_isapackage=="") $frm_isapackage=0;

//echo "<p>";
// echo "*$frm_script* *$frm_comment* *$frm_moduleid* *$frm_title* *$userid* *$version*";
//echo "</p>";
$link=mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$frm_script = mysql_real_escape_string($frm_script, $link);
$frm_title = mysql_real_escape_string($frm_title, $link);
$frm_comment = mysql_real_escape_string($frm_comment, $link);

// 0. Copy script to changelog
copy_script_to_changelog($frm_scriptid);

// 1. Update script
$query="UPDATE tbscript set code='$frm_script', title='$frm_title', comments='$frm_comment', module_id=$frm_moduleid,isaview=$frm_isaview,isapackage=$frm_isapackage, update_dt=NOW(), update_user='$user' where id=$frm_scriptid;";
mysql_query($query);

if ($frm_incversion==1) {
   $version = get_and_increase_global_version();
   $query5="UPDATE tbscript set versionnr=$version where id=$frm_scriptid;";
   mysql_query($query5);
} else {
  // retrieve version for email notification
  $query22="SELECT * FROM tbscript WHERE id=$frm_scriptid;";
  mysql_query($query22);
  $result22=mysql_query($query22);
  $version=mysql_result($result22,0,"versionnr");
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
   
   if (isset($_POST["BRANCH_$branchid"])) $branchnamepost = $_POST["BRANCH_$branchid"]; else $branchnamepost="";
   if ($branchnamepost=="1") {
      //echo "<b>$scriptid $branchid $branchname</b> ";
      $query4="INSERT INTO tbscriptbranch (id, script_id, branch_id) VALUES ('', $frm_scriptid, $branchid);";
      mysql_query($query4);
   }
   $i++;
}

// 4. Email notification
if ($emails_enable) {
  $body = "$frm_script";
  if ($frm_comment!="") $body="$body\n/*\n$frm_comment\n*/";
  $query16="SELECT * FROM tbmodule WHERE id=$frm_moduleid";
  mysql_query($query16);
  $result16=mysql_query($query16);
  $modulename=mysql_result($result16,0,"name");
  $branches=list_branches($frm_scriptid);
  
  $subject="$emails_subject_identifier($modulename) $version edited by $user for$branches: $frm_title";
  notify_users_with_email($sendmail_command,$deltasql_path,$emails_sender, $subject, $body);
}

mysql_close();
js_redirect("show_script.php?id=$frm_scriptid&edit=1");
?>

</body>
</html>
