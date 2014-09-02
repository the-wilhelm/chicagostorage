CREATE TABLE `wp_xmt_acc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nme` varchar(100) NOT NULL,
  `cfg` longblob NOT NULL,
  `las_twt_imp_dtp` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nme_unique` (`nme`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8