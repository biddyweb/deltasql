<?php
 session_start();
 include("utils/constants.inc.php");
 include("utils/utils.inc.php");
 

 $count=$_GET['nbscripts'];
 $scriptoffset=$count - ($count % $scriptsperpage);
 $_SESSION["scriptoffset"] = $scriptoffset;
 js_redirect("list_scripts.php");

?>