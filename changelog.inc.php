<?php

function copy_script_to_changelog($scriptid) {
  $query="select * from tbscript where id=$scriptid";
  $result=mysql_query($query);  
  if ($result=="") die('<b>Internal error in changelog.inc.php</b>');

  $title=mysql_real_escape_string  ( mysql_result($result,0,"title"));           
  $comments=mysql_real_escape_string  ( mysql_result($result,0,"comments"));
  $create_dt=mysql_result($result,0,"create_dt");
  $update_dt=mysql_result($result,0,"update_dt");
  $update_user=mysql_result($result,0,"update_user");
  $versionnr=mysql_result($result,0,"versionnr");
  $moduleid=mysql_result($result,0,"module_id");
  $scriptuserid=mysql_result($result,0,"user_id");
  $script=mysql_real_escape_string  ( mysql_result($result,0,"code"));
  $isaview=mysql_result($result,0,"isaview");
  $isapackage=mysql_result($result,0,"isapackage");
  
  if (($update_dt=="") || ($update_dt=="0000-00-00 00:00:00")) $update_dt=$create_dt;
  
  $query2="INSERT INTO tbscriptchangelog (id, script_id, code, title, comments,create_dt,versionnr,user_id,module_id,isaview,isapackage, update_user) 
           VALUES('',$scriptid,\"$script\",\"$title\",\"$comments\",'$update_dt',$versionnr,$scriptuserid,$moduleid,$isaview,$isapackage, '$update_user');";
  mysql_query($query2);
   
  return;
}

?>