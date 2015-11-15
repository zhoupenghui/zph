/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.5.39 : Database - jingxi
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`jingxi` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `jingxi`;

/*Table structure for table `jx_adminer_admin` */

DROP TABLE IF EXISTS `jx_adminer_admin`;

CREATE TABLE `jx_adminer_admin` (
  `admin_name` varchar(10) DEFAULT NULL COMMENT '管理员名',
  `admin_pwd` varchar(32) DEFAULT NULL,
  `pwd_salt` varchar(30) DEFAULT NULL COMMENT '加盐加密',
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `jx_adminer_admin` */

insert  into `jx_adminer_admin`(`admin_name`,`admin_pwd`,`pwd_salt`,`admin_id`) values ('admin','e10adc3949ba59abbe56e057f20f883e',NULL,2);

/*Table structure for table `jx_goods` */

DROP TABLE IF EXISTS `jx_goods`;

CREATE TABLE `jx_goods` (
  `goods_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(40) NOT NULL COMMENT '商品名字',
  `goods_brand` varchar(40) NOT NULL COMMENT '商品品牌',
  `goods_type` varchar(40) DEFAULT NULL COMMENT '商品类型',
  `goods_num` int(10) DEFAULT NULL COMMENT '商品数量',
  `goods_addr` varchar(100) NOT NULL COMMENT '主图地址',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_weight` decimal(10,3) DEFAULT NULL COMMENT '商品重量',
  `goods_time` int(10) DEFAULT NULL COMMENT '商品上传时间',
  `goods_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '商品更新时间',
  `goods_new` tinyint(1) DEFAULT '0' COMMENT '商品新品',
  `goods_recommend` tinyint(1) DEFAULT '0' COMMENT '商品推荐',
  `goods_hot` tinyint(1) DEFAULT '0' COMMENT '商品热销',
  `goods_delete` tinyint(1) DEFAULT '0' COMMENT '商品是否删除',
  `goods_condition` tinyint(1) DEFAULT '0' COMMENT '商品上架',
  `goods_sale` int(10) DEFAULT NULL COMMENT '商品卖出数量',
  `goods_sn` int(18) DEFAULT NULL COMMENT '商品编号',
  `goods_describe` varchar(100) DEFAULT NULL COMMENT '商品描述(属性)',
  `goods_status` int(11) DEFAULT NULL COMMENT '商品状态',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

/*Data for the table `jx_goods` */

insert  into `jx_goods`(`goods_id`,`goods_name`,`goods_brand`,`goods_type`,`goods_num`,`goods_addr`,`goods_price`,`goods_weight`,`goods_time`,`goods_update`,`goods_new`,`goods_recommend`,`goods_hot`,`goods_delete`,`goods_condition`,`goods_sale`,`goods_sn`,`goods_describe`,`goods_status`) values (1,'苹果','手机',NULL,122,'upload/06.jpg','111.00',NULL,NULL,'2015-09-17 18:23:31',0,0,4,1,0,NULL,NULL,NULL,NULL),(2,'小米','手机',NULL,234,'upload/07.jpg','56.00',NULL,NULL,'2015-09-17 18:23:34',0,1,0,1,0,NULL,NULL,NULL,NULL),(3,'海尔','冰箱',NULL,234,'upload/08.jpg','23.00',NULL,NULL,'2015-09-17 18:23:36',1,2,0,0,0,NULL,NULL,NULL,NULL),(4,'1212','','123123',123,'upload/09.jpg','123123.00','23123.000',1442289397,'2015-09-17 18:23:39',0,1,0,0,1,NULL,21312,'23123213',123),(5,'三大','','123123',12,'upload/10.jpg','123123.00','12312.000',1442289638,'2015-09-17 18:23:45',0,1,0,0,1,NULL,122,'12312',12),(6,'123','','21312',1232,'upload/01.jpg','21312.00','3123.000',1442291241,'2015-09-17 18:23:26',1,1,1,0,1,NULL,121,'21312',1232),(7,'微微','','34123',23423,'upload/01.jpg','1234.00','134123.000',1442291741,'2015-09-17 18:22:26',1,1,1,0,1,NULL,21312,'13432',33423),(8,'点睡','','2312',131,'upload/02.jpg','123123.00','432.000',1442291809,'2015-09-17 18:22:32',1,1,1,0,1,NULL,123,'23424',131),(9,'12','','',100,'upload/03.jpg','127.00','3123.000',1442400445,'2015-09-17 18:22:36',0,1,0,0,1,NULL,88,'',100),(10,'12','','',3,'upload/04.jpg','127.00','3123.000',1442400500,'2015-09-17 18:22:40',0,1,0,0,1,NULL,88,'NIHAO ',3),(11,'12','','',3,'upload/05.jpg','127.00','3123.000',1442400500,'2015-09-17 18:22:46',0,1,0,0,1,NULL,88,'NIHAO ',3),(12,'点睡','','',13432,'upload/20150916/55f9498705882-100_100.png','345.00','432.000',1442400647,'2015-09-16 18:50:47',1,1,0,0,1,NULL,949,'按时发生的',13432),(13,'点睡','','',13432,'upload/20150916/55f949943d342-100_100.png','345.00','432.000',1442400660,'2015-09-16 18:51:00',1,1,0,0,1,NULL,949,'按时发生的',13432),(14,'点睡','','',13432,'upload/20150916/55f949943d342-100_100.png','345.00','432.000',1442400660,'2015-09-16 18:51:00',1,1,0,0,1,NULL,949,'按时发生的',13432),(15,'43243','','',100,'upload/55f7a0614619d.png','12121.00','2.000',1442401274,'2015-09-17 17:28:27',0,1,0,0,1,NULL,550,'',100),(16,'43243','','',100,'upload/55f7a0614619d.png','12121.00','2.000',1442401274,'2015-09-17 17:28:32',0,1,0,0,1,NULL,550,'',100),(17,'dgag','','',100,'upload/20150916/55f94c1a4447e-100_100.png','2313.00','2.000',1442401306,'2015-09-16 19:01:46',0,1,0,0,1,NULL,642,'',100),(18,'dgag','','',100,'upload/20150916/55f94c2ede40f-100_100.png','2313.00','2.000',1442401326,'2015-09-16 19:02:06',0,1,0,0,1,NULL,642,'',100),(19,'dgag','','',100,'upload/20150916/55f94c2ede40f-100_100.png','2313.00','2.000',1442401326,'2015-09-16 19:02:07',0,1,0,0,1,NULL,642,'',100),(20,'法度值v','','',65,'upload/20150916/55f94c6092424-100_100.png','876.00','2.000',1442401376,'2015-09-16 19:02:56',1,1,0,0,1,NULL,180,'76官方公会叫',75),(21,'法度值v','','',65,'upload/20150916/55f94c6092424-100_100.png','876.00','2.000',1442401376,'2015-09-16 19:02:56',1,1,0,0,1,NULL,180,'76官方公会叫',75),(22,'共和国','','',454,'upload/20150916/55f94d0fd0945-100_100.png','5465.00','2.000',1442401551,'2015-09-16 19:05:51',1,1,0,0,1,NULL,497,'订单',554),(23,'共和国','','',454,'upload/20150916/55f94d0fd0945-100_100.png','5465.00','2.000',1442401551,'2015-09-16 19:05:52',1,1,0,0,1,NULL,497,'订单',554),(24,'55 ','','',100,'upload/20150917/55fa16a85967e-100_100.png','555.00','2.000',1442453160,'2015-09-17 09:26:00',0,1,0,0,1,NULL,76,'',100),(25,'55 ','','',100,'upload/20150917/55fa16a85967e-100_100.png','555.00','2.000',1442453160,'2015-09-17 09:26:00',0,1,0,0,1,NULL,76,'',100),(26,'43243','','',100,'upload/20150917/55fa17280cd40-100_100.png','1211.00','2.000',1442453288,'2015-09-17 09:28:08',0,1,0,0,1,NULL,475,'',100),(27,'43243','','',100,'upload/20150917/55fa173dc7d42-100_100.png','1211.00','2.000',1442453309,'2015-09-17 09:28:29',0,1,0,0,1,NULL,475,'',100),(28,'43243','','',100,'upload/20150917/55fa173dc7d42-100_100.png','1211.00','2.000',1442453309,'2015-09-17 09:28:29',0,1,0,0,1,NULL,475,'',100),(29,'43243','','',100,'upload/20150917/55fa178f1c4ef-100_100.png','1211.00','2.000',1442453391,'2015-09-17 09:29:51',0,1,0,0,1,NULL,177,'',100),(30,'43243','','',100,'upload/20150917/55fa178f1c4ef-100_100.png','1211.00','2.000',1442453391,'2015-09-17 09:29:51',0,1,0,0,1,NULL,177,'',100),(31,'12qqqq','','',32,'upload/20150917/55fa17d0cf96f-100_100.png','167.00','2.000',1442453456,'2015-09-17 09:30:56',0,1,0,0,1,NULL,346,'dafs',32),(32,'12qqqq','','',32,'upload/20150917/55fa17d0cf96f-100_100.png','167.00','2.000',1442453456,'2015-09-17 09:30:57',0,1,0,0,1,NULL,346,'dafs',32),(33,'红 红','','',76,'upload/20150917/55fa8c312b272-160_160.jpg','263.00','121.000',1442483249,'2015-09-17 17:47:29',1,1,0,0,1,NULL,454,'这是一个字好东西',76),(34,'红 红','','',76,'upload/20150917/55fa8c312b272-160_160.jpg','263.00','121.000',1442483249,'2015-09-17 17:47:30',1,1,0,0,1,NULL,454,'这是一个字好东西',76),(35,'12','','',3,'upload/05.jpg','127.00','3123.000',1442400500,'2015-09-16 18:48:20',0,1,0,0,1,NULL,88,'NIHAO ',3),(36,'微微','','34123',23423,'upload/01.jpg','1234.00','134123.000',1442291741,'2015-09-17 17:28:25',1,1,1,0,1,NULL,21312,'13432',33423);

/*Table structure for table `jx_goods_brand` */

DROP TABLE IF EXISTS `jx_goods_brand`;

CREATE TABLE `jx_goods_brand` (
  `brand_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '品牌id',
  `brand_name` varchar(20) NOT NULL COMMENT '品牌名称',
  `brand_describe` varchar(200) DEFAULT NULL COMMENT '品牌描述',
  PRIMARY KEY (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `jx_goods_brand` */

insert  into `jx_goods_brand`(`brand_id`,`brand_name`,`brand_describe`) values (1,'诺基亚','诺基亚砖头般质有它没色狼量手机，'),(2,'苹果','苹果的品质，你吃就知道'),(3,'三星','三星，我们只做屏幕'),(4,'oppo','oppo手机，为音乐而生'),(5,'魅族','魅族，我们更懂你'),(6,'HTC','htc尊贵手机'),(7,'锤子手机','锤子手机，全力打造可以开核桃的手机'),(9,'一佳手机','一佳，追求最佳'),(11,'酷派','酷派最普通人的手机\r\n'),(15,'苹果','苹果的品质，你吃就知道'),(17,'魅族','魅族，我们更懂你');

/*Table structure for table `jx_goods_thumb` */

DROP TABLE IF EXISTS `jx_goods_thumb`;

CREATE TABLE `jx_goods_thumb` (
  `thumb_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '相册id',
  `goods_id` int(10) NOT NULL COMMENT '商品id',
  `img_addr` varchar(100) DEFAULT NULL COMMENT '相册地址',
  `thumb_addr` varchar(100) DEFAULT NULL COMMENT '缩略图地址',
  PRIMARY KEY (`thumb_id`),
  KEY `goods_id` (`goods_id`),
  CONSTRAINT `jx_goods_thumb_ibfk_1` FOREIGN KEY (`goods_id`) REFERENCES `jx_goods` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `jx_goods_thumb` */

insert  into `jx_goods_thumb`(`thumb_id`,`goods_id`,`img_addr`,`thumb_addr`) values (14,12,NULL,'upload/thumb/20150917/55fa8c321ced6-350_350.jpg'),(15,12,NULL,'upload/thumb/20150917/55fa8c321f4d7-350_350.jpg'),(16,12,NULL,'upload/thumb/20150917/55fa8c3221cf3-350_350.jpeg'),(17,12,NULL,'upload/thumb/20150917/55fa8c322320e-350_350.jpg'),(19,12,NULL,'upload/thumb/20150917/55fa8c322320e-350_350.jpg'),(20,12,NULL,'upload/thumb/20150917/55fa8c321ced6-350_350.jpg'),(21,12,NULL,'upload/thumb/20150917/55fa8c322320e-350_350.jpg'),(22,12,NULL,'upload/thumb/20150917/55fa8c322320e-350_350.jpg'),(23,12,NULL,'upload/thumb/20150917/55fa8c322320e-350_350.jpg');

/*Table structure for table `jx_goods_type` */

DROP TABLE IF EXISTS `jx_goods_type`;

CREATE TABLE `jx_goods_type` (
  `type_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `type_name` varchar(20) NOT NULL COMMENT '分类名称',
  `parent_id` int(10) DEFAULT NULL COMMENT '父类id',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `jx_goods_type` */

insert  into `jx_goods_type`(`type_id`,`type_name`,`parent_id`) values (2,'电视',0),(3,'空调',0),(4,'手机',0),(5,'长虹电视',2),(6,'长虹TCL',5),(7,'长虹001',5),(8,'黑白电视',2),(9,'黑白TCL',8),(10,'黑白001',8),(11,'长虹002',5),(12,'长虹003',5),(13,'黑白002',8),(14,'黑白003',8),(15,'中央空调',3),(16,'南岗空调',3),(17,'北方空调',3),(18,'中央01',15),(19,'中央02',15),(20,'中央03',16),(21,'梨子手机',4),(22,'桃子手机',4),(23,'梨子1号',21),(24,'梨子2号',21),(25,'桃子1号',22),(26,'桃子2号',22);

/*Table structure for table `jx_leave_msg` */

DROP TABLE IF EXISTS `jx_leave_msg`;

CREATE TABLE `jx_leave_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言ID',
  `user_name` varchar(10) DEFAULT NULL COMMENT '用户名',
  `msg_title` varchar(10) DEFAULT NULL COMMENT '留言标题',
  `msg_type` varchar(10) DEFAULT NULL COMMENT '留言类型',
  `msg_time` int(11) DEFAULT NULL COMMENT '留言时间',
  `msg_status` varchar(10) DEFAULT NULL COMMENT '留言状态',
  `msg_reply` text COMMENT '留言回复',
  `msg_content` text COMMENT '留言内容',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `goods_id` int(10) DEFAULT NULL COMMENT '商品ID',
  PRIMARY KEY (`msg_id`),
  KEY `goods_id` (`goods_id`),
  KEY `jx_leave_msg_ibfk_2` (`user_id`),
  CONSTRAINT `jx_leave_msg_ibfk_1` FOREIGN KEY (`goods_id`) REFERENCES `jx_goods` (`goods_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `jx_leave_msg_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `jx_user_admin` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `jx_leave_msg` */

insert  into `jx_leave_msg`(`msg_id`,`user_name`,`msg_title`,`msg_type`,`msg_time`,`msg_status`,`msg_reply`,`msg_content`,`user_id`,`goods_id`) values (4,'qweq','dgvf ','留言',546,'隐藏','点睡','发鬼地方换个地方就能更好看马甲',2,1),(5,'admin','34地方吃谁知道','投诉',57645,'显示','多少GV是东方红是官方能保存相关 ','大师傅v是的v东方播放功能的发挥到',3,5);

/*Table structure for table `jx_order_list` */

DROP TABLE IF EXISTS `jx_order_list`;

CREATE TABLE `jx_order_list` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_num` int(20) DEFAULT NULL COMMENT '订单号',
  `order_time` datetime DEFAULT NULL COMMENT '下单时间',
  `consignee` varchar(30) DEFAULT NULL COMMENT '收货人',
  `payable` int(10) DEFAULT NULL COMMENT '应付金额',
  `order_status` varchar(20) DEFAULT NULL COMMENT '订单状态',
  `goods_id` int(10) DEFAULT NULL COMMENT '商品ID',
  `email` varchar(20) DEFAULT NULL COMMENT '邮件地址',
  `address` varchar(100) DEFAULT NULL COMMENT '收货地址',
  `phone_number` int(20) DEFAULT NULL COMMENT '联系电话',
  `shipping_method` varchar(10) DEFAULT NULL COMMENT '配送方式',
  `payment` varchar(20) DEFAULT NULL COMMENT '支付方式',
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_num` (`order_num`),
  KEY `goods_id` (`goods_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `jx_order_list_ibfk_1` FOREIGN KEY (`goods_id`) REFERENCES `jx_goods` (`goods_id`),
  CONSTRAINT `jx_order_list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `jx_user_admin` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `jx_order_list` */

insert  into `jx_order_list`(`order_id`,`order_num`,`order_time`,`consignee`,`payable`,`order_status`,`goods_id`,`email`,`address`,`phone_number`,`shipping_method`,`payment`,`user_id`) values (1,1,'2015-09-16 15:26:02','zph',123,NULL,2,'2313wwe','343该奋斗吧',1234,'火车','现金',1),(4,2,'2012-12-12 00:00:00','admin',123,NULL,2,'2313wwe','fdsfds发送',1234567,'火车','现金',1),(6,3,'2014-12-11 00:00:00','zj',123,'未付款',1,'2313wwe','fdsfds发送',1234567,'火车','现金',1),(16,NULL,NULL,'zph',NULL,NULL,NULL,NULL,'343该奋斗吧',1234,NULL,'现金',NULL);

/*Table structure for table `jx_receiving area` */

DROP TABLE IF EXISTS `jx_receiving area`;

CREATE TABLE `jx_receiving area` (
  `province` varchar(10) DEFAULT NULL COMMENT '送货地址（省）',
  `city` varchar(10) DEFAULT NULL COMMENT '送货地址（市）',
  `area` varchar(10) DEFAULT NULL COMMENT '送货地址（区）',
  `deliver_id` int(10) NOT NULL COMMENT '送货地址id',
  PRIMARY KEY (`deliver_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jx_receiving area` */

/*Table structure for table `jx_session` */

DROP TABLE IF EXISTS `jx_session`;

CREATE TABLE `jx_session` (
  `sess_id` varchar(32) NOT NULL,
  `sess_data` text,
  `expire` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`sess_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `jx_session` */

insert  into `jx_session`(`sess_id`,`sess_data`,`expire`) values ('0cub5pom3rlhh76jre784erba7','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442570309),('3t7q406qpob2r1g25nbcdf56v6','code|s:4:\"SZTK\";',1442563174),('4o0j2untlftoc6t4eo20it2536','code|s:4:\"3XJ5\";',1442564239),('5hpc76ad42hngpigj4vrg93nt5','is_login|s:3:\"yes\";name|s:5:\"admin\";goods_name|s:6:\"苹果\";goods_price|s:6:\"111.00\";',1442498644),('5i91bcqkb45vjcm2qg9i561c70','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442560505),('68qijv3rm2knrpk6spb5a4vab7','is_login|s:3:\"yes\";name|s:3:\"zph\";',1442559666),('79nmrv8gj70enplo2llr0eqo01','is_login|s:3:\"yes\";name|s:5:\"admin\";',1442499879),('7tj8pqve6k51dt6qf9qup9gft3','is_login|s:3:\"yes\";name|s:3:\"zph\";',1442567121),('83j2bfu36ivpq8h4d1lvlgbuc1','code|s:4:\"MRTG\";',1442553815),('86518jp5t8n72p2oem43sva9e0','is_login|s:3:\"yes\";name|s:3:\"zph\";',1442563726),('9251c367vfvqnibvgrcsd1eem3','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:6:\"苹果\";goods_price|s:6:\"111.00\";',1442564286),('ahn0st3i39c0d03g2s8sbokot7','is_login|s:3:\"yes\";goods_name|s:6:\"苹果\";goods_price|s:6:\"111.00\";code|s:4:\"RXPW\";',1442496550),('c199ujn1hvrg1tod24d4o3kpb5','is_login|s:3:\"yes\";',1442334130),('coepbgqa4pe69do014ofppm8q7','code|s:4:\"YS0L\";',1442560518),('eatp9c0djest2d8mted8ur3fl2','is_login|s:3:\"yes\";',1442311887),('eukn35cqb7ng9d4q9ku0k9mvk4','is_login|s:3:\"yes\";',1442564872),('it85eg71g57seo9roq17ogmli1','is_login|s:3:\"yes\";goods_name|s:6:\"苹果\";goods_price|s:6:\"111.00\";',1442564219),('knpa9luuaogskunp1jn9857q03','is_login|s:3:\"yes\";name|s:3:\"zph\";',1442509534),('miunh4bq5a8q6r5b4fhdgu02p1','is_login|s:3:\"yes\";name|s:3:\"zph\";code|s:4:\"TYSF\";',1442567648),('mk9unaknf4tnioj1n163j3ln51','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442569760),('ms5bn4co0pu1mcvl991t5trip3','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442560725),('orp8j09611n9eu5cvf7ulqpgu1','is_login|s:3:\"yes\";',1442564972),('pc51nmregshuptqmpk920jlhe7','code|s:4:\"6EHI\";',1442498659),('s8l3jm5m9nrubnf1gnnrcjk4o3','is_login|s:3:\"yes\";name|s:5:\"admin\";',1442499810),('ssp1j94ulihc801uvdhq9e6on0','code|s:4:\"QDTV\";',1442564911),('t984vk383e0n0kfmlge0j3fut0','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:6:\"苹果\";goods_price|s:6:\"111.00\";',1442571060),('u31vd7imf4gjl9iog1k20630o3','is_login|s:3:\"yes\";name|s:3:\"zph\";code|s:4:\"OPA3\";',1442504180),('u5see6a56ofdlfmc3gslkn9o02','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442561928),('ufdrr883fbi1grbp3a41rpd4i3','is_login|s:3:\"yes\";goods_name|s:0:\"\";goods_price|s:0:\"\";',1442560406),('vn4o70be38dv8314505pa9bq56','is_login|s:3:\"yes\";name|s:3:\"zph\";goods_name|s:0:\"\";goods_price|s:0:\"\";code|s:4:\"L1CP\";',1442553804);

/*Table structure for table `jx_ship_order` */

DROP TABLE IF EXISTS `jx_ship_order`;

CREATE TABLE `jx_ship_order` (
  `ship_order_num` int(20) DEFAULT NULL COMMENT '发货单流水号',
  `order_num` int(20) DEFAULT NULL COMMENT '订单号',
  `ship_status` varchar(20) DEFAULT NULL COMMENT '发货单状态',
  `return_time` int(11) DEFAULT NULL COMMENT '退货时间',
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '发货单编号',
  `order_time` int(11) DEFAULT NULL COMMENT '下单时间',
  `consignee` varchar(10) DEFAULT NULL COMMENT '收货人',
  `ship_order_time` int(11) DEFAULT NULL COMMENT '发货时间',
  `supplier` varchar(20) DEFAULT NULL COMMENT '供货商',
  PRIMARY KEY (`order_id`),
  KEY `order_num` (`order_num`),
  CONSTRAINT `jx_ship_order_ibfk_1` FOREIGN KEY (`order_num`) REFERENCES `jx_order_list` (`order_num`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `jx_ship_order` */

insert  into `jx_ship_order`(`ship_order_num`,`order_num`,`ship_status`,`return_time`,`order_id`,`order_time`,`consignee`,`ship_order_time`,`supplier`) values (12312,1,'显示',1233,2,34,'张三',121,'长虹'),(12312,2,'隐藏',2323,3,2312,'李四',34223,'京西 ');

/*Table structure for table `jx_shop` */

DROP TABLE IF EXISTS `jx_shop`;

CREATE TABLE `jx_shop` (
  `shop_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物单ID',
  `goods_name` varchar(40) DEFAULT NULL COMMENT '商品名称',
  `goods_brand` varchar(40) DEFAULT NULL COMMENT '商品品牌',
  `goods_type` varchar(40) DEFAULT NULL COMMENT '商品类型',
  `goods_price` decimal(10,2) DEFAULT NULL COMMENT '商品价格',
  `goods_id` int(11) DEFAULT NULL COMMENT '商品ID',
  PRIMARY KEY (`shop_id`),
  KEY `goods_id` (`goods_id`),
  CONSTRAINT `jx_shop_ibfk_1` FOREIGN KEY (`goods_id`) REFERENCES `jx_goods` (`goods_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `jx_shop` */

/*Table structure for table `jx_switchable` */

DROP TABLE IF EXISTS `jx_switchable`;

CREATE TABLE `jx_switchable` (
  `img_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片轮播id',
  `img_addr` varchar(100) DEFAULT NULL COMMENT '图片地址',
  `img_describe` varchar(200) DEFAULT NULL COMMENT '图片描述',
  `img_view` tinyint(1) DEFAULT '0' COMMENT '图片是否显示',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `jx_switchable` */

insert  into `jx_switchable`(`img_id`,`img_addr`,`img_describe`,`img_view`) values (7,'upload/2.jpg','是否擦',0),(8,'upload/3.jpg','大',0),(9,'upload/5.jpg','受到',0),(10,'upload/4.jpg','几个号',0),(11,'upload/6.jpeg','图片',0),(12,'upload/7.jpg','图片',0),(13,'upload/8.jpg','图片',0),(14,'upload/1.jpg','图片',0),(15,'upload/5.jpg','受到',0);

/*Table structure for table `jx_user_admin` */

DROP TABLE IF EXISTS `jx_user_admin`;

CREATE TABLE `jx_user_admin` (
  `user_name` varchar(10) DEFAULT NULL COMMENT '用户名',
  `user_pwd` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `pwd_salt` varchar(30) DEFAULT NULL COMMENT '加盐加密',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `jx_user_admin` */

insert  into `jx_user_admin`(`user_name`,`user_pwd`,`user_id`,`pwd_salt`) values ('zj','123456',1,'123456'),('qweq','123456',2,NULL),('admin','e10adc3949ba59abbe56e057f20f883c',3,NULL),('zph','28a62e32a6399cb6eb9b749bcebdf7ca',13,'');

/*Table structure for table `jx_userinfo` */

DROP TABLE IF EXISTS `jx_userinfo`;

CREATE TABLE `jx_userinfo` (
  `user_id` int(10) unsigned DEFAULT NULL COMMENT '用户ID',
  `user_name` varchar(10) DEFAULT NULL COMMENT '用户名',
  `email` varchar(20) DEFAULT NULL COMMENT '邮件地址',
  `grade_num` int(10) DEFAULT NULL COMMENT '等级积分',
  `bonus_points` int(10) DEFAULT NULL COMMENT '消费积分',
  `Registration_Date` int(11) DEFAULT NULL COMMENT '注册日期',
  `menber_level` varchar(10) DEFAULT NULL COMMENT '用户等级',
  `sex` varchar(10) DEFAULT NULL COMMENT '性别',
  `birth` varchar(20) DEFAULT NULL COMMENT '出生日期',
  `MSN` float DEFAULT NULL,
  `QQ` float DEFAULT NULL,
  `office_phone` varchar(11) DEFAULT NULL COMMENT '办公电话',
  `home_phone` varchar(11) DEFAULT NULL COMMENT '家庭电话',
  `telephone` varchar(11) DEFAULT NULL COMMENT '手机号',
  `userinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户详细信息编号',
  PRIMARY KEY (`userinfo_id`),
  KEY `user_id_ibfk_1` (`user_id`),
  CONSTRAINT `user_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `jx_user_admin` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `jx_userinfo` */

insert  into `jx_userinfo`(`user_id`,`user_name`,`email`,`grade_num`,`bonus_points`,`Registration_Date`,`menber_level`,`sex`,`birth`,`MSN`,`QQ`,`office_phone`,`home_phone`,`telephone`,`userinfo_id`) values (NULL,'二级会员',' 123214',NULL,NULL,1442252801,'0','1','17-3-17',41324,5636350,'46546','4534654654','21342423543',23),(NULL,'432423',' 123214',222,NULL,1442252801,'0','1','17-3-17',41324,5636350,'46546','4534654654','21342423543',24),(NULL,'12',' 123214',NULL,NULL,1442252801,'0','1','17-3-17',41324,5636350,'46546','4534654654','21342423543',25),(NULL,'33',' 123214',NULL,NULL,1442252801,'0','1','17-3-17',41324,5636350,'46546','4534654654','21342423543',26);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
