-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.35-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para site_ads_and_mining_script
CREATE DATABASE IF NOT EXISTS `site_ads_and_mining_script` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `site_ads_and_mining_script`;

-- Volcando estructura para tabla site_ads_and_mining_script.balance
DROP TABLE IF EXISTS `balance`;
CREATE TABLE IF NOT EXISTS `balance` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `wallet_id` int(32) NOT NULL DEFAULT '0',
  `value` float NOT NULL DEFAULT '0',
  `update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  CONSTRAINT `FK_balance_wallet` FOREIGN KEY (`wallet_id`) REFERENCES `wallet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla site_ads_and_mining_script.found
DROP TABLE IF EXISTS `found`;
CREATE TABLE IF NOT EXISTS `found` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `wallet_id` int(32) NOT NULL DEFAULT '0',
  `job_id` varchar(250) NOT NULL,
  `hashes` float NOT NULL DEFAULT '0',
  `hashesPerSecond` float NOT NULL DEFAULT '0',
  `nonce` varchar(250) NOT NULL,
  `result` varchar(250) NOT NULL,
  `create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  KEY `job_id` (`job_id`(191)),
  CONSTRAINT `FK_completados_wallet` FOREIGN KEY (`wallet_id`) REFERENCES `wallet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla site_ads_and_mining_script.job
DROP TABLE IF EXISTS `job`;
CREATE TABLE IF NOT EXISTS `job` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `wallet_id` int(32) NOT NULL DEFAULT '0',
  `job_id` varchar(250) NOT NULL,
  `blob` varchar(250) NOT NULL,
  `target` varchar(250) NOT NULL,
  `throttle` int(32) NOT NULL DEFAULT '0',
  `create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  KEY `job_id` (`job_id`(191)),
  CONSTRAINT `FK_trabajos_wallet` FOREIGN KEY (`wallet_id`) REFERENCES `wallet` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla site_ads_and_mining_script.wallet
DROP TABLE IF EXISTS `wallet`;
CREATE TABLE IF NOT EXISTS `wallet` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `address` varchar(250) NOT NULL,
  `coin` varchar(50) NOT NULL,
  `banned` int(1) NOT NULL DEFAULT '0',
  `activated` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
