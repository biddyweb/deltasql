<?php session_start(); ?>
<html>
<head>
<title>deltasql - Delete project</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
$rights = $_SESSION["rights"];
$user = $_SESSION["username"];
$userid = $_SESSION["userid"];
if ($rights<2) die("<b>Not enough rights to delete a project.</b>");

$id = $_GET['id'];
$name = $_GET['name'];
if ($id=="") exit;

echo "<h2>Please confirm <b>project deletion</b>:</h2>";

echo "<h3><b>$name</b></h3><br><br><br>";

include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
$query="SELECT * from tbbranch where project_id=$id"; 
$result=mysql_query($query);
if ($result!="") $num=mysql_numrows($result); else $num=0; 

if ($num>0) {
 echo "<p><b>WARNING:</b> Following branches will be deleted as well, together with their script reference. ";
 echo "The scripts itself will not be deleted. <br></p>";

 echo "<table>";
 echo "<tr>
<th>branch name</th>
<th>description</th>
<th>updated</th>
<th>version</th>
<th>visible</th>
</tr>";
}

$i=0;
while ($i<$num) {
$branchname=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");
$versionnr=mysql_result($result,$i,"versionnr");
$visible=mysql_result($result,$i,"visible");

echo "
<tr>
<td><h3>$branchname</h3></td>
<td>$description</td>
<td>$create_dt</td>
<td>$versionnr</td>
<td>$visible</td>
</tr>
";

$i++;
}

if ($num>0) echo "</table>";

mysql_close();

echo "<p>Are you sure that you want to delete this project? If not, please press the <b>Back</b> button on your browser</p>";

echo "<ul>";
echo "<li><b><a href=\"delete_project.php?id=$id\">Yes, delete project $name</a></b></li>";
echo "</ul>";
?>

<hr>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>