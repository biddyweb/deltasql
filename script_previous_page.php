<?php
 session_start();
 include("utils/constants.inc.php");
 include("utils/utils.inc.php");
 if (isset($_SESSION['scriptsperpage'])) $scriptsperpage=$_SESSION['scriptsperpage']; else $scriptsperpage=$default_scriptsperpage;
 
 $scriptoffset = $_SESSION["scriptoffset"];
 $scriptoffset-=$scriptsperpage;
 if ($scriptoffset<0) $scriptoffset=0;
 $_SESSION["scriptoffset"] = $scriptoffset;
 js_redirect("list_scripts.php");
?>