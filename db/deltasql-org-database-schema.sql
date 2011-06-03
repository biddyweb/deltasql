-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 03, 2011 at 05:40 PM
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
  `sourcebranch` varchar(40) collate latin1_general_ci default NULL,
  `sourcebranch_id` int(11) default NULL,
  `istag` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbbranch`
--

INSERT INTO `tbbranch` (`id`, `name`, `project_id`, `description`, `versionnr`, `create_dt`, `visible`, `sourcebranch`, `sourcebranch_id`, `istag`) VALUES
(1, 'HEAD', NULL, 'This is the Trunk for all projects', 172, '2011-06-03', 1, NULL, NULL, 0),
(16, 'TAG_deltasql_1.3.2', 14, 'This is release reenabled the ability to perform updates from production schemas to development schemas.', 98, '2011-02-11', 1, 'HEAD', 1, 1),
(13, 'TAG_deltasql_1.3.0', 14, 'This release introduced a completely new sync algo and to tag releases.', 89, '2010-12-30', 1, 'HEAD', 1, 1),
(15, 'TAG_deltasql_1.3.1', 14, 'This release fixed the broken sync algo of 1.3.0 and disabled the ability to make out of a production schema a development schema.', 96, '2011-02-11', 1, 'HEAD', 1, 1),
(17, 'TAG_deltasql_1.3.3', 14, 'This release introduced history for edited scripts and did fixes into the right management.', 103, '2011-02-25', 1, 'HEAD', 1, 1),
(18, 'TAG_deltasql_1.3.4', 14, '- new feature: synchronizing from a tag (without specifying version number)\r\n- new feature: changes to branches are recorded\r\n- index.php patched', 114, '2011-02-26', 1, 'HEAD', 1, 1),
(19, 'TAG_deltasql_1.3.5', 14, 'Diff of history in scripts. Plotting of graph. Tagging of HEAD should always belong to a project.', 115, '2011-03-07', 1, 'HEAD', 1, 1),
(22, 'PROD_1_X', 24, 'This is branch 1 for our beloved customer X.', 146, '2011-04-15', 1, 'HEAD', 1, 0),
(24, 'TAG_deltasql_1.3.6', 14, 'This is a tag on branch HEAD for release 1.3.6 of deltasql.', 161, '2011-04-15', 1, 'HEAD', 1, 1),
(26, 'TAG_deltasql_1.3.7', 14, 'This is a tag for deltasql-Server on branch HEAD at version 173.', 173, '2011-06-03', 1, 'HEAD', 1, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbmodule`
--

