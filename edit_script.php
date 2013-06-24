<?php session_start(); ?>
<html>
<head>
<title>deltasql - Edit database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<script language="javascript"  type="text/javascript" src="validation.js"></script>
<script language="javascript"  type="text/javascript" src="scriptbranches.js"></script>
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
<h2>Edit Database Script</h2>
<form name="scriptform" action="edit_script_execution.php" method="post">
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
 echo "<select NAME=\"frmmoduleid\" onchange=\"javascript: getBranchesCheckListForEdit(this.value);\">";
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
 
 echo "<td>Apply script to</td><td>";
 echo "<fieldset name='branchset'><legend>Branches:</legend>";
 echo "</fieldset>";
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

// set checkboxes
 echo "
   <script type='text/javascript'>
    getBranchesCheckListForEdit($pmoduleid);
   </script>
   ";
 
?>
</body>
</html>
