<?php
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

echo "projectid;istag;visible;branchname;\n";
//create HEAD line
echo "*;0;1;HEAD;";

$query="SELECT * from tbbranch ORDER BY name ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

$i=0;
while ($i<$num) {  
  $id=mysql_result($result,$i,"id");
  $name=mysql_result($result,$i,"name");          
  $projectid=mysql_result($result,$i,"project_id");
  $istag=mysql_result($result,$i,"istag");
  $isvisible=mysql_result($result,$i,"visible");
  if ($name!="HEAD") echo "$projectid;$istag;$isvisible;$name;\n";
  $i++;
}
mysql_close();
?>