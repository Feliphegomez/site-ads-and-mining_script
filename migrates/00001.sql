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

-- Volcando estructura para tabla site_ads_and_mining_script.found
CREATE TABLE IF NOT EXISTS `found` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `hashes` int(32) NOT NULL DEFAULT '0',
  `hashesPerSecond` float NOT NULL DEFAULT '0',
  `job_id` varchar(250) NOT NULL,
  `nonce` varchar(250) NOT NULL,
  `result` varchar(250) NOT NULL,
  `wallet` varchar(250) NOT NULL,
  `coin` varchar(50) NOT NULL,
  `create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
-- Volcando estructura para tabla site_ads_and_mining_script.job
CREATE TABLE IF NOT EXISTS `job` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `blob` varchar(250) NOT NULL,
  `job_id` varchar(250) NOT NULL,
  `target` varchar(250) NOT NULL,
  `throttle` int(32) NOT NULL DEFAULT '0',
  `wallet` varchar(250) NOT NULL,
  `coin` varchar(50) NOT NULL,
  `create` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=532 DEFAULT CHARSET=utf8mb4;

-- La exportación de datos fue deseleccionada.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
