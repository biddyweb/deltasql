CREATE TABLE `tbsynchronize` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATE NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`tagname` VARCHAR( 128 ) NULL ,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`dbtype` VARCHAR( 32 ) NULL ,
UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE = MYISAM ;