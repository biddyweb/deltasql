-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. September 2011 um 09:22
-- Server Version: 5.1.33
-- PHP-Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Datenbank: `deltasql141`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbbranch`
--

CREATE TABLE IF NOT EXISTS `tbbranch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `description` varchar(400) COLLATE latin1_general_ci NOT NULL,
  `versionnr` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `sourcebranch` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `istag` tinyint(1) NOT NULL DEFAULT '0',
  `sourcebranch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbbranch`
--

INSERT INTO `tbbranch` (`id`, `name`, `project_id`, `description`, `versionnr`, `create_dt`, `visible`, `sourcebranch`, `istag`, `sourcebranch_id`) VALUES
(1, 'HEAD', NULL, 'This is the Trunk for all projects, the main line of development', 0, '2007-10-31 00:00:00', 1, '', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbmodule`
--

CREATE TABLE IF NOT EXISTS `tbmodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `description` varchar(700) COLLATE latin1_general_ci DEFAULT NULL,
  `create_dt` date DEFAULT NULL,
  `lastversionnr` int(11) NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `tbmodule`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbmoduleproject`
--

CREATE TABLE IF NOT EXISTS `tbmoduleproject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id` (`module_id`,`project_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbmoduleproject`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbparameter`
--

CREATE TABLE IF NOT EXISTS `tbparameter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paramtype` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `paramname` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `paramvalue` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `user_id` int(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tbparameter`
--

INSERT INTO `tbparameter` (`id`, `paramtype`, `paramname`, `paramvalue`) VALUES
(1, 'GLOBAL', 'VERSION', '10'),
(2, 'TEST', 'DB_CONNECTION', 'OK'),
(3, 'SECURITY', 'PWD_HASH_SALT', '37e76f509bb433f4f8afd6a7320c4885');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbphonetranscript`
--

CREATE TABLE IF NOT EXISTS `tbstats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `deltasql_version` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `create_dt` datetime DEFAULT NULL,
  `nbscripts` int(11) DEFAULT NULL,
  `nbmodules` int(11) DEFAULT NULL,
  `nbprojects` int(11) DEFAULT NULL,
  `nbbranches` int(11) DEFAULT NULL,
  `nbsyncs` int(11) DEFAULT NULL,
  `nbusers` int(11) DEFAULT NULL,
  `nbmp` int(11) DEFAULT NULL,
  `nbsb` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `tbphonetranscript`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbproject`
--

CREATE TABLE IF NOT EXISTS `tbproject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_general_ci NOT NULL,
  `description` varchar(700) COLLATE latin1_general_ci DEFAULT NULL,
  `create_dt` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbproject`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbscript`
--

CREATE TABLE IF NOT EXISTS `tbscript` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` longtext COLLATE latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `update_dt` datetime DEFAULT NULL,
  `update_user` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `comments` longtext COLLATE latin1_general_ci,
  `title` varchar(128) COLLATE latin1_general_ci DEFAULT NULL,
  `isapackage` tinyint(1) NOT NULL DEFAULT '0',
  `isaview` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbscript`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbscriptbranch`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbscriptbranch`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbscriptbranchchangelog`
--

CREATE TABLE IF NOT EXISTS `tbscriptbranchchangelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `script_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `script_id` (`script_id`,`branch_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbscriptbranchchangelog`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbscriptchangelog`
--

CREATE TABLE IF NOT EXISTS `tbscriptchangelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` longtext COLLATE latin1_general_ci NOT NULL,
  `module_id` int(11) NOT NULL,
  `versionnr` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `update_user` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `script_id` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `comments` longtext COLLATE latin1_general_ci,
  `title` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `isapackage` tinyint(1) NOT NULL DEFAULT '0',
  `isaview` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbscriptchangelog`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbscriptgeneration`
--

CREATE TABLE IF NOT EXISTS `tbscriptgeneration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionid` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `fromversionnr` int(11) DEFAULT NULL,
  `toversionnr` int(11) DEFAULT NULL,
  `frombranch` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `tobranch` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `frombranch_id` int(11) NOT NULL,
  `tobranch_id` int(11) NOT NULL,
  `exclbranch` tinyint(1) NOT NULL DEFAULT '0',
  `create_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tbscriptgeneration`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbsynchronize`
--

CREATE TABLE IF NOT EXISTS `tbsynchronize` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` date DEFAULT NULL,
  `update_user` varchar(64) DEFAULT NULL,
  `update_type` varchar(32) DEFAULT NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) DEFAULT NULL,
  `tagname` varchar(128) DEFAULT NULL,
  `update_fromversion` int(11) DEFAULT NULL,
  `update_fromsource` varchar(128) DEFAULT NULL,
  `dbtype` varchar(32) DEFAULT NULL,
  UNIQUE KEY `versionnr` (`versionnr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbsynchronize`
--

INSERT INTO `tbsynchronize` (`projectname`, `update_dt`, `update_user`, `update_type`, `versionnr`, `branchname`, `tagname`, `update_fromversion`, `update_fromsource`, `dbtype`) VALUES
('deltasql-server', NULL, 'INTERNAL', 'deltasql-server', 0, 'HEAD', 'TAG_deltasql_1.4.1', NULL, NULL, 'mySQL');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbusagehistory`
--

CREATE TABLE IF NOT EXISTS `tbsyncstats` (
  `projectname` varchar(64) NOT NULL,
  `update_dt` datetime DEFAULT NULL,
  `update_user` varchar(64) DEFAULT NULL,
  `update_type` varchar(32) DEFAULT NULL,
  `versionnr` int(11) NOT NULL,
  `branchname` varchar(128) DEFAULT NULL,
  `update_fromversion` int(11) DEFAULT NULL,
  `update_fromsource` varchar(128) DEFAULT NULL,
  `dbtype` varchar(32) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tbusagehistory`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbuser`
--

CREATE TABLE IF NOT EXISTS `tbuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `first` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `last` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `rights` int(11) NOT NULL DEFAULT '0',
  `encrypted` tinyint(1) NOT NULL DEFAULT '0',
  `passwhash` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tbuser`
--
-- Please note: Password for admin user is testdbsync
INSERT INTO `tbuser` (`id`, `username`, `password`, `first`, `last`, `email`, `rights`, `encrypted`, `passwhash`) VALUES
(1, 'admin', '****', 'Main', 'Administrator', 'admin@deltasql', 3, 1, 'aa27bde5b2303ed930c48751877b5991');

