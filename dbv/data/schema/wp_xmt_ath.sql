CREATE TABLE `wp_xmt_ath` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) NOT NULL,
  `nme` varchar(100) NOT NULL,
  `img_url` varchar(250) NOT NULL,
  `dte_upd` varchar(19) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid_unique` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8