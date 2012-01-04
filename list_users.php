<?php session_start(); ?>
<html>
<head>
<title>deltasql - Users</title>
<link rel="stylesheet" type="text/css" href="deltasql.css">
</head> 
<body>
<?php
include("head.inc.php");
include("utils/utils.inc.php");
show_user_level();
$myrights = $_SESSION["rights"];
if ($myrights<2) die("<b>Not enough rights to list all users</b>");
?>
<h4>All users</h4>
<table border="1">

<?php
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$query="SELECT * from tbuser ORDER BY last ASC"; // query che ti trova tutti i record e li mette in una variabile speciale
$result=mysql_query($query);   // che si chiama $result
$num=mysql_numrows($result); 

echo "<tr>
<th>id:</th>
<th>username:</th>
<th>type</th>
<th>first:</th>
<th>last:</th>
<th>e-mail:</th>
<th>actions</th>
</tr>";

$i=0;
while ($i<$num) {  // loop che passa attraverso tutti i record uno alla volta

$id=mysql_result($result,$i,"id");
$username=mysql_result($result,$i,"username");           // mettiamo nelle variabili seguenti il contenuto di un record (=linea)
$password=mysql_result($result,$i,"password");
$first=mysql_result($result,$i,"first");
$last=mysql_result($result,$i,"last");
$email=mysql_result($result,$i,"email");
$rights=mysql_result($result,$i,"rights");

echo "
<tr>
<td>$id</td>
<td>$username</td>
<td>";

if ($rights==1) {
   echo "Developer";
} else
if ($rights==2) {
   echo "Project Manager";
} else
if ($rights==3) {
   echo "Administrator";
} 

if ($first=="") $first="-";
if ($last=="") $last="-";
if ($email=="") $email="-";

echo "
</td>
<td>$first</td>
<td>$last</td> 
<td><i>$email</i></td>";

echo "<td>";
if ($myrights==3) echo "<a href=\"edit_user.php?id=$id&username=$username&rights=$rights&first=$first&last=$last&email=$email\"><img alt=\"Edit\" src=\"icons/edit.png\"></a> ";
if (($myrights==3) && ($username!="admin")) {
    $encoded_name=(urlencode($username));
    echo "<a href=\"delete_user_confirm.php?id=$id&name=$encoded_name\"><img alt=\"Delete\" src=\"icons/delete.png\"></a> ";
	echo "<a href=\"reset_user_password.php?id=$id&name=$encoded_name\">Reset password</a> ";
}
echo "</td>";
$i++; // $i=$i+1;
}

mysql_close();
?>
</table>
<br>
<hr>
<a href="manual.php#usermanagement"><img src="icons/help.png"> User Management</a></a><br>
<a href="index.php"><img src="icons/home.png"> Back to main menu</a>
</body>
</html>