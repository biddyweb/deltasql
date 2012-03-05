-- phpMyAdmin SQL Dump
-- version 2.11.3deb1ubuntu1.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 05 Mar, 2012 at 09:09 AM
-- Versione MySQL: 5.0.51
-- Versione PHP: 5.2.4-2ubuntu5.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `deltasql`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `tbbranch`
--

CREATE TABLE IF NOT EXISTS `tbbranch` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `project_id` int(11) default NULL,
  `description` varchar(400) collate latin1_general_ci NOT NULL,
  `versionnr` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL default '1',
  `sourcebranch` varchar(40) collate latin1_general_ci default NULL,
  `sourcebranch_id` int(11) default NULL,
  `istag` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=39 ;

--
-- Dump dei dati per la tabella `tbbranch`
--

INSERT INTO `tbbranch` (`id`, `name`, `project_id`, `description`, `versionnr`, `create_dt`, `visible`, `sourcebranch`, `sourcebranch_id`, `istag`) VALUES
(1, 'HEAD', NULL, 'This is the Trunk for all projects', 241, '2012-03-05 08:46:25', 1, NULL, NULL, 0),
(16, 'TAG_deltasql_1.3.2', 14, 'This is release reenabled the ability to perform updates from production schemas to development schemas.', 98, '2011-02-11 00:00:00', 1, 'HEAD', 1, 1),
(13, 'TAG_deltasql_1.3.0', 14, 'This release introduced a completely new sync algo and to tag releases.', 89, '2010-12-30 00:00:00', 1, 'HEAD', 1, 1),
(15, 'TAG_deltasql_1.3.1', 14, 'This release fixed the broken sync algo of 1.3.0 and disabled the ability to make out of a production schema a development schema.', 96, '2011-02-11 00:00:00', 1, 'HEAD', 1, 1),
(17, 'TAG_deltasql_1.3.3', 14, 'This release introduced history for edited scripts and did fixes into the right management.', 103, '2011-02-25 00:00:00', 1, 'HEAD', 1, 1),
(18, 'TAG_deltasql_1.3.4', 14, '- new feature: synchronizing from a tag (without specifying version number)\r\n- new feature: changes to branches are recorded\r\n- index.php patched', 114, '2011-02-26 00:00:00', 1, 'HEAD', 1, 1),
(19, 'TAG_deltasql_1.3.5', 14, 'Diff of history in scripts. Plotting of graph. Tagging of HEAD should always belong to a project.', 115, '2011-03-07 00:00:00', 1, 'HEAD', 1, 1),
(22, 'PROD_1_X', 24, 'This is branch 1 for our beloved customer X.', 146, '2011-04-15 00:00:00', 0, 'HEAD', 1, 0),
(24, 'TAG_deltasql_1.3.6', 14, 'An RSS feed with the latest scripts is added to deltasql server. A set of seven tutorial videos is available as well.', 161, '2011-04-15 00:00:00', 1, 'HEAD', 1, 1),
(27, 'TAG_deltasql_1.3.7', 14, 'This release replaces plaintext passwords with MD5 hashed passwords in TBUSER table. The password reset mechanism was improved as well.', 177, '2011-06-03 23:53:19', 1, 'HEAD', 1, 1),
(31, 'TAG_deltasql_1.4.0', 14, 'This release introduces the new Freepascal/Lazarus deltaclient.', 198, '2011-08-23 09:54:56', 1, 'HEAD', 1, 1),
(32, 'TAG_deltasql_1.4.1', 14, 'This is a tag for deltasql 1.4.1. In this version documentation got updated and deltasql was refactored to minimize STRICT php warnings.', 200, '2011-09-09 16:39:47', 1, 'HEAD', 1, 1),
(33, 'BRANCH_Amritatech', 14, 'This is a branch from the existing tag TAG_deltasql_1.3.1.', 96, '2011-11-24 14:21:12', 1, 'HEAD', 1, 0),
(34, 'BRANCH_PROD_Y', 24, 'This is a branch of PROD_1_X for our beloved customer Y', 211, '2012-01-04 15:52:52', 0, 'PROD_1_X', 22, 0),
(36, 'TAG_deltasql_1.4.2', 14, 'This version is a maintenance release. It did not contain any data model updates, only visual enhancementes and the new feature to branch from an existing tag.', 213, '2012-01-05 09:01:39', 1, 'HEAD', 1, 1),
(37, 'TAG_deltasql_1.4.3', 14, 'This release introduces user preferences: display help links and number of scripts per page as first configurable settings. Additionally, deltasql server is able to notify users with an email, if a new script is inserted.', 222, '2012-01-05 16:54:44', 1, 'HEAD', 1, 1),
(38, 'TAG_deltasql_1.5.0', 14, 'This release introduces statistics using the Open Flash Chart component.', 242, '2012-03-05 08:55:29', 1, 'HEAD', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbmodule`
--

CREATE TABLE IF NOT EXISTS `tbmodule` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  `lastversionnr` int(11) NOT NULL,
  `size` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=29 ;

--
-- Dump dei dati per la tabella `tbmodule`
--

INSERT INTO `tbmodule` (`id`, `name`, `description`, `create_dt`, `lastversionnr`, `size`) VALUES
(12, 'gpuII-server', 'This module stores scripts belonging to the GPU Preview package available at http://sourceforge.net/projects/gpu/files/', '2011-04-14', 119, 0),
(18, 'multivac-module', 'This is the multivac module for the project Multivac.', '2011-04-15', 154, 0),
(28, 'SVE', '', '2011-09-15', 206, 0),
(27, 'Test Module', 'A test module for everyone to experiment.', '2012-03-01', 238, 0),
(9, 'filedistributor', 'Table structure for File Distributor Project', '2012-01-26', 230, 0),
(10, 'deltasql-module', 'module for the deltasql project, containing all scripts (no further modularization needed).', '2012-03-05', 241, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbmoduleproject`
--

CREATE TABLE IF NOT EXISTS `tbmoduleproject` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_id` (`module_id`,`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=34 ;

--
-- Dump dei dati per la tabella `tbmoduleproject`
--

INSERT INTO `tbmoduleproject` (`id`, `module_id`, `project_id`) VALUES
(33, 12, 30),
(24, 18, 24),
(31, 28, 31),
(30, 27, 30),
(17, 12, 18),
(12, 9, 13),
(13, 10, 14);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbparameter`
--

CREATE TABLE IF NOT EXISTS `tbparameter` (
  `id` int(11) NOT NULL auto_increment,
  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,
  `paramname` varchar(20) collate latin1_general_ci NOT NULL,
  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Dump dei dati per la tabella `tbparameter`
--

INSERT INTO `tbparameter` (`id`, `paramtype`, `paramname`, `paramvalue`, `user_id`) VALUES
(1, 'GLOBAL', 'VERSION', '242', NULL),
(2, 'USAGESTATS', 'VERSION', '203', NULL),
(3, 'TEST', 'DB_CONNECTION', 'OK', NULL),
(4, 'SECURITY', 'PWD_HASH_SALT', '', NULL),
(5, 'UI', 'SCRIPTS_PER_PAGE', '15', 1),
(6, 'UI', 'DISPLAY_HELP_LINKS', '1', 1),
(7, 'UI', 'COLOR_ROWS', '1', 1),
(8, 'EMAIL', 'SEND_EMAIL_TO', 'tmengotti@hotmail.com', 1),
(9, 'UI', 'SCRIPTS_PER_PAGE', '15', 5),
(10, 'UI', 'DISPLAY_HELP_LINKS', '1', 5),
(11, 'UI', 'COLOR_ROWS', '1', 5),
(12, 'EMAIL', 'SEND_EMAIL_TO', 'tiziano.mengotti@gmail.com', 5);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbphonetranscript`
--

CREATE TABLE IF NOT EXISTS `tbphonetranscript` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(32) collate latin1_general_ci default NULL,
  `deltasql_version` varchar(32) collate latin1_general_ci default NULL,
  `create_dt` datetime default NULL,
  `nbscripts` int(11) default NULL,
  `nbmodules` int(11) default NULL,
  `nbprojects` int(11) default NULL,
  `nbbranches` int(11) default NULL,
  `nbsyncs` int(11) default NULL,
  `nbusers` int(11) default NULL,
  `nbmp` int(11) default NULL,
  `nbsb` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=13 ;

--
-- Dump dei dati per la tabella `tbphonetranscript`
--

INSERT INTO `tbphonetranscript` (`id`, `ip`, `deltasql_version`, `create_dt`, `nbscripts`, `nbmodules`, `nbprojects`, `nbbranches`, `nbsyncs`, `nbusers`, `nbmp`, `nbsb`) VALUES
(9, '85.25.10.70', '1.3.3', '2011-02-25 00:00:00', 33, 3, 4, 4, 111, 3, 5, 33),
(7, '62.2.103.33', '1.1.0', '2010-09-09 00:00:00', 51, 5, 2, 5, 0, 2, 4, 62),
(8, '81.62.32.181', '1.1.0', '2010-09-12 00:00:00', 7, 5, 1, 5, 0, 1, 4, 28),
(10, '85.25.10.70', '1.4.1', '2011-09-13 00:00:00', 53, 5, 5, 12, 6, 7, 5, 59),
(11, 'localhost', '1.4.4', '2012-03-02 00:00:00', 62, 6, 7, 16, 65, 7, 7, 69),
(12, 'localhost', '1.4.4', '2012-03-05 08:46:25', 62, 6, 7, 16, 69, 7, 7, 69);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbproject`
--

CREATE TABLE IF NOT EXISTS `tbproject` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=33 ;

--
-- Dump dei dati per la tabella `tbproject`
--

INSERT INTO `tbproject` (`id`, `name`, `description`, `create_dt`) VALUES
(31, 'posis standard', '', '2011-09-15'),
(32, 'Noah_base', '&#21517;&#22612;&#20043;&#20809;base&#24211;', '2011-12-29'),
(18, 'GPU-II', 'This is the server side project of GPU-II (http://gpu.sourceforge.net)', '2011-02-26'),
(24, 'Multivac', 'This is the Multivac project.', '2011-04-14'),
(30, 'TestProject', 'A test project for everyone to experiment.', '2011-09-13'),
(13, 'FileDistributor', 'Filedistributor project for the Global Processing Unit at http://gpu.sourceforge.net', '2010-10-06'),
(14, 'deltasql-Server', 'This is the project tracking changes of deltasql-server itself :-) Like a compiler that compiles itself :-D', '2010-10-06');

-- --------------------------------------------------------

--
-- Struttura della tabella `tbscript`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=143 ;

--
-- Dump dei dati per la tabella `tbscript`
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
(101, 'ALTER TABLE `tbuser` ADD `encrypted` TINYINT( 1 ) NOT NULL DEFAULT ''0'',\r\nADD `passwhash` VARCHAR( 40 ) NULL ;', 10, 172, 1, '2011-06-03 15:50:02', '0000-00-00 00:00:00', NULL, 'Adding columns for password encryption (1.3.7)', 'db update', 0, 0),
(102, 'INSERT INTO `tbparameter` VALUES ('''', ''SECURITY'', ''PWD_HASH_SALT'', ''CHANGEMETOANYRANDOMSTRING'');\r\n', 10, 174, 1, '2011-06-03 21:51:38', '0000-00-00 00:00:00', NULL, 'Added parameter to salt password hashes.', 'db update', 0, 0),
(104, 'UPDATE tbsynchronize SET tagname=''TAG_deltasql_1.3.7'' WHERE versionnr=0;', 10, 176, 1, '2011-06-03 23:29:39', '0000-00-00 00:00:00', NULL, 'We record on the database the deltasql version, so that we can detect upgrades in source code.', 'db update', 0, 0),
(111, 'ALTER TABLE `tbusagehistory` ADD `ip` VARCHAR( 32 ) NULL ;', 10, 197, 1, '2011-08-23 09:53:45', '0000-00-00 00:00:00', NULL, 'Adding ip to tbusagehistory to troubleshoot client issues.', 'db update', 0, 0),
(112, 'ALTER TABLE `tbsynchronize` DROP `schemaname`;\r\nALTER TABLE `tbusagehistory` DROP `schemaname`;\r\nALTER TABLE `tbsynchronize` DROP `description`;\r\nALTER TABLE `tbusagehistory` DROP `description`;', 10, 199, 1, '2011-09-09 16:39:00', '2011-09-13 09:12:47', 'admin', 'Removing fields schemaname and description as they are not used anymore.', 'db update', 0, 0),
(113, '-- DROP TABLE TBSYNCHRONIZE;\r\nCREATE TABLE TBSYNCHRONIZE\r\n(\r\n  PROJECTNAME                 VARCHAR2(64)              NOT NULL,\r\n  UPDATE_DT                   DATE    DEFAULT SYSDATE   NOT NULL,\r\n  UPDATE_USER                 VARCHAR2(64)              NULL,\r\n  UPDATE_TYPE                 VARCHAR2(32)              NULL,\r\n  VERSIONNR                   INTEGER                   NOT NULL,\r\n  BRANCHNAME                  VARCHAR2(128)             NULL,\r\n  TAGNAME                     VARCHAR2(128)             NULL,\r\n  UPDATE_FROMVERSION          INTEGER                   NULL,\r\n  UPDATE_FROMSOURCE           VARCHAR2(128)             NULL,\r\n  DBTYPE                      VARCHAR2(32)              NULL,\r\n  CONSTRAINT   UN_VERSIONNR   UNIQUE (VERSIONNR)\r\n);\r\n\r\n-- this stored procedure verifies that scripts are executed in the correct schema\r\nCREATE OR REPLACE PROCEDURE DELTASQL_VERIFY_SCHEMA (versionExt INTEGER, branchnameExt VARCHAR2,projectnameExt VARCHAR2)\r\nAS\r\n versionV INTEGER;\r\n branchnameV  VARCHAR2(128); \r\n projectnameV  VARCHAR2(64); \r\nBEGIN\r\n SELECT versionnr INTO versionV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);\r\n SELECT branchname INTO branchnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);\r\n SELECT projectname INTO projectnameV FROM tbsynchronize WHERE versionnr = (SELECT max(versionnr) FROM tbsynchronize);\r\n IF (branchnameV <> branchnameExt) OR (versionV <> versionExt) OR (projectnameV <> projectnameExt) then\r\n    raise_application_error(-20001, ''This script is for another schema or it was already executed!!!'');\r\n end IF;\r\nEND;\r\n/\r\n\r\nINSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, DBTYPE)\r\nVALUES (''TestProject'', 202, ''HEAD'', ''INTERNAL'', ''deltasql-server'', ''Oracle'');\r\nCOMMIT;', 27, 203, 1, '2011-09-13 14:33:03', '0000-00-00 00:00:00', NULL, 'Initial syncrhonization information for TestProject.', 'db update', 0, 0),
(114, 'create table test (id number primary key);', 27, 205, 1, '2011-09-15 15:58:05', '0000-00-00 00:00:00', NULL, '', 'db update', 0, 0),
(115, 'CREATE TABLE ken (id number PRIMARY KEY);', 27, 207, 1, '2011-12-22 10:25:50', '0000-00-00 00:00:00', NULL, 'testing from ken', 'db update', 0, 0),
(118, 'ALTER TABLE `tbparameter` ADD `user_id` int(11) NULL;', 10, 214, 1, '2012-01-05 09:09:20', '0000-00-00 00:00:00', NULL, 'Introducing customizable parameters for each user (user''s preferences)', 'db update', 0, 0),
(124, 'ALTER TABLE `tbparameter` DROP INDEX `paramtype`;\r\nALTER TABLE `tbparameter` ADD UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`);\r\n', 10, 221, 1, '2012-01-12 10:21:59', '2012-03-01 15:49:43', 'admin', 'Modifying unique key for table tbparameter\r\n', 'db update', 0, 0),
(129, 'update test set qr=1 where id=1;', 27, 226, 1, '2012-01-13 11:11:57', '0000-00-00 00:00:00', NULL, 'Test script to test notification by email', 'db update', 0, 0),
(130, 'UPDATE test SET qr=3 WHERE id=5;', 27, 227, 1, '2012-01-25 10:18:01', '2012-03-01 15:48:15', 'admin', 'Another test script to test email notification :-)', 'db update', 0, 0),
(138, 'CREATE TABLE `傲世灬荭人` (\r\n  `c_factionname` varchar(255) collate utf8_bin default NULL,\r\n  `c_faction_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_familyname` varchar(255) collate utf8_bin default NULL,\r\n  `c_familylevel` varchar(255) collate utf8_bin default NULL,\r\n  `c_playername` varchar(255) collate utf8_bin default NULL,\r\n  `c_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_userid` varchar(255) collate utf8_bin default NULL, `a` varchar(255) collate utf8_bin default NULL,\r\n  `b` varchar(255) collate utf8_bin default NULL\r\n) ENGINE=myisam DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\r\n\r\n\r\ninsert  into `傲世灬荭人`(`c_factionname`,`c_faction_level`,`c_familyname`,`c_familylevel`,`c_playername`,`c_level`,`c_userid`,`a`,`b`) values (''c_factionname'',''c_faction_level'',''c_familyname'',''c_familylevel'',''c_playername'',''c_level'',''c_userid'',''a'',''b''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''死亡VI墓碑'',''40'',''a765995095'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''╰★神★╯'',''32'',''ai516919189'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''边城浪子'',''51'',''axing0515'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''斌临天下'',''39'',''bin1980bin'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''我们小时候'',''32'',''c515290777'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''为伊守候'',''23'',''caiyong1978'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''寂寞一个人'',''28'',''chenfeng2194'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''ゞ布衣小酱╭'',''38'',''congjunzi8'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''爱静小小猪'',''39'',''fubin520530'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''弑神邪兵'',''52'',''fzdsh'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o群魔乱舞o'',''40'',''gao123_001'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''旋律中的粑粑'',''61'',''hhf27843182'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''望哥归来'',''53'',''kosf'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''℡荭人╮指间'',''28'',''lanping1988'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''龙★傲世'',''54'',''lg812129cd'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''戟★神'',''58'',''liu356389178'',''1000'',''-910''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''化神灬剑'',''55'',''liu58016008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蝴蝶流星剑の'',''22'',''lnsyfk87'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''★笑苍天★'',''31'',''lt0913'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小小吕布'',''41'',''lxaxh521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''荭人、瑞少'',''65'',''lylhome015'',''200000'',''-81042''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''陈冠希丶'',''34'',''lzy19920908'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''许你笔墨三千'',''33'',''m635659064'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''豆豆包包'',''57'',''mts24129957'',''2000'',''-1803''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''冤家路窄'',''45'',''mzyzdn701608'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小寶贝'',''51'',''pangzhen0916'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叮当'',''37'',''pta77992'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''一辈子枪'',''32'',''pta77993'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''天之泪'',''41'',''qq1376859197'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''逗〃逗'',''32'',''qq175625778'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''kak'',''33'',''rongzhiqiang'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''治疗万岁'',''30'',''shao65447'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''醉卧黄昏'',''44'',''tz156303519'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''左岸→右转☆'',''43'',''w419696107'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''消失的承诺'',''41'',''w479360475'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''〆﹏樱树╰椛'',''47'',''wanglin1278'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蓝齐儿'',''68'',''wangqi198331'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''依·恋'',''45'',''wg1399823342'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''世界之巅'',''49'',''wr13854212'',''1500'',''-1500''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''曾花谢落'',''29'',''xcy1995222'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@天仙配@'',''49'',''xiaocan521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@董永@'',''46'',''xiaocan5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''风魔碎牙'',''53'',''xiaogou5522'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叶武丶岚'',''29'',''yuwei5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''七哥哥'',''37'',''zgh5444'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o独霸天下o'',''36'',''zhang0008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''者别'',''47'',''zxw171299219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Xx小伙、'',''45'',''a279422279a'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''幻★觉'',''32'',''a787206577'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''灵物雨'',''41'',''a877630621'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刁蛮卐公主'',''41'',''abcdef197869'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''红s豆'',''39'',''anansxm6000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''aslong'',''35'',''aslongs'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''爱┍﹎难分.'',''44'',''bailu627'',''1000'',''-498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！小顺'',''44'',''bshun123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''xiao飞'',''49'',''cuishuren000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''聚仙丶裴元庆'',''41'',''dalian_jx5'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''清风澄汁'',''43'',''feixiangdu'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''DGGH'',''40'',''fjj888119'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''小伙就是叼'',''46'',''gwy110'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大漠孤鹰*冰'',''41'',''gyc1351419'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''光辉神'',''40'',''gymshuai'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杜杨鹏越'',''43'',''jackydxfyl'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕百战'',''41'',''jklip1411'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''╭箪身`只沩'',''44'',''kongdefa1990'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大年夜幽魂'',''40'',''li8687ke'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''漫步深澜'',''50'',''lxlei2962'',''10000'',''-3100''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凌迟'',''48'',''ouyouyou2599'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''莫灬丨小佳丨'',''48'',''qq8934165'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Q大仙儿Q'',''40'',''qwe444124777'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''深度'',''66'',''rxh271828'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''往事H如烟'',''46'',''sht115123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''√缘'',''43'',''sjf1003'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东北☆霸刀'',''41'',''smy4467'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''罐子'',''31'',''ss460895591'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气＾刺客'',''42'',''suenjiwei521'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''把钱放下'',''44'',''syszyq123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''魔神蚩尤'',''44'',''tyxzyy8005'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''寒霜'',''35'',''ufo8962'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！飞羽'',''28'',''w13845642559'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！阴阳'',''47'',''w139455'',''1500'',''-1498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东方咯隆美尔'',''32'',''w13946193285'',''1500'',''-1428''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''，圣多美了'',''48'',''w3a4n9g0200'',''5000'',''-2550''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''飞仙儿'',''39'',''wang30294216'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''§董事会§枫'',''39'',''wangchuan88'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！浩劫'',''18'',''wbok20006'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''*夜灵*'',''33'',''wgyeling'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凤舞九天'',''61'',''wx851219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''老木'',''39'',''wxz405090'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''龙枪'',''40'',''x2115454'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杀戮机器'',''41'',''x62714'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''◇◇丶磊子。'',''47'',''ximandula'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''狂战de魔'',''49'',''xuebin527'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕V斩无'',''44'',''y305971622y'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''没我de死'',''36'',''yjmr806'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''炎黄神龙'',''57'',''zhang1976205'',''3000'',''-1350''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气!小天'',''64'',''zi00383'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刃丶小胖'',''40'',''zxc523608016'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小妖女哪里跑'',''33'',''a138979598'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''Ese丶皮鞋'',''30'',''a3466812'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''沉默v地主'',''23'',''a5peace1'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''欧阳以南'',''43'',''a631319722'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''绝の帝'',''41'',''caohongye'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''⑤心'',''32'',''czc735099022'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''聚仙丶单雄信'',''39'',''dalian_jx3'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''彷徨∷飞鱼'',''63'',''daohaosiyij'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''c我本善良y'',''43'',''daoke1981'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''大宝的小宝'',''48'',''feiaihao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-在哪'',''53'',''gu280'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-归何处'',''50'',''gu280111'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''◥◣神◢◤'',''33'',''kakadebao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''深渊的微笑'',''46'',''liubin800714'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''孤独剑儿'',''42'',''ll413637548'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''逍遥の强'',''65'',''lq530618210'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小水笑'',''45'',''lxcalx'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''思娜'',''47'',''ming801011'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''幽魂、宁采臣'',''60'',''o0xiaoge0o'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''藤田逸轩'',''22'',''qaqerqqq12'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''处男'',''31'',''qq1046645206'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''嗷嗷的漂亮'',''63'',''qq380949969'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''至尊屠神'',''64'',''qq58812346'',''100000'',''-104120''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''二郎神他爸'',''50'',''qubowei'',''0'',''-340''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''狂龙九宵'',''49'',''snob01'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''v一剑倾城v'',''40'',''stephenze221'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''落叶缤纷傲'',''35'',''wang62097158'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''龙之子の俊熙'',''66'',''wj236439278'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''紫鸾仙子'',''51'',''wj34371480'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''潇潇仙子'',''36'',''wowanjuju'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''鬼铃'',''51'',''x1351445'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑斩邪仙'',''61'',''xiaozhe123'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑无虚发'',''49'',''xlh1986'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''ESC残战'',''45'',''xu5365245'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''天弛‰仙官'',''40'',''zhuzi0222'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''゛素颜、迟°'',''28'',''zl443001783'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业灵官'',''30'',''zw98776698'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业天君'',''30'',''zw98776699'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''百合'',''31'',''zy1973911'',''0'',''0'');\r\n\r\n', 27, 237, 1, '2012-03-01 15:56:24', '2012-03-01 17:20:26', 'admin', 't_players', 'db update', 0, 0),
(140, 'ALTER TABLE `tbphonetranscript` CHANGE `create_dt` `create_dt` DATETIME NULL DEFAULT NULL;\r\nALTER TABLE `tbusagehistory` CHANGE `update_dt` `update_dt` DATETIME NULL DEFAULT NULL; \r\n', 10, 239, 1, '2012-03-02 10:45:36', '0000-00-00 00:00:00', NULL, 'Changing structure of stats tables for datetime capabilities', 'db update', 0, 0),
(142, 'alter table tbusagehistory rename tbsyncstats;\r\nalter table tbphonetranscript rename tbstats;', 10, 241, 1, '2012-03-05 08:46:25', '0000-00-00 00:00:00', NULL, 'Renaming statistics tables.', 'db update', 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbscriptbranch`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranch` (
  `id` int(11) NOT NULL auto_increment,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=244 ;

--
-- Dump dei dati per la tabella `tbscriptbranch`
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
(193, 113, 1),
(178, 102, 1),
(177, 101, 1),
(180, 104, 1),
(181, 105, 1),
(188, 111, 1),
(192, 112, 1),
(194, 114, 1),
(195, 115, 1),
(198, 118, 1),
(210, 129, 1),
(235, 124, 1),
(234, 130, 33),
(239, 138, 1),
(233, 130, 1),
(241, 140, 1),
(243, 142, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbscriptbranchchangelog`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranchchangelog` (
  `id` int(11) NOT NULL auto_increment,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=78 ;

--
-- Dump dei dati per la tabella `tbscriptbranchchangelog`
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
(27, 37, 25),
(28, 38, 1),
(29, 39, 22),
(30, 40, 1),
(31, 41, 29),
(32, 42, 29),
(33, 43, 1),
(34, 44, 1),
(35, 45, 1),
(36, 46, 1),
(37, 47, 1),
(38, 48, 1),
(39, 49, 1),
(40, 50, 1),
(41, 51, 1),
(42, 52, 1),
(43, 53, 1),
(44, 54, 1),
(45, 55, 1),
(46, 56, 1),
(47, 57, 1),
(48, 58, 1),
(49, 59, 1),
(50, 60, 1),
(51, 61, 1),
(52, 62, 1),
(53, 63, 1),
(54, 64, 1),
(55, 65, 1),
(56, 66, 1),
(57, 67, 1),
(58, 68, 1),
(59, 69, 1),
(60, 70, 1),
(61, 71, 1),
(62, 72, 1),
(63, 73, 1),
(64, 74, 1),
(65, 75, 1),
(66, 76, 1),
(67, 76, 33),
(68, 77, 1),
(69, 78, 1),
(70, 79, 1),
(71, 79, 33),
(72, 80, 1),
(73, 81, 1),
(74, 82, 1),
(75, 83, 1),
(76, 84, 1),
(77, 85, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbscriptchangelog`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=86 ;

--
-- Dump dei dati per la tabella `tbscriptchangelog`
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
(37, 'SELECT * FROM adp', 21, 171, 1, 'admin', 100, '2011-06-01 10:16:20', 'READ TABLE', 'db update', 0, 0),
(38, 'create table nmi(id number);', 10, 191, 1, '', 109, '2011-07-27 17:57:46', '', 'NMI table', 0, 0),
(39, 'create table nmi(id number);', 10, 192, 1, 'admin', 109, '2011-07-27 18:01:12', '', 'NMI table', 0, 0),
(40, 'CREATE TABLE test (killana varchar(20));\r\n', 24, 190, 1, '', 108, '2011-06-28 16:06:19', '', 'toHead', 0, 0),
(41, 'create table 1 (killana varchar(20));\r\ncreate table 2 (killana varchar(20));\r\ncreate table 3 (killana varchar(20));\r\ncreate table 4 (killana varchar(20));', 24, 189, 1, '', 107, '2011-06-28 15:55:12', '', 'one more script', 0, 0),
(42, 'create table test (killana varchar(20));', 24, 188, 1, '', 106, '2011-06-28 15:46:01', 'sample scripts to lsf schema to a branch DBT1_Branch of the Sample Project', 'New Scripts from ', 0, 0),
(43, 'create table dummy_doo ( test text);', 26, 196, 1, '', 110, '2011-07-29 09:23:01', 'testing', 'db update', 0, 0),
(44, 'ALTER TABLE `tbsynchronize` DROP `schemaname`;\r\nALTER TABLE `tbusagehistory` DROP `schemaname`;', 10, 199, 1, '', 112, '2011-09-09 16:39:00', 'Removing field schemaname as it is not used anymore.', 'db update', 0, 0),
(45, 'ALTER TABLE `tbbranch` CHANGE `create_dt` `create_dt` DATETIME NOT NULL; ', 10, 175, 1, '', 103, '2011-06-03 23:10:30', 'Changing TBBRANCH to record hour timestamps.', 'db update', 0, 0),
(46, 'ALTER TABLE `tbbranch` CHANGE `create_dt` `create_dt` DATETIME; ', 10, 175, 1, 'admin', 103, '2011-09-10 18:22:36', 'Changing TBBRANCH to record hour timestamps.', 'db update', 0, 0),
(47, 'ALTER TABLE `tbsynchronize` DROP `schemaname`;\r\nALTER TABLE `tbusagehistory` DROP `schemaname`;\r\nALTER TABLE `tbsynchronize` DROP `description`;\r\nALTER TABLE `tbusagehistory` DROP `description`;', 10, 199, 1, 'admin', 112, '2011-09-10 10:16:07', 'Removing field schemaname as it is not used anymore.', 'db update', 0, 0),
(48, 'CREATE TABLE test (id number PRIMARY KEY);', 27, 209, 1, '', 117, '2011-12-22 10:26:24', '', 'db update2', 0, 0),
(49, 'CREATE TABLE test (id number PRIMARY KEY);', 27, 208, 1, '', 116, '2011-12-22 10:26:06', '', 'db update', 0, 0),
(50, 'create table test2;', 27, 217, 1, '', 120, '2012-01-09 11:36:46', '', 'db update', 0, 0),
(51, 'create table test;', 27, 216, 1, '', 119, '2012-01-09 11:36:34', '', 'db update', 0, 0),
(52, 'est', 27, 218, 1, '', 121, '2012-01-09 17:01:59', '', 'db update', 0, 0),
(53, '-- test email sending', 27, 219, 5, '', 122, '2012-01-12 09:43:17', '-- comment', 'db update', 0, 0),
(54, 'ALTER TABLE `tbparameter` DROP INDEX `paramtype`;\r\nALTER TABLE `tbparameter` ADD INDEX `paramtype` UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`);\r\n', 10, 221, 1, '', 124, '2012-01-12 10:21:59', '', 'db update', 0, 0),
(55, 'test', 27, 220, 1, '', 123, '2012-01-12 09:56:13', 'test', 'db update', 0, 0),
(56, '-- testing sending of an email', 27, 222, 1, '', 125, '2012-01-12 10:26:07', '-- testing sending of an email', 'db update', 0, 0),
(57, 'select * from test;', 10, 223, 5, '', 126, '2012-01-12 17:36:43', 'paripara', 'db update', 0, 0),
(58, 'tst', 10, 224, 5, '', 127, '2012-01-12 18:01:05', 'test', 'db update', 0, 0),
(59, 'update tbtest set test=''test'' where id=1;', 27, 225, 1, '', 128, '2012-01-13 11:04:44', 'Script to test email functionality :-)', 'db update', 0, 0),
(60, 'sadfasf', 10, 228, 1, '', 131, '2012-01-26 08:57:30', 'asdfasd', 'db update', 0, 0),
(61, 'sadfasfasdfadsf', 10, 228, 1, 'admin', 131, '2012-01-26 08:57:43', 'asdfasd', 'db update', 0, 0),
(62, 'sadfasfasdfadsfadfsadfs', 10, 228, 1, 'admin', 131, '2012-01-26 09:00:48', 'asdfasd', 'db update', 0, 0),
(63, 'taessdfafds', 10, 229, 1, '', 132, '2012-01-26 09:05:23', 'asdfadsf', 'db update', 0, 0),
(64, 'abctaessdfafds', 10, 229, 1, 'admin', 132, '2012-01-26 09:05:50', 'abcasdfadsf', 'db update', 0, 0),
(65, 'test', 9, 230, 1, '', 133, '2012-01-26 09:18:48', 'test', 'db update', 0, 0),
(66, '1test', 9, 231, 1, 'admin', 133, '2012-01-26 09:19:16', 'test', 'db update', 0, 0),
(67, '12test', 9, 231, 1, 'admin', 133, '2012-01-26 09:19:41', 'test', 'db update', 0, 0),
(68, 'test', 27, 232, 1, '', 134, '2012-01-26 09:51:51', 'test', 'db update', 0, 0),
(69, 'test2', 27, 232, 1, 'admin', 134, '2012-01-26 09:51:56', 'test2', 'db update', 0, 0),
(70, 'asfd', 27, 233, 1, '', 135, '2012-01-26 14:12:02', 'afd', 'db update', 0, 0),
(71, 'asfda', 27, 233, 1, 'admin', 135, '2012-01-26 14:12:09', 'afd', 'db update', 0, 0),
(72, 'test', 27, 234, 5, '', 136, '2012-01-27 08:55:58', 'test', 'db update', 0, 0),
(73, 'test2', 27, 234, 5, 'time', 136, '2012-01-27 08:58:02', 'test', 'db update', 0, 0),
(74, 'test23', 27, 234, 5, 'time', 136, '2012-01-27 09:00:03', 'test', 'db update', 0, 0),
(75, 'adsfadfs', 10, 235, 5, '', 137, '2012-01-27 09:03:23', 'test', 'db update', 0, 0),
(76, 'adsfadfs', 10, 235, 5, 'time', 137, '2012-01-27 09:03:45', 'test', 'db update', 0, 0),
(77, 'UPDATE test SET qr=3 WHERE id=2;', 27, 227, 1, '', 130, '2012-01-25 10:18:01', 'Another test script to test email notification :-)', 'db update', 0, 0),
(78, 'UPDATE test SET qr=3 WHERE id=2;', 27, 227, 1, 'admin', 130, '2012-03-01 15:44:49', 'Another test script to test email notification :-)', 'db update', 0, 0),
(79, 'UPDATE test SET qr=3 WHERE id=2;', 27, 227, 1, 'admin', 130, '2012-03-01 15:47:06', 'Another test script to test email notification :-)', 'db update', 0, 0),
(80, 'ALTER TABLE `tbparameter` DROP INDEX `paramtype`;\r\nALTER TABLE `tbparameter` ADD UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`);\r\n', 10, 221, 1, 'admin', 124, '2012-01-12 10:24:05', 'Modifying unique key for table tbparameter\r\n', 'db update', 0, 0),
(81, 'CREATE TABLE `傲世灬荭人` (\r\n  `c_factionname` varchar(255) collate utf8_bin default NULL,\r\n  `c_faction_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_familyname` varchar(255) collate utf8_bin default NULL,\r\n  `c_familylevel` varchar(255) collate utf8_bin default NULL,\r\n  `c_playername` varchar(255) collate utf8_bin default NULL,\r\n  `c_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_userid` varchar(255) collate utf8_bin default NULL,\r\n  `a` varchar(255) collate utf8_bin default NULL,\r\n  `b` varchar(255) collate utf8_bin default NULL\r\n) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\r\n\r\n\r\ninsert  into `傲世灬荭人`(`c_factionname`,`c_faction_level`,`c_familyname`,`c_familylevel`,`c_playername`,`c_level`,`c_userid`,`a`,`b`) values (''c_factionname'',''c_faction_level'',''c_familyname'',''c_familylevel'',''c_playername'',''c_level'',''c_userid'',''a'',''b''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''死亡VI墓碑'',''40'',''a765995095'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''╰★神★╯'',''32'',''ai516919189'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''边城浪子'',''51'',''axing0515'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''斌临天下'',''39'',''bin1980bin'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''我们小时候'',''32'',''c515290777'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''为伊守候'',''23'',''caiyong1978'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''寂寞一个人'',''28'',''chenfeng2194'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''ゞ布衣小酱╭'',''38'',''congjunzi8'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''爱静小小猪'',''39'',''fubin520530'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''弑神邪兵'',''52'',''fzdsh'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o群魔乱舞o'',''40'',''gao123_001'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''旋律中的粑粑'',''61'',''hhf27843182'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''望哥归来'',''53'',''kosf'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''℡荭人╮指间'',''28'',''lanping1988'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''龙★傲世'',''54'',''lg812129cd'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''戟★神'',''58'',''liu356389178'',''1000'',''-910''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''化神灬剑'',''55'',''liu58016008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蝴蝶流星剑の'',''22'',''lnsyfk87'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''★笑苍天★'',''31'',''lt0913'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小小吕布'',''41'',''lxaxh521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''荭人、瑞少'',''65'',''lylhome015'',''200000'',''-81042''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''陈冠希丶'',''34'',''lzy19920908'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''许你笔墨三千'',''33'',''m635659064'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''豆豆包包'',''57'',''mts24129957'',''2000'',''-1803''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''冤家路窄'',''45'',''mzyzdn701608'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小寶贝'',''51'',''pangzhen0916'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叮当'',''37'',''pta77992'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''一辈子枪'',''32'',''pta77993'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''天之泪'',''41'',''qq1376859197'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''逗〃逗'',''32'',''qq175625778'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''kak'',''33'',''rongzhiqiang'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''治疗万岁'',''30'',''shao65447'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''醉卧黄昏'',''44'',''tz156303519'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''左岸→右转☆'',''43'',''w419696107'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''消失的承诺'',''41'',''w479360475'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''〆﹏樱树╰椛'',''47'',''wanglin1278'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蓝齐儿'',''68'',''wangqi198331'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''依·恋'',''45'',''wg1399823342'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''世界之巅'',''49'',''wr13854212'',''1500'',''-1500''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''曾花谢落'',''29'',''xcy1995222'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@天仙配@'',''49'',''xiaocan521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@董永@'',''46'',''xiaocan5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''风魔碎牙'',''53'',''xiaogou5522'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叶武丶岚'',''29'',''yuwei5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''七哥哥'',''37'',''zgh5444'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o独霸天下o'',''36'',''zhang0008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''者别'',''47'',''zxw171299219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Xx小伙、'',''45'',''a279422279a'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''幻★觉'',''32'',''a787206577'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''灵物雨'',''41'',''a877630621'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刁蛮卐公主'',''41'',''abcdef197869'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''红s豆'',''39'',''anansxm6000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''aslong'',''35'',''aslongs'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''爱┍﹎难分.'',''44'',''bailu627'',''1000'',''-498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！小顺'',''44'',''bshun123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''xiao飞'',''49'',''cuishuren000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''聚仙丶裴元庆'',''41'',''dalian_jx5'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''清风澄汁'',''43'',''feixiangdu'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''DGGH'',''40'',''fjj888119'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''小伙就是叼'',''46'',''gwy110'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大漠孤鹰*冰'',''41'',''gyc1351419'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''光辉神'',''40'',''gymshuai'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杜杨鹏越'',''43'',''jackydxfyl'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕百战'',''41'',''jklip1411'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''╭箪身`只沩'',''44'',''kongdefa1990'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大年夜幽魂'',''40'',''li8687ke'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''漫步深澜'',''50'',''lxlei2962'',''10000'',''-3100''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凌迟'',''48'',''ouyouyou2599'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''莫灬丨小佳丨'',''48'',''qq8934165'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Q大仙儿Q'',''40'',''qwe444124777'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''深度'',''66'',''rxh271828'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''往事H如烟'',''46'',''sht115123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''√缘'',''43'',''sjf1003'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东北☆霸刀'',''41'',''smy4467'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''罐子'',''31'',''ss460895591'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气＾刺客'',''42'',''suenjiwei521'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''把钱放下'',''44'',''syszyq123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''魔神蚩尤'',''44'',''tyxzyy8005'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''寒霜'',''35'',''ufo8962'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！飞羽'',''28'',''w13845642559'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！阴阳'',''47'',''w139455'',''1500'',''-1498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东方咯隆美尔'',''32'',''w13946193285'',''1500'',''-1428''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''，圣多美了'',''48'',''w3a4n9g0200'',''5000'',''-2550''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''飞仙儿'',''39'',''wang30294216'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''§董事会§枫'',''39'',''wangchuan88'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！浩劫'',''18'',''wbok20006'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''*夜灵*'',''33'',''wgyeling'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凤舞九天'',''61'',''wx851219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''老木'',''39'',''wxz405090'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''龙枪'',''40'',''x2115454'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杀戮机器'',''41'',''x62714'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''◇◇丶磊子。'',''47'',''ximandula'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''狂战de魔'',''49'',''xuebin527'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕V斩无'',''44'',''y305971622y'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''没我de死'',''36'',''yjmr806'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''炎黄神龙'',''57'',''zhang1976205'',''3000'',''-1350''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气!小天'',''64'',''zi00383'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刃丶小胖'',''40'',''zxc523608016'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小妖女哪里跑'',''33'',''a138979598'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''Ese丶皮鞋'',''30'',''a3466812'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''沉默v地主'',''23'',''a5peace1'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''欧阳以南'',''43'',''a631319722'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''绝の帝'',''41'',''caohongye'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''⑤心'',''32'',''czc735099022'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''聚仙丶单雄信'',''39'',''dalian_jx3'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''彷徨∷飞鱼'',''63'',''daohaosiyij'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''c我本善良y'',''43'',''daoke1981'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''大宝的小宝'',''48'',''feiaihao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-在哪'',''53'',''gu280'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-归何处'',''50'',''gu280111'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''◥◣神◢◤'',''33'',''kakadebao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''深渊的微笑'',''46'',''liubin800714'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''孤独剑儿'',''42'',''ll413637548'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''逍遥の强'',''65'',''lq530618210'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小水笑'',''45'',''lxcalx'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''思娜'',''47'',''ming801011'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''幽魂、宁采臣'',''60'',''o0xiaoge0o'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''藤田逸轩'',''22'',''qaqerqqq12'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''处男'',''31'',''qq1046645206'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''嗷嗷的漂亮'',''63'',''qq380949969'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''至尊屠神'',''64'',''qq58812346'',''100000'',''-104120''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''二郎神他爸'',''50'',''qubowei'',''0'',''-340''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''狂龙九宵'',''49'',''snob01'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''v一剑倾城v'',''40'',''stephenze221'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''落叶缤纷傲'',''35'',''wang62097158'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''龙之子の俊熙'',''66'',''wj236439278'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''紫鸾仙子'',''51'',''wj34371480'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''潇潇仙子'',''36'',''wowanjuju'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''鬼铃'',''51'',''x1351445'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑斩邪仙'',''61'',''xiaozhe123'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑无虚发'',''49'',''xlh1986'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''ESC残战'',''45'',''xu5365245'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''天弛‰仙官'',''40'',''zhuzi0222'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''゛素颜、迟°'',''28'',''zl443001783'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业灵官'',''30'',''zw98776698'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业天君'',''30'',''zw98776699'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''百合'',''31'',''zy1973911'',''0'',''0'');\r\n\r\n', 10, 237, 1, '', 138, '2012-03-01 15:56:24', '', 'db update', 0, 0);
INSERT INTO `tbscriptchangelog` (`id`, `code`, `module_id`, `versionnr`, `user_id`, `update_user`, `script_id`, `create_dt`, `comments`, `title`, `isapackage`, `isaview`) VALUES
(82, 'CREATE TABLE `傲世灬荭人` (\r\n  `c_factionname` varchar(255) collate utf8_bin default NULL,\r\n  `c_faction_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_familyname` varchar(255) collate utf8_bin default NULL,\r\n  `c_familylevel` varchar(255) collate utf8_bin default NULL,\r\n  `c_playername` varchar(255) collate utf8_bin default NULL,\r\n  `c_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_userid` varchar(255) collate utf8_bin default NULL,\r\n  `a` varchar(255) collate utf8_bin default NULL,\r\n  `b` varchar(255) collate utf8_bin default NULL\r\n) ENGINE=myisam DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\r\n\r\n\r\ninsert  into `傲世灬荭人`(`c_factionname`,`c_faction_level`,`c_familyname`,`c_familylevel`,`c_playername`,`c_level`,`c_userid`,`a`,`b`) values (''c_factionname'',''c_faction_level'',''c_familyname'',''c_familylevel'',''c_playername'',''c_level'',''c_userid'',''a'',''b''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''死亡VI墓碑'',''40'',''a765995095'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''╰★神★╯'',''32'',''ai516919189'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''边城浪子'',''51'',''axing0515'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''斌临天下'',''39'',''bin1980bin'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''我们小时候'',''32'',''c515290777'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''为伊守候'',''23'',''caiyong1978'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''寂寞一个人'',''28'',''chenfeng2194'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''ゞ布衣小酱╭'',''38'',''congjunzi8'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''爱静小小猪'',''39'',''fubin520530'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''弑神邪兵'',''52'',''fzdsh'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o群魔乱舞o'',''40'',''gao123_001'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''旋律中的粑粑'',''61'',''hhf27843182'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''望哥归来'',''53'',''kosf'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''℡荭人╮指间'',''28'',''lanping1988'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''龙★傲世'',''54'',''lg812129cd'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''戟★神'',''58'',''liu356389178'',''1000'',''-910''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''化神灬剑'',''55'',''liu58016008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蝴蝶流星剑の'',''22'',''lnsyfk87'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''★笑苍天★'',''31'',''lt0913'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小小吕布'',''41'',''lxaxh521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''荭人、瑞少'',''65'',''lylhome015'',''200000'',''-81042''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''陈冠希丶'',''34'',''lzy19920908'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''许你笔墨三千'',''33'',''m635659064'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''豆豆包包'',''57'',''mts24129957'',''2000'',''-1803''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''冤家路窄'',''45'',''mzyzdn701608'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小寶贝'',''51'',''pangzhen0916'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叮当'',''37'',''pta77992'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''一辈子枪'',''32'',''pta77993'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''天之泪'',''41'',''qq1376859197'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''逗〃逗'',''32'',''qq175625778'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''kak'',''33'',''rongzhiqiang'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''治疗万岁'',''30'',''shao65447'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''醉卧黄昏'',''44'',''tz156303519'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''左岸→右转☆'',''43'',''w419696107'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''消失的承诺'',''41'',''w479360475'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''〆﹏樱树╰椛'',''47'',''wanglin1278'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蓝齐儿'',''68'',''wangqi198331'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''依·恋'',''45'',''wg1399823342'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''世界之巅'',''49'',''wr13854212'',''1500'',''-1500''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''曾花谢落'',''29'',''xcy1995222'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@天仙配@'',''49'',''xiaocan521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@董永@'',''46'',''xiaocan5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''风魔碎牙'',''53'',''xiaogou5522'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叶武丶岚'',''29'',''yuwei5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''七哥哥'',''37'',''zgh5444'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o独霸天下o'',''36'',''zhang0008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''者别'',''47'',''zxw171299219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Xx小伙、'',''45'',''a279422279a'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''幻★觉'',''32'',''a787206577'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''灵物雨'',''41'',''a877630621'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刁蛮卐公主'',''41'',''abcdef197869'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''红s豆'',''39'',''anansxm6000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''aslong'',''35'',''aslongs'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''爱┍﹎难分.'',''44'',''bailu627'',''1000'',''-498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！小顺'',''44'',''bshun123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''xiao飞'',''49'',''cuishuren000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''聚仙丶裴元庆'',''41'',''dalian_jx5'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''清风澄汁'',''43'',''feixiangdu'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''DGGH'',''40'',''fjj888119'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''小伙就是叼'',''46'',''gwy110'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大漠孤鹰*冰'',''41'',''gyc1351419'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''光辉神'',''40'',''gymshuai'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杜杨鹏越'',''43'',''jackydxfyl'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕百战'',''41'',''jklip1411'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''╭箪身`只沩'',''44'',''kongdefa1990'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大年夜幽魂'',''40'',''li8687ke'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''漫步深澜'',''50'',''lxlei2962'',''10000'',''-3100''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凌迟'',''48'',''ouyouyou2599'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''莫灬丨小佳丨'',''48'',''qq8934165'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Q大仙儿Q'',''40'',''qwe444124777'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''深度'',''66'',''rxh271828'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''往事H如烟'',''46'',''sht115123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''√缘'',''43'',''sjf1003'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东北☆霸刀'',''41'',''smy4467'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''罐子'',''31'',''ss460895591'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气＾刺客'',''42'',''suenjiwei521'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''把钱放下'',''44'',''syszyq123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''魔神蚩尤'',''44'',''tyxzyy8005'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''寒霜'',''35'',''ufo8962'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！飞羽'',''28'',''w13845642559'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！阴阳'',''47'',''w139455'',''1500'',''-1498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东方咯隆美尔'',''32'',''w13946193285'',''1500'',''-1428''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''，圣多美了'',''48'',''w3a4n9g0200'',''5000'',''-2550''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''飞仙儿'',''39'',''wang30294216'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''§董事会§枫'',''39'',''wangchuan88'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！浩劫'',''18'',''wbok20006'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''*夜灵*'',''33'',''wgyeling'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凤舞九天'',''61'',''wx851219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''老木'',''39'',''wxz405090'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''龙枪'',''40'',''x2115454'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杀戮机器'',''41'',''x62714'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''◇◇丶磊子。'',''47'',''ximandula'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''狂战de魔'',''49'',''xuebin527'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕V斩无'',''44'',''y305971622y'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''没我de死'',''36'',''yjmr806'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''炎黄神龙'',''57'',''zhang1976205'',''3000'',''-1350''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气!小天'',''64'',''zi00383'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刃丶小胖'',''40'',''zxc523608016'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小妖女哪里跑'',''33'',''a138979598'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''Ese丶皮鞋'',''30'',''a3466812'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''沉默v地主'',''23'',''a5peace1'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''欧阳以南'',''43'',''a631319722'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''绝の帝'',''41'',''caohongye'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''⑤心'',''32'',''czc735099022'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''聚仙丶单雄信'',''39'',''dalian_jx3'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''彷徨∷飞鱼'',''63'',''daohaosiyij'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''c我本善良y'',''43'',''daoke1981'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''大宝的小宝'',''48'',''feiaihao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-在哪'',''53'',''gu280'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-归何处'',''50'',''gu280111'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''◥◣神◢◤'',''33'',''kakadebao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''深渊的微笑'',''46'',''liubin800714'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''孤独剑儿'',''42'',''ll413637548'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''逍遥の强'',''65'',''lq530618210'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小水笑'',''45'',''lxcalx'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''思娜'',''47'',''ming801011'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''幽魂、宁采臣'',''60'',''o0xiaoge0o'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''藤田逸轩'',''22'',''qaqerqqq12'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''处男'',''31'',''qq1046645206'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''嗷嗷的漂亮'',''63'',''qq380949969'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''至尊屠神'',''64'',''qq58812346'',''100000'',''-104120''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''二郎神他爸'',''50'',''qubowei'',''0'',''-340''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''狂龙九宵'',''49'',''snob01'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''v一剑倾城v'',''40'',''stephenze221'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''落叶缤纷傲'',''35'',''wang62097158'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''龙之子の俊熙'',''66'',''wj236439278'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''紫鸾仙子'',''51'',''wj34371480'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''潇潇仙子'',''36'',''wowanjuju'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''鬼铃'',''51'',''x1351445'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑斩邪仙'',''61'',''xiaozhe123'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑无虚发'',''49'',''xlh1986'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''ESC残战'',''45'',''xu5365245'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''天弛‰仙官'',''40'',''zhuzi0222'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''゛素颜、迟°'',''28'',''zl443001783'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业灵官'',''30'',''zw98776698'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业天君'',''30'',''zw98776699'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''百合'',''31'',''zy1973911'',''0'',''0'');\r\n\r\n', 10, 237, 1, 'admin', 138, '2012-03-01 15:57:11', 't_players', 'db update', 0, 0),
(83, 'CREATE TABLE `傲世灬荭人` (\r\n  `c_factionname` varchar(255) collate utf8_bin default NULL,\r\n  `c_faction_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_familyname` varchar(255) collate utf8_bin default NULL,\r\n  `c_familylevel` varchar(255) collate utf8_bin default NULL,\r\n  `c_playername` varchar(255) collate utf8_bin default NULL,\r\n  `c_level` varchar(255) collate utf8_bin default NULL,\r\n  `c_userid` varchar(255) collate utf8_bin default NULL, `a` varchar(255) collate utf8_bin default NULL,\r\n  `b` varchar(255) collate utf8_bin default NULL\r\n) ENGINE=myisam DEFAULT CHARSET=utf8 COLLATE=utf8_bin;\r\n\r\n\r\ninsert  into `傲世灬荭人`(`c_factionname`,`c_faction_level`,`c_familyname`,`c_familylevel`,`c_playername`,`c_level`,`c_userid`,`a`,`b`) values (''c_factionname'',''c_faction_level'',''c_familyname'',''c_familylevel'',''c_playername'',''c_level'',''c_userid'',''a'',''b''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''死亡VI墓碑'',''40'',''a765995095'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''╰★神★╯'',''32'',''ai516919189'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''边城浪子'',''51'',''axing0515'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''斌临天下'',''39'',''bin1980bin'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''我们小时候'',''32'',''c515290777'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''为伊守候'',''23'',''caiyong1978'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''寂寞一个人'',''28'',''chenfeng2194'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''ゞ布衣小酱╭'',''38'',''congjunzi8'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''爱静小小猪'',''39'',''fubin520530'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''弑神邪兵'',''52'',''fzdsh'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o群魔乱舞o'',''40'',''gao123_001'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''旋律中的粑粑'',''61'',''hhf27843182'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''望哥归来'',''53'',''kosf'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''℡荭人╮指间'',''28'',''lanping1988'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''龙★傲世'',''54'',''lg812129cd'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''戟★神'',''58'',''liu356389178'',''1000'',''-910''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''化神灬剑'',''55'',''liu58016008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蝴蝶流星剑の'',''22'',''lnsyfk87'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''★笑苍天★'',''31'',''lt0913'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小小吕布'',''41'',''lxaxh521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''荭人、瑞少'',''65'',''lylhome015'',''200000'',''-81042''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''陈冠希丶'',''34'',''lzy19920908'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''许你笔墨三千'',''33'',''m635659064'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''豆豆包包'',''57'',''mts24129957'',''2000'',''-1803''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''冤家路窄'',''45'',''mzyzdn701608'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''小寶贝'',''51'',''pangzhen0916'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叮当'',''37'',''pta77992'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''一辈子枪'',''32'',''pta77993'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''天之泪'',''41'',''qq1376859197'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''逗〃逗'',''32'',''qq175625778'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''kak'',''33'',''rongzhiqiang'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''治疗万岁'',''30'',''shao65447'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''醉卧黄昏'',''44'',''tz156303519'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''左岸→右转☆'',''43'',''w419696107'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''消失的承诺'',''41'',''w479360475'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''〆﹏樱树╰椛'',''47'',''wanglin1278'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''蓝齐儿'',''68'',''wangqi198331'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''依·恋'',''45'',''wg1399823342'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''世界之巅'',''49'',''wr13854212'',''1500'',''-1500''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''曾花谢落'',''29'',''xcy1995222'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@天仙配@'',''49'',''xiaocan521'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''@董永@'',''46'',''xiaocan5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''风魔碎牙'',''53'',''xiaogou5522'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''叶武丶岚'',''29'',''yuwei5210'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''七哥哥'',''37'',''zgh5444'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''o独霸天下o'',''36'',''zhang0008'',''0'',''0''),(''傲世灬荭人'',''4'',''荭人、会馆'',''3'',''者别'',''47'',''zxw171299219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Xx小伙、'',''45'',''a279422279a'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''幻★觉'',''32'',''a787206577'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''灵物雨'',''41'',''a877630621'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刁蛮卐公主'',''41'',''abcdef197869'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''红s豆'',''39'',''anansxm6000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''aslong'',''35'',''aslongs'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''爱┍﹎难分.'',''44'',''bailu627'',''1000'',''-498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！小顺'',''44'',''bshun123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''xiao飞'',''49'',''cuishuren000'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''聚仙丶裴元庆'',''41'',''dalian_jx5'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''清风澄汁'',''43'',''feixiangdu'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''DGGH'',''40'',''fjj888119'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''小伙就是叼'',''46'',''gwy110'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大漠孤鹰*冰'',''41'',''gyc1351419'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''光辉神'',''40'',''gymshuai'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杜杨鹏越'',''43'',''jackydxfyl'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕百战'',''41'',''jklip1411'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''╭箪身`只沩'',''44'',''kongdefa1990'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''大年夜幽魂'',''40'',''li8687ke'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''漫步深澜'',''50'',''lxlei2962'',''10000'',''-3100''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凌迟'',''48'',''ouyouyou2599'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''莫灬丨小佳丨'',''48'',''qq8934165'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''Q大仙儿Q'',''40'',''qwe444124777'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''深度'',''66'',''rxh271828'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''往事H如烟'',''46'',''sht115123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''√缘'',''43'',''sjf1003'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东北☆霸刀'',''41'',''smy4467'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''罐子'',''31'',''ss460895591'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气＾刺客'',''42'',''suenjiwei521'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''把钱放下'',''44'',''syszyq123'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''魔神蚩尤'',''44'',''tyxzyy8005'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''寒霜'',''35'',''ufo8962'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！飞羽'',''28'',''w13845642559'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！阴阳'',''47'',''w139455'',''1500'',''-1498''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''东方咯隆美尔'',''32'',''w13946193285'',''1500'',''-1428''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''，圣多美了'',''48'',''w3a4n9g0200'',''5000'',''-2550''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''飞仙儿'',''39'',''wang30294216'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''§董事会§枫'',''39'',''wangchuan88'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气！浩劫'',''18'',''wbok20006'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''*夜灵*'',''33'',''wgyeling'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''凤舞九天'',''61'',''wx851219'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''老木'',''39'',''wxz405090'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''龙枪'',''40'',''x2115454'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''杀戮机器'',''41'',''x62714'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''◇◇丶磊子。'',''47'',''ximandula'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''狂战de魔'',''49'',''xuebin527'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''轩辕V斩无'',''44'',''y305971622y'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''没我de死'',''36'',''yjmr806'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''炎黄神龙'',''57'',''zhang1976205'',''3000'',''-1350''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''霸气!小天'',''64'',''zi00383'',''0'',''0''),(''傲世灬荭人'',''4'',''霸气||帝国'',''3'',''刃丶小胖'',''40'',''zxc523608016'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小妖女哪里跑'',''33'',''a138979598'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''Ese丶皮鞋'',''30'',''a3466812'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''沉默v地主'',''23'',''a5peace1'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''欧阳以南'',''43'',''a631319722'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''绝の帝'',''41'',''caohongye'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''⑤心'',''32'',''czc735099022'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''聚仙丶单雄信'',''39'',''dalian_jx3'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''彷徨∷飞鱼'',''63'',''daohaosiyij'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''c我本善良y'',''43'',''daoke1981'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''大宝的小宝'',''48'',''feiaihao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-在哪'',''53'',''gu280'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''心-归何处'',''50'',''gu280111'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''◥◣神◢◤'',''33'',''kakadebao'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''深渊的微笑'',''46'',''liubin800714'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''孤独剑儿'',''42'',''ll413637548'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''逍遥の强'',''65'',''lq530618210'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''小水笑'',''45'',''lxcalx'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''思娜'',''47'',''ming801011'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''幽魂、宁采臣'',''60'',''o0xiaoge0o'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''藤田逸轩'',''22'',''qaqerqqq12'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''处男'',''31'',''qq1046645206'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''嗷嗷的漂亮'',''63'',''qq380949969'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''至尊屠神'',''64'',''qq58812346'',''100000'',''-104120''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''二郎神他爸'',''50'',''qubowei'',''0'',''-340''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''狂龙九宵'',''49'',''snob01'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''v一剑倾城v'',''40'',''stephenze221'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''落叶缤纷傲'',''35'',''wang62097158'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''龙之子の俊熙'',''66'',''wj236439278'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''紫鸾仙子'',''51'',''wj34371480'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''潇潇仙子'',''36'',''wowanjuju'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''鬼铃'',''51'',''x1351445'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑斩邪仙'',''61'',''xiaozhe123'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''剑无虚发'',''49'',''xlh1986'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''ESC残战'',''45'',''xu5365245'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''天弛‰仙官'',''40'',''zhuzi0222'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''゛素颜、迟°'',''28'',''zl443001783'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业灵官'',''30'',''zw98776698'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''专业天君'',''30'',''zw98776699'',''0'',''0''),(''傲世灬荭人'',''4'',''風雲世家'',''4'',''百合'',''31'',''zy1973911'',''0'',''0'');\r\n\r\n', 10, 237, 1, 'admin', 138, '2012-03-01 16:11:43', 't_players', 'db update', 0, 0),
(84, 'test emnail', 27, 238, 1, '', 139, '2012-03-01 17:35:21', '', 'db update', 0, 0),
(85, '654q5w', 10, 240, 1, '', 141, '2012-03-02 11:02:08', '', 'db update', 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `tbscriptgeneration`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=302 ;

--
-- Dump dei dati per la tabella `tbscriptgeneration`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `tbsynchronize`
--

CREATE TABLE IF NOT EXISTS `tbsynchronize` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` date default NULL,
  `update_user` varchar(64) default NULL,
  `update_type` varchar(32) default NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) default NULL,
  `update_fromversion` int(11) default NULL,
  `update_fromsource` varchar(128) default NULL,
  `dbtype` varchar(32) default NULL,
  `tagname` varchar(128) default NULL,
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `tbsynchronize`
--

INSERT INTO `tbsynchronize` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `update_fromversion`, `update_fromsource`, `dbtype`, `tagname`) VALUES
('deltasql-server', NULL, 'INTERNAL', 'deltasql-server', 0, 'HEAD', NULL, NULL, 'mySQL', 'TAG_deltasql_1.3.7'),
('deltasql-Server', NULL, 'Not logged in', 'deltasql-server', 198, 'HEAD', 177, 'HEAD', 'mySQL', 'TAG_deltasql_1.4.0'),
('deltasql-Server', NULL, 'Not logged in', 'deltasql-server', 200, 'HEAD', 198, 'HEAD', 'mySQL', 'TAG_deltasql_1.4.1');

-- --------------------------------------------------------

--
-- Struttura della tabella `tbusagehistory`
--

CREATE TABLE IF NOT EXISTS `tbusagehistory` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` datetime default NULL,
  `update_user` varchar(64) default NULL,
  `update_type` varchar(32) default NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) default NULL,
  `update_fromversion` int(11) default NULL,
  `update_fromsource` varchar(128) default NULL,
  `dbtype` varchar(32) default NULL,
  `ip` varchar(32) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `tbusagehistory`
--

INSERT INTO `tbusagehistory` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `update_fromversion`, `update_fromsource`, `dbtype`, `ip`) VALUES
('deltasql-Server', '2011-08-25 00:00:00', 'Not logged in', 'deltasql-server', 198, 'HEAD', 196, 'HEAD', 'mySQL', '217.110.34.186'),
('deltasql-Server', '2011-08-25 00:00:00', 'Not logged in', 'deltasql-server', 198, 'HEAD', 114, 'HEAD', 'mySQL', '217.110.34.186'),
('deltasql-Server', '2011-09-02 00:00:00', 'Not logged in', 'deltasql-server', 198, 'HEAD', 177, 'HEAD', 'sqlite', '82.157.126.125'),
('deltasql-Server', '2011-09-09 00:00:00', 'admin', 'deltasql-server', 200, 'HEAD', 198, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 114, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 198, 'HEAD', 'mySQL', '91.213.136.2'),
('TestProject', '2011-09-13 00:00:00', 'admin', 'deltasql-server', 203, 'HEAD', 1, 'HEAD', 'Oracle', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'deltauser', 'deltaclient', 200, 'HEAD', 198, 'HEAD', '', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'deltauser', 'deltaclient', 177, 'HEAD', 161, 'HEAD', '', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'deltauser', 'deltaclient', 177, 'HEAD', 161, 'HEAD', 'Oracle', '91.213.136.2'),
('deltasql-Server', '2011-09-13 00:00:00', 'deltauser', 'deltaclient', 177, 'HEAD', 161, 'HEAD', 'Other', '91.213.136.2'),
('deltasql-Server', '2011-09-26 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 198, 'HEAD', 'mySQL', '91.213.136.2'),
('Multivac', '2011-09-27 00:00:00', 'admin', 'deltasql-server', 206, 'HEAD', 2, 'HEAD', 'mySQL', '188.80.95.105'),
('Multivac', '2011-10-05 00:00:00', 'admin', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-10-07 00:00:00', 'admin', 'deltasql-server', 96, 'HEAD', 89, 'HEAD', 'mySQL', '103.4.124.12'),
('deltasql-Server', '2011-10-07 00:00:00', 'admin', 'deltasql-server', 200, 'HEAD', 89, 'HEAD', 'mySQL', '103.4.124.12'),
('Multivac', '2011-10-26 00:00:00', 'admin', 'deltasql-server', 206, 'HEAD', 20, 'HEAD', 'mySQL', '203.177.74.135'),
('deltasql-Server', '2011-10-27 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'mySQL', '217.133.111.198'),
('TestProject', '2011-11-01 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 55, 'HEAD', 'Oracle', '72.196.199.206'),
('TestProject', '2011-11-02 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'mySQL', '159.53.174.145'),
('TestProject', '2011-11-02 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'Sybase', '159.53.174.145'),
('deltasql-Server', '2011-11-10 00:00:00', 'Not logged in', 'deltasql-server', 198, 'HEAD', 161, 'HEAD', 'Oracle', '212.202.230.122'),
('deltasql-Server', '2011-11-10 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 161, 'HEAD', 'Oracle', '212.202.230.122'),
('deltasql-Server', '2011-11-10 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 89, 'HEAD', 'Oracle', '212.202.230.122'),
('deltasql-Server', '2011-12-07 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 96, 'HEAD', 'Oracle', '62.180.244.232'),
('deltasql-Server', '2011-12-07 00:00:00', 'admin', 'deltasql-server', 206, 'HEAD', 89, 'HEAD', 'mySQL', '62.180.244.232'),
('deltasql-Server', '2011-12-07 00:00:00', 'admin', 'deltasql-server', 200, 'HEAD', 89, 'HEAD', 'Oracle', '62.180.244.232'),
('GPU-II', '2011-12-12 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'PostgreSQL', '212.59.44.6'),
('FileDistributor', '2011-12-12 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 1, 'HEAD', 'PostgreSQL', '212.59.44.4'),
('deltasql-Server', '2011-12-13 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 98, 'HEAD', 'mySQL', '72.22.186.68'),
('deltasql-Server', '2011-12-13 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 98, 'HEAD', 'mySQL', '72.22.186.68'),
('deltasql-Server', '2011-12-13 00:00:00', 'Not logged in', 'deltasql-server', 198, 'HEAD', 115, 'HEAD', 'mySQL', '178.114.217.43'),
('deltasql-Server', '2011-12-22 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 5, 'HEAD', 'mySQL', '203.177.193.54'),
('deltasql-Server', '2011-12-22 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 5, 'HEAD', 'mySQL', '203.177.193.54'),
('TestProject', '2011-12-22 00:00:00', 'Not logged in', 'deltasql-server', 206, 'HEAD', 5, 'HEAD', 'mySQL', '203.177.193.54'),
('TestProject', '2011-12-22 00:00:00', 'admin', 'deltasql-server', 209, 'HEAD', 2, 'HEAD', 'mySQL', '203.177.193.54'),
('deltasql-Server', '2011-12-23 00:00:00', 'admin', 'deltasql-server', 209, 'HEAD', 102, 'HEAD', 'mySQL', '80.58.205.42'),
('deltasql-Server', '2011-12-27 00:00:00', 'time', 'deltasql-server', 209, 'HEAD', 1, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 98, 'HEAD', 89, 'HEAD', 'mySQL', '125.17.110.162'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 89, 'HEAD', 'mySQL', '125.17.110.162'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 89, 'HEAD', 'mySQL', '125.17.110.162'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 89, 'HEAD', 'Oracle', '125.17.110.162'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 89, 'HEAD', 'MS SQL Server', '125.17.110.162'),
('deltasql-Server', '2011-12-27 00:00:00', 'Not logged in', 'deltasql-server', 115, 'HEAD', 89, 'HEAD', 'Other', '125.17.110.162'),
('deltasql-Server', '2011-12-28 00:00:00', 'Not logged in', 'deltasql-server', 209, 'HEAD', 4, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-12-28 00:00:00', 'Not logged in', 'deltasql-server', 209, 'HEAD', 177, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-12-28 00:00:00', 'Not logged in', 'deltasql-server', 209, 'HEAD', 1, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2011-12-29 00:00:00', 'Not logged in', 'deltasql-server', 209, 'HEAD', 89, 'HEAD', 'mySQL', '112.90.181.42'),
('deltasql-Server', '2011-12-29 00:00:00', 'admin', 'deltasql-server', 200, 'HEAD', 89, 'HEAD', 'mySQL', '112.90.181.42'),
('deltasql-Server', '2012-01-05 00:00:00', 'Not logged in', 'deltasql-server', 215, 'HEAD', 200, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-12 00:00:00', 'time', 'deltasql-server', 215, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-12 00:00:00', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-12 00:00:00', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 89, 'HEAD', 1, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 96, 'HEAD', 89, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 98, 'HEAD', 96, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 103, 'HEAD', 98, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 114, 'HEAD', 103, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 177, 'HEAD', 161, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 198, 'HEAD', 177, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 200, 'HEAD', 198, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-01-13 00:00:00', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('FileDistributor', '2012-01-25 00:00:00', 'Not logged in', 'deltasql-server', 226, 'HEAD', 1, 'HEAD', 'mySQL', '62.99.210.9'),
('TestProject', '2012-02-09 00:00:00', 'Not logged in', 'deltasql-server', 235, 'HEAD', 1, 'HEAD', 'mySQL', '178.119.13.60'),
('deltasql-Server', '2012-02-25 00:00:00', 'Not logged in', 'deltasql-server', 200, 'HEAD', 89, 'HEAD', 'MS SQL Server', '119.85.206.53'),
('deltasql-Server', '2012-03-02 16:23:36', 'Not logged in', 'deltasql-server', 240, 'HEAD', 1, 'HEAD', 'mySQL', '130.37.84.201'),
('deltasql-Server', '2012-03-02 16:24:13', 'Not logged in', 'deltasql-server', 240, 'HEAD', 20, 'HEAD', 'mySQL', '130.37.84.201'),
('deltasql-Server', '2012-03-02 16:24:21', 'Not logged in', 'deltasql-server', 240, 'HEAD', 21, 'HEAD', 'mySQL', '130.37.84.201'),
('deltasql-Server', '2012-03-02 16:24:28', 'Not logged in', 'deltasql-server', 240, 'HEAD', 70, 'HEAD', 'mySQL', '130.37.84.201'),
('deltasql-Server', '2012-03-05 08:56:26', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 08:58:09', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 08:59:06', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:02:17', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:06:35', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:06:53', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:06:58', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:08:39', 'admin', 'deltasql-server', 222, 'HEAD', 213, 'HEAD', 'mySQL', '91.213.136.2'),
('deltasql-Server', '2012-03-05 09:08:53', 'admin', 'deltasql-server', 242, 'HEAD', 222, 'HEAD', 'mySQL', '91.213.136.2');

-- --------------------------------------------------------

--
-- Struttura della tabella `tbuser`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=14 ;

--
-- Dump dei dati per la tabella `tbuser`
--

INSERT INTO `tbuser` (`id`, `username`, `password`, `first`, `last`, `email`, `rights`, `encrypted`, `passwhash`) VALUES
(1, 'admin', '****', 'Main', 'Administrator', 'admin@deltasql.org', 3, 1, 'd6ce200dba380fa8451760f84d7ab6fe'),
(3, 'dangermouse', '****', 'Paul', 'Smith', 'paul.smith@gmail.com', 1, 1, 'c3df5702a6c5d9c9ad375297d40ddbc3'),
(4, 'pinco', '', 'Pinco', 'Pallino', 'pincopallino@pallino.ch', 1, 1, '0104f1ecf2ab98ab68bb22b66a33193b'),
(5, 'time', '****', 'Tiz', 'Danger', 'tiz@danger.com', 2, 1, 'f38163018214363849be3f4a1d6656b7'),
(8, 'virus', 'virus', 'Virginia', 'Saladin', 'vir@saladin.com', 2, 0, NULL),
(11, 'linus', 'linus', 'Linus', 'Torvalds', 'linus@kernel.org', 1, 0, NULL),
(12, 'billgates', '****', 'Bill', 'Gates', 'bill@microsoft.com', 2, 1, '01b6ad058bbd2ab3bdaab9c3c9b87dfc');
