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
  `ID_KONTRAK_TRANS` int(11) NOT NULL,
  `ID_TRANSPORTIR` varchar(20) NOT NULL,
  `KD_KONTRAK_TRANS` varchar(50) DEFAULT NULL,
  `TGL_KONTRAK_TRANS` date DEFAULT NULL,
  `NILAI_KONTRAK_TRANS` int(11) DEFAULT NULL,
  `KET_KONTRAK_TRANS` varchar(200) DEFAULT NULL,
  `PATH_KONTRAK_TRANS` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_TRANS`),
  KEY `FK_RELATIONSHIP_13` (`ID_TRANSPORTIR`),
  CONSTRAINT `FK_RELATIONSHIP_13` FOREIGN KEY (`ID_TRANSPORTIR`) REFERENCES `master_transportir` (`ID_TRANSPORTIR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `data_kontrak_transportir` */

/*Table structure for table `det_kontrak_trans` */

DROP TABLE IF EXISTS `det_kontrak_trans`;

CREATE TABLE `det_kontrak_trans` (
  `ID_KONTRAK_TRANS` int(11) NOT NULL,
  `ID_DET_KONTRAK_TRANS` int(11) NOT NULL,
  `SLOC` varchar(4) NOT NULL,
  `TYPE_KONTRAK_TRANS` char(1) DEFAULT NULL,
  `HARGA_KONTRAK_TRANS` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_TRANS`,`ID_DET_KONTRAK_TRANS`),
  KEY `FK_RELATIONSHIP_15` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_14` FOREIGN KEY (`ID_KONTRAK_TRANS`) REFERENCES `data_kontrak_transportir` (`ID_KONTRAK_TRANS`),
  CONSTRAINT `FK_RELATIONSHIP_15` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `det_kontrak_trans` */

/*Table structure for table `detail_jalur_pasokan` */

DROP TABLE IF EXISTS `detail_jalur_pasokan`;

CREATE TABLE `detail_jalur_pasokan` (
  `ID_DEPO` varchar(20) NOT NULL,
  `SLOC` varchar(4) NOT NULL,
  `ID_JALUR_PASOKAN` int(11) NOT NULL,
  PRIMARY KEY (`ID_DEPO`,`SLOC`,`ID_JALUR_PASOKAN`),
  KEY `FK_RELATIONSHIP_12` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`ID_DEPO`) REFERENCES `master_depo` (`ID_DEPO`),
  CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_jalur_pasokan` */

/*Table structure for table `m_menu` */

DROP TABLE IF EXISTS `m_menu`;

CREATE TABLE `m_menu` (
  `MENU_ID` char(3) NOT NULL,
  `M_M_MENU_ID` char(3) DEFAULT NULL,
  `MENU_NAMA` varchar(100) DEFAULT NULL,
  `MENU_URL` varchar(100) DEFAULT NULL,
  `MENU_KETERANGAN` varchar(100) DEFAULT NULL,
  `MENU_ICON` varchar(50) DEFAULT NULL,
  `MENU_URUTAN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_menu` */

insert  into `m_menu`(`MENU_ID`,`M_M_MENU_ID`,`MENU_NAMA`,`MENU_URL`,`MENU_KETERANGAN`,`MENU_ICON`,`MENU_URUTAN`) values ('001',NULL,'User Management','#','','icon-cogs',4),('002','001','Role Management','user_management/role','','',2),('003','001','menu Management','user_management/menu','','',1),('004','001','User','user_management/user','','',3),('005',NULL,'Master','#','','icon-bar-chart',3),('006','005','Pemasok','master/pemasok','-','',0),('007',NULL,'Data Transaksi','datatransaksi','-','icon-ban-circle',1),('008','005','Master Level 1','master/master_level1','-','',1),('009','005','Master Level 2','master/master_level2','-','',2),('010','005','Master Level 3','master/master_level3','-','',3),('011','005','Master Level 4','master/master_level4','-','',4),('012',NULL,'Dashboard','dashboard','dashboard GBM','icon-step-forward',0),('013','012','Grafik','dashboard/grafik','grafik','',1),('014','012','Peta Jalur Pasokan','dashboard/peta','Dashboard peta','',2),('016','007','Stock Opname','datatransaksi/stockopname','','',1),('017',NULL,'Laporan','laporan','','icon-magnet',2);

/*Table structure for table `m_otoritas_menu` */

DROP TABLE IF EXISTS `m_otoritas_menu`;

CREATE TABLE `m_otoritas_menu` (
  `ROLES_ID` char(3) NOT NULL,
  `MENU_ID` char(3) NOT NULL,
  `IS_VIEW` char(1) DEFAULT NULL,
  `IS_ADD` char(1) DEFAULT NULL,
  `IS_EDIT` char(1) DEFAULT NULL,
  `IS_DELETE` char(1) DEFAULT NULL,
  `IS_APPROVE` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_otoritas_menu` */

insert  into `m_otoritas_menu`(`ROLES_ID`,`MENU_ID`,`IS_VIEW`,`IS_ADD`,`IS_EDIT`,`IS_DELETE`,`IS_APPROVE`) values ('1','012','t','t','t','t','t'),('1','013','t','t','t','t','t'),('1','014','t','t','t','t','t'),('1','007','t','t','t','t','t'),('1','016','t','t','t','t','t'),('1','017','t','t','t','t','t'),('1','005','t','t','t','t','t'),('1','006','t','t','t','t','t'),('1','008','t','t','t','t','t'),('1','009','t','t','t','t','t'),('1','010','t','t','t','t','t'),('1','011','t','t','t','t','t'),('1','001','t','t','t','t','t'),('1','003','t','t','t','t','t'),('1','002','t','t','t','t','t'),('1','004','t','t','t','t','t');

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `ID_USER` int(11) NOT NULL,
  `ROLES_ID` char(3) NOT NULL,
  `KD_USER` varchar(20) DEFAULT NULL,
  `NAMA_USER` varchar(50) DEFAULT NULL,
  `USERNAME` varchar(100) NOT NULL,
  `PWD_USER` varchar(100) NOT NULL,
  `EMAIL_USER` varchar(50) DEFAULT NULL,
  `LEVEL_USER` char(1) DEFAULT NULL,
  `ISAKTIF_USER` char(1) DEFAULT NULL,
  `CD_USER` date DEFAULT NULL,
  `CD_BY_USER` varchar(100) DEFAULT NULL,
  `UD_USER` date DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `FK_RELATIONSHIP_16` (`ROLES_ID`),
  CONSTRAINT `FK_RELATIONSHIP_16` FOREIGN KEY (`ROLES_ID`) REFERENCES `roles` (`ROLES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_user` */

insert  into `m_user`(`ID_USER`,`ROLES_ID`,`KD_USER`,`NAMA_USER`,`USERNAME`,`PWD_USER`,`EMAIL_USER`,`LEVEL_USER`,`ISAKTIF_USER`,`CD_USER`,`CD_BY_USER`,`UD_USER`) values (1,'1',NULL,'Adit','admin','admin',NULL,NULL,'1',NULL,NULL,NULL);

/*Table structure for table `master_depo` */

DROP TABLE IF EXISTS `master_depo`;

CREATE TABLE `master_depo` (
  `ID_DEPO` varchar(20) NOT NULL,
  `SLOC` varchar(4) NOT NULL,
  `ID_VENDOR` varchar(20) NOT NULL,
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
  `PLANT` varchar(4) DEFAULT NULL,
  `STORE_SLOC` varchar(4) DEFAULT NULL,
  `SLOC` varchar(4) DEFAULT NULL,
  `NAMA_TANGKI` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_TANGKI`),
  KEY `FK_RELATIONSHIP_7` (`PLANT`,`STORE_SLOC`),
  KEY `FK_RELATIONSHIP_9` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_7` FOREIGN KEY (`PLANT`, `STORE_SLOC`) REFERENCES `master_level3` (`PLANT`, `STORE_SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_tangki` */

/*Table structure for table `master_transportir` */

DROP TABLE IF EXISTS `master_transportir`;

CREATE TABLE `master_transportir` (
  `ID_TRANSPORTIR` varchar(20) NOT NULL,
  `KD_TRANSPORTIR` varchar(50) DEFAULT NULL,
  `NAMA_TRANSPORTIR` varchar(50) DEFAULT NULL,
  `KET_TRANSPORTIR` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`ID_TRANSPORTIR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_transportir` */

/*Table structure for table `master_vendor` */

DROP TABLE IF EXISTS `master_vendor`;

CREATE TABLE `master_vendor` (
  `ID_VENDOR` varchar(20) NOT NULL,
  `KODE_VENDOR` varchar(50) NOT NULL,
  `NAMA_VENDOR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_VENDOR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_vendor` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `ROLES_ID` char(3) NOT NULL,
  `ROLES_NAMA` varchar(50) DEFAULT NULL,
  `ROLES_KETERANGAN` varchar(100) DEFAULT NULL,
  `CD_ROLES` date DEFAULT NULL,
  `UP_ROLES` date DEFAULT NULL,
  PRIMARY KEY (`ROLES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`ROLES_ID`,`ROLES_NAMA`,`ROLES_KETERANGAN`,`CD_ROLES`,`UP_ROLES`) values ('1','Administrator','',NULL,NULL);

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `VALUE` varchar(100) DEFAULT NULL,
  `SETTING` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `setting` */

insert  into `setting`(`VALUE`,`SETTING`) values ('GBM PT. PLN (Persero)','nama_aplikasi'),('PT. PLN ','companyname');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
