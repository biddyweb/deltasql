-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 06, 2010 at 10:49 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.4-2ubuntu5.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `deltasql`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbbranch`
--

CREATE TABLE IF NOT EXISTS `tbbranch` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `project_id` int(11) default NULL,
  `description` varchar(400) collate latin1_general_ci NOT NULL,
  `versionnr` int(11) NOT NULL,
  `create_dt` date NOT NULL,
  `visible` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbbranch`
--

INSERT INTO `tbbranch` (`id`, `name`, `project_id`, `description`, `versionnr`, `create_dt`, `visible`) VALUES
(1, 'HEAD', NULL, 'This is the Trunk for all projects', 82, '2010-10-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbmodule`
--

CREATE TABLE IF NOT EXISTS `tbmodule` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  `lastversionnr` int(11) NOT NULL,
  `size` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tbmodule`
--

INSERT INTO `tbmodule` (`id`, `name`, `description`, `create_dt`, `lastversionnr`, `size`) VALUES
(9, 'filedistributor', 'Table structure for File Distributor Project', '2010-10-06', 66, 0),
(10, 'deltasql-module', 'module for the deltasql project', '2010-10-06', 82, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbmoduleproject`
--

CREATE TABLE IF NOT EXISTS `tbmoduleproject` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_id` (`module_id`,`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbmoduleproject`
--

INSERT INTO `tbmoduleproject` (`id`, `module_id`, `project_id`) VALUES
(12, 9, 13),
(13, 10, 14);

-- --------------------------------------------------------

--
-- Table structure for table `tbparameter`
--

CREATE TABLE IF NOT EXISTS `tbparameter` (
  `id` int(11) NOT NULL auto_increment,
  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,
  `paramname` varchar(20) collate latin1_general_ci NOT NULL,
  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `paramtype` (`paramtype`,`paramname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbparameter`
--

INSERT INTO `tbparameter` (`id`, `paramtype`, `paramname`, `paramvalue`) VALUES
(1, 'GLOBAL', 'VERSION', '82'),
(2, 'USAGESTATS', 'VERSION', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbphonetranscript`
--

CREATE TABLE IF NOT EXISTS `tbphonetranscript` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(32) collate latin1_general_ci default NULL,
  `deltasql_version` varchar(32) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  `nbscripts` int(11) default NULL,
  `nbmodules` int(11) default NULL,
  `nbprojects` int(11) default NULL,
  `nbbranches` int(11) default NULL,
  `nbsyncs` int(11) default NULL,
  `nbusers` int(11) default NULL,
  `nbmp` int(11) default NULL,
  `nbsb` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbphonetranscript`
--

INSERT INTO `tbphonetranscript` (`id`, `ip`, `deltasql_version`, `create_dt`, `nbscripts`, `nbmodules`, `nbprojects`, `nbbranches`, `nbsyncs`, `nbusers`, `nbmp`, `nbsb`) VALUES
(7, '62.2.103.33', '1.1.0', '2010-09-09', 51, 5, 2, 5, 0, 2, 4, 62),
(8, '81.62.32.181', '1.1.0', '2010-09-12', 7, 5, 1, 5, 0, 1, 4, 28);

-- --------------------------------------------------------

--
-- Table structure for table `tbproject`
--

CREATE TABLE IF NOT EXISTS `tbproject` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbproject`
--

INSERT INTO `tbproject` (`id`, `name`, `description`, `create_dt`) VALUES
(13, 'FileDistributor', 'Filedistributor project for the Global Processing Unit at http://gpu.sourceforge.net', '2010-10-06'),
(14, 'deltasql-Server', 'Tables needed for deltasql server', '2010-10-06');

-- --------------------------------------------------------

--
-- Table structure for table `tbscript`
--

CREATE TABLE IF NOT EXISTS `tbscript` (
  `id` int(11) NOT NULL auto_increment,
  `code` longtext collate latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `update_dt` datetime NOT NULL,
  `update_user` varchar(64) collate latin1_general_ci default NULL,
  `comments` longtext collate latin1_general_ci,
  `title` varchar(64) collate latin1_general_ci default NULL,
  `isapackage` tinyint(1) NOT NULL default '0',
  `isaview` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=58 ;

--
-- Dumping data for table `tbscript`
--

INSERT INTO `tbscript` (`id`, `code`, `module_id`, `versionnr`, `user_id`, `create_dt`, `update_dt`, `update_user`, `comments`, `title`, `isapackage`, `isaview`) VALUES
(29, 'CREATE TABLE `tbproject` (\r\n`id` INT NOT NULL AUTO_INCREMENT ,\r\n`name` VARCHAR( 32 ) NOT NULL ,\r\n`folder` VARCHAR( 16 ) NOT NULL ,\r\n`description` VARCHAR( 254 ) ,\r\n`isreportresult` INT DEFAULT ''1'',\r\n`isupload` INT DEFAULT ''0'',\r\n`nb_passes` INT DEFAULT ''1'' NOT NULL ,\r\nPRIMARY KEY ( `id` ) ,\r\nUNIQUE (\r\n`folder` \r\n)\r\n);', 9, 52, 1, '2010-10-06 10:23:17', '0000-00-00 00:00:00', NULL, 'Table tbproject', 'db update', 0, 0),
(30, 'ALTER TABLE `tbproject` ADD `status` VARCHAR( 32 ) NOT NULL DEFAULT ''None'';\r\nALTER TABLE `tbproject` ADD `current_pass` INT NOT NULL DEFAULT ''0'' AFTER `nb_passes` ;\r\nALTER TABLE `tbproject` ADD `tot_requests` INT NOT NULL DEFAULT ''0'';\r\nALTER TABLE `tbproject` ADD `tot_results` INT NOT NULL DEFAULT ''0'';\r\nALTER TABLE `tbproject` ADD `owner` VARCHAR( 32 ) NOT NULL DEFAULT ''None'';\r\nALTER TABLE `tbproject` ADD `isexecutable` INT( 11 ) NOT NULL DEFAULT ''0'' AFTER `isupload` ;\r\nALTER TABLE `tbproject` ADD `issinglewu` INT NOT NULL DEFAULT ''0'',\r\nADD `singlewuname` VARCHAR( 128 ) NULL ,\r\nADD `size` INT NULL ;\r\nALTER TABLE `tbproject` ADD `isforcedistribution` INT NOT NULL DEFAULT ''0'';', 9, 53, 1, '2010-10-06 10:23:55', '0000-00-00 00:00:00', NULL, 'missing fields in tables tbproject', 'db update', 0, 0),
(31, 'CREATE TABLE `tbwork` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`filename` VARCHAR( 254 ) NOT NULL ,\r\n`project_id` INT NOT NULL ,\r\n`requests` INT NOT NULL DEFAULT ''0'',\r\n`results` INT NOT NULL DEFAULT ''0'',\r\n`result_1` VARCHAR( 254 ) NULL ,\r\n`result_2` VARCHAR( 254 ) NULL ,\r\n`result_3` VARCHAR( 254 ) NULL ,\r\n`result_4` VARCHAR( 254 ) NULL ,\r\n`result_5` VARCHAR( 254 ) NULL ,\r\n`status` VARCHAR( 16 ) NOT NULL DEFAULT ''None''\r\n) ENGINE = MYISAM ;', 9, 54, 1, '2010-10-06 10:24:20', '0000-00-00 00:00:00', NULL, 'create table tbwork', 'db update', 0, 0),
(32, 'ALTER TABLE `tbwork` ADD `processor_1` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_2` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_3` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_4` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_5` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `workunitnb` INT NULL AFTER `id` ;', 9, 55, 1, '2010-10-06 10:24:40', '0000-00-00 00:00:00', NULL, 'missing fields in table tbwork', 'db update', 0, 0),
(33, 'CREATE TABLE `users` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `username` varchar(32) collate latin1_general_ci NOT NULL,\r\n  `password` varchar(32) collate latin1_general_ci default NULL,\r\n  `first` varchar(32) collate latin1_general_ci default NULL,\r\n  `last` varchar(32) collate latin1_general_ci default NULL,\r\n  `email` varchar(64) collate latin1_general_ci default NULL,\r\n  `rights` int(11) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `username` (`username`)\r\n) ENGINE=MyISAM;\r\nALTER TABLE `users` ADD `team_id` INT NULL ;', 9, 56, 1, '2010-10-06 10:25:10', '0000-00-00 00:00:00', NULL, 'create table tbusers', 'db update', 0, 0),
(34, 'INSERT INTO `users` ( `id` , `username` , `password` , `first` , `last` , `email` , `rights` )\r\nVALUES (NULL , ''admin'', ''ajsdflasdjf'', ''Main'', ''Administrator'', ''admin@gpufd'', ''3'');\r\n', 9, 57, 1, '2010-10-06 10:25:38', '0000-00-00 00:00:00', NULL, 'inserting admin user', 'db update', 0, 0),
(35, 'CREATE TABLE `tbexecutable` (\r\n`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`project_id` INT( 11 ) NOT NULL ,\r\n`win_x86` VARCHAR( 255 ) NULL ,\r\n`linux_x86` VARCHAR( 255 ) NULL ,\r\n`linux_ppc` VARCHAR( 255 ) NULL ,\r\n`macosx_x86` VARCHAR( 255 ) NULL ,\r\n`macosx_ppc` VARCHAR( 255 ) NULL ,\r\nINDEX ( `project_id` )\r\n) ENGINE = MYISAM ;', 9, 58, 1, '2010-10-06 10:26:12', '0000-00-00 00:00:00', NULL, 'creating table tbexecutable', 'db update', 0, 0),
(36, 'ALTER TABLE `tbexecutable` ADD `extractfolder` VARCHAR( 128 ) NULL ;\r\n', 9, 59, 1, '2010-10-06 10:26:37', '0000-00-00 00:00:00', NULL, 'missing field in table tbexecutable', 'db update', 0, 0),
(37, 'CREATE TABLE `tbftpupload` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `project_id` int(11) NOT NULL,\r\n  `ftpurl` varchar(255) collate latin1_general_ci NOT NULL,\r\n  `ftppath` varchar(255) collate latin1_general_ci NOT NULL,\r\n  `prefix` varchar(64) collate latin1_general_ci default NULL,\r\n  PRIMARY KEY  (`id`),\r\n  KEY `project_id` (`project_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\nALTER TABLE `tbftpupload` ADD `ftpport` INT( 11 ) NOT NULL DEFAULT ''21'',\r\nADD `user` VARCHAR( 64 ) NULL ,\r\nADD `password` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbftpupload` ADD `extension` VARCHAR( 64 ) NULL AFTER `prefix` ;', 9, 60, 1, '2010-10-06 10:27:09', '0000-00-00 00:00:00', NULL, 'creating table tbftpupload', 'db update', 0, 0),
(38, 'CREATE TABLE `tbprocessor` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`processor` VARCHAR( 128 ) NOT NULL ,\r\n`user_id` INT NULL ,\r\n`description` VARCHAR( 256 ) NULL ,\r\n`cputype` VARCHAR( 64 ) NULL\r\n) ENGINE = MYISAM ;', 9, 61, 1, '2010-10-06 10:27:55', '0000-00-00 00:00:00', NULL, 'creating table tbprocessor', 'db update', 0, 0),
(39, 'ALTER TABLE `tbprocessor` ADD `mhz` INT NULL ,\r\nADD `ram` INT NULL ,\r\nADD `cpus` INT NULL ;\r\nALTER TABLE `tbprocessor` ADD `operatingsystem` VARCHAR( 128 ) NULL ;\r\nALTER TABLE `tbprocessor` ADD `team_id` INT NULL ,\r\nADD `uptime` DOUBLE NULL ,\r\nADD `totuptime` DOUBLE NULL ,\r\nADD `zip` VARCHAR( 16 ) NULL ,\r\nADD `city` VARCHAR( 64 ) NULL ,\r\nADD `region` VARCHAR( 64 ) NULL ,\r\nADD `country` VARCHAR( 32 ) NULL ,\r\nADD `geolocation_x` DOUBLE NULL ,\r\nADD `geolocation_y` DOUBLE NULL ;', 9, 62, 1, '2010-10-06 10:28:26', '0000-00-00 00:00:00', NULL, 'adding missing fields to table tbprocessor', 'db update', 0, 0),
(40, 'ALTER TABLE `tbprocessor` ADD `nodeid` VARCHAR( 64 ) NULL AFTER `user_id` ,\r\nADD `ip` VARCHAR( 32 ) NULL AFTER `nodeid` ,\r\nADD `port` INT NULL AFTER `ip` ,\r\nADD `acceptincoming` INT NOT NULL DEFAULT ''0'' AFTER `port` ,\r\nADD `updated` DATETIME NULL AFTER `acceptincoming` ;\r\nALTER TABLE `tbprocessor` ADD `freeconn` INT NULL ,\r\nADD `maxconn` INT NULL ;\r\nALTER TABLE `tbprocessor` ADD `version` VARCHAR( 16 ) NULL;', 9, 63, 1, '2010-10-06 10:28:54', '0000-00-00 00:00:00', NULL, 'more missing fields on table processor', 'db update', 0, 0),
(41, 'CREATE TABLE `tbgpuprocessor` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`processor_id` INT NOT NULL ,\r\n`abarth` VARCHAR( 16 ) NULL ,\r\n`speed` INT NULL ,\r\n`crawlo` INT NULL ,\r\n`terra` INT NULL ,\r\n`threads` INT NULL ,\r\n`inqueue` INT NULL ,\r\n`trafficdown` INT NULL ,\r\n`trafficup` INT NULL ,\r\n`partlevel` DOUBLE NULL ,\r\n`ip1` VARCHAR( 32 ) NULL ,\r\n`ip2` VARCHAR( 32 ) NULL ,\r\n`ip3` VARCHAR( 32 ) NULL ,\r\n`ip4` VARCHAR( 32 ) NULL ,\r\n`ip5` VARCHAR( 32 ) NULL ,\r\n`ip6` VARCHAR( 32 ) NULL ,\r\n`ip7` VARCHAR( 32 ) NULL ,\r\n`ip8` VARCHAR( 32 ) NULL ,\r\n`ip9` VARCHAR( 32 ) NULL ,\r\n`ip10` VARCHAR( 32 ) NULL\r\n) ENGINE = MYISAM ;\r\n', 9, 64, 1, '2010-10-06 10:29:19', '0000-00-00 00:00:00', NULL, 'creating table tbgpuprocessor', 'db update', 0, 0),
(42, 'ALTER TABLE `tbgpuprocessor`\r\nADD `updated` DATETIME NULL;', 9, 65, 1, '2010-10-06 10:29:41', '0000-00-00 00:00:00', NULL, 'missing fields on table tbgpuprocessor', 'db update', 0, 0),
(43, 'CREATE TABLE `tbteam` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`name` VARCHAR( 64 ) NOT NULL ,\r\n`description` VARCHAR( 1024 ) NULL ,\r\n`url` VARCHAR( 256 ) NULL\r\n) ENGINE = MYISAM ;', 9, 66, 1, '2010-10-06 10:30:05', '0000-00-00 00:00:00', NULL, 'creating table tbteam', 'db update', 0, 0),
(44, 'CREATE TABLE `tbbranch` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `name` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `project_id` int(11) default NULL,\r\n  `description` varchar(400) collate latin1_general_ci NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `create_dt` date NOT NULL,\r\n  `visible` tinyint(1) NOT NULL default ''1'',\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `name` (`name`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;', 10, 69, 1, '2010-10-06 10:38:00', '0000-00-00 00:00:00', NULL, 'inserting table tbbranch', 'db update', 0, 0),
(45, 'INSERT INTO `tbbranch` VALUES (1, ''HEAD'', NULL, ''This is the Trunk for all projects'', 0, ''2007-10-31'', 1);', 10, 70, 1, '2010-10-06 10:38:22', '0000-00-00 00:00:00', NULL, 'inserting branch value', 'db update', 0, 0),
(46, 'CREATE TABLE `tbmodule` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `name` text collate latin1_general_ci NOT NULL,\r\n  `description` varchar(700) collate latin1_general_ci default NULL,\r\n  `create_dt` date default NULL,\r\n  `lastversionnr` int(11) NOT NULL,\r\n  `size` int(11) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;\r\n', 10, 71, 1, '2010-10-06 10:38:51', '0000-00-00 00:00:00', NULL, 'module table', 'db update', 0, 0),
(47, 'CREATE TABLE `tbmoduleproject` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `module_id` int(11) NOT NULL,\r\n  `project_id` int(11) NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `module_id` (`module_id`,`project_id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;\r\n\r\n', 10, 72, 1, '2010-10-06 10:39:12', '0000-00-00 00:00:00', NULL, 'moduleproject table', 'db update', 0, 0),
(48, 'CREATE TABLE `tbparameter` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,\r\n  `paramname` varchar(20) collate latin1_general_ci NOT NULL,\r\n  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `paramtype` (`paramtype`,`paramname`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;\r\n', 10, 73, 1, '2010-10-06 10:39:33', '0000-00-00 00:00:00', NULL, 'parameter table', 'db update', 0, 0),
(49, 'INSERT INTO `tbparameter` VALUES (1, ''GLOBAL'', ''VERSION'', ''6'');', 10, 74, 1, '2010-10-06 10:39:51', '0000-00-00 00:00:00', NULL, 'inserting parameter', 'db update', 0, 0),
(50, 'CREATE TABLE `tbscript` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `create_dt` date NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `versionnr` (`versionnr`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\n', 10, 75, 1, '2010-10-06 10:40:16', '0000-00-00 00:00:00', NULL, 'inserting script', 'db update', 0, 0),
(51, 'ALTER TABLE `tbscript` ADD `update_dt` DATE NULL AFTER `create_dt` ;\r\nALTER TABLE `tbscript` ADD `update_user` VARCHAR( 64 ) NULL AFTER `update_dt`;\r\nALTER TABLE `tbscript` CHANGE `create_dt` `create_dt` DATETIME NOT NULL;\r\nALTER TABLE `tbscript` CHANGE `update_dt` `update_dt` DATETIME NOT NULL; ', 10, 76, 1, '2010-10-06 10:40:45', '0000-00-00 00:00:00', NULL, 'modifying script table, added missing columns', 'db update', 0, 0),
(52, 'CREATE TABLE `tbscriptbranch` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `script_id` int(11) NOT NULL,\r\n  `branch_id` int(11) NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `script_id` (`script_id`,`branch_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\n', 10, 77, 1, '2010-10-06 10:41:23', '0000-00-00 00:00:00', NULL, 'creating table scriptbranch', 'db update', 0, 0),
(53, 'CREATE TABLE `tbsynchronize` (\r\n`projectname` VARCHAR( 64 ) NOT NULL ,\r\n`update_dt` DATE NULL ,\r\n`update_user` VARCHAR( 64 ) NULL ,\r\n`update_type` VARCHAR( 32 ) NULL ,\r\n`versionnr` INT NOT NULL,\r\n`branchname` VARCHAR( 128 ) NULL ,\r\n`description` VARCHAR( 128 ) NULL,\r\n`update_fromversion` INT NULL,\r\n`update_fromsource` VARCHAR( 128 ) NULL,\r\n`schemaname`  VARCHAR( 32 ) NULL ,\r\n`dbtype` VARCHAR( 32 ) NULL ,\r\nUNIQUE KEY `versionnr` (`versionnr`)\r\n) ENGINE = MYISAM ;', 10, 78, 1, '2010-10-06 10:41:47', '0000-00-00 00:00:00', NULL, 'creating table synchronize', 'db update', 0, 0),
(54, 'INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, SCHEMANAME, DBTYPE)\r\nVALUES (''deltasql-server'', 0, ''HEAD'', ''INTERNAL'', ''deltasql-server'', '''', ''mySQL'');', 10, 79, 1, '2010-10-06 10:42:12', '0000-00-00 00:00:00', NULL, 'inserting value in tbsynchronize', 'db update', 0, 0),
(55, 'CREATE TABLE `tbusagehistory` (\r\n`projectname` VARCHAR( 64 ) NOT NULL ,\r\n`update_dt` DATE NULL ,\r\n`update_user` VARCHAR( 64 ) NULL ,\r\n`update_type` VARCHAR( 32 ) NULL ,\r\n`versionnr` INT NOT NULL,\r\n`branchname` VARCHAR( 128 ) NULL ,\r\n`description` VARCHAR( 128 ) NULL,\r\n`update_fromversion` INT NULL,\r\n`update_fromsource` VARCHAR( 128 ) NULL,\r\n`schemaname`  VARCHAR( 32 ) NULL ,\r\n`dbtype` VARCHAR( 32 ) NULL \r\n) ENGINE = MYISAM ;', 10, 80, 1, '2010-10-06 10:43:03', '0000-00-00 00:00:00', NULL, 'creating table usage history', 'db update', 0, 0),
(56, 'CREATE TABLE `tbuser` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `username` varchar(32) collate latin1_general_ci NOT NULL,\r\n  `password` varchar(32) collate latin1_general_ci default NULL,\r\n  `first` varchar(32) collate latin1_general_ci default NULL,\r\n  `last` varchar(32) collate latin1_general_ci default NULL,\r\n  `email` varchar(64) collate latin1_general_ci default NULL,\r\n  `rights` int(11) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `username` (`username`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;', 10, 81, 1, '2010-10-06 10:43:26', '0000-00-00 00:00:00', NULL, 'creating table user', 'db update', 0, 0),
(57, 'CREATE TABLE `tbphonetranscript` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `ip` varchar(32) NULL,\r\n  `deltasql_version` varchar(32) NULL,\r\n  `create_dt` date default NULL,\r\n  `nbscripts` int(11) NULL,\r\n  `nbmodules` int(11) NULL,\r\n  `nbprojects` int(11) NULL,\r\n  `nbbranches` int(11) NULL,\r\n  `nbsyncs` int(11) NULL,\r\n  `nbusers` int(11) NULL,\r\n  `nbmp` int(11) NULL,\r\n  `nbsb` int(11) NULL,\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;', 10, 82, 1, '2010-10-06 10:43:56', '0000-00-00 00:00:00', NULL, 'creating table phonetranscript', 'db update', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbscriptbranch`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranch` (
  `id` int(11) NOT NULL auto_increment,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=100 ;

--
-- Dumping data for table `tbscriptbranch`
--

INSERT INTO `tbscriptbranch` (`id`, `script_id`, `branch_id`) VALUES
(94, 52, 1),
(78, 36, 1),
(79, 37, 1),
(81, 39, 1),
(93, 51, 1),
(95, 53, 1),
(83, 41, 1),
(82, 40, 1),
(77, 35, 1),
(84, 42, 1),
(80, 38, 1),
(75, 33, 1),
(76, 34, 1),
(91, 49, 1),
(88, 46, 1),
(87, 45, 1),
(86, 44, 1),
(85, 43, 1),
(90, 48, 1),
(89, 47, 1),
(92, 50, 1),
(74, 32, 1),
(96, 54, 1),
(98, 56, 1),
(72, 30, 1),
(73, 31, 1),
(97, 55, 1),
(71, 29, 1),
(99, 57, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbsynchronize`
--

CREATE TABLE IF NOT EXISTS `tbsynchronize` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` date default NULL,
  `update_user` varchar(64) default NULL,
  `update_type` varchar(32) default NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) default NULL,
  `description` varchar(128) default NULL,
  `update_fromversion` int(11) default NULL,
  `update_fromsource` varchar(128) default NULL,
  `schemaname` varchar(32) default NULL,
  `dbtype` varchar(32) default NULL,
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbsynchronize`
--

INSERT INTO `tbsynchronize` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `description`, `update_fromversion`, `update_fromsource`, `schemaname`, `dbtype`) VALUES
('deltasql-server', NULL, 'INTERNAL', 'deltasql-server', 0, 'HEAD', NULL, NULL, NULL, '', 'mySQL');

-- --------------------------------------------------------

--
-- Table structure for table `tbusagehistory`
--

CREATE TABLE IF NOT EXISTS `tbusagehistory` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` date default NULL,
  `update_user` varchar(64) default NULL,
  `update_type` varchar(32) default NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) default NULL,
  `description` varchar(128) default NULL,
  `update_fromversion` int(11) default NULL,
  `update_fromsource` varchar(128) default NULL,
  `schemaname` varchar(32) default NULL,
  `dbtype` varchar(32) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbusagehistory`
--

INSERT INTO `tbusagehistory` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `description`, `update_fromversion`, `update_fromsource`, `schemaname`, `dbtype`) VALUES
('deltasql-test-project', '2010-01-13', 'Not logged in', 'deltasql-server', 25, 'HEAD', '', 24, 'DELTA_1', '', 'mySQL'),
('deltasql-test-project', '2010-02-18', 'Not logged in', 'deltasql-server', 28, 'DELTA_1', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-02-21', 'Not logged in', 'deltasql-server', 28, 'DELTA_2', '', 13, 'DELTA_1', '', 'Oracle'),
('deltasql-test-project', '2010-03-07', 'Not logged in', 'deltasql-server', 29, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-03-23', 'Not logged in', 'deltasql-server', 29, 'HEAD', '', 20, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-03-29', 'admin', 'deltasql-server', 30, 'HEAD', '', 23, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-02', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 20, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-08', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-04-19', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 15, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-27', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-29', 'admin', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-30', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-30', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-30', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-30', 'Not logged in', 'deltasql-server', 30, 'HEAD', '', 14, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-04-30', 'admin ', 'deltasql-server', 31, 'HEAD', '', 14, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-05-13', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'PostgreSQL'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Other'),
('deltasql-test-project', '2010-05-18', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Sybase'),
('deltasql-test-project', '2010-05-26', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 0, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-06-08', 'admin', 'deltasql-server', 34, 'DELTA_2', '', 1, 'HEAD', '', 'Oracle'),
('DMS-2009', '2010-06-08', 'IamI', 'deltasql-server', 41, 'HEAD', 'UPDATE to LATEST', 1, 'HEAD', '', 'Oracle'),
('DMS-2009', '2010-06-08', 'IamI', 'deltasql-server', 41, 'HEAD', 'add test', 1, 'HEAD', '', 'Oracle'),
('DMS-2009', '2010-06-08', 'IamI', 'deltasql-server', 41, '00002-update', '', 38, 'HEAD', '', 'Oracle'),
('deltasql-test-project', '2010-07-26', 'Not logged in', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('Allegro', '2010-07-31', 'Not logged in', 'deltasql-server', 44, 'HEAD', '', 1, 'HEAD', '', 'PostgreSQL'),
('deltasql-test-project', '2010-08-30', 'admin', 'deltasql-server', 31, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('Allegro', '2010-09-09', 'admin', 'deltasql-server', 46, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('Allegro', '2010-09-09', 'admin', 'deltasql-server', 46, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('Allegro', '2010-09-10', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 1, 'HEAD', '', ''),
('Allegro', '2010-09-10', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 44, 'HEAD', '', ''),
('Allegro', '2010-09-10', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 1, 'HEAD', '', ''),
('Allegro', '2010-09-10', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 45, 'HEAD', '', ''),
('Allegro', '2010-09-14', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 0, 'HEAD', '', ''),
('Allegro', '2010-09-14', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 1, 'HEAD', '', ''),
('Allegro', '2010-09-14', 'Unknown User', 'Unknown Client', 46, 'HEAD', '', 2, 'HEAD', '', ''),
('FileDistributor', '2010-10-06', 'admin', 'deltasql-server', 66, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-10-06', 'admin', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'Oracle');

-- --------------------------------------------------------

--
-- Table structure for table `tbuser`
--

CREATE TABLE IF NOT EXISTS `tbuser` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci default NULL,
  `first` varchar(32) collate latin1_general_ci default NULL,
  `last` varchar(32) collate latin1_general_ci default NULL,
  `email` varchar(64) collate latin1_general_ci default NULL,
  `rights` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`id`, `username`, `password`, `first`, `last`, `email`, `rights`) VALUES
(1, 'admin', 'testdbsync', 'Main', 'Administrator', 'admin@deltasql', 3);
