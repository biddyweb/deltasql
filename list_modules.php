<?php session_start(); ?>
<html>
<head> 
<title>deltasql - List database modules</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head>
<body>
<?php
echo "<style type=\"text/css\">";
include ("deltasql.css");
echo "</style>";

include("head.inc.php");
include("utils/utils.inc.php");
include("utils/constants.inc.php");

if (!file_exists($configurationfile)) die("<h2><a href=\"install.php\">$installmessage</a></h2>");

show_user_level();
if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
} else $rights=0;
?>
<h2>Modules</h2>
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
<th>update dt</th>
<th>last version number</th>
<th>actions</th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$name=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");
$lastversionnr=mysql_result($result,$i,"lastversionnr");

if ($description=="") $description="-";
echo "
<tr>
<td>$id</td>
<td>$name</td>
<td>$description</td>
<td>$create_dt</td>
<td>$lastversionnr</td>
<td>";
if ($rights>=2) echo "<a href=\"edit_module.php?id=$id\"><img alt=\"Edit\" src=\"icons/edit.png\"></a> ";
if ($rights==3) {
    $name_encoded=urlencode($name);
    echo "<a href=\"delete_module_confirm.php?id=$id&amp;name=$name_encoded\"><img alt=\"Delete\" src=\"icons/delete.png\"></a>";
}
echo "</td>";

$i++; 
}

mysql_close();
?>
</table>
<br>
<?php
if (isset($_SESSION['displayhelplinks'])) $displayhelp=$_SESSION['displayhelplinks']; else $displayhelp=$default_displayhelplinks;
if ($displayhelp==1)
  echo '<a href="faq.php#modules"><img src="icons/help.png"> Why are there projects and modules?</a><br>';
?>
<?php include("bottom.inc.php"); ?>
</body>
</html>
