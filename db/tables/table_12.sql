CREATE TABLE `tbstats` (
  `id` int(11) NOT NULL auto_increment,
  `ip` varchar(32) NULL,
  `deltasql_version` varchar(32) NULL,
  `create_dt` datetime default NULL,
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