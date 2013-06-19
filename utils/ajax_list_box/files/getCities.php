<?php
	$Conn = mysql_connect("localhost", "root", "");
	if (!$Conn)
		die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));
	$DB_select = mysql_select_db("main_template", $Conn);
	if (!$DB_select)
		die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));
		
		
		
		
	$stateid = trim($_REQUEST['stateid']);
	if ($stateid != "")
	{
		$sql = sprintf("SELECT city_id, city_name FROM city WHERE state_id = '%d' ", $stateid);
		$rs = mysql_query($sql);
		if (mysql_num_rows($rs) > 0) 
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$str .=  $row['city_id'].":".$row['city_name']."###";
			}
			echo $str = substr($str,0,-3);
		}
	}
	
?>