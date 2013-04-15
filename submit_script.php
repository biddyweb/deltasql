<?php session_start(); ?>
<html>
<head>
<title>deltasql - Submit database script</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<script type="text/javascript">
<!--
function SetAllBranches(CheckValue)
{
	if(!document.forms['script']) {
		return;
	}
	var objCheckBoxes = document.forms['script'].elements;
	// set the check value for all check boxes
	for(var i = 0; i < objCheckBoxes.length; i++) {
		var obj = objCheckBoxes[i];
		if (obj.name.indexOf('BRANCH_') >= 0) {
			obj.checked = CheckValue;
		}
	}
}

function RemoveEmptyLines() {
  var text = document.forms['script'].elements['script'].value;
  text = text.replace(/\n\n/g, "\n");
  document.forms['script'].elements['script'].value = text;  
  alarm(text);
}
// -->
</script>
</head>
<body>
<?php
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
<h2>Insert a new database script</h2>
<form action="submit_script.php" name="script" method="post">
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
 echo "<select NAME=\"frmmoduleid\">";
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
 
 $query7="SELECT * FROM tbbranch WHERE visible=1 AND istag=0 order by name ASC";
 $result7=mysql_query($query7);
 $num7=mysql_numrows($result7); 
 
 // HEAD comes first
 $headid=retrieve_head_id();

 echo "<input name=\"BRANCH_$headid\" type=\"checkbox\" value=\"1\" checked=\"checked\" /> HEAD ||";

 $i=0;
 while ($i<$num7) { 
   $branchid=mysql_result($result7,$i,"id");
   $branchname=mysql_result($result7,$i,"name");

   if ($branchname!="HEAD") { 
     echo "<input name=\"BRANCH_$branchid\" type=\"checkbox\" value=\"1\"";
     echo "/>$branchname |";
   } 
   $i++;
 }
 
 echo "</td>";
 echo "</tr>";
 
 echo "<tr>";
 echo "<td>Particular script (optional):</td>";
 echo "<td><input name=\"frmisaview\" type=\"checkbox\" value=\"1\"/>View";
 echo "<input name=\"frmisapackage\" type=\"checkbox\" value=\"1\"/>Package</td>";
 echo "</tr>";
 
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
<hr>
<a href="list_scripts.php">Back to List Scripts</a> | <a href="index.php"><img src="icons/home.png"> Back to main page</a>

<?php

if (isset($_POST['script'])) $frm_script=$_POST['script']; else exit;

if (!isset($_POST['frmisaview']))  $frm_isaview=0; else $frm_isaview=$_POST['frmisaview'];
if (!isset($_POST['frmisapackage']))  $frm_isapackage=0; else $frm_isapackage=$_POST['frmisapackage'];
if (!isset($_POST['anothersubmit'])) $frm_anothersubmit=0; else $frm_anothersubmit=$_POST['anothersubmit'];
if (!isset($_POST['comment'])) $frm_comment=''; else $frm_comment=$_POST['comment'];
if (!isset($_POST['frmmoduleid'])) $frm_moduleid=''; else  $frm_moduleid=$_POST['frmmoduleid'];
if (!isset($_POST['title'])) $frm_title=''; else $frm_title=$_POST['title'];

if ($frm_moduleid=="") die("<b><font color=\"red\">Please specify a database module.</font></b>");
//echo "<p>";
// echo "*$frm_script* *$frm_comment* *$frm_moduleid* *$frm_title* *$userid* *$version $frm_isaview  $frm_isapackage*";
//echo "</p>";
$link=mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

// we repeat the previous query to add the tbscriptbranch
$query3="SELECT * FROM tbbranch order by id ASC";
$result3=mysql_query($query3);
$num3=mysql_numrows($result3); 

// 1. Insert script
$version = get_and_increase_global_version();
$frm_script = mysql_real_escape_string($frm_script, $link);
$frm_title = mysql_real_escape_string($frm_title, $link);
$frm_comment = mysql_real_escape_string($frm_comment, $link);
//echo "<b>*$version*</b>";

$query="INSERT INTO tbscript (id, code, title, comments,create_dt,versionnr,user_id,module_id,isaview,isapackage) VALUES('','$frm_script', '$frm_title','$frm_comment',NOW(),$version,$userid,$frm_moduleid,$frm_isaview,$frm_isapackage);";
mysql_query($query);
//echo "$query\n";

// 2. Retrieve id of inserted script
// the query utilize lot of parameters as version might not be atomic in particular circumstances
$query2="SELECT * FROM tbscript WHERE (versionnr=$version) and (user_id=$userid) and (module_id=$frm_moduleid)";
//echo "$query2\n";
$result2=mysql_query($query2);
$scriptid=mysql_result($result2,0,"id");

// 3. Create tbscriptbranch
 $i=0;
 while ($i<$num3) { 
   $branchid=mysql_result($result3,$i,"id");
   $branchname=mysql_result($result3,$i,"name");
   
   if (isset($_POST["BRANCH_$branchid"])) $branchnamepost = $_POST["BRANCH_$branchid"]; else $branchnamepost = ""; 
   if ($branchnamepost=="1") {
      //echo "<b>$scriptid $branchid $branchname</b> ";
      $query3="INSERT INTO tbscriptbranch (id, script_id, branch_id) VALUES ('', $scriptid, $branchid);";
      mysql_query($query3);
   }
   $i++;
 }


// 4. Actualize module version
$query4="UPDATE tbmodule SET create_dt=NOW(),lastversionnr=$version WHERE id=$frm_moduleid";
mysql_query($query4);

// 5. Actualize head version
$query5="UPDATE tbbranch SET versionnr=$version, create_dt=NOW() WHERE name='HEAD'";
mysql_query($query5);

// 6. Notify users with email
if ($emails_enable) {
  $body = "$frm_script";
  if ($frm_comment!="") $body="$body\n/*\n$frm_comment\n*/";
  $query16="SELECT * FROM tbmodule WHERE id=$frm_moduleid";
  mysql_query($query16);
  $result16=mysql_query($query16);
  $modulename=mysql_result($result16,0,"name");
  
  $query21="SELECT * FROM tbuser WHERE id=$userid";
  mysql_query($query21);
  $result21=mysql_query($query21);
  $authorname=mysql_result($result21,0,"username");
  $branches=list_branches($scriptid);
  $subject="$emails_subject_identifier($modulename) $version by $authorname for$branches: $frm_title";
  notify_users_with_email($sendmail_command,$deltasql_path,$emails_sender, $subject, $body);
}
mysql_close();


if ($frm_anothersubmit=="1") {
 $_SESSION['chainscriptsubmit'] = 1;
 js_redirect("submit_script.php");
}
else {
  $_SESSION['chainscriptsubmit'] = 0;
  $_SESSION["scriptoffset"] = 0;
  js_redirect("list_scripts.php");
} 
 ?>

</body>
</html>
