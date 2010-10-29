select 'version='||versionnr from tbsynchronize where versionnr = (select max(versionnr) from tbsynchronize);
