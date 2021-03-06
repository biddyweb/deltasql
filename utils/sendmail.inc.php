<?php

function send_email($cmdsend, $path, $from, $to, $subject, $body) {
   // first, we create a temporary file in output/emails/ directory
   // in the format required by sendmail which is fairly straightforward.
   $c = uniqid (rand (),true);
   $sessionid = md5($c);
   
   $emailfile="output/emails/email_$sessionid";
   $fh = fopen($emailfile, 'w') or die("Can't create file $emailfile");
   fwrite($fh, 
"From: $from
To: $to
Subject: $subject
$body
");
   fclose($fh);
   
   $output = shell_exec("$cmdsend $path$emailfile");
   
   //logging output in logfile
   $logfile="output/emails/log.txt";
   $flog = fopen($logfile, 'w') or die("Can't create file $logfile");
   fwrite($fh, $output);
   fclose($fh);
   
   unlink($emailfile);
   return;
}


function notify_users_with_email($cmdsend, $path, $from, $subject, $body) {
  // searching for all users which would like to be notified
  $query="SELECT * from tbparameter where paramtype='EMAIL' and paramname='SEND_EMAIL_TO' and TRIM(paramvalue)<>'';"; 
  $result=mysql_query($query);  
  $num=mysql_numrows($result); 
  
  $i=0;
  while ($i<$num) {  
    $to=mysql_result($result,$i,"paramvalue");
	send_email($cmdsend, $path, $from,$to,$subject,$body);
	$i++;
  }	
  return;
}

function list_branches($scriptid) {
   // retrieve to which branches and HEAD the script was applied
	$query3="SELECT * from tbscriptbranch sb, tbbranch b where (sb.script_id=$scriptid) and (sb.branch_id=b.id) order by b.id asc"; 
	$result3=mysql_query($query3);   
	$num3=mysql_numrows($result3);
	$j=0;
	$branches="";
    while ($j <$num3) {  
        $branchname=mysql_result($result3,$j,"name");   
        $branches = "$branches $branchname";
        $j++;
    }
	
	return $branches;
}


?>