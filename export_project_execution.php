<?php
/*
  This PHP script exports the table TBSCRIPT, TBMODULE, TBBRANCH and TBPROJECT
  either in XML or HTML format, making use of stylesheets and XSLT transformation,
  if the HTML export is desired.
  
  Source code is under GPL, (c) 2007-2013 the deltasql Team
  
*/
 include('utils/sql2xml/sql2xml.php');
 include('utils/sql2xml/xsl.php'); 
 include('utils/utils.inc.php'); 
 include('utils/constants.inc.php'); 
 include('conf/config.inc.php'); 
 
 $projectid = $_POST['frmprojectid'];
 $format    = $_POST['formatgroup'];
 
 // full deltasql export if projectid is not defined
 if ($projectid=="") $projectclause=""; else $projectclause="and p.id=$projectid";

 if ($format=='html') prepare_XSLT();
 echo "<scripts>\n"; 
 $level_list = Array("script", "branches");
 sql2xml("select s.id, s.code, s.versionnr, s.title, s.create_dt, s.update_dt, m.name as modulename, p.name as projectname,
		  b.name as branchname
          from tbscript s, tbmodule m, tbmoduleproject mp, tbproject p, tbbranch b, tbscriptbranch sb 
          where 
		  s.module_id=m.id 
		  and mp.module_id=m.id and mp.project_id=p.id 
		  and sb.branch_id=b.id and sb.script_id=s.id
		  $projectclause
		  order by id asc;"
		 , $level_list, 8);
 
  echo "</scripts>\n";
 if ($format=='html') apply_XSLT();
?>