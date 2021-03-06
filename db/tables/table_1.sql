CREATE TABLE `tbbranch` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) collate latin1_general_ci NOT NULL,
  `project_id` int(11) default NULL,
  `description` varchar(400) collate latin1_general_ci NOT NULL,
  `versionnr` int(11) NOT NULL,
  `create_dt` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL default '1',
  `sourcebranch` VARCHAR( 40 ) NULL,
  `istag` tinyint(1) NOT NULL default '0',
  `ishead` TINYINT( 1 ) NOT NULL DEFAULT  '0',
  `sourcebranch_id` int(11) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;
