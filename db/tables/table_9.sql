CREATE TABLE `tbsyncstats` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATETIME NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`dbtype` VARCHAR( 32 ) NULL ,
`ip` VARCHAR( 32 ) NULL 
) ENGINE = MYISAM ;