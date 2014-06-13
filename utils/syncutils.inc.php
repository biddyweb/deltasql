<?php
/*
	Utils used by the logic in dbsync_automated_update.php to print scripts, when generating the
	script from the Database Synchronization form
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/

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

function output_scripts($result, $htmlformatted, $xmlformatted, $singlefiles, &$textresult, $disable_sql_highlighting, $useclause /* for MS SQL server */, $dbtype) {
 if ($htmlformatted) {
        include_once('geshi/geshi.php');
 }    
 include('conf/config.inc.php');
 include('utils/constants.inc.php');

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
  
  if (($useclause!="") && ($dbtype==$db_sqlserver)) {
	$script = "USE ". $useclause . ";\nGO\n" . $script;
  }  
  if ($dbtype==$db_sqlserver) {
    $script = $script . "\nGO\n";
  }
  
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