<?php session_start(); ?>
<html> 
<head>
<title>deltasql - List branches </title>
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
?>
<a href="index.php">Back to main menu</a>

<h4>Project branches</h4>
<table border="1">

<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbbranch ORDER BY id ASC"; 
$result=mysql_query($query);  
$num=mysql_numrows($result); 

echo "<tr>
<th>id</th>
<th>name</th>
<th>project</th>
<th>description</th>
<th>source branch</th>
<th>update datum</th>
<th>version number when branch done</th>
<th>visible</th>
</tr>";

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$name=mysql_result($result,$i,"name");          
$description=mysql_result($result,$i,"description");
$create_dt=mysql_result($result,$i,"create_dt");
// exception for HEAD, we show something else, as in db the latest update version is saved
$versionnr=mysql_result($result,$i,"versionnr");
if ($name=="HEAD") $versionnr="always latest ($versionnr)"; 
$projectid=mysql_result($result,$i,"project_id");
$visible=mysql_result($result,$i,"visible");
$sourcebranch=mysql_result($result,$i,"sourcebranch");

$query2="SELECT * from tbproject where id=$projectid"; 
$result2=mysql_query($query2);
if ($result2!="") $projectname=mysql_result($result2,0,'name');
  else $projectname="";

echo "
<tr>
<td>$id</td>
<td>$name</td>
<td>$projectname</td>
<td>$description</td>
<td>$sourcebranch</td>
<td>$create_dt</td>
<td>$versionnr</td>
<td>$visible</td>
<td>";
if (($rights>=2) && ($name!="HEAD")) {
    if ($visible==0) {
      echo " <a href=\"change_branch_visibility.php?id=$id&show=1\">Show</a> ";
    } else {
      echo " <a href=\"change_branch_visibility.php?id=$id&show=0\">Hide</a> ";
    }
    echo "<a href=\"edit_branch.php?id=$id\">Edit</a> ";
    echo "<a href=\"branch_again.php?id=$id\">BranchAgain</a> ";
    if ($rights==3) {
	    $encoded_name=urlencode($name);
        echo " <a href=\"delete_branch_confirm.php?id=$id&name=$encoded_name\">Delete</a> ";
    }    
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
