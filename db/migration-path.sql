/*
Steps to upgrade from 1.2.1 to 1.3.0:
- Adding source branch information to tbbranch
- New table: tbscriptgeneration
- tagname added to tbsynchronization
*/

ALTER TABLE `tbbranch` ADD `sourcebranch` VARCHAR( 40 ) NULL;
ALTER TABLE `tbbranch` ADD `sourcebranch_id` int(11) DEFAULT NULL;

UPDATE `tbbranch` SET sourcebranch='HEAD' WHERE name<>'HEAD';
UPDATE `tbbranch` SET sourcebranch_id=1 WHERE name<>'HEAD';

ALTER TABLE `tbbranch` ADD `istag` tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE tbsynchronize ADD tagname varchar(128) NULL;
CREATE TABLE `tbscriptgeneration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,
  `fromversionnr` int(11) DEFAULT NULL,
  `toversionnr` int(11) DEFAULT NULL,
  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,
  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,
  `frombranch_id` int(11) NOT NULL,
  `tobranch_id` int(11) NOT NULL,
  `create_dt` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;
 

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 89, 'HEAD', 'TAG_deltasql_1.3.0', 'admin', 'deltasql-server', 1, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 89 on date 2012-01-13 11:11:57
 
-- version: 94 module: deltasql-module date: 2011-02-10 11:07:04
-- applied to: HEAD

/*
Added parameter to test db connection (1.3.1)
*/

INSERT INTO `tbparameter` VALUES ('', 'TEST', 'DB_CONNECTION', 'OK');
 

-- version: 95 module: deltasql-module date: 2011-02-10 11:08:06
-- applied to: HEAD

/*
added missing test script (when installing deltasql with test data)
*/

--INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview)
--VALUES  (9, '-- 6 script only for HEAD before branch DELTA_2 comes', 5, 17, 1, '2008-05-21', '', '', 'db update', 0, 0);
 

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 96, 'HEAD', 'TAG_deltasql_1.3.1', 'admin', 'deltasql-server', 89, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 96 on date 2012-01-13 11:11:57

-- version: 97 module: deltasql-module date: 2011-02-11 16:57:02
-- applied to: HEAD

/*
improvement to allow upgrade from production schemas to development schemas. (1.3.2)
*/

ALTER TABLE tbscriptgeneration ADD  `exclbranch` tinyint(1) NOT NULL DEFAULT '0';
 

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 98, 'HEAD', 'TAG_deltasql_1.3.2', 'admin', 'deltasql-server', 96, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 98 on date 2012-01-13 11:11:57

-- version: 101 module: deltasql-module date: 2011-02-25 15:11:44
-- applied to: HEAD

/*
Table to record changes in history. (1.3.3)
*/

CREATE TABLE `tbscriptchangelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` longtext collate latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `update_user` VARCHAR( 64 ) NULL,
  `script_id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `comments` longtext collate latin1_general_ci,
  `title` varchar(64) collate latin1_general_ci DEFAULT NULL,
  `isapackage` tinyint(1) NOT NULL DEFAULT '0',
  `isaview` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 103, 'HEAD', 'TAG_deltasql_1.3.3', 'admin', 'deltasql-server', 98, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 103 on date 2012-01-13 11:11:57


-- version: 113 module: deltasql-module date: 2011-02-26 18:42:09
-- applied to: HEAD

/*
table to track changes into branches (1.3.4)
*/

