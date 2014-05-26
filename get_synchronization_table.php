<?php session_start(); ?>
<html>
<head>
<title>deltasql - Get Synchronization Table</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
<link rel="shortcut icon" href="pictures/favicon.ico" />
<script language="javascript"  type="text/javascript" src="validation.js"></script>
<script language="javascript" type="text/javascript">
<?php include("scriptbranches.js"); ?>
</script>
</head>
<body>
<?php
include("utils/constants.inc.php");
include("utils/utils.inc.php");
include("utils/components.inc.php");
if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");
include("conf/config.inc.php");
include("head.inc.php");

if (isset($_GET['id'])) $id=$_GET['id']; else $id="";
if (isset($_GET['name'])) $name=$_GET['name']; else $name="";
echo "<h2>Get Synchronization Table</h2>";

echo "
<form name=\"gettable\" id=\"gettable\" method=\"post\" action=\"synchronization_table.php\">
";
 
 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 
 if ($id=="") {
	echo "Please choose the <b>Project Name</b>: <br><br>";
    printProjectComboBox("", 'onchange="javascript: getBranchesForProject(this.value);"');
	echo "<br><br>";
 } else {
    // call javascript function with id
	echo "<script>getBranchesForProject($id); </script>";
 }
 
 echo "Please select if the Database Schema will <b>follow HEAD or stay a branch</b>: <br><br>";
 echo "<select NAME=\"frmsourcebranch\">";
 // *** For IE compatibility
 $headid=retrieve_head_id();
 if ($id!="") {
    $query="SELECT * FROM tbbranch where (project_id=$id) and (istag=0) order by id ASC";
 } else {
      $query="SELECT * FROM tbbranch where (id<>$headid) and (istag=0) order by id ASC";
 }
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 $i=0;
 echo "<option SELECTED VALUE=\"HEAD\">HEAD";

 while ($i<$num) { 
   $branchid=mysql_result($result,$i,"id");
   $branchname=mysql_result($result,$i,"name");
   echo "<option ";
   echo "VALUE=\"$branchname\">$branchname";
   $i++;
 }
 echo "</select><br><br>";
 // *** End of IE compatibility
 
 mysql_close();
 
?>
<?php
if ($id!="") {
	echo "<input type=\"hidden\" name=\"frmprojectid\"  value=\"$id\">";
	echo "<input type=\"hidden\" name=\"frmprojectname\"  value=\"$name\">";
}
?>

<input type="Submit" value="Get Synchronization Table">
</form>
<?php include("bottom.inc.php"); ?>
</body>
</html>
