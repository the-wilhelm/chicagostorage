CREATE TABLE `wp_xmt_twt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_nme` varchar(100) NOT NULL,
  `twt_id` bigint(20) NOT NULL,
  `twt_ath` varchar(100) NOT NULL,
  `twt` varchar(255) NOT NULL,
  `twt_dtp` varchar(19) NOT NULL,
  `twt_typ` varchar(3) NOT NULL,
  `twt_src` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `acc_nme_twt_id` (`acc_nme`,`twt_id`),
  KEY `acc_nme_index` (`acc_nme`),
  KEY `twt_id_index` (`twt_id`),
  KEY `twt_index` (`twt`),
  KEY `twt_dtp_index` (`twt_dtp`),
  KEY `twt_typ_index` (`twt_typ`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8