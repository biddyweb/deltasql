<?php
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbbranch ORDER BY name ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "projectid;istag;branchname;\n";

$i=0;
while ($i<$num) {  
  $id=mysql_result($result,$i,"id");
  $name=mysql_result($result,$i,"name");          
  $projectid=mysql_result($result,$i,"project_id");
  $istag=mysql_result($result,$i,"istag");
  if ($name!="HEAD") echo "$projectid;$istag;$name;\n";
  $i++;
}
mysql_close();
?>