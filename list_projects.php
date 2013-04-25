<?php session_start(); ?>
<html> 
<head>
<title>deltasql - List Projects</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

include("dbsync_currentversion.inc.php");
show_user_level();
if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else $rights=0;

?>
<h2>Projects</h2>
<table border="1">

<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbproject ORDER BY name ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "<tr>
<th>id</th>
<th>name</th>
<th>description</th>
<th>create dt</th>
<th>last change at</th>
<th>actions</th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$name=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");

$lastchange=dbsynccurrentversion("", $id, 0);

if ($description=="") $description="-";
echo "
<tr BGCOLOR=\"#FDD017\">
<td>$id</td>
<td>$name</td>
<td>$description</td>
<td>$create_dt</td>
<td>$lastchange</td>
<td>";

if ($rights>1) 
    echo "<a href=\"add_module_to_project.php?id=$id&name=$name\">Add Module</a> "; 
echo "<a href=\"list_project_modules.php?id=$id&name=$name\">List Project Modules</a> <a href=\"dbsync.php?id=$id&name=$name\">Synchro</a> <b><a href=\"get_synchronization_table.php?id=$id&name=$name\">Table</a></b> ";

if ($rights>1) {
 echo "<a href=\"create_branch.php?id=$id&name=$name\">Branch</a> ";
}
if ($rights>=2) echo "<a href=\"edit_project.php?id=$id\"><img alt=\"Edit\" src=\"icons/edit.png\"></a> ";
if ($rights>1) {
   $encoded_name=urlencode($name);
   echo "<a href=\"delete_project_confirm.php?id=$id&name=$encoded_name\"><img alt=\"Delete\" src=\"icons/delete.png\"></a> ";
}
echo "</td></tr>";

$i++; 
}

mysql_close();
?>
</table>
<br>

<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
   echo '<a href="manual.php#projectsandmodules"><img src="icons/help.png"> How to define projects and modules</a><br>';
 include("bottom.inc.php");
?>
</body>
</html>
