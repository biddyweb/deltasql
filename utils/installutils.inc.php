<?php
/*
	Utils used by the logic in install_execution.php to read and execute scripts
	while installing deltasql server.
	
	(c) 2007-2013 HB9TVM and the deltasql team
*/


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

?>