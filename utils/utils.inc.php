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


function echo_files_as_select_options($basedir) {
 $dir_handle = @opendir("$basedir") or die("Unable to open $basedir");
 while ($file = readdir($dir_handle)) 
 {
   if (($file=="README.txt") || ($file=="CVS")) continue;
   if (($file!=".") && ($file!="..")) {
        echo "<option VALUE=\"$file\">$file";
   }  
 }
 closedir($dir_handle);
}


function readFileToString($filename) {
$output="";
$file = fopen($filename, "r");
while(!feof($file)) {

    //read file line by line into variable
  $output = $output . fgets($file, 4096);
 
}
fclose ($file);
return $output; 
}


function executeScripts($directory, $prefix, $howmany) {

for ($i=1; $i<=$howmany; $i++) {
  // a connection needs to be established
  $query=readFileToString("$directory/$prefix$i.sql"); 
  $result=mysql_query($query); 
  if ($result==1) {
    echo "Script $directory/$prefix$i.sql succesfully executed.<br>";
  } else {
    echo "Script $directory/$prefix$i.sql <b>failed</b>.<br>";
  }
}
}

function errormessage($msgid, $message, $xmlformatted, $htmlformatted) {
    include("conf/config.inc.php");
    $urlerror = "$dns_name/manual_errormessages.php#$msgid";
    if ($htmlformatted)  {
        die("<a href=\"$urlerror\">$msgid:$message</a>");
    } 
    else 
    if ($xmlformatted)
    {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<xml>\n";
        echo "  <type>error</type>\n";
        echo "  <msgerrorid>$msgid</msgerrorid>\n";       
        echo "  <msgerror>![CDATA[$message]]</msgerror>\n";
        echo "  <msglink>![CDATA[$urlerror]]</msglink>\n";
        echo "</xml>\n";
        die("");
    } else {
        if ($msgid==8) die ("$message"); // not really an error, just a comment that there are no scripts to be executed, see dbsync_update.inc.php
        else
        die("Error Number: $msgid\n Error Text: $message\n Error Explanation: $urlerror\n");
    }
}

function color_row($date_now, $create_dt) {
// conversion from mySQL to a PHP date
preg_match ("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $create_dt, $regs);
$updated_php = mktime ($regs[4],$regs[5],$regs[6],$regs[2],$regs[3],$regs[1]);

$one_day=86400;
$one_hour=3600;
$one_minute=60;

$diff=($date_now-$updated_php);
if ($diff>(2*$one_day)) {
  echo "<tr>";
} else 
if ($diff>(5*$one_hour))
{  
  echo "<tr BGCOLOR=\"#99CCFF\">"; // blue
} else
if ($diff>(20*$one_minute)) {
  echo "<tr BGCOLOR=\"#FDD017\">"; //yellow 
} else {
  echo "<tr BGCOLOR=\"#33FF00\">"; //green
}
}

function empty_directory($dirname) {
    if (is_dir($dirname))
       $dir_handle = opendir($dirname);
    if (!$dir_handle)
       return false;
    while($file = readdir($dir_handle)) {
       if ($file != "." && $file != "..") {
          if (!is_dir($dirname."/".$file))
             unlink($dirname."/".$file); 
       }
    }
    closedir($dir_handle);
}

?>
