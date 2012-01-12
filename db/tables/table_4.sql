CREATE TABLE `tbparameter` (
  `id` int(11) NOT NULL auto_increment,
  `paramtype` varchar(20) collate latin1_general_ci NOT NULL,
  `paramname` varchar(20) collate latin1_general_ci NOT NULL,
  `paramvalue` varchar(255) collate latin1_general_ci NOT NULL,
  `user_id` int(11) NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `paramtype` (`paramtype`,`paramname`,`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;