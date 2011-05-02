<?php
include("utils/constants.inc.php");
if (!file_exists($configurationfile)) die("Please setup deltasql!");
include("conf/config.inc.php");
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
<rss version=\"0.91\">
	<channel>
		<title>deltasql - latest scripts</title>
		<link>$dns_name</link>
		<description>This feed shows the latest SQL scripts published on deltasql :-)</description>
		<language>en-en</language>
";

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

$queryscript="SELECT * FROM tbscript ORDER BY versionnr desc LIMIT 0, $scriptsonrssfeed;";
$result=mysql_query($queryscript);
if ($result=="") {
   $num=0;
} else {
   $num=mysql_numrows($result); 
}

$i=0;
while ($i<$num) {  

$id=mysql_result($result,$i,"id");
$title=htmlentities(mysql_result($result,$i,"title"));           
$comments=htmlentities(mysql_result($result,$i,"comments"));
$create_dt=mysql_result($result,$i,"create_dt");
$update_dt=mysql_result($result,$i,"update_dt");
$update_user=mysql_result($result,$i,"update_user");
$versionnr=mysql_result($result,$i,"versionnr");
$moduleid=mysql_result($result,$i,"module_id");
$scriptuserid=mysql_result($result,$i,"user_id");
$script=htmlentities(mysql_result($result,$i,"code"));
$isaview=mysql_result($result,$i,"isaview");
$isapackage=mysql_result($result,$i,"isapackage");

$modulequery="SELECT * FROM tbmodule where id=$moduleid";
$moduleresult=mysql_query($modulequery);
$modulename=mysql_result($moduleresult,0,"name");

$userquery="SELECT * FROM tbuser where id=$scriptuserid";
$userresult=mysql_query($userquery);
$username=mysql_result($userresult,0,"username");

echo "      <item>\n";
echo "			<title>[$modulename] $title</title>\n";
echo "			<link>$dns_name/show_script.php?id=$id</link>\n";
echo "			<pubDate>$create_dt</pubDate>\n";
echo "			<description>\n
                $script\n";
if ($comments!="") {
echo "          /*\n
               $comments\n
			   */\n";    
}
echo "           </description>\n";
echo "			<author>$username</author>\n";
echo "		</item>\n";

$i++;
}

mysql_close();

echo "
    </channel>
</rss>
";


?>