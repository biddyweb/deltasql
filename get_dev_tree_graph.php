<?php
include("conf/config.inc.php");

$excltag=isset($_POST['frmexcltag']);
$projectid=$_POST['frmprojectid'];

require_once('utils/phptreegraphext/classes/Node.php');
require_once('utils/phptreegraphext/classes/Tree.php');
require_once('utils/phptreegraphext/classes/GDRenderer.php');

$objTree = new GDRenderer(30, 10, 30, 50, 40);

mysql_connect($dbserver, $username, $password);
@mysql_select_db($database) or die("Unable to select database");

if ($excltag==1) $clause="AND istag=0"; else $clause="";
$query="SELECT * from tbbranch WHERE ((project_id=$projectid) OR (project_id IS NULL)) $clause ORDER BY id ASC;"; 
$result=mysql_query($query);  
if ($result=="") $num=0; else $num=mysql_numrows($result); 

$i=0;
while ($i<$num) {  
  $id=mysql_result($result,$i,"id");
  $name=mysql_result($result,$i,"name");
  $sourcebranchid=mysql_result($result,$i,"sourcebranch_id");
  $versionnr=mysql_result($result,$i,"versionnr");
  $visible=mysql_result($result,$i,"visible");
  $istag=mysql_result($result,$i,"istag");
  
  $disver=$versionnr;
  if ($istag==1) $disver="$disver TAG";
  if ($visible==0) $disver="$disver +h";
  
  $disverlen=strlen($disver);
  $namelen=strlen($name);
  if ($disverlen>$namelen) $maxlen=$disverlen; else $maxlen=$namelen;
  
  $objTree->add($id, $sourcebranchid, $name, $disver, $maxlen*9, 30);
  
  $i++;
}

mysql_close();

$objTree->setBGColor(array(255, 255, 255));
$objTree->setNodeTitleColor(array(0, 128, 255));
$objTree->setNodeMessageColor(array(0, 192, 255));
$objTree->setLinkColor(array(0, 64, 128));
//$objTree->setNodeLinks(GDRenderer::LINK_BEZIER);
$objTree->setNodeBorder(array(0, 0, 0), 2);
$objTree->setFTFont('/usr/share/fonts/truetype/msttcorefonts/arial.ttf', 10, 0, GDRenderer::CENTER);

$objTree->stream();

?>
