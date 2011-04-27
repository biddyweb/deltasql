<?php
include("utils/constants.inc.php");
include("conf/config.inc.php");
echo "
<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>
<rss version=\"0.91\">
	<channel>
		<title>deltasql - latest scripts</title>
		<link>$dns_name</link>
		<description>The latest SQL scripts are shown on this deltasql RSS feed</description>
		<language>en-en</language>
";

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

mysql_close();

echo "
    </channel>
</rss>	
";


?>