<?php
include("utils/utils.inc.php");
include("utils/constants.inc.php");
include("conf/config.inc.php");
mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

    $projectid = trim($_REQUEST['projectid']);
	if ($projectid != "")
	{
        $headid  = retrieve_head_id();
        $str =  "$headid:HEAD###";
	
        $sql = sprintf("SELECT id, name FROM tbbranch WHERE project_id=%d order by name asc", $projectid);
        //echo "query: $sql";
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