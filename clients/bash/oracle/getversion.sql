SET ECHO OFF NEWP 0 SPA 0 PAGES 0 FEED OFF HEAD OFF TRIMS OFF TAB OFF
SPOOL oracle/version.txt
select 'version='||versionnr from TBSYNCHRONIZE where versionnr = 
(select 
max(versionnr) from TBSYNCHRONIZE);
SPOOL OFF
quit
