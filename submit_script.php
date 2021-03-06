<?php session_start(); ?>
<html>
<head>
<title>deltasql - Submit database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
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
//show_user_level();
$rights = $_SESSION["rights"];

// this does not seem to work on all Apache instances
//$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<1) die("<b>Not enough rights to insert a new database script.</b>");

 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");

 // checking if there is at least one module, if not print an error message and exit
 $query44="SELECT count(*) FROM tbmodule";
 $result44=mysql_query($query44);
 $modcount=mysql_result($result44,0,"count(*)");
 if ($modcount==0) {
     mysql_close();
	 die("<b><font color=\"red\">You need to create at least one module before submitting scripts.</font></b>");
 }

?>
<h2>Insert a New Database Script</h2>
<form name="scriptform" action="submit_script_execution.php" name="script" method="post">
<table>
<tr>
<td>Title:</td>
<td><input type="text" name="title" value="<?php echo "$default_script_title"; ?>" size="120"></td>
</tr>
<tr>
<td>Author:</td> 
<?php
 // retrieving user name from user id
 // necessary because some old Apaches have problems with the username (why?)
 $query33="SELECT username FROM tbuser WHERE id=$userid";
 $result33=mysql_query($query33);
 $user = mysql_result($result33, 0, "username");

 echo "<td><b>$user</b></td>";
?>
</tr>
<tr>
<td>Module:</td>
<td>
<?php
 echo "<select NAME=\"frmmoduleid\" onchange=\"javascript: getBranchesCheckListForSubmit(this.value);\">";
 echo "<option SELECTED VALUE=\"\">";

 $query6="SELECT * FROM tbmodule ORDER BY name asc";
 $result6=mysql_query($query6);
 $num6=mysql_numrows($result6); 
 
 $i=0;
 while ($i<$num6) { 
   $moduleid=mysql_result($result6,$i,"id");
   $modulename=mysql_result($result6,$i,"name");
   echo "<option VALUE=\"$moduleid\">$modulename";
   $i++;
 }
 echo "</select></td></tr>";

 echo "\n<tr><td>Apply script to:<br>";
 echo "<a onclick=\"SetAllBranches(true);\">all</a> .:. <a onclick=\"SetAllBranches(false);\">none</a></td><td>";
 echo "<fieldset name='branchset'><legend>Branches:</legend>";

 // ****
 // We live branches for IE compatibility where intelligent branch selection does not work for some reason, if there would not be IE, we could remove it
 $query7="SELECT * FROM tbbranch WHERE visible=1 AND istag=0 order by name ASC";
 $result7=mysql_query($query7);
 $num7=mysql_numrows($result7); 
 
 // HEAD comes first
 $headid=retrieve_head_id();

 echo "<input name=\"BRANCH_$headid\" type=\"checkbox\" value=\"1\" checked=\"checked\" /><label>HEAD</label>";

 $i=0;
 while ($i<$num7) { 
   $branchid=mysql_result($result7,$i,"id");
   $branchname=mysql_result($result7,$i,"name");

   if ($branchname!="HEAD") { 
     echo "<input name=\"BRANCH_$branchid\" type=\"checkbox\" value=\"1\"";
     echo "/><label>$branchname</label>";
   } 
   $i++;
 }
 // End of IE compatiblity
 // ****
 
 
 echo "</fieldset>";
 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td>Particular script (optional):</td><td>";
 echo "<input name=\"frmisaview\" type=\"checkbox\" value=\"1\"/>View";
 echo "<input name=\"frmisapackage\" type=\"checkbox\" value=\"1\"/>Package";
 echo "</td></tr>";
 
 mysql_close();
?>

</table>
Script: <a onclick="RemoveEmptyLines();">Remove empty lines</a><br>
<textarea name="script" rows="25" cols="<?php echo "$wide_textarea_chars"; ?>">
</textarea><br>
Comments:<br>
<textarea name="comment" rows="2" cols="<?php echo "$wide_textarea_chars"; ?>">
</textarea>
<br>
<?php
if (isset($_SESSION['chainscriptsubmit'])) $chainscriptsubmit = $_SESSION['chainscriptsubmit']; else $chainscriptsubmit = ""; 
echo "<input name=\"anothersubmit\" type=\"checkbox\" value=\"1\" ";
if ($chainscriptsubmit==1) echo "checked=\"checked\"";
echo " />Submit Another Script after this one<br>";
?>
<input type="Submit" value="Submit script">
</form>
<?php include("bottom.inc.php") ?> 
</body>
</html>
