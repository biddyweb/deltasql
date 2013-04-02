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
 
 //TODO: we could do a full export of deltasql scripts!
 if ($projectid=="") die("<b>Error: no projectname defined</b>");

 if ($format=='html') prepare_XSLT();
 echo "<scripts>\n"; 
 
  echo "</scripts>\n";
 if ($format=='html') apply_XSLT();
?>