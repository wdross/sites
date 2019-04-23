-- MySQL dump 10.13  Distrib 5.1.69, for debian-linux-gnu (i486)
--
-- Host: localhost    Database: pantrydb
-- ------------------------------------------------------
-- Server version	5.1.69-0ubuntu0.10.04.1

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
-- Current Database: `bingodb`
--

CREATE DATABASE IF NOT EXISTS `bingodb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bingodb`;

--
-- Table structure for table `bingo`
--

DROP TABLE IF EXISTS `bingo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bingo` (
  `shortname` varchar(30) NOT NULL,
  `title` varchar(70) NOT NULL,
  `exclaim` varchar(70) NOT NULL,
  `free` varchar(70) NOT NULL,
  `phrases` varchar(64000) NOT NULL,
  `lastupdate` DATETIME NOT NULL,
  PRIMARY KEY (`shortname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `usages`;
CREATE TABLE `usages` (
  `user` varchar(70),
  `ipaddress` varchar(70) NOT NULL,
  `eventdatetime` DATETIME NOT NULL,
  `what` varchar(10) NOT NULL,
  `game` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- Created on 2018-12-31; usages added 2019-02-26
