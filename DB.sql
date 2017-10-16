/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.21 : Database - gbm_new
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gbm_new` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `gbm_new`;

/*Table structure for table `data_kontrak_transportir` */

DROP TABLE IF EXISTS `data_kontrak_transportir`;

CREATE TABLE `data_kontrak_transportir` (
  `ID_KONTRAK_TRANS` int(11) NOT NULL AUTO_INCREMENT,
  `ID_TRANSPORTIR` int(11) NOT NULL,
  `KD_KONTRAK_TRANS` varchar(50) DEFAULT NULL,
  `TGL_KONTRAK_TRANS` date DEFAULT NULL,
  `NILAI_KONTRAK_TRANS` int(11) DEFAULT NULL,
  `KET_KONTRAK_TRANS` varchar(150) DEFAULT NULL,
  `PATH_KONTRAK_TRANS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_TRANS`),
  KEY `FK_RELATIONSHIP_15` (`ID_TRANSPORTIR`),
  CONSTRAINT `FK_RELATIONSHIP_15` FOREIGN KEY (`ID_TRANSPORTIR`) REFERENCES `master_transportir` (`ID_TRANSPORTIR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `data_kontrak_transportir` */

/*Table structure for table `detail_jalur_pasokan` */

DROP TABLE IF EXISTS `detail_jalur_pasokan`;

CREATE TABLE `detail_jalur_pasokan` (
  `ID_DEPO` int(11) NOT NULL AUTO_INCREMENT,
  `SLOC` varchar(4) NOT NULL,
  `ID_JALUR_PASOKAN` int(11) NOT NULL,
  PRIMARY KEY (`ID_DEPO`,`SLOC`,`ID_JALUR_PASOKAN`),
  KEY `FK_RELATIONSHIP_12` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`ID_DEPO`) REFERENCES `master_depo` (`ID_DEPO`),
  CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_jalur_pasokan` */

/*Table structure for table `id_det_kontrak_trans` */

DROP TABLE IF EXISTS `id_det_kontrak_trans`;

CREATE TABLE `id_det_kontrak_trans` (
  `ID_KONTRAK_TRANS` int(11) NOT NULL AUTO_INCREMENT,
  `ID_DET_KONTRAK_TRANS` int(11) NOT NULL,
  `SLOC` varchar(4) NOT NULL,
  `TYPE_TRANS` char(1) DEFAULT NULL,
  `HARGA_TRANS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_TRANS`,`ID_DET_KONTRAK_TRANS`),
  KEY `FK_RELATIONSHIP_16` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_14` FOREIGN KEY (`ID_KONTRAK_TRANS`) REFERENCES `data_kontrak_transportir` (`ID_KONTRAK_TRANS`),
  CONSTRAINT `FK_RELATIONSHIP_16` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `id_det_kontrak_trans` */

/*Table structure for table `master_depo` */

DROP TABLE IF EXISTS `master_depo`;

