<?php

function send_email($from, $to, $subject, $body) {
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
   
   $output = shell_exec("sendmail -t < $emailfile");
   //echo "<pre>$output</pre>";

   unlink($emailfile);
   return;
}


function notify_users_with_email($from, $subject, $body) {
  // searching for all users which would like to be notified
  $query="SELECT * from tbparameter where paramtype='EMAIL' and paramname='SEND_EMAIL_TO' and paramvalue<>'';"; 
  $result=mysql_query($query);  
  $num=mysql_numrows($result); 
  
  $i=0;
  while ($i<$num) {  
    $to=mysql_result($result,$i,"paramvalue");
	send_email($from,$to,$subject,$body);
	$i++;
  }	
  return;
}


?>