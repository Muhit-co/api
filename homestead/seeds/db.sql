# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: muhitapidb.ckx27cjvbdh9.eu-west-1.rds.amazonaws.com (MySQL 5.6.22-log)
# Database: muhit
# Generation Time: 2015-08-18 18:32:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table announcements
# ------------------------------------------------------------

DROP TABLE IF EXISTS `announcements`;

CREATE TABLE `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hood_id` int(10) unsigned NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;

INSERT INTO `announcements` (`id`, `hood_id`, `location`, `title`, `content`, `created_at`, `updated_at`, `user_id`)
VALUES
	(1,1,NULL,'Hola','Sevgili Fenerbahçeliler, 16.04.2015 tarihinde Saat 09.00-14.00 saatleri arasında Kılıç Sokak\'ta elektrik kesilecektir.','2015-06-14 10:00:00','2015-06-14 10:00:00',1);

/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table cities
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cities`;

CREATE TABLE `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,'İstanbul','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'Adana','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,'undefined','2015-08-03 22:44:28','2015-08-03 22:44:28'),
	(4,'İzmir','2015-08-14 10:47:53','2015-08-14 10:47:53');

/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table districts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `districts`;

CREATE TABLE `districts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;

INSERT INTO `districts` (`id`, `city_id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,1,'Şişli','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,1,'Bahçelievler','2015-07-11 16:20:12','2015-07-11 16:20:12'),
	(7,1,'Üsküdar','2015-07-15 14:44:13','2015-07-15 14:44:13'),
	(8,1,'Beyoğlu','2015-07-21 21:31:38','2015-07-21 21:31:38'),
	(9,1,'Beşiktaş','2015-07-25 17:40:58','2015-07-25 17:40:58'),
	(10,3,'Greater London','2015-08-03 22:44:28','2015-08-03 22:44:28'),
	(11,1,'Avcılar','2015-08-06 23:35:49','2015-08-06 23:35:49'),
	(12,1,'Kadıköy','2015-08-12 20:20:56','2015-08-12 20:20:56'),
	(13,1,'Fatih','2015-08-13 09:51:21','2015-08-13 09:51:21'),
	(14,4,'Karşıyaka','2015-08-14 10:47:53','2015-08-14 10:47:53');

/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table hoods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `hoods`;

CREATE TABLE `hoods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(10) unsigned NOT NULL,
  `district_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `hoods` WRITE;
/*!40000 ALTER TABLE `hoods` DISABLE KEYS */;

