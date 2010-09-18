<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head> 
    <title>deltasql - List database modules</title>
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
//if ($rights<1) die("<b>Not enough rights to list all modules</b>");
?>
<a href="index.php">Back to main menu</a>

<h4>Database modules</h4>
<table border="1">

<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbmodule ORDER BY name ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "<tr>
<th>id</th>
<th>name</th>
<th>description</th>
<th>update datum</th>
<th>last version number</th>
<th></th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$name=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");
$lastversionnr=mysql_result($result,$i,"lastversionnr");

echo "
<tr>
<td>$id</td>
<td>$name</td>
<td>$description</td>
<td>$create_dt</td>
<td>$lastversionnr</td>
<td>";
if ($rights>=2) echo "<a href=\"edit_module.php?id=$id\">Edit</a> ";
if ($rights==3) {
    $name_encoded=urlencode($name);
    echo "<a href=\"delete_module_confirm.php?id=$id&amp;name=$name_encoded\">Delete</a>";
}
echo "</td>";

$i++; 
}

mysql_close();
?>
</table>
<br>
<a href="index.php">Back to main menu</a>
</body>
</html>
