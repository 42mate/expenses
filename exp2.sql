-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: laravel
-- ------------------------------------------------------
-- Server version	5.7.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_user_id_foreign` (`user_id`),
  CONSTRAINT `categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Tarjeta',1,'2020-05-03 22:01:09','2020-05-03 22:01:09'),(2,'Alquiler',1,'2020-05-03 22:01:15','2020-05-03 22:01:15'),(3,'Expensas',1,'2020-05-03 22:01:21','2020-05-03 22:01:21'),(4,'Nafta',1,'2020-05-03 22:01:29','2020-05-03 22:01:29'),(5,'Supermercado',1,'2020-05-03 22:01:35','2020-05-03 22:01:35'),(6,'Guardería',1,'2020-05-03 22:01:44','2020-05-03 22:01:44'),(7,'Salidas',1,'2020-05-03 22:02:08','2020-05-03 22:02:08'),(8,'Pesca',1,'2020-05-03 22:02:14','2020-05-03 22:02:14'),(9,'Internet',1,'2020-05-03 22:02:24','2020-05-03 22:02:24'),(10,'Servicios',1,'2020-05-03 22:02:36','2020-05-03 22:02:36'),(11,'Delivery y Comidas',1,'2020-05-03 22:05:51','2020-05-03 22:05:51'),(12,'Verdulería',1,'2020-05-06 12:59:49','2020-05-06 12:59:49'),(13,'Carnicería',1,'2020-05-06 12:59:54','2020-05-06 12:59:54'),(14,'Varios',1,'2020-05-06 19:33:31','2020-05-06 19:33:31');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demo_entity`
--

