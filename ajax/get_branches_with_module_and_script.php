<?php
include("../utils/utils.inc.php");
include("../utils/constants.inc.php");
include("../conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

    $moduleid = trim($_REQUEST['moduleid']);
    $scriptd = trim($_REQUEST['scriptid']);
    if (($moduleid != "") && ($scriptid != ""))
	{
        $headid  = retrieve_head_id();
        $str =  "$headid:";
        // checking if the script belongs to head
        $checkhead="SELECT * from tbmoduleproject WHERE script_id="+$scriptid+" AND ";
        
        $str = $str . "HEAD###";
	
        $sql = sprintf("SELECT b.id, b.name FROM tbbranch b, tbmoduleproject mp WHERE b.visible=1 and b.istag=0 and b.project_id=mp.project_id and mp.module_id=%d order by name asc", $moduleid);
		
        $rs = mysql_query($sql);
		if (mysql_num_rows($rs) > 0) 
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$str .=  $row['id'].":".$row['name']."###";
			}
		}
        echo $str = substr($str,0,-3);
	}

mysql_close();
?>