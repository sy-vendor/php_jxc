set session sql_mode='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';
DROP TABLE IF EXISTS `#@___boss`;
CREATE TABLE `#@__boss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `boss` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `logindate` datetime NOT NULL,
  `loginip` varchar(15) NOT NULL,
  `errnumber` int(11) NOT NULL,
  `rank` smallint(6) NOT NULL,
  `key` varchar(50) NOT NULL,
  `key1` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#;

DROP TABLE IF EXISTS `#@__config`;
CREATE TABLE `#@__config` (
`id` INT( 11 ) NOT NULL ,
`config_name` VARCHAR( 30 ) NOT NULL ,
`config_mem` VARCHAR( 50 ) NOT NULL ,
`config_value` VARCHAR( 30 ) NOT NULL ,
`config_type` VARCHAR( 20 ) NOT NULL ,
`config_len` VARCHAR( 20 ) NOT NULL ,
PRIMARY KEY ( `id` ) 
) ENGINE=InnoDB DEFAULT CHARSET=#~lang~#;

DROP TABLE IF EXISTS `#@__flink`;
CREATE TABLE `#@__flink` (
  `ID` int(11) NOT NULL auto_increment,
  `sortrank` int(11) NOT NULL default '0',
  `url` varchar(100) NOT NULL default '',
  `webname` varchar(30) NOT NULL default '',
  `msg` varchar(250) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `logo` varchar(100) NOT NULL default '',
  `dtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `typeid` int(11) NOT NULL default '0',
  `ischeck` smallint(6) NOT NULL default '1',
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#;

DROP TABLE IF EXISTS `#@__area`;
CREATE TABLE `#@__area` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(20) NOT NULL default '',
  `reid` int(10) unsigned NOT NULL default '0',
  `disorder` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#;

DROP TABLE IF EXISTS `#@__recordline`;
CREATE TABLE `#@__recordline` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`message` TEXT NOT NULL ,
`date` DATETIME NOT NULL ,
`ip` VARCHAR( 15 ) NOT NULL ,
`userid` VARCHAR( 20 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__usertype`;
CREATE TABLE `#@__usertype` (
`rank` SMALLINT( 6 ) NOT NULL ,
`typename` VARCHAR( 30 ) NOT NULL ,
`system` SMALLINT( 6 ) NOT NULL ,
`content` TEXT NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__menu`;
CREATE TABLE `#@__menu` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 100 ) NOT NULL ,
`url` VARCHAR( 100 ) NOT NULL ,
`reid` INT( 10 ) NOT NULL ,
`rank` TEXT NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__categories`;
CREATE TABLE `#@__categories` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`categories` VARCHAR( 50 ) NOT NULL ,
`reid` SMALLINT( 6 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__dw`;
CREATE TABLE `#@__dw` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dwname` VARCHAR( 20 ) NOT NULL ,
`reid` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__gys`;
CREATE TABLE `#@__gys` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`g_name` VARCHAR( 100 ) NOT NULL ,
`g_address` VARCHAR( 120 ) NOT NULL ,
`g_people` VARCHAR( 10 ) NOT NULL ,
`g_phone` VARCHAR( 12 ) NOT NULL ,
`g_qq` VARCHAR( 20 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__staff`;
CREATE TABLE `#@__staff` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`s_name` VARCHAR( 10 ) NOT NULL ,
`s_address` VARCHAR( 120 ) NOT NULL ,
`s_phone` VARCHAR( 15 ) NOT NULL ,
`s_part` VARCHAR( 50 ) NOT NULL ,
`s_way` SMALLINT( 6 ) NOT NULL DEFAULT '0',
`s_money` FLOAT( 20 ) NOT NULL ,
`s_utype` SMALLINT( 6 ) NOT NULL ,
`s_duty` VARCHAR( 50 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__guest`;
CREATE TABLE `#@__guest` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`g_name` VARCHAR( 50 ) NOT NULL ,
`g_man` VARCHAR( 20 ) NOT NULL ,
`g_address` VARCHAR( 120 ) NOT NULL ,
`g_phone` VARCHAR( 15 ) NOT NULL ,
`g_qq` VARCHAR( 50 ) NOT NULL ,
`g_bank` VARCHAR( 60 ) NOT NULL ,
`g_card` VARCHAR( 50 ) NOT NULL ,
`g_pay` VARCHAR( 20 ) NULL DEFAULT '0',
`g_group` SMALLINT( 6 ) NOT NULL ,
`g_people` VARCHAR( 20 ) NOT NULL ,
`g_helpword` VARCHAR( 30 ) NOT NULL ,
`g_dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__group`;
CREATE TABLE `#@__group` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`groupname` VARCHAR( 30 ) NOT NULL ,
`sub` FLOAT NOT NULL DEFAULT '10' ,
`groupmem` TEXT NOT NULL ,
`staffid` SMALLINT( 6 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#;

DROP TABLE IF EXISTS `#@__lab`;
CREATE TABLE `#@__lab` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`l_name` VARCHAR( 30 ) NOT NULL ,
`l_city` VARCHAR( 30 ) NOT NULL ,
`l_mang` VARCHAR( 10 ) NOT NULL ,
`l_default` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__basic`;
CREATE TABLE `#@__basic` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`cp_number` VARCHAR( 15 ) NOT NULL ,
`cp_tm` VARCHAR( 15 ) NOT NULL ,
`cp_name` VARCHAR( 50 ) NOT NULL ,
`cp_gg` VARCHAR( 50 ) NOT NULL ,
`cp_categories` SMALLINT( 6 ) NOT NULL ,
`cp_categories_down` SMALLINT( 6 ) NOT NULL ,
`cp_dwname` SMALLINT( 6 ) NOT NULL ,
`cp_jj` FLOAT( 20 ) NOT NULL ,
`cp_sale` FLOAT( 20 ) NOT NULL ,
`cp_saleall` FLOAT( 20 ) NOT NULL ,
`cp_sale1` FLOAT( 10 ) NOT NULL ,
`cp_sdate` DATE NOT NULL DEFAULT '0000-00-00',
`cp_edate` DATE NOT NULL DEFAULT '0000-00-00',
`cp_gys` VARCHAR( 50 ) NOT NULL ,
`cp_helpword` VARCHAR( 50 ) NOT NULL ,
`cp_bz` TEXT NOT NULL ,
`cp_style` SMALLINT( 1 ) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportrk`;
CREATE TABLE `#@__reportrk` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0' ,
`finish` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportbackgys`;
CREATE TABLE `#@__reportbackgys` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportnone`;
CREATE TABLE `#@__reportnone` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportsale`;
CREATE TABLE `#@__reportsale` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0' ,
`r_adid` VARCHAR( 10 ) NOT NULL ,
`finish` SMALLINT( 6 ) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportsback`;
CREATE TABLE `#@__reportsback` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0' 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__kc`;
CREATE TABLE `#@__kc` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL  ,
`number` INT( 11 ) NOT NULL ,
`labid` SMALLINT( 6 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`rk_price` FLOAT NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`bank` SMALLINT( 4 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__kcbackgys`;
CREATE TABLE `#@__kcbackgys` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL ,
`number` INT( 11 ) NOT NULL ,
`labid` SMALLINT( 6 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`idh` VARCHAR( 20 ) NOT NULL ,
`rk_price` FLOAT NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__none`;
CREATE TABLE `#@__none` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL ,
`number` INT( 11 ) NOT NULL ,
`labid` SMALLINT( 6 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__sale`;
CREATE TABLE `#@__sale` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL ,
`sale` FLOAT NOT NULL ,
`salelab` SMALLINT( 6 ) NOT NULL ,
`number` INT( 11 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`member` VARCHAR( 50 ) NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__saleback`;
CREATE TABLE `#@__saleback` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL ,
`number` INT( 11 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`sdh` VARCHAR( 20 ) NOT NULL ,
`member` VARCHAR( 50 ) NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' ,
`r_text` TEXT NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__mainkc`;
CREATE TABLE `#@__mainkc` (
`kid` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`p_id` VARCHAR( 15 ) NOT NULL  ,
`l_id` SMALLINT( 6 ) NOT NULL ,
`d_id` VARCHAR( 20 ) NOT NULL ,
`number` INT( 11 ) NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__accounts`;
CREATE TABLE `#@__accounts` (
`id` SMALLINT( 8 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`atype` VARCHAR( 10 ) NOT NULL ,
`amoney` FLOAT( 50 ) NOT NULL ,
`abank` SMALLINT( 6 ) NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`apeople` VARCHAR( 10 ) NOT NULL ,
`atext` TEXT NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__bank`;
CREATE TABLE `#@__bank` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`bank_name` VARCHAR( 30 ) NOT NULL ,
`bank_money` FLOAT NOT NULL ,
`bank_account` VARCHAR( 30 ) NOT NULL ,
`bank_default` SMALLINT( 6 ) NOT NULL ,
`bank_text` TEXT NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__part`;
CREATE TABLE `#@__part` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`p_name` VARCHAR( 100 ) NOT NULL ,
`p_text` TEXT NOT NULL 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__reportswitch`;
CREATE TABLE `#@__reportswitch` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`r_dh` VARCHAR( 20 ) NOT NULL ,
`r_people` VARCHAR( 10 ) NOT NULL ,
`r_date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`r_status` SMALLINT( 6 ) NOT NULL DEFAULT '0' 
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 


DROP TABLE IF EXISTS `#@__switch`;
CREATE TABLE `#@__switch` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`productid` VARCHAR( 15 ) NOT NULL ,
`people` VARCHAR( 15 ) NOT NULL ,
`number` INT( 11 ) NOT NULL ,
`rdh` VARCHAR( 20 ) NOT NULL ,
`fromlab` SMALLINT( 6 ) NOT NULL ,
`tolab` SMALLINT( 6 ) NOT NULL ,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 

DROP TABLE IF EXISTS `#@__pay`;
CREATE TABLE `#@__pay` (
`id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`guestid` VARCHAR( 15 ) NOT NULL ,
`money` VARCHAR( 15 ) NOT NULL ,
`mem` TEXT NULL,
`dtime` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=#~lang~#; 
