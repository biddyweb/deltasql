--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `city_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `state_id` bigint(20) NOT NULL,
  `country_id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `state_id`, `country_id`, `city_name`) VALUES
(1, 1, 98, 'Mumbai'),
(2, 1, 98, 'Nashik'),
(3, 2, 98, 'Surat'),
(4, 2, 98, 'Baroda');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`state_id`, `country_id`, `state_name`) VALUES
(1, 98, 'Maharashtra'),
(2, 98, 'Gujarat');
