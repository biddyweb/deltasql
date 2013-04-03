<?php

function getparam($name, $default) {
 if (isset($_GET["$name"])) return $_GET["$name"]; else return $default;
}

function create_unique_id() {
    return md5( uniqid (rand(), true));
}

function get_parameter_default($paramtype, $paramname, $userid, $defaultparam) {
  if ($userid=="") $userquery="AND user_id IS NULL";
  else $userquery="AND user_id=$userid";
  
  $query="SELECT paramvalue from tbparameter where paramtype='$paramtype' and paramname='$paramname' $userquery"; 
  $result=mysql_query($query);  
  $num=mysql_numrows($result);
  
  if ($num>0) 
     $paramvalue=mysql_result($result,0,"paramvalue");
  else
     $paramvalue=$defaultparam;
  return $paramvalue;
}

function get_parameter($paramtype, $paramname, $userid) {
  $paramvalue=get_parameter_default($paramtype,$paramname,$userid,"");
  return $paramvalue;
}

function set_parameter($paramtype, $paramname, $paramvalue, $userid) {
  if ($userid=="") $userupdate="";
  else $userupdate="AND user_id=$userid";
  
  // decide first if we need to insert a new parameter
  $check = get_parameter_default($paramtype, $paramname, $userid, 'missing parameter');
  if ($check=='missing parameter') {
      if ($userid=="") $userid="NULL";
	  $query="INSERT INTO tbparameter (id, paramtype, paramname, paramvalue, user_id) VALUES('', '$paramtype', '$paramname', '$paramvalue', $userid);";    	  
  }
  else
      $query="UPDATE tbparameter p SET p.paramvalue='$paramvalue' where paramtype='$paramtype' and paramname='$paramname' $userupdate"; 
  mysql_query($query); 
}

function get_global_version() {
  return get_parameter('GLOBAL','VERSION','');
}

function get_and_increase_global_version() {
  $version=get_parameter('GLOBAL','VERSION','')+1;
  set_parameter('GLOBAL','VERSION',"$version",'');
  return $version;
}

function retrieve_head_id() {
  $query="SELECT id from tbbranch WHERE name='HEAD'"; 
  $result=mysql_query($query);  
  $headid=mysql_result($result,0,"id");
  return $headid;
}

function retrieve_salt() {
  return get_parameter('SECURITY','PWD_HASH_SALT', '');
}

function salt_and_hash($pwd, $salt) {  
  return md5("$pwd$salt");
}

function js_redirect($s)
{
print "<body onload=\"window.location='$s';\">";
//print "<a href='$s'>Javascript redirect.. If your page doesn't redirect click here.</a>";
print "</body>";
exit();
}

function show_user_level() {
echo "<center>";

if(isset($_SESSION['rights'])) {
  $rights = $_SESSION["rights"];
  $usersession = $_SESSION['username'];
} else {
  $rights=0; $usersession="";
}  

if ($rights==1) {
echo "<b>You are logged in as Developer ($usersession)</b><br>";
} else
if ($rights==2) {
echo "<b>You are logged in as Project Manager ($usersession)</b><br>";
} else
if ($rights==3) {
echo "<b>You are logged in as Administrator ($usersession)</b><br>";
} else {
echo "<b>Please <a href=\"login.php\">login</a></b><br>";
}
echo "</center>";
}

?>
