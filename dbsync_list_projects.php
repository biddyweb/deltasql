<?php
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbproject ORDER BY name ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

$i=0;
while ($i<$num) {  
   $id=mysql_result($result,$i,"id");
   $name=mysql_result($result,$i,"name");          
   echo "$id;$name;\n";
   $i++;
}
mysql_close();
?>