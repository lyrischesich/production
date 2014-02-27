<?php
require_once APP.DS."Config".DS."database.php";
class DatabaseManager {
	
	public $name = 'DatabaseManager';
	
	static $connection;
	
	static $dbconf;
	static $host;
	static $user;
	static $password;
	static $db;
	
	static function connect($autoSelectDB=true) {
		self::$dbconf = new DATABASE_CONFIG();
		self::$host = self::$dbconf->default['host'];
		self::$user = self::$dbconf->default['login'];
		self::$password = self::$dbconf->default['password'];
		self::$db = self::$dbconf->default['database'];
		
		self::$connection = @mysql_connect(self::$host, self::$user, self::$password);
		if (!self::$connection)
			return "Verbindung zur Datenbank konnte nicht hergestellt werden";
		
		if ($autoSelectDB) mysql_select_db(self::$db, self::$connection);
		
		return true;
	}
	
	public static function import($dump_file) {
		if (!self::$connection) {
			self::connect();
		}
					
		$content = file_get_contents($dump_file);
		
		$sqls = explode(";", $content);
		
		foreach ($sqls as $sql) {
			mysql_query($sql, self::$connection);
		}
		
		if (mysql_error() != '') {
			return "Beim Importieren der Datenbank ist ein Fehler aufgetreten.<br/>Bitte überprüfen Sie die Integrität der Datenbank.";
		}
		
		mysql_close();
		
		return true;
	}
	
	public static function createDatabaseStructure() {
		if (!self::$connection) {
			self::connect(false);
		}
		
		mysql_query("DROP DATABASE IF EXISTS `".self::$db."`");
		mysql_query("CREATE DATABASE `".self::$db."`");
		mysql_select_db(self::$db);
		
		//Tabellen erstellen
		$sql = "
-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Feb 2014 um 13:46
-- Server Version: 5.5.35
-- PHP-Version: 5.3.10-1ubuntu3.9

SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `cafeteria_dev`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `changelogs`
--

DROP TABLE IF EXISTS `changelogs`;
CREATE TABLE IF NOT EXISTS `changelogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `for_date` date NOT NULL,
  `change_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `value_before` varchar(50) NOT NULL,
  `value_after` varchar(50) NOT NULL,
  `column_name` varchar(50) NOT NULL,
  `user_did` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `columns`
--

DROP TABLE IF EXISTS `columns`;
CREATE TABLE IF NOT EXISTS `columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `obligated` tinyint(4) NOT NULL,
  `req_admin` tinyint(4) NOT NULL,
  `order` smallint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1  ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `message` varchar(200) NOT NULL,
  `column_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `column_id` (`column_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `columns_users`
--

DROP TABLE IF EXISTS `columns_users`;
CREATE TABLE IF NOT EXISTS `columns_users` (
  `date` date NOT NULL,
  `half_shift` tinyint(4) NOT NULL,
  `column_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `column_id` (`column_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `specialdates`
--

DROP TABLE IF EXISTS `specialdates`;
CREATE TABLE IF NOT EXISTS `specialdates` (
  `date` date NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `tel1` varchar(32) NOT NULL,
  `tel2` varchar(32) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `leave_date` date DEFAULT NULL,
  `mo` enum('N','G','1','2','H') NOT NULL,
  `di` enum('N','G','1','2','H') NOT NULL,
  `mi` enum('N','G','1','2','H') NOT NULL,
  `do` enum('N','G','1','2','H') NOT NULL,
  `fr` enum('N','G','1','2','H') NOT NULL,
  `admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `columns_text`
--
ALTER TABLE `columns_text`
  ADD CONSTRAINT `columns_text_ibfk_2` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `columns_users`
--
ALTER TABLE `columns_users`
  ADD CONSTRAINT `columns_users_ibfk_7` FOREIGN KEY (`column_id`) REFERENCES `columns` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `columns_users_ibfk_9` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		
		$sql = explode(';', $sql);
		foreach ($sql as $sqlString)
			mysql_query($sqlString);
	}
}
?>