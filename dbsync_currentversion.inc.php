<?php

function dbsynccurrentversion($projectname, $projectid, $echoing) {

if ($projectname!="") { 
 // retrieve and overwrite project id
 $queryproj="SELECT * FROM tbproject WHERE name='$projectname'";
 $resultproj=mysql_query($queryproj);
 $projectid=mysql_result($resultproj,0,"id"); 
}  
 
 $query="SELECT * FROM tbmoduleproject where project_id=$projectid";
 $result=mysql_query($query);
 $num=mysql_numrows($result); 
 
 $i=0;
 $maxversion = 0;
 while ($i<$num) { 
   $moduleid=mysql_result($result,$i,"module_id");
   $query2="SELECT * from tbmodule where id=$moduleid";
   $result2=mysql_query($query2);  

   $id=mysql_result($result2,0,"id");
   $name=mysql_result($result2,0,"name");          
   $description=mysql_result($result2,0,"description");
   $create_dt=mysql_result($result2,0,"create_dt");
   $lastversionnr=mysql_result($result2,0,"lastversionnr");
   
   if ($echoing==1) {
      echo "module$i.name = $name\n";
      echo "module$i.version = $lastversionnr\n";
   }

   if ($lastversionnr>$maxversion) $maxversion=$lastversionnr;
   $i++;
 }
 return $maxversion; 
 }
 
 ?>
