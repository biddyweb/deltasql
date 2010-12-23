CREATE TABLE `tbscriptgeneration` (
  `id` int(11) NOT NULL auto_increment,
  `sessionid` varchar(40) collate latin1_general_ci NOT NULL,
  `fromversionnr` int(11) default NULL,
  `toversionnr` int(11) default NULL,
  `frombranch` varchar(40) collate latin1_general_ci NOT NULL,
  `tobranch` varchar(40) collate latin1_general_ci NOT NULL,
  `frombranch_id` int(11) NOT NULL,
  `tobranch_id` int(11) NOT NULL,
  `create_dt` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1;