CREATE TABLE `master_depo` (
  `ID_DEPO` int(11) NOT NULL AUTO_INCREMENT,
  `SLOC` varchar(4) NOT NULL,
  `ID_VENDOR` int(11) NOT NULL,
  `NAMA_DEPO` varchar(150) DEFAULT NULL,
  `LAT_DEPO` varchar(100) DEFAULT NULL,
  `LOT_DEPO` varchar(100) DEFAULT NULL,
  `ALAMAT_DEPO` varchar(150) DEFAULT NULL,
  `FLAG_DEPO` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_DEPO`),
  KEY `FK_RELATIONSHIP_10` (`SLOC`),
  KEY `FK_RELATIONSHIP_8` (`ID_VENDOR`),
  CONSTRAINT `FK_RELATIONSHIP_10` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`ID_VENDOR`) REFERENCES `master_vendor` (`ID_VENDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_depo` */

/*Table structure for table `master_jenis_bahan_bakar` */

DROP TABLE IF EXISTS `master_jenis_bahan_bakar`;

CREATE TABLE `master_jenis_bahan_bakar` (
  `ID_JNS_BHN_BKR` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_JNS_BHN_BKR` varchar(20) DEFAULT NULL,
  `NAMA_JNS_BHN_BKR` varchar(50) DEFAULT NULL,
  `KET_JNS_BHN_BKR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_JNS_BHN_BKR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_bahan_bakar` */

/*Table structure for table `master_kurs` */

DROP TABLE IF EXISTS `master_kurs`;

CREATE TABLE `master_kurs` (
  `ID_KURS` int(11) NOT NULL AUTO_INCREMENT,
  `TGL_KURS` date DEFAULT NULL,
  `BELI_KURS` int(11) DEFAULT NULL,
  `JUAL_KURS` int(11) DEFAULT NULL,
  `AVG_KURS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_KURS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_kurs` */

/*Table structure for table `master_level1` */

DROP TABLE IF EXISTS `master_level1`;

CREATE TABLE `master_level1` (
  `COCODE` varchar(4) NOT NULL,
  `ID_REGIONAL` varchar(2) NOT NULL,
  `LEVEL1` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL1` varchar(50) DEFAULT NULL,
  `IS_AKTIF_LVL1` char(1) DEFAULT NULL,
  PRIMARY KEY (`COCODE`),
  KEY `FK_RELATIONSHIP_5` (`ID_REGIONAL`),
  CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_REGIONAL`) REFERENCES `master_regional` (`ID_REGIONAL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level1` */

/*Table structure for table `master_level2` */

DROP TABLE IF EXISTS `master_level2`;

CREATE TABLE `master_level2` (
  `PLANT` varchar(4) NOT NULL,
  `COCODE` varchar(4) NOT NULL,
  `LEVEL2` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL2` varchar(100) DEFAULT NULL,
  `IS_AKTIF_LVL2` char(1) DEFAULT NULL,
  PRIMARY KEY (`PLANT`),
  KEY `FK_RELATIONSHIP_1` (`COCODE`),
  CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`COCODE`) REFERENCES `master_level1` (`COCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level2` */

/*Table structure for table `master_level3` */

DROP TABLE IF EXISTS `master_level3`;

CREATE TABLE `master_level3` (
  `PLANT` varchar(4) NOT NULL,
  `STORE_SLOC` varchar(4) NOT NULL,
  `LEVEL3` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL3` varchar(100) DEFAULT NULL,
  `IS_AKTIF_LVL3` char(1) DEFAULT NULL,
  PRIMARY KEY (`PLANT`,`STORE_SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`PLANT`) REFERENCES `master_level2` (`PLANT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level3` */

/*Table structure for table `master_level4` */

DROP TABLE IF EXISTS `master_level4`;

CREATE TABLE `master_level4` (
  `SLOC` varchar(4) NOT NULL,
  `PLANT` varchar(4) DEFAULT NULL,
  `STORE_SLOC` varchar(4) DEFAULT NULL,
  `LEVEL4` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL4` varchar(50) DEFAULT NULL,
  `IS_AKTI_LVL4` char(1) DEFAULT NULL,
  `LAT_LVL4` varchar(100) DEFAULT NULL,
  `LOT_LVL4` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`SLOC`),
  KEY `FK_RELATIONSHIP_6` (`PLANT`,`STORE_SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_6` FOREIGN KEY (`PLANT`, `STORE_SLOC`) REFERENCES `master_level3` (`PLANT`, `STORE_SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level4` */

/*Table structure for table `master_regional` */

DROP TABLE IF EXISTS `master_regional`;

CREATE TABLE `master_regional` (
  `ID_REGIONAL` varchar(2) NOT NULL,
  `NAMA_REGIONAL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_REGIONAL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_regional` */

/*Table structure for table `master_tangki` */

DROP TABLE IF EXISTS `master_tangki`;

CREATE TABLE `master_tangki` (
  `ID_TANGKI` varchar(4) NOT NULL,
  `ID_JNS_BHN_BKR` int(11) NOT NULL,
  `PLANT` varchar(4) DEFAULT NULL,
  `STORE_SLOC` varchar(4) DEFAULT NULL,
  `SLOC` varchar(4) DEFAULT NULL,
  `NAMA_TANGKI` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_TANGKI`),
  KEY `FK_RELATIONSHIP_13` (`ID_JNS_BHN_BKR`),
  KEY `FK_RELATIONSHIP_7` (`PLANT`,`STORE_SLOC`),
  KEY `FK_RELATIONSHIP_9` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_13` FOREIGN KEY (`ID_JNS_BHN_BKR`) REFERENCES `master_jenis_bahan_bakar` (`ID_JNS_BHN_BKR`),
  CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`PLANT`, `STORE_SLOC`) REFERENCES `master_level3` (`PLANT`, `STORE_SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_tangki` */

/*Table structure for table `master_transportir` */

DROP TABLE IF EXISTS `master_transportir`;

CREATE TABLE `master_transportir` (
  `ID_TRANSPORTIR` int(11) NOT NULL AUTO_INCREMENT,
  `KD_TRANSPORTIR` varchar(50) DEFAULT NULL,
  `NAMA_TRANSPORTIR` varchar(50) DEFAULT NULL,
  `KET_TRANSPORTIR` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ID_TRANSPORTIR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_transportir` */

/*Table structure for table `master_vendor` */

DROP TABLE IF EXISTS `master_vendor`;

CREATE TABLE `master_vendor` (
  `ID_VENDOR` int(11) NOT NULL AUTO_INCREMENT,
  `KODE_VENDOR` varchar(50) NOT NULL,
  `NAMA_VENDOR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_VENDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_vendor` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
