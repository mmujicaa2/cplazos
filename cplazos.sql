/*
SQLyog Community v13.2.1 (64 bit)
MySQL - 5.7.40 : Database - cplazos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cplazos` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_spanish_ci */;

USE `cplazos`;

/*Table structure for table `agenda` */

DROP TABLE IF EXISTS `agenda`;

CREATE TABLE `agenda` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rit` int(10) DEFAULT NULL,
  `era` year(4) DEFAULT NULL,
  `tipotramite` varchar(200) DEFAULT NULL,
  `tipoplazo` varchar(200) DEFAULT NULL,
  `ndias` int(10) DEFAULT NULL,
  `fehchaingreso` date DEFAULT NULL,
  `fechafatal` date DEFAULT NULL,
  `fechawarning` date DEFAULT NULL,
  `visible` binary(1) DEFAULT NULL,
  `eliminado` binary(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `agenda` */

/*Table structure for table `correounidad` */

DROP TABLE IF EXISTS `correounidad`;

CREATE TABLE `correounidad` (
  `id_correo` int(10) NOT NULL AUTO_INCREMENT,
  `correo` varchar(100) DEFAULT NULL,
  `id_unidad` int(10) DEFAULT NULL,
  PRIMARY KEY (`id_correo`),
  KEY `id_correo` (`id_correo`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `correounidad` */

insert  into `correounidad`(`id_correo`,`correo`,`id_unidad`) values 
(1,'apantoja@pjud.cl',1),
(2,'evergara@pjud.cl',1),
(3,'agordillo@pjud.cl',2),
(4,'pjoglar@pjud.cl',2),
(5,'eabarraza@pjud.cl',3),
(6,'scjorquera@pjud.cl',3),
(7,'mmujica@pjud.cl',4);

/*Table structure for table `feriado` */

DROP TABLE IF EXISTS `feriado`;

CREATE TABLE `feriado` (
  `id_feriado` int(10) NOT NULL AUTO_INCREMENT,
  `fechaferiado` date DEFAULT NULL,
  PRIMARY KEY (`id_feriado`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `feriado` */

/*Table structure for table `plazos` */

DROP TABLE IF EXISTS `plazos`;

CREATE TABLE `plazos` (
  `id_plazo` int(10) NOT NULL AUTO_INCREMENT,
  `nmplazo` varchar(200) DEFAULT NULL,
  `periodo` varchar(200) DEFAULT NULL,
  `cantperiodo` int(10) DEFAULT NULL,
  KEY `id_plazo` (`id_plazo`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `plazos` */

insert  into `plazos`(`id_plazo`,`nmplazo`,`periodo`,`cantperiodo`) values 
(1,'Prision Preventiva','mes',6),
(2,'Auto de Apertura con exclusion de prueba','días',3),
(3,'Auto de Apertura sin exclusion de prueba',NULL,6);

/*Table structure for table `unidad` */

DROP TABLE IF EXISTS `unidad`;

CREATE TABLE `unidad` (
  `id_unidad` int(10) NOT NULL AUTO_INCREMENT,
  `nunidad` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_unidad`),
  KEY `id_unidad` (`id_unidad`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `unidad` */

insert  into `unidad`(`id_unidad`,`nunidad`) values 
(1,'Unidad de Atencion de Público y Sala'),
(2,'Unidad de Servicios y Cumplimiento'),
(3,'Unidad de Causa'),
(4,'Prueba');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
