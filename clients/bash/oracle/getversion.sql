SPOOL ./versiondb.txt
select versionnr from TBSYNCHRONIZE where versionnr = (select max(versionnr) from TBSYNCHRONIZE);
SPOOL OFF
