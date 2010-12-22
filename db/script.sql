-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- Server version: 5.0.27
-- PHP Version: 5.2.0
-- 
-- Database: `deltasql`
--


CREATE TABLE `tbbranch` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `project_id` int(11) default NULL,
  `description` varchar(400) collate latin1_general_ci NOT NULL,
  `versionnr` int(11) NOT NULL,
  `create_dt` date NOT NULL,
  `visible` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;
ALTER TABLE `tbbranch` ADD `sourcebranch` VARCHAR( 40 ) NULL;
ALTER TABLE `tbbranch` ADD `istag` tinyint(1) NOT NULL default '0';

INSERT INTO `tbbranch` VALUES (1, 'HEAD', NULL, 'This is the Trunk for all projects', 0, '2007-10-31', 1, '', 0);

-- 
-- Table structure for table `tbmodule`
-- 

CREATE TABLE `tbmodule` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  `lastversionnr` int(11) NOT NULL,
  `size` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;


-- 
-- Table structure for table `tbmoduleproject`
-- 

CREATE TABLE `tbmoduleproject` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `module_id` (`module_id`,`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;


-- 
-- Table structure for table `tbparameter`
-- 

CREATE TABLE `tbparameter` (
  `id` int(11) NOT NULL auto_increment,
  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,
  `paramname` varchar(20) collate latin1_general_ci NOT NULL,
  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `paramtype` (`paramtype`,`paramname`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `tbparameter`
-- 

INSERT INTO `tbparameter` VALUES (1, 'GLOBAL', 'VERSION', '6');


-- 
-- Table structure for table `tbproject`
-- 

CREATE TABLE `tbproject` (
  `id` int(11) NOT NULL auto_increment,
  `name` text collate latin1_general_ci NOT NULL,
  `description` varchar(700) collate latin1_general_ci default NULL,
  `create_dt` date default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

-- 
-- Table structure for table `tbscript`
-- 

CREATE TABLE `tbscript` (
  `id` int(11) NOT NULL auto_increment,
  `code` longtext collate latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_dt` date NOT NULL,
  `comments` longtext collate latin1_general_ci,
  `title` varchar(64) collate latin1_general_ci default NULL,
  `isapackage` tinyint(1) NOT NULL default '0',
  `isaview` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

ALTER TABLE `tbscript` ADD `update_dt` DATE NULL AFTER `create_dt` ;
ALTER TABLE `tbscript` ADD `update_user` VARCHAR( 64 ) NULL AFTER `update_dt`;
ALTER TABLE `tbscript` CHANGE `create_dt` `create_dt` DATETIME NOT NULL;
ALTER TABLE `tbscript` CHANGE `update_dt` `update_dt` DATETIME NOT NULL; 

-- 
-- Dumping data for table `tbscript`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tbscriptbranch`
-- 

CREATE TABLE `tbscriptbranch` (
  `id` int(11) NOT NULL auto_increment,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `tbscriptbranch`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `tbsynchronize`
-- 

CREATE TABLE `tbsynchronize` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATE NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`description` VARCHAR( 128 ) NULL,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`schemaname`  VARCHAR( 32 ) NULL ,
`dbtype` VARCHAR( 32 ) NULL ,
UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE = MYISAM ;

INSERT INTO tbsynchronize (PROJECTNAME, VERSIONNR, BRANCHNAME, UPDATE_USER, UPDATE_TYPE, SCHEMANAME, DBTYPE)
VALUES ('deltasql-server', 0, 'HEAD', 'INTERNAL', 'deltasql-server', '', 'mySQL');


-- --------------------------------------------------------

-- 
-- Table structure for table `tbusagehistory`
-- 

CREATE TABLE `tbusagehistory` (
`projectname` VARCHAR( 64 ) NOT NULL ,
`update_dt` DATE NULL ,
`update_user` VARCHAR( 64 ) NULL ,
`update_type` VARCHAR( 32 ) NULL ,
`versionnr` INT NOT NULL,
`branchname` VARCHAR( 128 ) NULL ,
`description` VARCHAR( 128 ) NULL,
`update_fromversion` INT NULL,
`update_fromsource` VARCHAR( 128 ) NULL,
`schemaname`  VARCHAR( 32 ) NULL ,
`dbtype` VARCHAR( 32 ) NULL 
) ENGINE = MYISAM ;



-- --------------------------------------------------------

-- 
-- Table structure for table `tbuser`
-- 

CREATE TABLE `tbuser` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) collate latin1_general_ci NOT NULL,
  `password` varchar(32) collate latin1_general_ci default NULL,
  `first` varchar(32) collate latin1_general_ci default NULL,
  `last` varchar(32) collate latin1_general_ci default NULL,
  `email` varchar(64) collate latin1_general_ci default NULL,
  `rights` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

INSERT INTO `tbuser` VALUES (1, 'admin', 'testdbsync', 'Main', 'Administrator', 'admin@deltasql', 3);

-- 
-- Table structure for table `tbphonetranscript`
-- 

CREATE TABLE `tbphonetranscript` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(32) NULL,
  `deltasql_version` varchar(32) NULL,
  `create_dt` date default NULL,
  `nbscripts` int(11) NULL,
  `nbmodules` int(11) NULL,
  `nbprojects` int(11) NULL,
  `nbbranches` int(11) NULL,
  `nbsyncs` int(11) NULL,
  `nbusers` int(11) NULL,
  `nbmp` int(11) NULL,
  `nbsb` int(11) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;
