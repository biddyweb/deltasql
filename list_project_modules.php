<?php session_start(); ?>
<html>
<head>
<title>deltasql - List Project Modules</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
include("head.inc.php");
include("conf/config.inc.php");
include("utils/utils.inc.php");
if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else $rights=0;

$projectid = $_GET['id'];
$projectname = $_GET['name'];

echo "<h2>List Project Modules of $projectname</h2>";

echo "<table border=1><tr>
<th>id</th>
<th>name</th>
<th>description</th>
<th>update datum</th>
<th>last version number</th>
</tr>";


 mysql_connect($dbserver, $username, $password);
 @mysql_select_db($database) or die("Unable to select database");
 $query="SELECT * FROM tbmoduleproject where project_id=$projectid";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 
 $i=0;
 while ($i<$num) { 
   $moduleid=mysql_result($result,$i,"module_id");
   $query2="SELECT * from tbmodule where id=$moduleid";
   $result2=mysql_query($query2);  

   $id=mysql_result($result2,0,"id");
   $name=mysql_result($result2,0,"name");          
   $description=mysql_result($result2,0,"description");
   $create_dt=mysql_result($result2,0,"create_dt");
   $lastversionnr=mysql_result($result2,0,"lastversionnr");
   
   if ($description=="") $description="-";
   echo "
    <tr>
    <td>$id</td>
    <td>$name</td>
    <td>$description</td>
    <td>$create_dt</td>
    <td>$lastversionnr</td>";

 if ($rights>=2) {
    echo "<td>";
    echo "<a href=\"delete_project_module.php?projectid=$projectid&moduleid=$moduleid&name=$projectname\"><img alt=\"Delete\" src=\"icons/delete.png\"></a>";    
    echo "</td>";
 }    
 echo "</tr>";
   
   $i++;
 }
 echo "</table>";
 mysql_close();
 if ($rights>1)
    echo "<a href=\"add_module_to_project.php?id=$projectid&name=$projectname\"><img alt=\"New\" src=\"icons/new.png\"> Add Module to Project</a><br>";
 ?>
<br>
<a href="list_projects.php">Back to List Projects</a>
</body>
</html>