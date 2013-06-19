<?php
	$Conn = mysql_connect("localhost", "root", "");
	if (!$Conn)
		die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));
	$DB_select = mysql_select_db("main_template", $Conn);
	if (!$DB_select)
		die("Error: ".mysql_errno($Conn).":- ".mysql_error($Conn));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script language="javascript"  type="text/javascript" src="validation.js"></script>
<script language="javascript" type="text/javascript">
	function getCities(id)
	{
		var obj = document.form1;
		if (id != "")
		{
			url = "getCities.php?stateid="+id;
			http.open("GET", url, true);
			http.onreadystatechange = getCitiesResponse; 
			http.send(null);
			
		}
	}
	
	function getCitiesResponse()
	{
		//alert(http.readyState);
		var obj = document.form1;
		if (http.readyState == 4)
		{
			var result = trimString(http.responseText);
			if (result != '' && result != 'undefined')
			{
				clearBox(obj.city);
				obj.city.options[0] = new Option("-City-", "");
				var result_line_arr = result.split("###");
				for (i=0;i<result_line_arr.length;i++)
				{
					var result_arr = result_line_arr[i].split(":");
					var code = result_arr[0];
					var name = result_arr[1];
					obj.city.options[i+1] = new Option(name, code);
				}
			}		
		}
	}
</script>
</head>

<body>
<table width="60%" border="0" cellspacing="0" cellpadding="5">
<form action="" method="post" name="form1">
  <tr>
      <td align="right" class="verdana11">State 
      :</td>
      <td align="left" class="verdana11">
      	<select name="state" id="state" onchange="javascript: getCities(this.value);">
        	<option value="">-State-</option>
            <?php
				$sql = "select * from state";
				$rs = mysql_query($sql);
				while($row = mysql_fetch_assoc($rs))
				{ ?>
					<option value="<?=$row['state_id']?>"><?=$row['state_name']?></option>
				<?php }
            ?>
        </select>      </td>
  </tr>
    <tr>
      <td align="right" class="verdana11">City 
      : </td>
      <td align="left" class="verdana11">
      <select name="city" id="city" style="width:150px;">
      		<option value="">-City-</option>
      </select>      </td>
    </tr>
</form>
</table>

</body>
</html>
