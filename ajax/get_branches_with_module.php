<?php
include("../utils/utils.inc.php");
include("../utils/constants.inc.php");
include("../conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

    $moduleid = trim($_REQUEST['moduleid']);
    if ($moduleid != "")
	{
        $headid  = retrieve_head_id();
        // the :1: is to say that the checkbox needs to be checked
        $str =  "$headid:1:HEAD###";
	
        $sql = sprintf("SELECT b.id, b.name FROM tbbranch b, tbmoduleproject mp WHERE b.visible=1 and b.istag=0 and b.project_id=mp.project_id and mp.module_id=%d order by name asc", $moduleid);
		
        $rs = mysql_query($sql);
		if (mysql_num_rows($rs) > 0) 
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$str .=  $row['id'].":0:".$row['name']."###";
			}
		}
        echo $str = substr($str,0,-3);
	}

mysql_close();
?>