CREATE TABLE `tbscriptbranchchangelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;
 

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 114, 'HEAD', 'TAG_deltasql_1.3.4', 'admin', 'deltasql-server', 103, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 114 on date 2012-01-13 11:11:57

-- version: 172 module: deltasql-module date: 2011-06-03 15:50:02
-- applied to: HEAD

/*
Adding columns for password encryption (1.3.7)
*/

ALTER TABLE `tbuser` ADD `encrypted` TINYINT( 1 ) NOT NULL DEFAULT '0',
ADD `passwhash` VARCHAR( 40 ) NULL ;

-- version: 174 module: deltasql-module date: 2011-06-03 21:51:38
-- applied to: HEAD

/*
Added parameter to salt password hashes.
*/

INSERT INTO `tbparameter` VALUES ('', 'SECURITY', 'PWD_HASH_SALT', 'CHANGEMETOANYRANDOMSTRING');
 

-- version: 176 module: deltasql-module date: 2011-06-03 23:29:39
-- applied to: HEAD

/*
We record on the database the deltasql version, so that we can detect upgrades in source code.
*/

UPDATE tbsynchronize SET tagname='TAG_deltasql_1.3.7' WHERE versionnr=0;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 177, 'HEAD', 'TAG_deltasql_1.3.7', 'admin', 'deltasql-server', 161, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 177 on date 2012-01-13 11:11:57


-- version: 197 module: deltasql-module date: 2011-08-23 09:53:45
-- applied to: HEAD

/*
Adding ip to tbusagehistory to troubleshoot client issues.
*/

ALTER TABLE `tbusagehistory` ADD `ip` VARCHAR( 32 ) NULL ;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 198, 'HEAD', 'TAG_deltasql_1.4.0', 'admin', 'deltasql-server', 177, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 198 on date 2012-01-13 11:11:57

-- version: 199 module: deltasql-module date: 2011-09-09 16:39:00
-- applied to: HEAD

/*
Removing fields schemaname and description as they are not used anymore.
*/

ALTER TABLE `tbsynchronize` DROP `schemaname`;
ALTER TABLE `tbusagehistory` DROP `schemaname`;
ALTER TABLE `tbsynchronize` DROP `description`;
ALTER TABLE `tbusagehistory` DROP `description`;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 200, 'HEAD', 'TAG_deltasql_1.4.1', 'admin', 'deltasql-server', 198, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 200 on date 2012-01-13 11:11:57

-- Please make sure this script is executed on the correct schema!!
 
-- version: 214 module: deltasql-module date: 2012-01-05 09:09:20
-- applied to: HEAD

/*
Introducing customizable parameters for each user (user's preferences)
*/

ALTER TABLE `tbparameter` ADD `user_id` int(11) NULL;

-- version: 221 module: deltasql-module date: 2012-01-12 10:21:59
-- applied to: HEAD

/*
Modifying unique key for table tbparameter

*/

ALTER TABLE `tbparameter` DROP INDEX `paramtype`;
ALTER TABLE `tbparameter` ADD UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`);
 

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 222, 'HEAD', 'TAG_deltasql_1.4.3', 'admin', 'deltasql-server', 213, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 222 on date 2012-01-13 11:11:57

-- version: 239 module: deltasql-module date: 2012-03-02 10:45:36
-- applied to: HEAD 

/*
Changing structure of stats tables for datetime capabilities
*/
ALTER TABLE `tbphonetranscript` CHANGE `create_dt` `create_dt` DATETIME NULL DEFAULT NULL;
ALTER TABLE `tbusagehistory` CHANGE `update_dt` `update_dt` DATETIME NULL DEFAULT NULL; 
 

-- version: 241 module: deltasql-module date: 2012-03-05 08:46:25
-- applied to: HEAD 

/*
Renaming statistics tables.
*/
ALTER TABLE tbusagehistory RENAME tbsyncstats;
ALTER TABLE tbphonetranscript RENAME tbstats;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 242, 'HEAD', 'TAG_deltasql_1.5.0', 'admin', 'deltasql-server', 222, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 242 on date 2012-03-05 08:46:25

ALTER TABLE  `tbscript` CHANGE  `title`  `title` VARCHAR( 128 ) CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL;

-- updating synchronization information for the database schema
INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, TAGNAME, UPDATE_USER, UPDATE_TYPE, UPDATE_FROMVERSION, UPDATE_FROMSOURCE, DBTYPE)
VALUES ('deltasql-Server', 252, 'HEAD', 'TAG_deltasql_1.6.0', 'admin', 'deltasql-server', 242, 'HEAD', 'mySQL');
-- all scripts to reach db HEAD beginning from version 252 on date 2013-03-27 15:41:42
-- synchronization script generated in 0.0339 seconds

 
