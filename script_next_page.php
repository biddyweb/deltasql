<?php
 session_start();
 include("utils/constants.inc.php");
 include("utils/utils.inc.php");
 
 $scriptoffset = $_SESSION["scriptoffset"];
 $scriptoffset+=$scriptsperpage;
 $_SESSION["scriptoffset"] = $scriptoffset;
 js_redirect("list_scripts.php");
?>