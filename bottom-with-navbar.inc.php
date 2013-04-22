<hr>
<?php
echo "<a  href=\"index.php\"><img src=\"icons/home.png\"> Main</a> |";
echo "<a href=\"list_scripts.php\"><img src=\"pictures/rss-icon.png\" border=0/> List Scripts</a></a> | ";
echo "<a href=\"dbsync.php\"><img src=\"icons/show2.png\"> Synchronize</a> | ";
if ($enable_server_stats) echo "<a href=\"server_stats.php\">Statistics</a>";   
?>
</td>
</tr>
</table>
