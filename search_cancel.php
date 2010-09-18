<?php
   session_start();
   include("utils/utils.inc.php");
   
   $scriptoffset = 0;
   $_SESSION["scriptoffset"] = $scriptoffset;
  
   $_SESSION["search_title"] = "";
   $_SESSION["search_comments"] = "";
   $_SESSION["search_script"] = "";
   $_SESSION["search_authorid"] = "";
   $_SESSION["search_moduleid"] = "";
   $_SESSION["search_branchid"] = "";
   $_SESSION["search_frmisaview"] = "";
   $_SESSION["search_frmisapackage"] = "";
   
   $_SESSION["search_fromversion"] = "";
   $_SESSION["search_toversion"] = "";
   
   $_SESSION["search_fromdata"] = "";
   $_SESSION["search_todata"] = "";
   
   $_SESSION["search_modified"] = "";
   
   js_redirect("list_scripts.php");

?>