DROP TABLE IF EXISTS `demo_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demo_entity` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `birth_date` date NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demo_entity`
--

LOCK TABLES `demo_entity` WRITE;
/*!40000 ALTER TABLE `demo_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `demo_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `expenses_user_id_foreign` (`user_id`),
  KEY `expenses_category_id_foreign` (`category_id`),
  CONSTRAINT `expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `expenses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (1,42382.73,'2020-05-01 00:00:00','Tarjeta Mes Mayo','2020-05-03 22:03:55','2020-05-03 22:03:55',1,1),(2,5516.82,'2020-05-01 00:00:00','Expensas Mayo','2020-05-03 22:04:30','2020-05-03 22:04:30',1,3),(3,1230.00,'2020-05-01 00:00:00','Cervezas','2020-05-03 22:04:55','2020-05-03 22:04:55',1,7),(4,2500.00,'2020-05-01 00:00:00','Delidrinks Gin y Campari','2020-05-03 22:05:13','2020-05-03 22:05:13',1,7),(5,500.00,'2020-05-01 00:00:00','Empandas Cachu','2020-05-03 22:06:03','2020-05-03 22:06:03',1,11),(6,450.00,'2020-05-02 00:00:00','Asado con Ale y Huevo','2020-05-03 22:06:29','2020-05-03 22:06:29',1,7),(7,400.00,'2020-05-02 00:00:00','Pata muslos x 4','2020-05-03 22:06:47','2020-05-03 22:06:47',1,5),(8,6600.00,'2020-05-03 00:00:00','Guarderia El Timon','2020-05-03 22:07:34','2020-05-03 22:07:34',1,6),(9,15000.00,'2020-05-03 00:00:00','Alquiler Mayo','2020-05-03 22:07:53','2020-05-03 22:07:53',1,2),(10,1514.51,'2020-05-03 00:00:00','Internet Mayo','2020-05-03 22:10:01','2020-05-03 22:10:01',1,9),(11,1200.00,'2020-05-03 00:00:00','Internet Benitez','2020-05-03 22:10:18','2020-05-03 22:10:18',1,9),(12,100.00,'2020-05-06 00:00:00','manzanas','2020-05-06 13:00:07','2020-05-06 13:00:07',1,12),(13,250.00,'2020-05-06 00:00:00','Pechugas de Pollo 1kg','2020-05-06 13:00:22','2020-05-06 13:00:22',1,13),(14,1500.00,'2020-05-06 00:00:00','La llave del chaco, artículos de librería','2020-05-06 19:33:53','2020-05-06 19:33:53',1,14),(15,100.00,'2020-05-07 00:00:00','Barbijos','2020-05-07 15:08:22','2020-05-07 15:08:22',1,14),(16,1200.00,'2020-05-08 00:00:00','Carnes','2020-05-08 15:52:59','2020-05-08 15:52:59',1,13),(17,400.00,'2020-05-08 00:00:00','Feria','2020-05-08 15:53:12','2020-05-08 15:53:12',1,12),(18,5000.00,'2020-05-08 00:00:00','Depilación','2020-05-08 15:53:29','2020-05-08 15:53:29',1,14),(19,2000.00,'2020-05-10 00:00:00','Nafta súper shell','2020-05-10 14:49:41','2020-05-10 14:49:41',1,4),(20,100.00,'2020-05-10 00:00:00','Torta Parilla','2020-05-10 14:50:17','2020-05-10 14:50:17',1,11),(21,850.00,'2020-05-10 00:00:00','Chupi cunple','2020-05-10 17:50:18','2020-05-10 17:50:18',1,7),(22,750.00,'2020-05-10 00:00:00','Torta mirasoles','2020-05-10 17:50:43','2020-05-10 17:50:43',1,11),(23,850.00,'2020-05-11 00:00:00','Fernet','2020-05-11 01:00:22','2020-05-11 01:00:22',1,7),(24,1500.00,'2020-05-11 00:00:00','Puchos','2020-05-11 01:00:38','2020-05-11 01:00:38',1,14),(25,550.00,'2020-05-11 00:00:00','El perro','2020-05-11 01:01:07','2020-05-11 01:01:07',1,11),(26,13880.00,'2020-05-11 00:00:00','Mancuernas y pesas','2020-05-11 18:20:03','2020-05-11 18:20:03',1,14),(27,185.00,'2020-05-15 00:00:00','Piedritas gato','2020-05-15 11:13:03','2020-05-15 11:13:03',1,14),(28,850.00,'2020-05-15 00:00:00','Pizzas cachu','2020-05-15 23:13:03','2020-05-15 23:13:03',1,11),(29,2600.00,'2020-05-17 00:00:00','Asado cris','2020-05-17 15:33:32','2020-05-17 15:33:32',1,7),(30,500.00,'2020-05-17 00:00:00','Huevos','2020-05-17 15:33:50','2020-05-17 15:33:50',1,13),(31,400.00,'2020-05-17 00:00:00','Salame','2020-05-17 15:34:08','2020-05-17 15:34:08',1,13),(32,1500.00,'2020-05-16 00:00:00','Birras y Puchos','2020-05-18 12:28:10','2020-05-18 12:28:10',1,7),(33,1380.00,'2020-05-18 00:00:00','Supermercado','2020-05-18 22:44:36','2020-05-18 22:44:36',1,5),(34,800.00,'2020-05-22 00:00:00','Súper, yerba, galle y abrelata','2020-05-22 14:41:22','2020-05-22 14:41:22',1,5),(35,650.00,'2020-05-23 00:00:00','Pizzas gusty','2020-05-23 22:51:16','2020-05-23 22:51:16',1,11),(36,510.00,'2020-05-23 00:00:00','Birra','2020-05-23 22:51:28','2020-05-23 22:51:28',1,11),(37,800.00,'2020-05-23 00:00:00','Birra','2020-05-23 22:52:06','2020-05-23 22:52:06',1,7);
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (6,'2014_10_12_000000_create_users_table',1),(7,'2014_10_12_100000_create_password_resets_table',1),(8,'2019_08_19_000000_create_failed_jobs_table',1),(9,'2020_05_22_205922_demo_entity',1),(10,'2020_05_23_020626_tables',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Agustin','casivaagustin@gmail.com',NULL,'$2y$10$llq6C/og4fySA.ukmH0AaOeotHJF0FXyAlL7K9kHW.4cSS./cKbB2','JpBbVXgFkLz6zHTegXSPnQYObfNd8nf1x5AEKN8AU2nOVS0hS4EpXDHX13EC','2020-05-03 22:00:40','2020-05-03 23:01:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-25 20:25:03
