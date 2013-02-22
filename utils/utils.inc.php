<?php

function getparam($name, $default) {
 if (isset($_GET["$name"])) return $_GET["$name"]; else return $default;
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

function printXmlScript($script, $comment, $module, $versionnr, $type, $date) {
    echo "  <script>\n";
    echo "      <scripttype>$type</scripttype>\n";
    echo "      <versionnr>$versionnr</versionnr>\n";
    echo "      <module>$module</module>\n";
    echo "      <create_dt>$date</create_dt>\n";
    echo "      <comment>\n![CDATA[$comment]]\n     </comment>\n";
    echo "      <content>\n![CDATA[$script]]\n      </content>\n";
    echo "  </script>\n";
}

function output_scripts($result, $htmlformatted, $xmlformatted, $singlefiles, &$textresult, $disable_sql_highlighting) {
 if ($htmlformatted) {
        include_once('geshi/geshi.php');
 }    
 include('conf/config.inc.php');

 if ($result=="") return 0;
 $i=0;
 $num=mysql_numrows($result);
 
 while ($i<$num) {  

  $scriptid=mysql_result($result,$i,"id");
  //$title=mysql_result($result,$i,"title");           
  $comments=mysql_result($result,$i,"comments");
  $create_dt=mysql_result($result,$i,"create_dt");
  $versionnr=mysql_result($result,$i,"versionnr");
  $moduleid=mysql_result($result,$i,"module_id");
  $script=mysql_result($result,$i,"code");
  $isapackage=mysql_result($result,$i,"isapackage");
  $isaview=mysql_result($result,$i,"isaview");
	
  // echo the script
  $query2="SELECT * from tbmodule where id=$moduleid"; 
  $result2=mysql_query($query2);   
  $modulename=mysql_result($result2, 0,  "name");
	
  if ($singlefiles==1) {
    if ($script_prefix=="") $script_prefix="script_";
	if ($script_extension=="") $script_extension=".sql";
	
	if ($versionnr<10)      $versiontext="000000$versionnr"; else
	if ($versionnr<100)     $versiontext="00000$versionnr"; else
	if ($versionnr<1000)    $versiontext="0000$versionnr"; else
	if ($versionnr<10000)   $versiontext="000$versionnr"; else
	if ($versionnr<100000)  $versiontext="00$versionnr"; else
    if ($versionnr<1000000) $versiontext="0$versionnr"; else	
	$versiontext="$versionnr";
	
    $outputfile="output/scripts/$script_prefix$versiontext$script_extension";
    $fh = fopen($outputfile, 'w') or die("<b>Can't open file $outputfile</b>");
    fwrite($fh, "$script");
    fclose($fh);
  } else {
  
	if ($htmlformatted==1) {
        $verstr = "-- version: <b>$versionnr</b> module: <b>$modulename</b> date: <b>$create_dt</b><br/> \n";
		echo $verstr;
		$textresult = $textresult . $verstr;
	}
	else
    if ($xmlformatted==1) {
        echo "  <script>\n      <scripttype>dbupdate</scripttype>\n     <versionnr>$versionnr</versionnr>\n     <module>$modulename</module>\n      <create_dt>$create_dt</create_dt>\n";
    } else
        echo "-- version: $versionnr module: $modulename date: $create_dt \n";
	
	if (!$xmlformatted) echo "-- applied to: ";
	// retrieve to which branches and HEAD the script was applied
	$query3="SELECT * from tbscriptbranch sb, tbbranch b where (sb.script_id=$scriptid) and (sb.branch_id=b.id) order by b.id asc"; 
	$result3=mysql_query($query3);   
	$num3=mysql_numrows($result3);
	$j=0;
    while ($j <$num3) {  
        $branchname=mysql_result($result3,$j,"name");   
        if ($htmlformatted==1) echo " <b>$branchname</b> "; else 
        if ($xmlformatted==1) echo "        <branch>$branchname</branch>\n";
        else
        echo " $branchname ";
        $j++;
    }
    if ($htmlformatted==1) echo "<br>"; else if (!$xmlformatted) echo "\n";

    if (($isapackage==1) || ($isaview==1) && (!$xmlformatted)) {
        echo "-- marked as: ";
        if ($isapackage==1) {
            if ($htmlformatted==1) echo "<b>package</b> "; else echo "package ";
        }
        if ($isaview==1) {
            if ($htmlformatted==1) echo "<b>view</b> "; else echo "view ";
        }
    }
    if ($htmlformatted==1) echo "<br>"; else if (!$xmlformatted) echo "\n";

    if ($xmlformatted==1) {
        echo "      <comment>\n![CDATA[$comments]]\n     </comment>\n";   
    } else {
        if ($comments!="") {
            $comments="/*\n$comments\n*/\n";
			$textresult = $textresult . $comments;
        if ($htmlformatted==1) $comments='<pre>'.htmlspecialchars($comments).'</pre>';
            echo $comments;
			
        }
    }
 
   if ($xmlformatted==1) {
      echo "      <content>\n![CDATA[$script]]\n       </content>\n    </script>\n";
   } else
   if ($script!="") {
	// a valid SQL statement always ends with ;
    // does not work too well
    //$lastchar = substr($script, 0, -2); // trick to retrieve the last char
	//if (($lastchar!=";") && ($lastchar!="/") && ($lastchar!="\\")) $script="$script;";

	//html encoding
	if ($htmlformatted==1) {
		$textresult = $textresult . $script . "\n\n";
        if ($disable_sql_highlighting==true) {
		    echo "<pre>";
            $script = htmlspecialchars($script);
            echo "$script";
            echo "</pre>";         
        } else {
              geshi_highlight($script, 'sql');
        }
        echo '<br/><br/>';
	} else {
      // normal text output
	  echo "$script\n\n\n";
    }
   }
  } // $singlefiles else clause ends here
$i++; // $i=$i+1;
}
return $num;
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

function printDatabaseComboBox ($dbdefault) {
include("constants.inc.php");                                                   
//echo "*$dbdefault*";
if ($dbdefault=="") $dbdefault = $db_oracle;
echo "<select name=\"frmdbtype\">";
if ($dbdefault == $db_oracle)
    echo "<option value=\"$db_oracle\" SELECTED>$db_oracle";
  else
    echo "<option value=\"$db_oracle\">$db_oracle";
if ($dbdefault == $db_mysql)                                                   
    echo "<option value=\"$db_mysql\" SELECTED>$db_mysql";                    
  else                                                                          
    echo "<option value=\"$db_mysql\">$db_mysql";
if ($dbdefault == $db_pgsql)                                                   
    echo "<option value=\"$db_pgsql\" SELECTED>$db_pgsql";                    
  else                                                                          
    echo "<option value=\"$db_pgsql\">$db_pgsql";
if ($dbdefault == $db_sqlserver)        
   echo "<option value=\"$db_sqlserver\" SELECTED>$db_sqlserver";               
  else                                                                          
    echo "<option value=\"$db_sqlserver\">$db_sqlserver"; 
if ($dbdefault == $db_sqlite)
    echo "<option value=\"$db_sqlite\" SELECTED>$db_sqlite";
  else
    echo "<option value=\"$db_sqlite\">$db_sqlite";	
if ($dbdefault == $db_sybase)
    echo "<option value=\"$db_sybase\" SELECTED>$db_sybase";
  else
    echo "<option value=\"$db_sybase\">$db_sybase";
if ($dbdefault == $db_other)
    echo "<option value=\"$db_other\" SELECTED>$db_other";
  else
    echo "<option value=\"$db_other\">$db_other";

echo "</select><br><br>";

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