INSERT INTO `tbmodule` (`id`, `name`, `description`, `create_dt`, `lastversionnr`, `size`) VALUES
(12, 'gpuII-server', 'This module stores scripts belonging to the GPU Preview package available at http://sourceforge.net/projects/gpu/files/', '2011-04-14', 119, 0),
(18, 'multivac-module', 'This is the multivac module for the project Multivac.', '2011-04-15', 154, 0),
(9, 'filedistributor', 'Table structure for File Distributor Project', '2011-01-05', 90, 0),
(10, 'deltasql-module', 'module for the deltasql project, containing all scripts (no further modularization needed).', '2011-06-03', 172, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tbmoduleproject`
--

INSERT INTO `tbmoduleproject` (`id`, `module_id`, `project_id`) VALUES
(24, 18, 24),
(17, 12, 18),
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbparameter`
--

INSERT INTO `tbparameter` (`id`, `paramtype`, `paramname`, `paramvalue`) VALUES
(1, 'GLOBAL', 'VERSION', '173'),
(2, 'USAGESTATS', 'VERSION', '101'),
(3, 'TEST', 'DB_CONNECTION', 'OK');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tbphonetranscript`
--

INSERT INTO `tbphonetranscript` (`id`, `ip`, `deltasql_version`, `create_dt`, `nbscripts`, `nbmodules`, `nbprojects`, `nbbranches`, `nbsyncs`, `nbusers`, `nbmp`, `nbsb`) VALUES
(9, '85.25.10.70', '1.3.3', '2011-02-25', 33, 3, 4, 4, 111, 3, 5, 33),
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbproject`
--

INSERT INTO `tbproject` (`id`, `name`, `description`, `create_dt`) VALUES
(18, 'GPU-II', 'This is the server side project of GPU-II (http://gpu.sourceforge.net)', '2011-02-26'),
(24, 'Multivac', 'This is the Multivac project.', '2011-04-14'),
(13, 'FileDistributor', 'Filedistributor project for the Global Processing Unit at http://gpu.sourceforge.net', '2010-10-06'),
(14, 'deltasql-Server', 'This is the project tracking changes of deltasql-server itself :-) Like a compiler that compiles itself :-D', '2010-10-06');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=102 ;

--
-- Dumping data for table `tbscript`
--

INSERT INTO `tbscript` (`id`, `code`, `module_id`, `versionnr`, `user_id`, `create_dt`, `update_dt`, `update_user`, `comments`, `title`, `isapackage`, `isaview`) VALUES
(29, 'CREATE TABLE `tbproject` (\r\n`id` INT NOT NULL AUTO_INCREMENT ,\r\n`name` VARCHAR( 32 ) NOT NULL ,\r\n`folder` VARCHAR( 16 ) NOT NULL ,\r\n`description` VARCHAR( 254 ) ,\r\n`isreportresult` INT DEFAULT ''1'',\r\n`isupload` INT DEFAULT ''0'',\r\n`nb_passes` INT DEFAULT ''1'' NOT NULL ,\r\nPRIMARY KEY ( `id` ) ,\r\nUNIQUE (\r\n`folder` \r\n)\r\n);', 9, 52, 1, '2010-10-06 10:23:17', '0000-00-00 00:00:00', NULL, 'Table tbproject', 'db update', 0, 0),
(30, 'ALTER TABLE `tbproject` ADD `status` VARCHAR( 32 ) NOT NULL DEFAULT ''None'';\r\nALTER TABLE `tbproject` ADD `current_pass` INT NOT NULL DEFAULT ''0'' AFTER `nb_passes` ;\r\nALTER TABLE `tbproject` ADD `tot_requests` INT NOT NULL DEFAULT ''0'';\r\nALTER TABLE `tbproject` ADD `tot_results` INT NOT NULL DEFAULT ''0'';\r\nALTER TABLE `tbproject` ADD `owner` VARCHAR( 32 ) NOT NULL DEFAULT ''None'';\r\nALTER TABLE `tbproject` ADD `isexecutable` INT( 11 ) NOT NULL DEFAULT ''0'' AFTER `isupload` ;\r\nALTER TABLE `tbproject` ADD `issinglewu` INT NOT NULL DEFAULT ''0'',\r\nADD `singlewuname` VARCHAR( 128 ) NULL ,\r\nADD `size` INT NULL ;\r\nALTER TABLE `tbproject` ADD `isforcedistribution` INT NOT NULL DEFAULT ''0'';', 9, 53, 1, '2010-10-06 10:23:55', '0000-00-00 00:00:00', NULL, 'missing fields in tables tbproject', 'db update', 0, 0),
(31, 'CREATE TABLE `tbwork` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`filename` VARCHAR( 254 ) NOT NULL ,\r\n`project_id` INT NOT NULL ,\r\n`requests` INT NOT NULL DEFAULT ''0'',\r\n`results` INT NOT NULL DEFAULT ''0'',\r\n`result_1` VARCHAR( 254 ) NULL ,\r\n`result_2` VARCHAR( 254 ) NULL ,\r\n`result_3` VARCHAR( 254 ) NULL ,\r\n`result_4` VARCHAR( 254 ) NULL ,\r\n`result_5` VARCHAR( 254 ) NULL ,\r\n`status` VARCHAR( 16 ) NOT NULL DEFAULT ''None''\r\n) ENGINE = MYISAM ;', 9, 54, 1, '2010-10-06 10:24:20', '0000-00-00 00:00:00', NULL, 'create table tbwork', 'db update', 0, 0),
(32, 'ALTER TABLE `tbwork` ADD `processor_1` VARCHAR( 64 ) NULL;\r\nALTER TABLE `tbwork` ADD `processor_2` VARCHAR( 64 ) NULL;\r\nALTER TABLE `tbwork` ADD `processor_3` VARCHAR( 64 ) NULL;\r\nALTER TABLE `tbwork` ADD `processor_4` VARCHAR( 64 ) NULL;\r\nALTER TABLE `tbwork` ADD `processor_5` VARCHAR( 64 ) NULL;\r\nALTER TABLE `tbwork` ADD `workunitnb` INT NULL AFTER `id`;', 9, 55, 1, '2010-10-06 10:24:40', '2011-02-25 16:18:19', 'dangermouse', 'missing fields in table tbwork', 'db update', 0, 0),
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
(51, 'ALTER TABLE `tbscript` ADD `update_dt` DATE NULL AFTER `create_dt` ;\r\nALTER TABLE `tbscript` ADD `update_user` VARCHAR( 64 ) NULL AFTER `update_dt`;\r\nALTER TABLE `tbscript` CHANGE `create_dt` `create_dt` DATETIME NOT NULL;\r\nALTER TABLE `tbscript` CHANGE `update_dt` `update_dt` DATETIME NOT NULL; ', 10, 76, 1, '2010-10-06 10:40:45', '2011-02-25 16:12:43', 'dangermouse', 'modifying script table, added missing columns, so that hour is stored.', 'db update', 0, 0),
(52, 'CREATE TABLE `tbscriptbranch` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `script_id` int(11) NOT NULL,\r\n  `branch_id` int(11) NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `script_id` (`script_id`,`branch_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\n', 10, 77, 1, '2010-10-06 10:41:23', '0000-00-00 00:00:00', NULL, 'creating table scriptbranch', 'db update', 0, 0),
(53, 'CREATE TABLE `tbsynchronize` (\r\n`projectname` VARCHAR( 64 ) NOT NULL ,\r\n`update_dt` DATE NULL ,\r\n`update_user` VARCHAR( 64 ) NULL ,\r\n`update_type` VARCHAR( 32 ) NULL ,\r\n`versionnr` INT NOT NULL,\r\n`branchname` VARCHAR( 128 ) NULL ,\r\n`description` VARCHAR( 128 ) NULL,\r\n`update_fromversion` INT NULL,\r\n`update_fromsource` VARCHAR( 128 ) NULL,\r\n`schemaname`  VARCHAR( 32 ) NULL ,\r\n`dbtype` VARCHAR( 32 ) NULL ,\r\nUNIQUE KEY `versionnr` (`versionnr`)\r\n) ENGINE = MYISAM ;', 10, 78, 1, '2010-10-06 10:41:47', '0000-00-00 00:00:00', NULL, 'creating table synchronize', 'db update', 0, 0),
(54, 'INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, SCHEMANAME, DBTYPE)\r\nVALUES (''deltasql-server'', 0, ''HEAD'', ''INTERNAL'', ''deltasql-server'', '''', ''mySQL'');', 10, 79, 1, '2010-10-06 10:42:12', '0000-00-00 00:00:00', NULL, 'inserting value in tbsynchronize', 'db update', 0, 0),
(55, 'CREATE TABLE `tbusagehistory` (\r\n`projectname` VARCHAR( 64 ) NOT NULL ,\r\n`update_dt` DATE NULL ,\r\n`update_user` VARCHAR( 64 ) NULL ,\r\n`update_type` VARCHAR( 32 ) NULL ,\r\n`versionnr` INT NOT NULL,\r\n`branchname` VARCHAR( 128 ) NULL ,\r\n`description` VARCHAR( 128 ) NULL,\r\n`update_fromversion` INT NULL,\r\n`update_fromsource` VARCHAR( 128 ) NULL,\r\n`schemaname`  VARCHAR( 32 ) NULL ,\r\n`dbtype` VARCHAR( 32 ) NULL \r\n) ENGINE = MYISAM ;', 10, 80, 1, '2010-10-06 10:43:03', '0000-00-00 00:00:00', NULL, 'creating table usage history', 'db update', 0, 0),
(56, 'CREATE TABLE `tbuser` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `username` varchar(32) collate latin1_general_ci NOT NULL,\r\n  `password` varchar(32) collate latin1_general_ci default NULL,\r\n  `first` varchar(32) collate latin1_general_ci default NULL,\r\n  `last` varchar(32) collate latin1_general_ci default NULL,\r\n  `email` varchar(64) collate latin1_general_ci default NULL,\r\n  `rights` int(11) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `username` (`username`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;', 10, 81, 1, '2010-10-06 10:43:26', '0000-00-00 00:00:00', NULL, 'creating table user', 'db update', 0, 0),
(60, 'ALTER TABLE `tbbranch` ADD `sourcebranch` VARCHAR( 40 ) NULL;\r\nALTER TABLE `tbbranch` ADD `sourcebranch_id` int(11) default NULL;\r\n\r\nUPDATE `tbbranch` SET sourcebranch=''HEAD'' where name<>''HEAD'';\r\nUPDATE `tbbranch` SET sourcebranch_id=1 where name<>''HEAD'';\r\n\r\nALTER TABLE `tbbranch` ADD `istag` tinyint(1) NOT NULL default ''0'';\r\nALTER TABLE tbsynchronize ADD tagname varchar(128) NULL;\r\nCREATE TABLE `tbscriptgeneration` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `fromversionnr` int(11) default NULL,\r\n  `toversionnr` int(11) default NULL,\r\n  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `frombranch_id` int(11) NOT NULL,\r\n  `tobranch_id` int(11) NOT NULL,\r\n  `create_dt` datetime default NULL,\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;\r\n', 10, 88, 1, '2010-12-30 16:45:02', '2011-02-25 16:02:13', 'admin', 'Steps to upgrade from 1.2.1 to 1.3.0:\r\n- Adding source branch information to tbbranch\r\n- New table: tbscriptgeneration\r\n- tagname added to tbsynchronization', 'db update', 0, 0),
(65, 'CREATE TABLE `tbscriptchangelog` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `update_user` VARCHAR( 64 ) NULL,\r\n  `script_id` int(11) NOT NULL,\r\n  `create_dt` datetime NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1; ', 10, 101, 1, '2011-02-25 15:11:44', '2011-02-26 07:47:35', 'admin', 'Table to record changes in history. (1.3.3)', 'db update', 0, 0),
(62, 'INSERT INTO `tbparameter` VALUES ('''', ''TEST'', ''DB_CONNECTION'', ''OK'');\r\n', 10, 94, 1, '2011-02-10 11:07:04', '2011-02-26 07:46:44', 'admin', 'Added parameter to test db connection (1.3.1)', 'db update', 0, 0),
(63, '--INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) \r\n--VALUES  (9, ''-- 6 script only for HEAD before branch DELTA_2 comes'', 5, 17, 1, ''2008-05-21'', '''', '''', ''db update'', 0, 0);\r\n', 10, 95, 1, '2011-02-10 11:08:06', '2011-02-26 15:45:08', 'admin', 'added missing test script (when installing deltasql with test data)', 'db update', 0, 0),
(64, 'ALTER TABLE tbscriptgeneration ADD  `exclbranch` tinyint(1) NOT NULL default ''0'';\r\n', 10, 97, 1, '2011-02-11 16:57:02', '2011-02-26 07:47:14', 'admin', 'improvement to allow upgrade from production schemas to development schemas. (1.3.2)', 'db update', 0, 0),
(67, 'CREATE TABLE `tbclient` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`nodeid` VARCHAR( 32 ) NOT NULL ,\r\n`nodename` VARCHAR( 32 ) NOT NULL ,\r\n`country` VARCHAR( 32 ) NOT NULL ,\r\n`region` VARCHAR( 32 ) NULL ,\r\n`city` VARCHAR( 32 ) NULL ,\r\n`zip` VARCHAR( 32 ) NULL ,\r\n`ip` VARCHAR( 32 ) NULL ,\r\n`port` VARCHAR( 32 ) NULL ,\r\n`localip` VARCHAR( 32 ) NULL ,\r\n`os` VARCHAR( 32 ) NOT NULL ,\r\n`version` VARCHAR( 16 ) NOT NULL,\r\n`acceptincoming` INT NOT NULL DEFAULT ''0'',\r\n`gigaflops` INT NOT NULL,\r\n`ram` INT NOT NULL,\r\n`mhz` INT NOT NULL,\r\n`nbcpus` INT NOT NULL,\r\n`bits` INT NOT NULL,\r\n`isscreensaver` INT NOT NULL DEFAULT ''0'',\r\n`uptime` DOUBLE NOT NULL ,\r\n`totaluptime` DOUBLE NOT NULL ,\r\n`longitude` DOUBLE NOT NULL ,\r\n`latitude` DOUBLE NOT NULL ,\r\n`userid` VARCHAR( 32 ) NOT NULL ,\r\n`team` VARCHAR( 64 ) NOT NULL ,\r\n`description` VARCHAR( 256 ) NULL ,\r\n`cputype` VARCHAR( 64 ) NULL,\r\n`create_dt` DATETIME NOT NULL,\r\n`update_dt` DATETIME NULL\r\n) ENGINE = MYISAM ;\r\n', 12, 107, 5, '2011-02-26 15:47:13', '0000-00-00 00:00:00', NULL, 'Client table', 'db update', 0, 0),
(68, 'CREATE TABLE `tbchannel` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`nodeid` VARCHAR( 32 ) NOT NULL ,\r\n`nodename` VARCHAR( 32 ) NOT NULL ,\r\n`user` VARCHAR( 32 ) NOT NULL ,\r\n`channame` VARCHAR( 32 ) NOT NULL ,\r\n`chantype` VARCHAR( 32 ) NOT NULL ,\r\n`content` VARCHAR( 1024 ) NOT NULL ,\r\n`ip` VARCHAR( 32 ) NULL ,\r\n`usertime_dt` DATETIME NULL,\r\n`create_dt` DATETIME NOT NULL\r\n) ENGINE = MYISAM ;', 12, 108, 5, '2011-02-26 15:47:37', '0000-00-00 00:00:00', NULL, 'Channel table', 'db update', 0, 0),
(69, 'CREATE TABLE `tbparameter` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,\r\n  `paramname` varchar(20) collate latin1_general_ci NOT NULL,\r\n  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `paramtype` (`paramtype`,`paramname`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;\r\n\r\n\r\nINSERT INTO `tbparameter` (`id`, `paramtype`, `paramname`, `paramvalue`) VALUES\r\n(1, ''TEST'', ''DB_CONNECTION'', ''OK'');\r\n', 12, 109, 5, '2011-02-26 15:48:13', '0000-00-00 00:00:00', NULL, 'Parameter table with some value', 'db update', 0, 0),
(70, 'CREATE TABLE `tbjob` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`jobid` VARCHAR( 16 ) NOT NULL ,\r\n`job` VARCHAR( 1024 ) NOT NULL ,\r\n`workunitincoming` VARCHAR( 64 ) NOT NULL ,\r\n`workunitoutgoing` VARCHAR( 64 ) NOT NULL ,\r\n`requests` INT NOT NULL DEFAULT ''1'',\r\n`delivered` INT NOT NULL DEFAULT ''0'',\r\n`results` INT NOT NULL DEFAULT ''0'',\r\n`nodename` VARCHAR( 64 ) NOT NULL ,\r\n`nodeid` VARCHAR( 32 ) NOT NULL ,\r\n`ip` VARCHAR( 32 ) NULL ,\r\n`create_dt` DATETIME NOT NULL\r\n) ENGINE = MYISAM ;', 12, 110, 5, '2011-02-26 15:48:46', '0000-00-00 00:00:00', NULL, 'job table', 'db update', 0, 0),
(71, 'CREATE TABLE `tbjobqueue` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`job_id` INT NOT NULL ,\r\n`nodeid` VARCHAR( 32 ) NOT NULL ,\r\n`transmitted` INT NOT NULL DEFAULT ''0'',\r\n`received` INT NOT NULL DEFAULT ''0'',\r\n`create_dt` DATETIME NOT NULL,\r\n`transmission_dt` DATETIME NULL,\r\n`reception_dt` DATETIME NULL\r\n) ENGINE = MYISAM ;', 12, 111, 5, '2011-02-26 15:49:17', '0000-00-00 00:00:00', NULL, 'job queue table', 'db update', 0, 0),
(72, 'CREATE TABLE `tbjobresult` (\r\n`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,\r\n`job_id` INT NOT NULL ,\r\n`jobid` VARCHAR( 16 ) NOT NULL ,\r\n`jobqueue_id` INT NOT NULL ,\r\n`jobresult` VARCHAR( 1024 ) NOT NULL ,\r\n`workunitresult` VARCHAR( 64 ) NOT NULL ,\r\n`iserroneous` INT NOT NULL DEFAULT ''0'',\r\n`errorid` INT NOT NULL DEFAULT ''0'',\r\n`errorarg` VARCHAR( 32 ) NOT NULL ,\r\n`errormsg` VARCHAR( 32 ) NOT NULL ,\r\n`nodename` VARCHAR( 64 ) NOT NULL ,\r\n`nodeid` VARCHAR( 32 ) NOT NULL ,\r\n`ip` VARCHAR( 32 ) NULL ,\r\n`create_dt` DATETIME NOT NULL\r\n) ENGINE = MYISAM ;\r\n', 12, 112, 5, '2011-02-26 15:49:42', '0000-00-00 00:00:00', NULL, 'job result table', 'db update', 0, 0),
(73, 'CREATE TABLE `tbscriptbranchchangelog` (\r\n  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n  `script_id` int(11) NOT NULL,\r\n  `branch_id` int(11) NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `script_id` (`script_id`,`branch_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\n ', 10, 113, 1, '2011-02-26 18:42:09', '2011-02-28 15:42:02', 'admin', 'table to track changes into branches (1.3.4)', 'db update', 0, 0),
(82, 'update tbtrade set tradable=1;', 18, 138, 1, '2011-04-14 23:05:52', '0000-00-00 00:00:00', NULL, 'Sets all trades to tradable.', 'db update', 0, 0),
(83, 'alter table tbuser add email varchar(64) NULL;', 18, 139, 1, '2011-04-14 23:07:17', '0000-00-00 00:00:00', NULL, 'adds column email to table tbuser.', 'db update', 0, 0),
(89, 'alter table tbtrade\r\nadd confirmstatus int not null;', 18, 148, 1, '2011-04-15 19:07:16', '0000-00-00 00:00:00', NULL, 'add confirmstatus to tbtrade', 'db update', 0, 0),
(90, 'alter table tbuser\r\nadd faxnr varchar(64) null;', 18, 149, 1, '2011-04-15 19:08:25', '0000-00-00 00:00:00', NULL, 'adding faxnumber for a user', 'db update', 0, 0),
(91, 'alter table tbtrade add update_dt\r\n datetime null;', 18, 150, 1, '2011-04-15 19:11:49', '0000-00-00 00:00:00', NULL, 'recording latest change date on a trade', 'db update', 0, 0),
(92, 'alter table tbuser add update_dt\r\n datetime null;', 18, 151, 1, '2011-04-15 19:12:23', '0000-00-00 00:00:00', NULL, 'recording latest user modification date.', 'db update', 0, 0),
(95, 'update tbtrade set confirmstatus=20;', 18, 154, 1, '2011-04-15 23:00:21', '2011-04-22 19:04:53', 'admin', 'sets confirmstatus to UPDATED.', 'db update', 0, 0),
(101, 'ALTER TABLE `tbuser` ADD `encrypted` TINYINT( 1 ) NOT NULL DEFAULT ''0'',\r\nADD `passwhash` VARCHAR( 40 ) NULL ;', 10, 172, 1, '2011-06-03 15:50:02', '0000-00-00 00:00:00', NULL, 'Adding columns for password encryption (1.3.7)', 'db update', 0, 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=178 ;

--
-- Dumping data for table `tbscriptbranch`
--

INSERT INTO `tbscriptbranch` (`id`, `script_id`, `branch_id`) VALUES
(94, 52, 1),
(78, 36, 1),
(79, 37, 1),
(81, 39, 1),
(125, 51, 1),
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
(126, 32, 1),
(96, 54, 1),
(98, 56, 1),
(72, 30, 1),
(73, 31, 1),
(97, 55, 1),
(71, 29, 1),
(123, 60, 1),
(129, 65, 1),
(127, 62, 1),
(130, 63, 1),
(128, 64, 1),
(131, 67, 1),
(132, 68, 1),
(133, 69, 1),
(134, 70, 1),
(135, 71, 1),
(136, 72, 1),
(138, 73, 1),
(145, 80, 1),
(146, 81, 1),
(147, 82, 1),
(148, 83, 1),
(156, 89, 1),
(158, 90, 22),
(157, 90, 1),
(159, 91, 1),
(160, 91, 22),
(170, 95, 1),
(161, 92, 1),
(171, 95, 22),
(177, 101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbscriptbranchchangelog`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranchchangelog` (
  `id` int(11) NOT NULL auto_increment,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tbscriptbranchchangelog`
--

INSERT INTO `tbscriptbranchchangelog` (`id`, `script_id`, `branch_id`) VALUES
(1, 15, 1),
(2, 16, 1),
(3, 17, 1),
(4, 18, 1),
(5, 19, 1),
(6, 20, 1),
(7, 21, 1),
(8, 22, 1),
(9, 22, 21),
(10, 23, 1),
(11, 24, 1),
(12, 25, 1),
(13, 25, 21),
(14, 26, 1),
(15, 27, 1),
(16, 28, 1),
(17, 29, 1),
(18, 30, 1),
(19, 31, 1),
(20, 32, 1),
(21, 33, 1),
(22, 34, 1),
(23, 35, 1),
(24, 36, 1),
(25, 37, 1),
(26, 37, 22),
(27, 37, 25);

-- --------------------------------------------------------

--
-- Table structure for table `tbscriptchangelog`
--

CREATE TABLE IF NOT EXISTS `tbscriptchangelog` (
  `id` int(11) NOT NULL auto_increment,
  `code` longtext collate latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `update_user` varchar(64) collate latin1_general_ci default NULL,
  `script_id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `comments` longtext collate latin1_general_ci,
  `title` varchar(64) collate latin1_general_ci default NULL,
  `isapackage` tinyint(1) NOT NULL default '0',
  `isaview` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `tbscriptchangelog`
--

INSERT INTO `tbscriptchangelog` (`id`, `code`, `module_id`, `versionnr`, `user_id`, `update_user`, `script_id`, `create_dt`, `comments`, `title`, `isapackage`, `isaview`) VALUES
(2, 'CREATE TABLE `tbscriptchangelog` ( `id` int(11) NOT NULL auto_increment, `code` longtext collate latin1_general_ci NOT NULL, `module_id` int(11) NOT NULL, `versionnr` int(11) NOT NULL, `user_id` int(11) NOT NULL, `update_user` VARCHAR( 64 ) NULL, `script_id` int(11) NOT NULL, `create_dt` datetime NOT NULL, `comments` longtext collate latin1_general_ci, `title` varchar(64) collate latin1_general_ci default NULL, `isapackage` tinyint(1) NOT NULL default ''0'', `isaview` tinyint(1) NOT NULL default ''0'', PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;', 10, 101, 1, 'admin', 65, '2011-02-25 15:25:33', '** Table to record changes in history ***', 'db update', 0, 0),
(3, 'CREATE TABLE `tbscriptchangelog` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `update_user` VARCHAR( 64 ) NULL,\r\n  `script_id` int(11) NOT NULL,\r\n  `create_dt` datetime NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1; ', 10, 101, 1, 'admin', 65, '2011-02-25 15:51:55', 'Table to record changes in history', 'db update', 0, 0),
(4, 'CREATE TABLE `tbscriptchangelog` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `update_user` VARCHAR( 64 ) NULL,\r\n  `script_id` int(11) NOT NULL,\r\n  `create_dt` datetime NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1; ', 10, 101, 1, 'admin', 65, '2011-02-25 16:00:55', '* Table to record changes in history', 'db update', 0, 0),
(5, 'CREATE TABLE `tbscriptchangelog` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `update_user` VARCHAR( 64 ) NULL,\r\n  `script_id` int(11) NOT NULL,\r\n  `create_dt` datetime NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1; ', 10, 101, 1, 'admin', 65, '2011-02-25 16:01:20', '" Table to record changes in history', 'db update', 0, 0),
(6, 'ALTER TABLE `tbbranch` ADD `sourcebranch` VARCHAR( 40 ) NULL;\r\nALTER TABLE `tbbranch` ADD `sourcebranch_id` int(11) default NULL;\r\n\r\nUPDATE `tbbranch` SET sourcebranch=''HEAD'' where name<>''HEAD'';\r\nUPDATE `tbbranch` SET sourcebranch_id=1 where name<>''HEAD'';\r\n\r\nALTER TABLE `tbbranch` ADD `istag` tinyint(1) NOT NULL default ''0'';\r\nALTER TABLE tbsynchronize ADD tagname varchar(128) NULL;\r\nCREATE TABLE `tbscriptgeneration` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `fromversionnr` int(11) default NULL,\r\n  `toversionnr` int(11) default NULL,\r\n  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `frombranch_id` int(11) NOT NULL,\r\n  `tobranch_id` int(11) NOT NULL,\r\n  `create_dt` datetime default NULL,\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;\r\n', 10, 91, 1, 'admin', 60, '2011-02-25 15:49:42', 'Steps to upgrade from 1.2.1 to 1.3.0:\r\n- Adding source branch information to tbbranch\r\n- New table: tbscriptgeneration\r\n- tagname added to tbsynchronization', 'db update', 0, 0),
(7, 'ALTER TABLE `tbbranch` ADD `sourcebranch` VARCHAR( 40 ) NULL;\r\nALTER TABLE `tbbranch` ADD `sourcebranch_id` int(11) default NULL;\r\n\r\nUPDATE `tbbranch` SET sourcebranch=''HEAD'' where name<>''HEAD'';\r\nUPDATE `tbbranch` SET sourcebranch_id=1 where name<>''HEAD'';\r\n\r\nALTER TABLE `tbbranch` ADD `istag` tinyint(1) NOT NULL default ''0'';\r\nALTER TABLE tbsynchronize ADD tagname varchar(128) NULL;\r\nCREATE TABLE `tbscriptgeneration` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `fromversionnr` int(11) default NULL,\r\n  `toversionnr` int(11) default NULL,\r\n  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,\r\n  `frombranch_id` int(11) NOT NULL,\r\n  `tobranch_id` int(11) NOT NULL,\r\n  `create_dt` datetime default NULL,\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;\r\n', 10, 91, 1, 'admin', 60, '2011-02-25 16:01:58', ' "Steps to upgrade from 1.2.1 to 1.3.0:\r\n- Adding source branch information to tbbranch\r\n- New table: tbscriptgeneration\r\n- tagname added to tbsynchronization', 'db update', 0, 0),
(8, 'INSERT INTO foo (id, comment) VALUES('''', ''paripara'');', 11, 102, 1, '', 66, '0000-00-00 00:00:00', 'test script to be deleted', 'db update', 0, 0),
(9, 'ALTER TABLE `tbscript` ADD `update_dt` DATE NULL AFTER `create_dt` ;\r\nALTER TABLE `tbscript` ADD `update_user` VARCHAR( 64 ) NULL AFTER `update_dt`;\r\nALTER TABLE `tbscript` CHANGE `create_dt` `create_dt` DATETIME NOT NULL;\r\nALTER TABLE `tbscript` CHANGE `update_dt` `update_dt` DATETIME NOT NULL; ', 10, 76, 1, '', 51, '0000-00-00 00:00:00', 'modifying script table, added missing columns', 'db update', 0, 0),
(10, 'ALTER TABLE `tbwork` ADD `processor_1` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_2` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_3` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_4` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `processor_5` VARCHAR( 64 ) NULL ;\r\nALTER TABLE `tbwork` ADD `workunitnb` INT NULL AFTER `id` ;', 9, 55, 1, '', 32, '2010-10-06 10:24:40', 'missing fields in table tbwork', 'db update', 0, 0),
(11, 'INSERT INTO `tbparameter` VALUES ('''', ''TEST'', ''DB_CONNECTION'', ''OK'');\r\n', 10, 94, 1, '', 62, '2011-02-10 11:07:04', 'Added parameter to test db connection', 'db update', 0, 0),
(12, 'ALTER TABLE tbscriptgeneration ADD  `exclbranch` tinyint(1) NOT NULL default ''0'';\r\n', 10, 97, 1, '', 64, '2011-02-11 16:57:02', 'improvement to allow upgrade from production schemas to development schemas.', 'db update', 0, 0),
(13, 'CREATE TABLE `tbscriptchangelog` (\r\n  `id` int(11) NOT NULL auto_increment,\r\n  `code` longtext collate latin1_general_ci NOT NULL,\r\n  `module_id` int(11) NOT NULL,\r\n  `versionnr` int(11) NOT NULL,\r\n  `user_id` int(11) NOT NULL,\r\n  `update_user` VARCHAR( 64 ) NULL,\r\n  `script_id` int(11) NOT NULL,\r\n  `create_dt` datetime NOT NULL,\r\n  `comments` longtext collate latin1_general_ci,\r\n  `title` varchar(64) collate latin1_general_ci default NULL,\r\n  `isapackage` tinyint(1) NOT NULL default ''0'',\r\n  `isaview` tinyint(1) NOT NULL default ''0'',\r\n  PRIMARY KEY  (`id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1; ', 10, 101, 1, 'admin', 65, '2011-02-25 16:01:32', 'Table to record changes in history', 'db update', 0, 0),
(14, 'INSERT INTO tbscript (id, code, module_id, versionnr, user_id, update_dt, update_user, comments, title, isapackage, isaview) VALUES  (9, ''-- 6 script only for HEAD before branch DELTA_2 comes'', 5, 17, 1, ''2008-05-21'', '''', '''', ''db update'', 0, 0);\r\n', 10, 95, 1, '', 63, '2011-02-10 11:08:06', 'added missing test script (when installing deltasql with test data)', 'db update', 0, 0),
(15, 'CREATE TABLE `tbscriptbranchchangelog` (\r\n  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n  `script_id` int(11) NOT NULL,\r\n  `branch_id` int(11) NOT NULL,\r\n  PRIMARY KEY  (`id`),\r\n  UNIQUE KEY `script_id` (`script_id`,`branch_id`)\r\n) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;\r\n ', 10, 113, 1, '', 73, '2011-02-26 18:42:09', 'table to track changes into branches', 'db update', 0, 0),
(16, 'test', 10, 118, 1, '', 74, '2011-04-14 09:42:42', 'test', 'db update', 0, 0),
(17, 'UPDATE tbtrade set tradable=1;', 12, 119, 8, '', 75, '2011-04-14 21:50:18', 'sets all trades to tradable', 'db update', 0, 0),
(18, 'update tbuser set visible=1;', 13, 123, 1, '', 77, '2011-04-14 22:03:21', 'makes all users visible.', 'db update', 0, 0),
(19, 'update tbtrade set tradable=1;', 13, 122, 1, '', 76, '2011-04-14 22:02:50', 'makes all trades tradable', 'db update', 0, 0),
(20, 'update tbuser set visible=1;', 10, 131, 1, '', 79, '2011-04-14 22:37:05', 'Sets all users to visible.', 'db update', 0, 0),
(21, 'update tbtrade set tradable=1;', 10, 130, 1, '', 78, '2011-04-14 22:36:22', 'Setting all trades in tradable status.', 'db update', 0, 0),
(22, 'alter tbtrade add update_dt datetime null;', 18, 146, 1, '', 88, '2011-04-15 18:52:26', 'Remembering when the trade was latest modified.', 'db update', 0, 0),
(23, 'select * from dual;', 18, 145, 1, '', 87, '2011-04-15 18:51:33', 'just a test', 'db update', 0, 0),
(24, 'update tbtrade set confirmstatus=1;', 18, 144, 1, '', 86, '2011-04-15 18:48:23', 'Setting confirmstatus for all trades to 1.', 'db update', 0, 0),
(25, 'alter table tbuser add faxnr varchar(64) null;', 18, 143, 1, '', 85, '2011-04-15 18:47:48', 'adding column faxnumber to tbuser', 'db update', 0, 0),
(26, 'alter table tbtrade add confirmstatus int not null;', 10, 142, 1, '', 84, '2011-04-15 18:46:27', 'adding confirmstatus to table tbtrade', 'db update', 0, 0),
(27, 'update tbtrade set confirmstatus=1;', 18, 152, 1, '', 93, '2011-04-15 22:29:57', 'sets confirm status to 1.', 'db update', 0, 0),
(28, 'update tbtrade set confirmstatus=10;', 18, 153, 1, '', 94, '2011-04-15 22:45:07', 'set confirmstatus to NEW', 'db update', 0, 0),
(29, 'INSERT INTO `tbparameter` VALUES ('''', ''CONFIGURATION'', ''MAX_CONCURRENT_SYNCS'', ''10'');\r\n \r\n\r\n ', 10, 155, 1, '', 96, '2011-04-15 23:29:47', 'special parameter with maximum number of concurrent syncs.', 'db update', 0, 0),
(30, 'INSERT INTO `tbparameter` VALUES ('''', ''CONFIGURATION'', ''MAX_CONCURRENT_SYNCS'', ''10'');\r\n \r\n\r\n ', 10, 158, 1, '', 97, '2011-04-15 23:43:13', 'Adding parameter specifying number of concurrent connections.', 'db update', 0, 0),
(31, 'INSERT INTO `tbparameter` VALUES ('''', ''CONFIGURATION'', ''MAX_CONCURRENT_SYNCS'', ''10'');\r\n \r\n\r\n \r\n', 10, 160, 1, '', 98, '2011-04-15 23:53:23', 'Adding a parameter to handle the maximum number of concurrent syncs.', 'db update', 0, 0),
(32, 'update tbtrade set confirmstatus=10;', 18, 154, 1, '', 95, '2011-04-15 23:00:21', 'sets confirmstatus to NEW.', 'db update', 0, 0),
(33, 'update tbtrade set confirmstatus=20;', 18, 154, 1, 'admin', 95, '2011-04-22 19:04:24', 'sets confirmstatus to NEW.', 'db update', 0, 0),
(34, 'update tbtrade set confirmstatus=20;', 18, 154, 1, 'admin', 95, '2011-04-22 19:04:39', 'sets confirmstatus to UPDATED.', 'db update', 0, 0),
(35, 'create table test (\r\n  id      number(9),\r\n  data    varchar2(256)\r\n)\r\n/', 10, 167, 1, '', 99, '2011-05-28 15:30:55', '', 'db update', 0, 0),
(36, 'SELECT * FROM adp', 21, 171, 1, '', 100, '2011-06-01 10:15:35', 'READ TABLE', 'db update', 0, 0),
(37, 'SELECT * FROM adp', 21, 171, 1, 'admin', 100, '2011-06-01 10:16:20', 'READ TABLE', 'db update', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbscriptgeneration`
--

CREATE TABLE IF NOT EXISTS `tbscriptgeneration` (
  `id` int(11) NOT NULL auto_increment,
  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,
  `fromversionnr` int(11) default NULL,
  `toversionnr` int(11) default NULL,
  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,
  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,
  `frombranch_id` int(11) NOT NULL,
  `tobranch_id` int(11) NOT NULL,
  `create_dt` datetime default NULL,
  `exclbranch` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=115 ;

--
-- Dumping data for table `tbscriptgeneration`
--


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
  `tagname` varchar(128) default NULL,
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbsynchronize`
--

INSERT INTO `tbsynchronize` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `description`, `update_fromversion`, `update_fromsource`, `schemaname`, `dbtype`, `tagname`) VALUES
('deltasql-server', NULL, 'INTERNAL', 'deltasql-server', 0, 'HEAD', NULL, NULL, NULL, '', 'mySQL', NULL);

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
('deltasql-Server', '2010-10-06', 'admin', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-10-06', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-10-06', 'admin', 'deltasql-server', 82, 'HEAD', '', 0, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-10-06', 'admin', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-10-06', 'admin', 'deltasql-server', 82, 'HEAD', '', 0, 'HEAD', '', 'Oracle'),
('FileDistributor', '2010-10-07', 'admin', 'deltasql-server', 82, 'FILEDIST_1', '', 1, 'HEAD', '', 'Oracle'),
('FileDistributor', '2010-10-21', 'admin', 'deltasql-server', 66, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('FileDistributor', '2010-10-21', 'admin', 'deltasql-server', 66, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-23', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('FileDistributor', '2010-10-24', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 0, 'HEAD', '', ''),
('deltasql-Server', '2010-10-24', 'Not logged in', 'deltasql-server', 82, 'HEAD', 'aXI71N  <a href="http://ryleluevmbux.com/">ryleluevmbux</a>, [url=http://qdyobfhddiwp.com/]qdyobfhddiwp[/url], [link=http://idlr', 56, 'HEAD', '', 'Oracle'),
('FileDistributor', '2010-10-31', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 15, 'HEAD', '', ''),
('FileDistributor', '2010-10-31', 'Unknown User', 'Unknown Client', 66, 'HEAD', '', 15, 'HEAD', '', ''),
('FileDistributor', '2010-11-02', 'Not logged in', 'deltasql-server', 66, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('FileDistributor', '2010-11-03', 'Not logged in', 'deltasql-server', 82, 'FILEDIST_1', '', 3, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-11-04', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2010-11-04', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'PostgreSQL'),
('deltasql-Server', '2010-11-04', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-Server', '2010-11-04', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'sqlite'),
('deltasql-Server', '2010-11-04', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'Other'),
('deltasql-Server', '2010-11-05', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2010-11-21', 'Not logged in', 'deltasql-server', 82, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('FileDistributor', '2010-12-22', 'Not logged in', 'deltasql-server', 85, 'FILEDIST_1', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2010-12-30', 'admin', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2010-12-30', 'admin', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-20', 'Not logged in', 'deltasql-server', 90, 'HEAD', '', 34, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-20', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 46, 'HEAD', '', 'Other'),
('deltasql-Server', '2011-01-21', 'Not logged in', 'deltasql-server', 90, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-21', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-21', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'MS SQL Server'),
('deltasql-Server', '2011-01-21', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'PostgreSQL'),
('deltasql-Server', '2011-01-25', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 3, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-26', 'Not logged in', 'deltasql-server', 91, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-26', 'Not logged in', 'deltasql-server', 91, 'HEAD', '', 69, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-01-27', 'Not logged in', 'deltasql-server', 91, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-02-03', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-11', 'admin', 'deltasql-server', 98, 'HEAD', '', 45, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-11', 'admin', 'deltasql-server', 98, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('FileDistributor', '2011-02-11', 'Unknown User', 'Unknown Client', 98, 'HEAD', '', 3, 'HEAD', '', ''),
('deltasql-Server', '2011-02-21', 'admin', 'deltasql-server', 98, 'HEAD', '', 90, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-22', 'Not logged in', 'deltasql-server', 100, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'Not logged in', 'deltasql-server', 103, 'HEAD', '', 91, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 103, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 103, 'HEAD', '', 96, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 104, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 103, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 96, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-26', 'admin', 'deltasql-server', 103, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-02-27', 'admin', 'deltasql-server', 114, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-02-28', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-02-28', 'admin', 'deltasql-server', 103, 'HEAD', '', 96, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-02', 'Not logged in', 'deltasql-server', 103, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-03-02', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 96, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-03-02', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-02', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 98, 'HEAD', '', 'Oracle'),
('FileDistributor', '2011-03-02', 'Not logged in', 'deltasql-server', 114, 'HEAD', 'D0Uvwc  <a href="http://zdrqvfobedcd.com/">zdrqvfobedcd</a>, [url=http://rehnpubkssem.com/]rehnpubkssem[/url], [link=http://kije', 9, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-04', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-07', 'Not logged in', 'deltasql-server', 114, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-07', 'admin', 'deltasql-server', 114, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-09', 'Not logged in', 'deltasql-server', 117, 'HEAD', '', 89, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-03-18', 'Not logged in', 'deltasql-server', 117, 'HEAD', '', 4, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-18', 'admin', 'deltasql-server', 115, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-23', 'Not logged in', 'deltasql-server', 98, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-24', 'admin', 'deltasql-server', 115, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-03-31', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 2, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-03-31', 'Not logged in', 'deltasql-server', 89, 'HEAD', '', 2, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-04-01', 'Not logged in', 'deltasql-server', 117, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-04', 'Not logged in', 'deltasql-server', 117, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-10', 'admin', 'deltasql-server', 117, 'HEAD', '', 96, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-10', 'admin', 'deltasql-server', 115, 'HEAD', '', 89, 'HEAD', '', 'PostgreSQL'),
('deltasql-Server', '2011-04-11', 'admin', 'deltasql-server', 117, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-14', 'admin', 'deltasql-server', 117, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('Multivac', '2011-04-14', 'admin', 'deltasql-server', 135, 'HEAD', '', 133, 'HEAD', '', 'mySQL'),
('Multivac', '2011-04-14', 'admin', 'deltasql-server', 139, 'HEAD', '', 137, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'Not logged in', 'deltasql-server', 139, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 144, 'PROD_1.0_X', '', 139, 'HEAD', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 146, 'PROD_1.0_X', '', 144, 'PROD_1.0_X', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 149, 'PROD_1_X', '', 139, 'HEAD', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 151, 'PROD_1_X', '', 149, 'PROD_1_X', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 151, 'HEAD', '', 151, 'PROD_1_X', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 152, 'HEAD', '', 151, 'PROD_1_X', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 153, 'HEAD', '', 151, 'PROD_1_X', '', 'mySQL'),
('Multivac', '2011-04-15', 'admin', 'deltasql-server', 154, 'HEAD', '', 151, 'PROD_1_X', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'admin', 'deltasql-server', 156, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'admin', 'deltasql-server', 156, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'admin', 'deltasql-server', 156, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'admin', 'deltasql-server', 156, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-15', 'admin', 'deltasql-server', 161, 'HEAD', '', 103, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-22', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 12, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-22', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 11, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-22', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 11, 'HEAD', '', 'mySQL'),
('FileDistributor', '2011-04-22', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 10, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-04-26', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-04-26', 'Not logged in', 'deltasql-server', 161, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-05-03', 'admin', 'deltasql-server', 163, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-05-10', 'Not logged in', 'deltasql-server', 165, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('FileDistributor', '2011-05-10', 'Not logged in', 'deltasql-server', 165, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('FileDistributor', '2011-05-10', 'Not logged in', 'deltasql-server', 165, 'HEAD', '', 1, 'HEAD', '', 'mySQL'),
('FileDistributor', '2011-05-10', 'Not logged in', 'deltasql-server', 165, 'HEAD', '', 1, 'HEAD', '', 'Oracle'),
('deltasql-Server', '2011-05-20', 'Not logged in', 'deltasql-server', 115, 'HEAD', '', 3, 'HEAD', '', 'mySQL'),
('Multivac', '2011-06-01', 'admin', 'deltasql-server', 171, 'HEAD', '', 140, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-06-03', 'admin', 'deltasql-server', 161, 'HEAD', '', 89, 'HEAD', '', 'mySQL'),
('deltasql-Server', '2011-06-03', 'admin', 'deltasql-server', 172, 'HEAD', '', 161, 'HEAD', '', 'mySQL');

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
  `encrypted` tinyint(1) NOT NULL default '0',
  `passwhash` varchar(40) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbuser`
--

INSERT INTO `tbuser` (`id`, `username`, `password`, `first`, `last`, `email`, `rights`, `encrypted`, `passwhash`) VALUES
(1, 'admin', 'testdbsync', 'Main', 'Administrator', 'admin@deltasql', 3, 0, NULL),
(3, 'dangermouse', 'danger', 'Paul', 'Smith', 'paul.smith@gmail.com', 1, 0, NULL),
(4, 'pinco', '', 'Pinco', 'Pallino', 'pincopallino@pallino.ch', 1, 1, '0104f1ecf2ab98ab68bb22b66a33193b'),
(5, 'time', 'time', 'Tiz', 'Danger', 'tiz@danger.com', 2, 0, NULL),
(8, 'virus', 'virus', 'Virginia', 'Saladin', 'vir@sal.com', 1, 0, NULL),
(11, 'linus', 'linus', 'Linus', 'Torvalds', 'linus@kernel.org', 1, 0, NULL),
(12, 'billgates', 'billgates', 'Bill', 'Gates', 'bill@microsoft.com', 2, 0, NULL);