INSERT INTO `hoods` (`id`, `city_id`, `district_id`, `name`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'Yayla','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,1,6,'Siyavuşpaşa Mahallesi','2015-07-11 16:20:12','2015-07-11 16:20:12'),
	(7,1,7,'Altunizade Mahallesi','2015-07-15 14:44:13','2015-07-15 14:44:13'),
	(8,1,8,'Gümüşsuyu Mahallesi','2015-07-21 21:31:38','2015-07-21 21:31:38'),
	(9,1,9,'Gayrettepe Mahallesi','2015-07-25 17:40:58','2015-07-25 17:40:58'),
	(10,1,8,'Tomtom Mahallesi','2015-07-31 16:06:42','2015-07-31 16:06:42'),
	(11,3,10,'undefined','2015-08-03 22:44:29','2015-08-03 22:44:29'),
	(12,1,8,'Kemankeş Karamustafa Paşa Mahallesi','2015-08-06 20:21:47','2015-08-06 20:21:47'),
	(13,1,9,'Kuruçeşme Mahallesi','2015-08-06 20:29:54','2015-08-06 20:29:54'),
	(14,1,11,'Cihangir Mahallesi','2015-08-06 23:35:49','2015-08-06 23:35:49'),
	(15,1,8,'Cihangir Mahallesi','2015-08-07 15:38:48','2015-08-07 15:38:48'),
	(16,1,8,'Firuzağa Mahallesi','2015-08-11 23:37:10','2015-08-11 23:37:10'),
	(17,1,8,'Kılıçali Paşa Mahallesi','2015-08-12 17:41:30','2015-08-12 17:41:30'),
	(18,1,12,'Fenerbahçe Mahallesi','2015-08-12 20:20:56','2015-08-12 20:20:56'),
	(19,1,13,'Alemdar Mahallesi','2015-08-13 09:51:21','2015-08-13 09:51:21'),
	(20,1,9,'Yıldız Mahallesi','2015-08-13 19:33:16','2015-08-13 19:33:16'),
	(21,4,14,'Yalı Mahallesi','2015-08-14 10:47:53','2015-08-14 10:47:53'),
	(22,1,12,'Sahrayı Cedit Mahallesi','2015-08-14 20:21:44','2015-08-14 20:21:44'),
	(23,1,9,'Abbasağa Mahallesi','2015-08-16 17:16:34','2015-08-16 17:16:34'),
	(24,1,9,'Sinanpaşa Mahallesi','2015-08-16 21:41:42','2015-08-16 21:41:42'),
	(25,1,9,'Etiler Mahallesi','2015-08-17 13:38:21','2015-08-17 13:38:21'),
	(26,1,8,'Ömer Avni Mahallesi','2015-08-18 17:21:12','2015-08-18 17:21:12'),
	(27,1,13,'Cerrah Paşa Mahallesi','2015-08-18 20:55:48','2015-08-18 20:55:48');

/*!40000 ALTER TABLE `hoods` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table issue_images
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issue_images`;

CREATE TABLE `issue_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `issue_images` WRITE;
/*!40000 ALTER TABLE `issue_images` DISABLE KEYS */;

INSERT INTO `issue_images` (`id`, `issue_id`, `image`, `created_at`, `updated_at`)
VALUES
	(23,28,'issues/14388933492952','2015-08-06 23:35:50','2015-08-06 23:35:50'),
	(24,30,'issues/14393904901096','2015-08-12 17:41:30','2015-08-12 17:41:30'),
	(25,30,'issues/14393904909123','2015-08-12 17:41:31','2015-08-12 17:41:31'),
	(26,33,'issues/1439550820719','2015-08-14 14:13:41','2015-08-14 14:13:41');

/*!40000 ALTER TABLE `issue_images` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table issue_reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issue_reports`;

CREATE TABLE `issue_reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `issue_id` bigint(20) unsigned NOT NULL,
  `feedback` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table issue_supporters
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issue_supporters`;

CREATE TABLE `issue_supporters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `issue_supporters` WRITE;
/*!40000 ALTER TABLE `issue_supporters` DISABLE KEYS */;

INSERT INTO `issue_supporters` (`id`, `issue_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(7,29,14,'2015-08-09 23:07:03','2015-08-09 23:07:03'),
	(8,28,14,'2015-08-10 04:34:28','2015-08-10 04:34:28'),
	(9,26,14,'2015-08-11 21:47:56','2015-08-11 21:47:56'),
	(10,27,14,'2015-08-11 21:48:07','2015-08-11 21:48:07'),
	(11,26,8,'2015-08-11 22:27:35','2015-08-11 22:27:35'),
	(12,29,8,'2015-08-11 23:09:11','2015-08-11 23:09:11'),
	(13,30,8,'2015-08-13 10:46:41','2015-08-13 10:46:41'),
	(14,30,14,'2015-08-13 15:26:27','2015-08-13 15:26:27'),
	(15,32,1,'2015-08-13 19:33:42','2015-08-13 19:33:42'),
	(16,33,8,'2015-08-14 14:19:15','2015-08-14 14:19:15'),
	(17,30,11,'2015-08-16 17:10:39','2015-08-16 17:10:39'),
	(18,33,11,'2015-08-16 17:10:47','2015-08-16 17:10:47'),
	(19,34,8,'2015-08-16 21:34:15','2015-08-16 21:34:15'),
	(20,33,14,'2015-08-17 08:41:57','2015-08-17 08:41:57'),
	(21,33,20,'2015-08-18 09:26:53','2015-08-18 09:26:53'),
	(22,34,20,'2015-08-18 09:27:54','2015-08-18 09:27:54'),
	(23,35,20,'2015-08-18 10:29:20','2015-08-18 10:29:20'),
	(24,35,8,'2015-08-18 17:47:57','2015-08-18 17:47:57'),
	(25,36,21,'2015-08-18 19:11:31','2015-08-18 19:11:31');

/*!40000 ALTER TABLE `issue_supporters` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table issue_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issue_tag`;

CREATE TABLE `issue_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` int(10) unsigned NOT NULL,
  `issue_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `issue_tag` WRITE;
/*!40000 ALTER TABLE `issue_tag` DISABLE KEYS */;

INSERT INTO `issue_tag` (`id`, `tag_id`, `issue_id`, `created_at`, `updated_at`)
VALUES
	(1,7,26,'2015-07-31 16:06:42','2015-07-31 16:06:42'),
	(2,8,26,'2015-07-31 16:06:42','2015-07-31 16:06:42'),
	(3,2,27,'2015-08-06 20:29:54','2015-08-06 20:29:54'),
	(4,11,27,'2015-08-06 20:29:54','2015-08-06 20:29:54'),
	(5,1,28,'2015-08-06 23:35:49','2015-08-06 23:35:49'),
	(6,1,29,'2015-08-07 15:38:48','2015-08-07 15:38:48'),
	(7,1,30,'2015-08-12 17:41:30','2015-08-12 17:41:30'),
	(8,11,30,'2015-08-12 17:41:30','2015-08-12 17:41:30'),
	(9,11,31,'2015-08-12 20:20:56','2015-08-12 20:20:56'),
	(10,1,32,'2015-08-13 19:33:16','2015-08-13 19:33:16'),
	(11,9,32,'2015-08-13 19:33:16','2015-08-13 19:33:16'),
	(12,1,33,'2015-08-14 14:13:40','2015-08-14 14:13:40'),
	(13,3,34,'2015-08-16 17:16:34','2015-08-16 17:16:34'),
	(14,1,35,'2015-08-18 10:29:07','2015-08-18 10:29:07'),
	(15,4,35,'2015-08-18 10:29:07','2015-08-18 10:29:07'),
	(16,8,35,'2015-08-18 10:29:07','2015-08-18 10:29:07'),
	(17,1,36,'2015-08-18 17:21:12','2015-08-18 17:21:12'),
	(18,3,36,'2015-08-18 17:21:12','2015-08-18 17:21:12'),
	(19,6,36,'2015-08-18 17:21:12','2015-08-18 17:21:12'),
	(20,7,36,'2015-08-18 17:21:12','2015-08-18 17:21:12'),
	(21,8,36,'2015-08-18 17:21:12','2015-08-18 17:21:12');

/*!40000 ALTER TABLE `issue_tag` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table issue_updates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issue_updates`;

CREATE TABLE `issue_updates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `issue_id` bigint(20) unsigned NOT NULL,
  `old_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `new_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `issue_updates` WRITE;
/*!40000 ALTER TABLE `issue_updates` DISABLE KEYS */;

INSERT INTO `issue_updates` (`id`, `user_id`, `issue_id`, `old_status`, `new_status`, `created_at`, `updated_at`)
VALUES
	(38,6,26,'n/a','new','2015-07-31 16:06:42','2015-07-31 16:06:42'),
	(39,1,27,'n/a','new','2015-08-06 20:29:54','2015-08-06 20:29:54'),
	(40,6,28,'n/a','new','2015-08-06 23:35:50','2015-08-06 23:35:50'),
	(41,8,29,'n/a','new','2015-08-07 15:38:48','2015-08-07 15:38:48'),
	(42,1,30,'n/a','new','2015-08-12 17:41:31','2015-08-12 17:41:31'),
	(43,8,31,'n/a','new','2015-08-12 20:20:56','2015-08-12 20:20:56'),
	(44,8,31,'new','deleted','2015-08-12 20:21:15','2015-08-12 20:21:15'),
	(45,6,26,'new','deleted','2015-08-13 15:24:57','2015-08-13 15:24:57'),
	(46,6,27,'new','deleted','2015-08-13 15:25:10','2015-08-13 15:25:10'),
	(47,6,28,'new','deleted','2015-08-13 15:25:23','2015-08-13 15:25:23'),
	(48,8,29,'new','deleted','2015-08-13 19:18:01','2015-08-13 19:18:01'),
	(49,1,32,'n/a','new','2015-08-13 19:33:16','2015-08-13 19:33:16'),
	(50,8,33,'n/a','new','2015-08-14 14:13:41','2015-08-14 14:13:41'),
	(51,11,34,'n/a','new','2015-08-16 17:16:34','2015-08-16 17:16:34'),
	(52,20,35,'n/a','new','2015-08-18 10:29:07','2015-08-18 10:29:07'),
	(53,9,36,'n/a','new','2015-08-18 17:21:12','2015-08-18 17:21:12');

/*!40000 ALTER TABLE `issue_updates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table issues
# ------------------------------------------------------------

DROP TABLE IF EXISTS `issues`;

CREATE TABLE `issues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'new',
  `city_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `hood_id` int(10) unsigned DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_anonymous` tinyint(1) NOT NULL DEFAULT '0',
  `coordinates` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `supporter_count` int(11) NOT NULL DEFAULT '0',
  `problem` text COLLATE utf8_unicode_ci NOT NULL,
  `solution` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `issues` WRITE;
/*!40000 ALTER TABLE `issues` DISABLE KEYS */;

INSERT INTO `issues` (`id`, `user_id`, `title`, `status`, `city_id`, `district_id`, `hood_id`, `location`, `created_at`, `updated_at`, `is_anonymous`, `coordinates`, `deleted_at`, `supporter_count`, `problem`, `solution`)
VALUES
	(26,6,'Şehrimde daha ağaçlar olsun','new',0,0,0,'Tomtom Mahallesi, Beyoğlu, İstanbul','2015-07-31 16:06:42','2015-08-13 15:24:57',0,'41.031510399999995, 28.9781476','2015-08-13 15:24:57',2,'Fazla az ağaclar','Daha ağaclar koymak'),
	(27,1,'Placeholder','new',1,9,13,'Kuruçeşme Mahallesi, Beşiktaş, İstanbul','2015-08-06 20:29:54','2015-08-13 15:25:10',0,'41.059400100000005, 29.0355414','2015-08-13 15:25:10',1,'Fikir detay sayfasında linkler çalışmıyor.','Bu test fikrini oluşturup, iyice bakıp çözelim.'),
	(28,6,'More plants for everyone','new',1,11,14,'Cihangir Mahallesi, Avcılar, İstanbul','2015-08-06 23:35:49','2015-08-13 15:25:23',0,'','2015-08-13 15:25:23',1,'Gidecek','Geçinmekte'),
	(29,8,'Sıraselviler daha yürünebilir bir cadde olsun.','new',1,8,15,'Cihangir Mahallesi, Beyoğlu, İstanbul','2015-08-07 15:38:48','2015-08-13 19:18:01',0,'','2015-08-13 19:18:01',2,'Sıraselviler caddesinde araçlar bekleme yaptığı için dar kaldırımlarda yürümek çok zor oluyor.','Yeni bir düzenleme ile bu çok işlek cadde daha yaya dostu bir yer haline gelmeli.\r\n'),
	(30,1,'Karakoy yollari duzenlensin','new',1,8,17,'Kılıçali Paşa Mahallesi, Beyoğlu, İstanbul','2015-08-12 17:41:30','2015-08-12 17:41:30',0,'41.0255196, 28.982529',NULL,3,'Alt yapi guncellemesi nedeniyle kazilan ve kalici bir sekilde doldurulmayan yollar hem turistler hem de her gun bolgede olan yerel halki cok zorluyor. ','Yollarin kalici bir sekilde tamamlanmasi ve arac trafiginr mumkun olcude kapatilmasi hem bolgenim artan potansiyeline katki saglayacak hem de yasayanlarin hayat standardini yukseltecektir. '),
	(31,8,'Fikir','new',1,12,18,'Fenerbahçe Mahallesi, Kadıköy, İstanbul','2015-08-12 20:20:56','2015-08-12 20:21:15',0,'','2015-08-12 20:21:15',0,'Sorun','Çözüm'),
	(32,1,'Test fikri','new',1,9,20,'Yıldız Mahallesi, Beşiktaş, İstanbul','2015-08-13 19:33:16','2015-08-13 19:33:16',0,'41.0419651, 29.009070899999994',NULL,1,'sitedeki sorun olmasa','çözümler de olmaz'),
	(33,8,'Sıraselviler yürünebilir bir cadde olsun.','new',1,8,15,'Cihangir Mahallesi, Beyoğlu, İstanbul','2015-08-14 14:13:40','2015-08-14 14:13:40',0,'',NULL,4,'Sıraselviler caddesinde araçlar bekleme yaptığı için dar kaldırımlarda yürümek çok zor oluyor. ','Yeni bir düzenleme ile araç işgali önlenmeli. Kaldırımlar genişletilerek bu çok işlek cadde daha yaya dostu bir yer haline gelmeli.'),
	(34,11,'Beşiktaş Sahil boyunca Bisiklet Yolu Yapılsın','new',1,9,23,'Abbasağa Mahallesi, Beşiktaş, İstanbul','2015-08-16 17:16:34','2015-08-16 17:16:34',0,'41.0491555, 29.0044182',NULL,2,'kabataştan bebeğe kadar olan hat bisikletlilerin sıkça kullandığı bir güzergah ve güvenli bir bisiklet yolu yok','kabataştan bebeğe kadar kesintisiz bir bisiklet yolu yapılsın'),
	(35,20,'Fenerbahçe burnuna giden yolun trafik sorunu çözülmeli.','new',1,12,18,'Fenerbahçe Mahallesi, Kadıköy, İstanbul','2015-08-18 10:29:07','2015-08-18 10:29:07',0,'',NULL,2,'Fenerbahçe\'de akşamüstünden itibaren başlayan trafik, vale servisi dolayısıyla tıkanmaktadır. Dört  şeritli Fenerkalamış caddesi neredeyse ilerlemeyen tek bir şeride inerek kafe, lokanta ve eğlence yerleri tarafından işgal edilmekte, kimliği belirsiz kişiler tarafından vale hizmeti altında kayıt dışı otopark ücreti toplanmaktadır. Bu kolay kazanılan paranın getirdiği gelirin yüksekliği dört şeritli yolun sıklıkla kapanmasına sebep olmaktadır.','Öncelikle trafiğin akışını rahatlatmak için yol kenarına belediyenin otopark hizmeti koyması, (otomat ya da otopark görevlisi olabilir) otopark ücretlerinin kayıt altına alması ve bir trafik polis ekibinin oluşturulması bu sorunu kolayca çözebilir. Alternatif olarak araçla gelenler burun tarafındaki otopark alanlarına yönlendirilebilir. Denizle yeşilin, ağaçların buluştuğu yegane parklarımızdan biri burada. Oksijen almak, rahatlamak için gittiğimiz Fenerbahçe parkına ulaşmak için çok zorluk yaşıyoruz. Bize bu yol akışını sağlayacak kişilere şimdiden şükranlarımı sunarım.'),
	(36,9,'Beşiktaş sahil yolu düzenlensin','new',1,8,26,'Ömer Avni Mahallesi, Beyoğlu, İstanbul','2015-08-18 17:21:12','2015-08-18 17:21:12',0,'41.0326996, 28.989647500000004',NULL,1,'Düzensiz Beşiktaş sahil yolu','Sahil düzenlemesi yapılsın');

/*!40000 ALTER TABLE `issues` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2015_01_01_000001_create_oauth_scopes_table',1),
	('2015_01_01_000002_create_oauth_grants_table',1),
	('2015_01_01_000003_create_oauth_grant_scopes_table',1),
	('2015_01_01_000004_create_oauth_clients_table',1),
	('2015_01_01_000005_create_oauth_client_endpoints_table',1),
	('2015_01_01_000006_create_oauth_client_scopes_table',1),
	('2015_01_01_000007_create_oauth_client_grants_table',1),
	('2015_01_01_000008_create_oauth_sessions_table',1),
	('2015_01_01_000009_create_oauth_session_scopes_table',1),
	('2015_01_01_000010_create_oauth_auth_codes_table',1),
	('2015_01_01_000011_create_oauth_auth_code_scopes_table',1),
	('2015_01_01_000012_create_oauth_access_tokens_table',1),
	('2015_01_01_000013_create_oauth_access_token_scopes_table',1),
	('2015_01_01_000014_create_oauth_refresh_tokens_table',1),
	('2015_05_17_152813_users',1),
	('2015_05_24_124227_create_cities_table',1),
	('2015_05_24_124315_create_districts_table',1),
	('2015_05_24_124404_create_hoods_table',1),
	('2015_05_24_124555_users_active_hood',1),
	('2015_05_24_124704_users_level',1),
	('2015_05_24_171356_create_tags_table',2),
	('2015_05_24_171746_create_issues_table',2),
	('2015_05_24_171938_create_issue_images_table',2),
	('2015_05_24_172033_create_comments_table',2),
	('2015_05_24_172122_create_issue_updates_table',2),
	('2015_06_14_161107_create_announcements_table',3),
	('2015_06_14_164208_announcement_user_id',3),
	('2015_07_05_152000_anonym_issues',4),
	('2015_07_11_152724_issue_coordinates',5),
	('2015_07_11_161109_issuesSoftDeletes',5),
	('2015_07_11_181135_user_hood_and_verify',6),
	('2015_07_11_181836_user_is_verified',6),
	('2015_07_11_195843_issue_supporters',7),
	('2015_07_30_152333_issue_supporter_count',8),
	('2015_07_31_152048_issues_title_problem_solution',9),
	('2015_08_12_190228_issue_reports',10);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_access_token_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_access_token_scopes`;

CREATE TABLE `oauth_access_token_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_access_token_scopes_access_token_id_index` (`access_token_id`),
  KEY `oauth_access_token_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_access_token_scopes_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_access_token_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_access_tokens`;

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_access_tokens_id_session_id_unique` (`id`,`session_id`),
  KEY `oauth_access_tokens_session_id_index` (`session_id`),
  CONSTRAINT `oauth_access_tokens_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;

INSERT INTO `oauth_access_tokens` (`id`, `session_id`, `expire_time`, `created_at`, `updated_at`)
VALUES
	('714fU9Ui0pOuLUvVoOxJsUdItSEUD3Hc8EAbHnTr',33,1438979240,'2015-07-08 23:27:20','2015-07-08 23:27:20'),
	('d1thCyjbzgjZut47fmpALQ98f7tSaLqyC0kjaCdo',31,1438697896,'2015-07-05 17:18:16','2015-07-05 17:18:16'),
	('fBqpIQkmpOnIzKqTsbxT8P3fjre10j1ChIYgbWLB',44,1440431127,'2015-07-25 18:45:27','2015-07-25 18:45:27'),
	('fQsXcD5ZkxSiNtBGk4BR5Bj9PCFhrp1qxa9uSpnN',39,1439205104,'2015-07-11 14:11:44','2015-07-11 14:11:44'),
	('h26GqNqgefj1Qf3UgHUVRtkmjgH6qLdCflAoQoYN',43,1437567508,'2015-07-15 15:18:28','2015-07-15 15:18:28'),
	('haQik0AMVOq5pIb2wyHnDGX2spQLLOfxFQPBffMR',32,1438979099,'2015-07-08 23:24:59','2015-07-08 23:24:59'),
	('iG9a22os0GhZsNYiCmqQ0YKQtrw6qphHauhVRKDJ',40,1439205505,'2015-07-11 14:18:25','2015-07-11 14:18:25'),
	('IWbQvBMBrcOh9QtQhMLVIjhDFLSgXswKLvIfYbA0',35,1438979916,'2015-07-08 23:38:36','2015-07-08 23:38:36'),
	('KBlowoNrFKmZ856x9S9HnpwBJW96UpPFkjwQUWY2',36,1438980776,'2015-07-08 23:52:56','2015-07-08 23:52:56'),
	('ntDXxQrzO8zHb4eWEl7rbBz23XbX7cqXmnrKmOIW',38,1439203501,'2015-07-11 13:45:01','2015-07-11 13:45:01'),
	('oF4uNy5HRqWODGZGg28hMZrhXnhmjJLnWIhVFsWP',30,1438693146,'2015-07-05 15:59:06','2015-07-05 15:59:06'),
	('oF5fvaVtawaw5RZ1JtOg4xsYJul4fAV95k5nCyWI',37,1438981168,'2015-07-08 23:59:28','2015-07-08 23:59:28'),
	('pWTQcQKXnA12AMjsnZeCiOLGuSgXpBNIFB3u7v2w',29,1438688362,'2015-07-05 14:39:22','2015-07-05 14:39:22'),
	('qkXdKIgOCRdCOaFKJc5rHuoaWuGDsAGxX2AqNdp5',41,1439553694,'2015-07-15 15:01:34','2015-07-15 15:01:34'),
	('ShWVBwFlWYOJikwBbTmk7vZYzboMfjNZsdFxsioq',27,1438269374,'2015-06-30 18:16:14','2015-06-30 18:16:14'),
	('soOxGCexMS4A2wS8TIvEf95OK7ubus1ZI76SljC4',28,1438274440,'2015-06-30 19:40:40','2015-06-30 19:40:40'),
	('vOgAzmLdNh352UDp2WgtUvfOkCJxoAzmU9SNss4h',45,1440597846,'2015-07-27 17:04:06','2015-07-27 17:04:06'),
	('zSdnK4jOGR6TiekOftRJVGMoYUJhgKINDGwJ9rlz',42,1439553779,'2015-07-15 15:02:59','2015-07-15 15:02:59'),
	('zZ7PK1Y7vbrhsKvo8rLAT6QGQJ4GGJeL6Vzk3Ci2',34,1438979679,'2015-07-08 23:34:39','2015-07-08 23:34:39');

/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_auth_code_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_auth_code_scopes`;

CREATE TABLE `oauth_auth_code_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `auth_code_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_code_scopes_auth_code_id_index` (`auth_code_id`),
  KEY `oauth_auth_code_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_auth_code_scopes_auth_code_id_foreign` FOREIGN KEY (`auth_code_id`) REFERENCES `oauth_auth_codes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_auth_code_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_auth_codes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_auth_codes`;

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `session_id` int(10) unsigned NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_session_id_index` (`session_id`),
  CONSTRAINT `oauth_auth_codes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_client_endpoints
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_client_endpoints`;

CREATE TABLE `oauth_client_endpoints` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_client_endpoints_client_id_redirect_uri_unique` (`client_id`,`redirect_uri`),
  CONSTRAINT `oauth_client_endpoints_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_client_grants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_client_grants`;

CREATE TABLE `oauth_client_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_grants_client_id_index` (`client_id`),
  KEY `oauth_client_grants_grant_id_index` (`grant_id`),
  CONSTRAINT `oauth_client_grants_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `oauth_client_grants_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_client_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_client_scopes`;

CREATE TABLE `oauth_client_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_client_scopes_client_id_index` (`client_id`),
  KEY `oauth_client_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_client_scopes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_client_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_clients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_clients`;

CREATE TABLE `oauth_clients` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_clients_id_secret_unique` (`id`,`secret`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;

INSERT INTO `oauth_clients` (`id`, `secret`, `name`, `created_at`, `updated_at`)
VALUES
	('1','1','test','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_grant_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_grant_scopes`;

CREATE TABLE `oauth_grant_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `grant_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_grant_scopes_grant_id_index` (`grant_id`),
  KEY `oauth_grant_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_grant_scopes_grant_id_foreign` FOREIGN KEY (`grant_id`) REFERENCES `oauth_grants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_grant_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_grants
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_grants`;

CREATE TABLE `oauth_grants` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_refresh_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_refresh_tokens`;

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `access_token_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `expire_time` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`access_token_id`),
  UNIQUE KEY `oauth_refresh_tokens_id_unique` (`id`),
  CONSTRAINT `oauth_refresh_tokens_access_token_id_foreign` FOREIGN KEY (`access_token_id`) REFERENCES `oauth_access_tokens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;

INSERT INTO `oauth_refresh_tokens` (`id`, `access_token_id`, `expire_time`, `created_at`, `updated_at`)
VALUES
	('qxFI273ZwcLy5S5IM6zXxKRiCcHYGQ4OYCl5JQmL','714fU9Ui0pOuLUvVoOxJsUdItSEUD3Hc8EAbHnTr',1451939240,'2015-07-08 23:27:20','2015-07-08 23:27:20'),
	('1vNVLJt5ycyzGXq4PWPJxRQ0eBtfsK36dH2629rt','d1thCyjbzgjZut47fmpALQ98f7tSaLqyC0kjaCdo',1451657896,'2015-07-05 17:18:16','2015-07-05 17:18:16'),
	('CG4Ezj0bwf4aBmSj85rq2v0wJpmmILMnqkMrVYn8','fBqpIQkmpOnIzKqTsbxT8P3fjre10j1ChIYgbWLB',1453391127,'2015-07-25 18:45:27','2015-07-25 18:45:27'),
	('7NCZhNFFiw4nxwu0oPyWiq0rt3phaarNxwaTGrc0','fQsXcD5ZkxSiNtBGk4BR5Bj9PCFhrp1qxa9uSpnN',1452165104,'2015-07-11 14:11:44','2015-07-11 14:11:44'),
	('3oo1yoVgQIxKhWYEyOVS2MW6fsZxq7DThdxVTZME','h26GqNqgefj1Qf3UgHUVRtkmjgH6qLdCflAoQoYN',1452514708,'2015-07-15 15:18:28','2015-07-15 15:18:28'),
	('tRLcez7lxwAvuWYmNkQ4K0HIei7zXx0JjtYqxcPM','haQik0AMVOq5pIb2wyHnDGX2spQLLOfxFQPBffMR',1451939099,'2015-07-08 23:24:59','2015-07-08 23:24:59'),
	('3wwOb87LkLigABOkv6h5ETfDbjlO3x3Mo6keFKJY','iG9a22os0GhZsNYiCmqQ0YKQtrw6qphHauhVRKDJ',1452165505,'2015-07-11 14:18:25','2015-07-11 14:18:25'),
	('YY7WEihjHcGuzGwGYO1kO4CoYHha0rK1ER9a8IPC','IWbQvBMBrcOh9QtQhMLVIjhDFLSgXswKLvIfYbA0',1451939916,'2015-07-08 23:38:36','2015-07-08 23:38:36'),
	('vN9cGXXHP8cwgIaF02Z9qzIC1wzPaEVJ3xRpjstF','KBlowoNrFKmZ856x9S9HnpwBJW96UpPFkjwQUWY2',1451940776,'2015-07-08 23:52:56','2015-07-08 23:52:56'),
	('lyOyTTmc1DZtuV3IdKI2FmJmobahjxjb6T18bYUk','ntDXxQrzO8zHb4eWEl7rbBz23XbX7cqXmnrKmOIW',1452163501,'2015-07-11 13:45:01','2015-07-11 13:45:01'),
	('aywSEMBBBXJxrAUaCCgvydt0XuCXedB1ALvxBcjj','oF4uNy5HRqWODGZGg28hMZrhXnhmjJLnWIhVFsWP',1451653146,'2015-07-05 15:59:06','2015-07-05 15:59:06'),
	('CwfohXo5lMzCpMzrEJ3rZweCoFDfAl3qvCwGSk5b','oF5fvaVtawaw5RZ1JtOg4xsYJul4fAV95k5nCyWI',1451941168,'2015-07-08 23:59:28','2015-07-08 23:59:28'),
	('qZNNsgqFjTR7Fz4RnixslDZNA9M15YURwjaZW7vu','pWTQcQKXnA12AMjsnZeCiOLGuSgXpBNIFB3u7v2w',1451648362,'2015-07-05 14:39:22','2015-07-05 14:39:22'),
	('i3RMIVCKeVKMDsQLBKAxhEOPRjUKn97eE3EXmlGc','qkXdKIgOCRdCOaFKJc5rHuoaWuGDsAGxX2AqNdp5',1452513694,'2015-07-15 15:01:34','2015-07-15 15:01:34'),
	('keB2NqHyg5LTfLSUPz2mBHvO4oGT3Uv2CXnxXIAm','ShWVBwFlWYOJikwBbTmk7vZYzboMfjNZsdFxsioq',1451229374,'2015-06-30 18:16:14','2015-06-30 18:16:14'),
	('wUbv7q0BHbPLzfFCtaftujvpYW1rpeAim0Mddm2W','soOxGCexMS4A2wS8TIvEf95OK7ubus1ZI76SljC4',1451234440,'2015-06-30 19:40:40','2015-06-30 19:40:40'),
	('peNcAeTmipycscJdesaEzUMVANpjCIQ3H28pVrp6','vOgAzmLdNh352UDp2WgtUvfOkCJxoAzmU9SNss4h',1453557846,'2015-07-27 17:04:06','2015-07-27 17:04:06'),
	('yxtfNMKeYr6ZflqSYlShnTFldXHjvVIWPs9Q9SlO','zSdnK4jOGR6TiekOftRJVGMoYUJhgKINDGwJ9rlz',1452513779,'2015-07-15 15:02:59','2015-07-15 15:02:59'),
	('i0TiqeFulT43duhQEkykgx0pTcQ4wcHR3IxLwknB','zZ7PK1Y7vbrhsKvo8rLAT6QGQJ4GGJeL6Vzk3Ci2',1451939679,'2015-07-08 23:34:39','2015-07-08 23:34:39');

/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_scopes`;

CREATE TABLE `oauth_scopes` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;

INSERT INTO `oauth_scopes` (`id`, `description`, `created_at`, `updated_at`)
VALUES
	('1','default','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table oauth_session_scopes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_session_scopes`;

CREATE TABLE `oauth_session_scopes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(10) unsigned NOT NULL,
  `scope_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_session_scopes_session_id_index` (`session_id`),
  KEY `oauth_session_scopes_scope_id_index` (`scope_id`),
  CONSTRAINT `oauth_session_scopes_scope_id_foreign` FOREIGN KEY (`scope_id`) REFERENCES `oauth_scopes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `oauth_session_scopes_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `oauth_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table oauth_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `oauth_sessions`;

CREATE TABLE `oauth_sessions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `owner_type` enum('client','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `owner_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_redirect_uri` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `oauth_sessions_client_id_owner_type_owner_id_index` (`client_id`,`owner_type`,`owner_id`),
  CONSTRAINT `oauth_sessions_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `oauth_clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `oauth_sessions` WRITE;
/*!40000 ALTER TABLE `oauth_sessions` DISABLE KEYS */;

INSERT INTO `oauth_sessions` (`id`, `client_id`, `owner_type`, `owner_id`, `client_redirect_uri`, `created_at`, `updated_at`)
VALUES
	(27,'1','user','1',NULL,'2015-06-30 18:16:14','2015-06-30 18:16:14'),
	(28,'1','user','1',NULL,'2015-06-30 19:40:40','2015-06-30 19:40:40'),
	(29,'1','user','1',NULL,'2015-07-05 14:39:22','2015-07-05 14:39:22'),
	(30,'1','user','5',NULL,'2015-07-05 15:59:06','2015-07-05 15:59:06'),
	(31,'1','user','5',NULL,'2015-07-05 17:18:16','2015-07-05 17:18:16'),
	(32,'1','user','5',NULL,'2015-07-08 23:24:59','2015-07-08 23:24:59'),
	(33,'1','user','5',NULL,'2015-07-08 23:27:20','2015-07-08 23:27:20'),
	(34,'1','user','5',NULL,'2015-07-08 23:34:39','2015-07-08 23:34:39'),
	(35,'1','user','5',NULL,'2015-07-08 23:38:36','2015-07-08 23:38:36'),
	(36,'1','user','5',NULL,'2015-07-08 23:52:56','2015-07-08 23:52:56'),
	(37,'1','user','5',NULL,'2015-07-08 23:59:28','2015-07-08 23:59:28'),
	(38,'1','user','5',NULL,'2015-07-11 13:45:01','2015-07-11 13:45:01'),
	(39,'1','user','5',NULL,'2015-07-11 14:11:44','2015-07-11 14:11:44'),
	(40,'1','user','5',NULL,'2015-07-11 14:18:25','2015-07-11 14:18:25'),
	(41,'1','user','5',NULL,'2015-07-15 15:01:34','2015-07-15 15:01:34'),
	(42,'1','user','5',NULL,'2015-07-15 15:02:59','2015-07-15 15:02:59'),
	(43,'1','user','5',NULL,'2015-07-15 15:18:28','2015-07-15 15:18:28'),
	(44,'1','user','5',NULL,'2015-07-25 18:45:27','2015-07-25 18:45:27'),
	(45,'1','user','5',NULL,'2015-07-27 17:04:06','2015-07-27 17:04:06');

/*!40000 ALTER TABLE `oauth_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`id`, `name`, `background`, `created_at`, `updated_at`)
VALUES
	(1,'Yaya','f2b42c','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(2,'Aydınlatma','eae657','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(3,'Bisiklet','e8a0c1','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(4,'Trafik ışığı','ea6d4b','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(6,'Sürdürülebilir','7dd3ac','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(7,'Ağaçlandırma','a7cc81','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(8,'Park','7ea56d','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(9,'Enerji','c673c0','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(10,'Geri dönüşüm','c4a26c','0000-00-00 00:00:00','0000-00-00 00:00:00'),
	(11,'Diğer','ccccdd','0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_social_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_social_accounts`;

CREATE TABLE `user_social_accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `user_social_accounts` WRITE;
/*!40000 ALTER TABLE `user_social_accounts` DISABLE KEYS */;

INSERT INTO `user_social_accounts` (`id`, `user_id`, `source`, `source_id`, `access_token`, `created_at`, `updated_at`)
VALUES
	(1,5,'facebook','851074154986461','CAAUuUHZAVlSoBAKf0xXLp0eLuZC8uNC1PIHDPoznjjVroejZAiMjsQcN4QTVeGfF4ZA6brlenuaIXVCusuajTOoE58JiNiPbAg8QiUAKIMjmSS7OTpF0LfKvQhLTp4emWFt3Eflcpvk6w7s7ZBGCSRoEEXg0xOYTD2FD5vECKSZAHHsctXh2kg0VNW5pphooCPIq3UtRaklVFS4FJrrnZAFsHcej32JMwDGUktlRRttJgZDZD','2015-06-18 12:55:26','2015-06-18 12:55:26');

/*!40000 ALTER TABLE `user_social_accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'placeholders/profile.png',
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `level` int(11) NOT NULL DEFAULT '0',
  `hood_id` int(11) DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `coordinates` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `email`, `first_name`, `last_name`, `picture`, `password`, `remember_token`, `created_at`, `updated_at`, `level`, `hood_id`, `location`, `coordinates`, `is_verified`)
VALUES
	(1,'gcg','guneycan@gmail.com','Guney Can','Gokoglu','placeholders/profile.png','$2y$10$BANroyFEJSWXHCgDZGk4ku4/gV3trb09QasOIVFDJ1ZpYs6o9hCOu',NULL,'2015-05-24 12:54:18','2015-05-24 12:54:18',0,NULL,NULL,NULL,0),
	(2,'emre-yanik','emre@emre.co','emre','yanik','placeholders/profile.png','$2y$10$MXQCOm3/lZIjpaY1tx8mAeJDSpyFo88L2I.6pcYKRjFSpIyj9n8eO',NULL,'2015-06-14 17:09:44','2015-06-14 17:09:44',0,NULL,NULL,NULL,0),
	(3,'emre-yanik1434293703','emre@emre.com','emre','yanik','placeholders/profile.png','$2y$10$Zm7Nt8Ld7ym/scKsQgaa3.s08k.IoHJgL1EElJkH4AVRnuVhjcpK6',NULL,'2015-06-14 17:55:03','2015-06-14 17:55:03',0,NULL,NULL,NULL,0),
	(4,'emre-yanik1434293753','emre@emre.comm','emre','yanik','placeholders/profile.png','$2y$10$84c4mvvZn4IfBgRdBYyEReAWQoSBz7sLHY1HpLjPmNl92UwuHuK7m',NULL,'2015-06-14 17:55:53','2015-06-14 17:55:53',0,NULL,NULL,NULL,0),
	(5,'emre-yanik1434396350','emreyanik89@gmail.com','Emre','Yanık','placeholders/profile.png','$2y$10$L1c2o9xHks7TX7MfWJRgWeU8QuD4JbFCUBP1/PX5AwMi0K6o66C5C','s22vabqpXHEg95NtFsoksYlLHblbRPPIGrPyS0yMwvgXAJhqXN3yIMRyZ701','2015-06-15 22:25:50','2015-06-27 15:46:36',0,NULL,NULL,NULL,0),
	(6,'daniel-swakman','hello@ldaniel.eu','Daniel','Swakman','placeholders/profile.png','$2y$10$hjB7uYZ3fC/VBzP23dJ.QOKxFiBmzZ1HgpCz9IKwRHwGSen/08sLC','ybtFKPlSCzogOQWodcA9TlLaviiOSe7jBLkxh7MbfM24zG7VtuJdDR8prXPN','2015-06-20 17:38:51','2015-08-18 21:30:05',10,NULL,NULL,NULL,0),
	(7,'sera-tolgay','seratolgay@gmail.com','Sera','Tolgay','placeholders/profile.png','$2y$10$eaRdD1c.bBE46tycQ1o2eeJssHZtEcxcbuoSZmP56avLOhp83umc6',NULL,'2015-06-21 10:15:51','2015-06-21 10:15:51',10,NULL,NULL,NULL,0),
	(8,'sera-tolgay1434896057','seratolgay@mac.com','Sera','Tolgay','placeholders/profile.png','$2y$10$I7OcHGNtx9k0hK5BsOJt8e2In/QOCWKCaxx4pelOenIuFRicncKji','7QrHBw8dOQ46YHlkP2wiD0QBLLGp2eWTQqjmV5m4L8NilZNa9J6K8YzLsKrA','2015-06-21 17:14:18','2015-08-12 19:59:38',0,15,'Cihangir Mahallesi, Beyoğlu, İstanbul',NULL,0),
	(9,'ece-omur','eceomur1@gmail.com','Ece','Ömür','placeholders/profile.png','$2y$10$Wy/dY8Yl1bMYfZCf3uBx3.vH7M5Qb8T0gq0kK9vf2mxT12lSQfR0G','kl4uHw1vSFAuSDk8XiWn4GoZSc8Etc9tJnKYlvFYhajyLxW4ifB0PTDnYe1L','2015-06-22 21:35:02','2015-06-22 21:49:38',10,NULL,NULL,NULL,0),
	(10,'bulent-ekuklu','bulentek@yahoo.com','Bulent','Ekuklu','placeholders/profile.png','$2y$10$sgQaX45Dqf6ZbR0VoZ9ryO2sDfL5c5pChgHj3t7oSkW3FJky4D5Du',NULL,'2015-06-26 12:41:38','2015-06-26 12:41:38',0,NULL,NULL,NULL,0),
	(11,'anil-arpat','anilarpat@gmail.com','Anıl','Arpat','placeholders/profile.png','$2y$10$HNVQ.2oLJgd4NLST6Q80qukecFBAYX1U65hDZDDWLVmx29sTrS4eq',NULL,'2015-06-27 16:18:14','2015-06-27 16:18:14',0,NULL,NULL,NULL,0),
	(12,'-','','','','placeholders/profile.png','$2y$10$/rvt9M6kyaoib1QKnsUVYO8kv3tuzitf.c3BF./5u6Paz.j7V3GD.','4uODszNwY86VgYDFYUTIGJSDXpUZLDbykXiv9SSmsdKyfGnJTf2bZI1IuBxT','2015-07-29 12:36:40','2015-07-29 12:36:51',0,NULL,NULL,NULL,0),
	(13,'serra-toygar','snowblues1@yahoo.com','Serra','Toygar','placeholders/profile.png','$2y$10$Q685YRoXCYAo2hAaeSPbueiBSaaKebmU8qazkxJTUk51Yn2vCzgpO','NTlKr5k773Y24Qm4WyOtsFhHFVXqjQnkRo9RvoWPh4LTRxqp5JeX0CkmYjLL','2015-07-29 12:37:28','2015-07-29 12:39:04',0,NULL,NULL,NULL,0),
	(14,'test-user','test_user@muhit.co','Test ','User','placeholders/profile.png','$2y$10$QbWyPjJpdJxDH8/aUkBMSeYpNCnIdZnAkYyuAVM.ErIgrM2xWnFOG','mrPmGaWqwznnRaLiD11tmJhJILv48yGFko1k0vCautsMfZei5bV7jpOHAN09','2015-08-06 20:20:06','2015-08-17 10:44:34',0,12,'Kemankeş Karamustafa Paşa Mahallesi, Beyoğlu, İstanbul',NULL,0),
	(15,'test-muhtar','test_muhtar@muhit.co','Test','Muhtar','placeholders/profile.png','$2y$10$X3LN.YW5.Wiio5RWlxEirubGVFY24betIXFeWeykT.0eJoilhMoDy','zV6fMyL9i6lHmNfWvx46hcsHRgCljV2whBeryB80V0wgoB93RLxmlpSKdLEs','2015-08-06 20:20:58','2015-08-06 23:39:19',5,10,'Tomtom Mahallesi, Beyoğlu, İstanbul',NULL,0),
	(16,'test-belediye','test_belediye@muhit.co','Test','Belediye','placeholders/profile.png','$2y$10$mpBTpP/uzTQ1b/WF3u1qaulbjivQC0lEchuhQKnXBc4TIZ/PORnOe','1BPoc1SLNxYvPAxXrk8THjgAulS1OBivqqbXn21assci4FiPHZcMUa2uDMC9','2015-08-06 20:21:47','2015-08-06 20:21:52',7,12,'Kemankeş Karamustafa Paşa Mahallesi, Beyoğlu, İstanbul',NULL,0),
	(17,'timur-tolgay','ttolgay@me.com','Timur','TOLGAY','placeholders/profile.png','$2y$10$CKdbbZKcyF.sHwh1LJcHJ.CiP/44KqjstpGVRZRUA0sprWBx3Zqt.',NULL,'2015-08-13 10:28:00','2015-08-13 10:28:00',0,18,'Fenerbahçe Mahallesi, Kadıköy, İstanbul',NULL,0),
	(18,'ahmet-tosun','ahmet@poltio.com','Ahmet','Tosun','placeholders/profile.png','$2y$10$PQxQ4ToDV0UlSCGLHuVgf.mz4QVpEkz3l4ho27jOUd.yVbQgYRqfK',NULL,'2015-08-13 14:37:49','2015-08-13 14:37:49',0,NULL,NULL,NULL,0),
	(19,'sandrine-ramboux','Sramboux@4carma.com','Sandrine','Ramboux','placeholders/profile.png','$2y$10$plxy03wh5jtxwMDDtBfJ8eRd9X9YjPILBqMLCMnYJQ.VuAqnWbWVu',NULL,'2015-08-17 13:38:21','2015-08-17 13:38:21',0,25,'Etiler Mahallesi, Beşiktaş, İstanbul',NULL,0),
	(20,'derya-tolgay','deryatolgay@gmail.com','Derya','Tolgay','placeholders/profile.png','$2y$10$UQad/2x0EZvrx/GSjiBhWunAWaGbSWhT6gfV38ldONLKV/GmHoQp6','9V6ZrtgMoKPpZGWZbM5jwCYG7gbav2WV1KN81x1YX06OxHtxEMiXHrqu80uR','2015-08-18 09:26:10','2015-08-18 10:34:00',0,18,'Fenerbahçe Mahallesi, Kadıköy, İstanbul',NULL,0),
	(21,'esin-isik','g.e.isik@gmail.com','Esin','Işık','placeholders/profile.png','$2y$10$krh35PIp5kvotoSqD5BBIuFbRf7xgAzyQWzzBpz8f8fQ0iIYYEt1e',NULL,'2015-08-18 19:08:32','2015-08-18 19:08:32',0,8,'Gümüşsuyu Mahallesi, Beyoğlu, İstanbul',NULL,0);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
