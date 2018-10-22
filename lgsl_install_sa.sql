CREATE TABLE `lgsl` (

  `id`         INT     (11)  NOT NULL auto_increment,
  `type`       VARCHAR (50)  NOT NULL DEFAULT '',
  `ip`         VARCHAR (255) NOT NULL DEFAULT '',
  `c_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
  `q_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
  `s_port`     VARCHAR (5)   NOT NULL DEFAULT '0',
  `zone`       VARCHAR (255) NOT NULL DEFAULT '',
  `disabled`   TINYINT (1)   NOT NULL DEFAULT '0',
  `comment`    VARCHAR (255) NOT NULL DEFAULT '',
  `status`     TINYINT (1)   NOT NULL DEFAULT '0',
  `cache`      TEXT          NOT NULL,
  `cache_time` TEXT          NOT NULL,

  PRIMARY KEY (`id`)

) ENGINE=MyISAM CHARSET=utf8 COLLATE=utf8_unicode_ci;
