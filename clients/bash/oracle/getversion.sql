SET ECHO OFF NEWP 0 SPA 0 PAGES 0 FEED OFF HEAD OFF TRIMS ON TAB OFF
SPOOL rawversion.txt
select versionnr from TBSYNCHRONIZE where versionnr = (select max(versionnr) from TBSYNCHRONIZE);
SPOOL OFF
quit
