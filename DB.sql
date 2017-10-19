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

/*Table structure for table `adendum_kontrak_pemasok` */

DROP TABLE IF EXISTS `adendum_kontrak_pemasok`;

CREATE TABLE `adendum_kontrak_pemasok` (
  `ID_ADENDUM_PEMASOK` varchar(5) NOT NULL,
  `ID_KONTRAK_PEMASOK` varchar(5) NOT NULL,
  `NO_ADENDUM_PEMASOK` varchar(20) DEFAULT NULL,
  `TGL_ADENDUM_PEMASOK` date DEFAULT NULL,
  `JUDUL_ADENDUM_PEMASOK` varchar(100) DEFAULT NULL,
  `PERIODE_AWAL_ADENDUM_PEMASOK` date DEFAULT NULL,
  `PERIODE_AKHIR_ADENMDUM_PEMASOK` date DEFAULT NULL,
  `JENIS_AKHIR_ADENDUM_PEMASOK` char(1) DEFAULT NULL,
  `VOL_AKHIR_ADENDUM_PEMASOK` int(11) DEFAULT NULL,
  `ALPHA_ADENDUM_PEMASOK` float DEFAULT NULL,
  `RP_ADENDUM_PEMASOK` int(11) DEFAULT NULL,
  `PENJAMIN_ADENDUM_PEMASOK` varchar(100) DEFAULT NULL,
  `NO_PENJAMIN_ADENDUM_PEMASOK` varchar(20) DEFAULT NULL,
  `NOMINAL_ADENDUM_PEMASOK` int(11) DEFAULT NULL,
  `TGL_AKHIR_ADENDUM_PEMASOK` date DEFAULT NULL,
  `KET_ADENDUM_PEMASOK` varchar(100) DEFAULT NULL,
  `CD_ADENDUM_PEMASOK` date DEFAULT NULL,
  `CD_BY_ADENDUM_PEMASOK` varchar(100) DEFAULT NULL,
  `UD_ADENDUM_PEMASOK` date DEFAULT NULL,
  PRIMARY KEY (`ID_ADENDUM_PEMASOK`),
  KEY `FK_RELATIONSHIP_25` (`ID_KONTRAK_PEMASOK`),
  CONSTRAINT `FK_RELATIONSHIP_25` FOREIGN KEY (`ID_KONTRAK_PEMASOK`) REFERENCES `data_kontrak_pemasok` (`ID_KONTRAK_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `adendum_kontrak_pemasok` */

/*Table structure for table `data_kontrak_pemasok` */

DROP TABLE IF EXISTS `data_kontrak_pemasok`;

CREATE TABLE `data_kontrak_pemasok` (
  `ID_KONTRAK_PEMASOK` varchar(5) NOT NULL,
  `NOPJBBM_KONTRAK_PEMASOK` varchar(20) DEFAULT NULL,
  `TGL_KONTRAK_PEMASOK` date DEFAULT NULL,
  `JUDUL_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `PERIODE_AWAL_KONTRAK_PEMASOK` date DEFAULT NULL,
  `PERIODE_AKHIR_KONTRAK_PEMASOK` date DEFAULT NULL,
  `JENIS_KONTRAK_PEMASOK` char(1) DEFAULT NULL,
  `VOLUME_KONTRAK_PEMASOK` int(11) DEFAULT NULL,
  `ALPHA_KONTRAK_PEMASOK` float DEFAULT NULL,
  `RUPIAH_KONTRAK_PEMASOK` int(11) DEFAULT NULL,
  `PENJAMIN_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `NO_PENJAMIN_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `NOMINAL_JAMINAN_KONTRAK` int(11) DEFAULT NULL,
  `TGL_BERAKHIR_JAMINAN_KONTRAK` date DEFAULT NULL,
  `KET_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `CD_KONTRAK_PEMASOK` date DEFAULT NULL,
  `CD_BY_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `UD_KONTRAK_PEMASOK` date DEFAULT NULL,
  `ISAKTIF_KONTRAK_PEMASOK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `data_kontrak_pemasok` */

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
  `SLOC` varchar(10) NOT NULL,
  `ID_DEPO` varchar(20) NOT NULL,
  `ID_DET_KONTRAK_TRANS` int(11) NOT NULL,
  `TYPE_KONTRAK_TRANS` char(1) DEFAULT NULL,
  `HARGA_KONTRAK_TRANS` int(11) DEFAULT NULL,
  `CD_DET_KONTRAK_TRANS` date DEFAULT NULL,
  `CD_BY_DET_KONTRAK_TRANS` varchar(100) DEFAULT NULL,
  `UD_DET_KONTRAK_TRANS` date DEFAULT NULL,
  PRIMARY KEY (`ID_KONTRAK_TRANS`,`SLOC`,`ID_DEPO`,`ID_DET_KONTRAK_TRANS`),
  KEY `FK_RELATIONSHIP_15` (`SLOC`),
  KEY `FK_RELATIONSHIP_23` (`ID_DEPO`),
  CONSTRAINT `FK_RELATIONSHIP_14` FOREIGN KEY (`ID_KONTRAK_TRANS`) REFERENCES `data_kontrak_transportir` (`ID_KONTRAK_TRANS`),
  CONSTRAINT `FK_RELATIONSHIP_15` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_23` FOREIGN KEY (`ID_DEPO`) REFERENCES `master_depo` (`ID_DEPO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `det_kontrak_trans` */

/*Table structure for table `det_tera_tangki` */

DROP TABLE IF EXISTS `det_tera_tangki`;

CREATE TABLE `det_tera_tangki` (
  `ID_TANGKI` varchar(4) NOT NULL,
  `ID_TERA` varchar(5) NOT NULL,
  `ID_DET_TERA` varchar(5) NOT NULL,
  `PATH_DET_TERA` varchar(100) DEFAULT NULL,
  `TGL_DET_TERA` date DEFAULT NULL,
  `ISAKTIF_DET_TERA` char(1) DEFAULT NULL,
  `CD_BY_DET_TERA` date DEFAULT NULL,
  `CD_DET_TERA` varchar(100) DEFAULT NULL,
  `UD_DET_TERA` date DEFAULT NULL,
  PRIMARY KEY (`ID_TANGKI`,`ID_TERA`,`ID_DET_TERA`),
  KEY `FK_RELATIONSHIP_22` (`ID_TERA`),
  CONSTRAINT `FK_RELATIONSHIP_21` FOREIGN KEY (`ID_TANGKI`) REFERENCES `master_tangki` (`ID_TANGKI`),
  CONSTRAINT `FK_RELATIONSHIP_22` FOREIGN KEY (`ID_TERA`) REFERENCES `master_tera` (`ID_TERA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `det_tera_tangki` */

/*Table structure for table `detail_jalur_pasokan` */

DROP TABLE IF EXISTS `detail_jalur_pasokan`;

CREATE TABLE `detail_jalur_pasokan` (
  `ID_DEPO` varchar(20) NOT NULL,
  `SLOC` varchar(10) NOT NULL,
  `ID_JALUR_PASOKAN` varchar(5) NOT NULL,
  `CD_JALUR_PASOKAN` date DEFAULT NULL,
  `UD_JALUR_PASOKAN` date DEFAULT NULL,
  `UD_BY_JALUR_PASOKAN` varchar(100) DEFAULT NULL,
  `ISAKTIF_JALUR_PASOKAN` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_DEPO`,`SLOC`,`ID_JALUR_PASOKAN`),
  KEY `FK_RELATIONSHIP_12` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`ID_DEPO`) REFERENCES `master_depo` (`ID_DEPO`),
  CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `detail_jalur_pasokan` */

/*Table structure for table `doc_kontrak_pemasok` */

DROP TABLE IF EXISTS `doc_kontrak_pemasok`;

CREATE TABLE `doc_kontrak_pemasok` (
  `ID_DOC_PEMASOK` char(5) NOT NULL,
  `ID_KONTRAK_PEMASOK` varchar(5) NOT NULL,
  `PATH_DOC_PEMASOK` varchar(100) DEFAULT NULL,
  `CD_DOC_PEMASOK` date DEFAULT NULL,
  `CD_BY_DOC_PEMASOK` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_DOC_PEMASOK`),
  KEY `FK_RELATIONSHIP_24` (`ID_KONTRAK_PEMASOK`),
  CONSTRAINT `FK_RELATIONSHIP_24` FOREIGN KEY (`ID_KONTRAK_PEMASOK`) REFERENCES `data_kontrak_pemasok` (`ID_KONTRAK_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `doc_kontrak_pemasok` */

/*Table structure for table `file_adendum_kontrak_pemasok` */

DROP TABLE IF EXISTS `file_adendum_kontrak_pemasok`;

CREATE TABLE `file_adendum_kontrak_pemasok` (
  `ID_FILE_KONTRAK_PEMASOK` varchar(5) NOT NULL,
  `ID_ADENDUM_PEMASOK` varchar(5) NOT NULL,
  `PATH_FILE_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  `CD_FILE_KONTRAK_PEMASOK` date DEFAULT NULL,
  `UD_FILE_KONTRAK_PEMASOK` date DEFAULT NULL,
  `FILE_KONTRAK_PEMASOK` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_FILE_KONTRAK_PEMASOK`),
  KEY `FK_RELATIONSHIP_26` (`ID_ADENDUM_PEMASOK`),
  CONSTRAINT `FK_RELATIONSHIP_26` FOREIGN KEY (`ID_ADENDUM_PEMASOK`) REFERENCES `adendum_kontrak_pemasok` (`ID_ADENDUM_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `file_adendum_kontrak_pemasok` */

/*Table structure for table `m_jns_bhn_bkr` */

DROP TABLE IF EXISTS `m_jns_bhn_bkr`;

CREATE TABLE `m_jns_bhn_bkr` (
  `ID_JNS_BHN_BKR` varchar(5) NOT NULL,
  `NAMA_JNS_BHN_BKR` varchar(50) DEFAULT NULL,
  `KODE_JNS_BHN_BKR` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_JNS_BHN_BKR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_jns_bhn_bkr` */

/*Table structure for table `m_menu` */

DROP TABLE IF EXISTS `m_menu`;

CREATE TABLE `m_menu` (
  `MENU_ID` char(3) NOT NULL,
  `M_M_MENU_ID` char(3) DEFAULT NULL,
  `MENU_NAMA` varchar(100) DEFAULT NULL,
  `MENU_URL` varchar(100) DEFAULT NULL,
  `MENU_KETERANGAN` varchar(100) DEFAULT NULL,
  `MENU_ICON` varchar(50) DEFAULT NULL,
  `MENU_URUTAN` int(11) DEFAULT NULL,
  PRIMARY KEY (`MENU_ID`),
  KEY `FK_RELATIONSHIP_19` (`M_M_MENU_ID`),
  CONSTRAINT `FK_RELATIONSHIP_19` FOREIGN KEY (`M_M_MENU_ID`) REFERENCES `m_menu` (`MENU_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_menu` */

insert  into `m_menu`(`MENU_ID`,`M_M_MENU_ID`,`MENU_NAMA`,`MENU_URL`,`MENU_KETERANGAN`,`MENU_ICON`,`MENU_URUTAN`) values ('001',NULL,'Dashboard','#','','icon-dashboard',1),('002',NULL,'User Management','#','','icon-barcode',3),('003','002','Menu Management','user_management/menu','','',1),('004','002','Role Management','user_management/role','','',2),('005','002','User','user_management/user','','',3),('006',NULL,'Data Transaksi','#','','icon-globe',2),('007','006','Stock Opname','data_transaksi/stockopname','','icon-credit-card',1),('008',NULL,'Master','#','','icon-coffee',3);

/*Table structure for table `m_otoritas_menu` */

DROP TABLE IF EXISTS `m_otoritas_menu`;

CREATE TABLE `m_otoritas_menu` (
  `ROLES_ID` char(3) NOT NULL,
  `MENU_ID` char(3) NOT NULL,
  `IS_VIEW` char(1) DEFAULT NULL,
  `IS_ADD` char(1) DEFAULT NULL,
  `IS_EDIT` char(1) DEFAULT NULL,
  `IS_DELETE` char(1) DEFAULT NULL,
  `IS_APPROVE` char(1) DEFAULT NULL,
  `UD_OTORITAS` date DEFAULT NULL,
  PRIMARY KEY (`ROLES_ID`,`MENU_ID`),
  KEY `FK_RELATIONSHIP_18` (`MENU_ID`),
  CONSTRAINT `FK_RELATIONSHIP_17` FOREIGN KEY (`ROLES_ID`) REFERENCES `roles` (`ROLES_ID`),
  CONSTRAINT `FK_RELATIONSHIP_18` FOREIGN KEY (`MENU_ID`) REFERENCES `m_menu` (`MENU_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_otoritas_menu` */

insert  into `m_otoritas_menu`(`ROLES_ID`,`MENU_ID`,`IS_VIEW`,`IS_ADD`,`IS_EDIT`,`IS_DELETE`,`IS_APPROVE`,`UD_OTORITAS`) values ('001','002','t','t','t','t','t',NULL),('001','003','t','t','t','t','t',NULL),('001','004','t','t','t','t','t',NULL),('001','005','t','t','t','t','t',NULL),('001','006','t','t','t','t','t',NULL),('001','007','t','t','t','t','t',NULL),('001','008','t','t','t','t','t',NULL),('01','006','t','t','t','t','t',NULL),('01','007','t','t','t','t','t',NULL),('01','008','t','t','t','t','t',NULL),('02','001','t','t','t','t','t',NULL),('02','002','t','t','t','t','t',NULL),('02','003','t','t','t','t','t',NULL),('02','004','t','t','t','t','t',NULL),('02','005','t','t','t','t','t',NULL),('02','006','t','t','t','t','t',NULL),('02','007','t','t','t','t','t',NULL),('02','008','t','t','t','t','t',NULL),('03','001','t','t','t','t','t',NULL),('03','002','t','t','t','t','t',NULL),('03','003','t','t','t','t','t',NULL),('03','004','t','t','t','t','t',NULL),('03','005','t','t','t','t','t',NULL),('03','006','t','t','t','t','t',NULL),('03','007','t','t','t','t','t',NULL),('03','008','t','t','t','t','t',NULL);

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
  `KODE_LEVEL` varchar(50) DEFAULT NULL,
  `ISAKTIF_USER` char(1) DEFAULT NULL,
  `CD_USER` date DEFAULT NULL,
  `CD_BY_USER` varchar(100) DEFAULT NULL,
  `UD_USER` date DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `FK_RELATIONSHIP_16` (`ROLES_ID`),
  CONSTRAINT `FK_RELATIONSHIP_16` FOREIGN KEY (`ROLES_ID`) REFERENCES `roles` (`ROLES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `m_user` */

insert  into `m_user`(`ID_USER`,`ROLES_ID`,`KD_USER`,`NAMA_USER`,`USERNAME`,`PWD_USER`,`EMAIL_USER`,`LEVEL_USER`,`KODE_LEVEL`,`ISAKTIF_USER`,`CD_USER`,`CD_BY_USER`,`UD_USER`) values (1,'001','xxxx','Adityass','admin','admin','admin','0','0','1',NULL,NULL,NULL),(2,'001','22222','Aditssss','stafflevel2','d9b1d7db4cd6e70935368a1efb10e377','andhambe@yahoo.comsss','1','321','0','2017-10-18','Aditya-0','2017-10-18'),(3,'01','92384273','Gembul','Gembul','123','adityaprandhana@gmail.com','1','321','1','2017-10-18','Adityass-0',NULL),(4,'03','','aa','aa','d9b1d7db4cd6e70935368a1efb10e377','adityaprandhana@gmail.com','2','1','1','2017-10-19','Adityass-0','2017-10-19'),(5,'02','','bb','bb','21ad0bd836b90d08f4cf640b4c298e7c','bb@mail.com','2','1','1','2017-10-19','Adityass-0',NULL);

/*Table structure for table `master_depo` */

DROP TABLE IF EXISTS `master_depo`;

CREATE TABLE `master_depo` (
  `ID_DEPO` varchar(20) NOT NULL,
  `ID_PEMASOK` varchar(20) NOT NULL,
  `NAMA_DEPO` varchar(150) DEFAULT NULL,
  `LAT_DEPO` varchar(100) DEFAULT NULL,
  `LOT_DEPO` varchar(100) DEFAULT NULL,
  `ALAMAT_DEPO` varchar(150) DEFAULT NULL,
  `FLAG_DEPO` char(1) DEFAULT NULL,
  `UD_DEPO` date DEFAULT NULL,
  `CD_DEPO` date DEFAULT NULL,
  `CD_BY_DEPO` varchar(100) DEFAULT NULL,
  `ISAKTIF_DEPO` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_DEPO`),
  KEY `FK_RELATIONSHIP_8` (`ID_PEMASOK`),
  CONSTRAINT `FK_RELATIONSHIP_8` FOREIGN KEY (`ID_PEMASOK`) REFERENCES `master_pemasok` (`ID_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_depo` */

/*Table structure for table `master_level1` */

DROP TABLE IF EXISTS `master_level1`;

CREATE TABLE `master_level1` (
  `COCODE` varchar(10) NOT NULL,
  `ID_REGIONAL` varchar(2) NOT NULL,
  `LEVEL1` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL1` varchar(50) DEFAULT NULL,
  `IS_AKTIF_LVL1` char(1) DEFAULT NULL,
  PRIMARY KEY (`COCODE`),
  KEY `FK_RELATIONSHIP_5` (`ID_REGIONAL`),
  CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`ID_REGIONAL`) REFERENCES `master_regional` (`ID_REGIONAL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level1` */

insert  into `master_level1`(`COCODE`,`ID_REGIONAL`,`LEVEL1`,`DESCRIPTION_LVL1`,`IS_AKTIF_LVL1`) values ('321','1','Level 1',NULL,NULL);

/*Table structure for table `master_level2` */

DROP TABLE IF EXISTS `master_level2`;

CREATE TABLE `master_level2` (
  `PLANT` varchar(10) NOT NULL,
  `COCODE` varchar(10) NOT NULL,
  `LEVEL2` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL2` varchar(100) DEFAULT NULL,
  `IS_AKTIF_LVL2` char(1) DEFAULT NULL,
  PRIMARY KEY (`PLANT`),
  KEY `FK_RELATIONSHIP_1` (`COCODE`),
  CONSTRAINT `FK_RELATIONSHIP_1` FOREIGN KEY (`COCODE`) REFERENCES `master_level1` (`COCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level2` */

insert  into `master_level2`(`PLANT`,`COCODE`,`LEVEL2`,`DESCRIPTION_LVL2`,`IS_AKTIF_LVL2`) values ('1','321','Level 2',NULL,NULL),('2','321','Level 2',NULL,NULL);

/*Table structure for table `master_level3` */

DROP TABLE IF EXISTS `master_level3`;

CREATE TABLE `master_level3` (
  `PLANT` varchar(10) NOT NULL,
  `STORE_SLOC` varchar(10) NOT NULL,
  `LEVEL3` varchar(50) DEFAULT NULL,
  `DESCRIPTION_LVL3` varchar(100) DEFAULT NULL,
  `IS_AKTIF_LVL3` char(1) DEFAULT NULL,
  PRIMARY KEY (`PLANT`,`STORE_SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`PLANT`) REFERENCES `master_level2` (`PLANT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_level3` */

insert  into `master_level3`(`PLANT`,`STORE_SLOC`,`LEVEL3`,`DESCRIPTION_LVL3`,`IS_AKTIF_LVL3`) values ('1','24234','Level 3',NULL,NULL);

/*Table structure for table `master_level4` */

DROP TABLE IF EXISTS `master_level4`;

CREATE TABLE `master_level4` (
  `SLOC` varchar(10) NOT NULL,
  `PLANT` varchar(10) DEFAULT NULL,
  `STORE_SLOC` varchar(10) DEFAULT NULL,
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

insert  into `master_level4`(`SLOC`,`PLANT`,`STORE_SLOC`,`LEVEL4`,`DESCRIPTION_LVL4`,`IS_AKTI_LVL4`,`LAT_LVL4`,`LOT_LVL4`) values ('33332','1',NULL,'Level 4',NULL,NULL,NULL,NULL),('34234','1','24234','Level 4',NULL,NULL,NULL,NULL);

/*Table structure for table `master_pemasok` */

DROP TABLE IF EXISTS `master_pemasok`;

CREATE TABLE `master_pemasok` (
  `ID_PEMASOK` varchar(20) NOT NULL,
  `KODE_PEMASOK` varchar(50) NOT NULL,
  `NAMA_PEMASOK` varchar(50) DEFAULT NULL,
  `CD_PEMASOK` date DEFAULT NULL,
  `CD_BY_PEMASOK` varchar(100) DEFAULT NULL,
  `UD_PEMASOK` date DEFAULT NULL,
  `ISAKTIF_PEMASOK` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_PEMASOK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_pemasok` */

/*Table structure for table `master_regional` */

DROP TABLE IF EXISTS `master_regional`;

CREATE TABLE `master_regional` (
  `ID_REGIONAL` varchar(2) NOT NULL,
  `NAMA_REGIONAL` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_REGIONAL`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_regional` */

insert  into `master_regional`(`ID_REGIONAL`,`NAMA_REGIONAL`) values ('1','Wilayah');

/*Table structure for table `master_tangki` */

DROP TABLE IF EXISTS `master_tangki`;

CREATE TABLE `master_tangki` (
  `ID_TANGKI` varchar(4) NOT NULL,
  `ID_JNS_BHN_BKR` varchar(5) NOT NULL,
  `SLOC` varchar(10) NOT NULL,
  `NAMA_TANGKI` varchar(50) DEFAULT NULL,
  `VOLUME_TANGKI` int(11) DEFAULT NULL,
  `DEADSTOCK_TANGKI` int(11) DEFAULT NULL,
  `CD_TANGKI` date DEFAULT NULL,
  `UD_TANGKI` date DEFAULT NULL,
  `STOCKEFEKTIF_TANGKI` int(11) DEFAULT NULL,
  `UD_BY_TANGKI` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_TANGKI`),
  KEY `FK_RELATIONSHIP_20` (`ID_JNS_BHN_BKR`),
  KEY `FK_RELATIONSHIP_9` (`SLOC`),
  CONSTRAINT `FK_RELATIONSHIP_20` FOREIGN KEY (`ID_JNS_BHN_BKR`) REFERENCES `m_jns_bhn_bkr` (`ID_JNS_BHN_BKR`),
  CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`SLOC`) REFERENCES `master_level4` (`SLOC`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_tangki` */

/*Table structure for table `master_tera` */

DROP TABLE IF EXISTS `master_tera`;

CREATE TABLE `master_tera` (
  `ID_TERA` varchar(5) NOT NULL,
  `NAMA_TERA` varchar(100) DEFAULT NULL,
  `CD_TERA` date DEFAULT NULL,
  `CD_BY_TERA` varchar(100) DEFAULT NULL,
  `UD_TERA` date DEFAULT NULL,
  `ISAKTIF_TERA` char(1) DEFAULT NULL,
  PRIMARY KEY (`ID_TERA`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `master_tera` */

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

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `ROLES_ID` char(3) NOT NULL,
  `ROLES_NAMA` varchar(50) DEFAULT NULL,
  `ROLES_KETERANGAN` varchar(100) DEFAULT NULL,
  `CD_ROLES` date DEFAULT NULL,
  `UP_ROLES` date DEFAULT NULL,
  `LEVEL_ROLES` char(1) DEFAULT NULL,
  PRIMARY KEY (`ROLES_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `roles` */

insert  into `roles`(`ROLES_ID`,`ROLES_NAMA`,`ROLES_KETERANGAN`,`CD_ROLES`,`UP_ROLES`,`LEVEL_ROLES`) values ('001','Administrator','',NULL,NULL,'0'),('01','Staff Level 1','-',NULL,NULL,'1'),('02','Staff lvl 2','',NULL,NULL,NULL),('03','staff lvl 4','',NULL,NULL,NULL);

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `VALUE` varchar(100) DEFAULT NULL,
  `SETTING` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `setting` */

insert  into `setting`(`VALUE`,`SETTING`) values ('GBM (Gas Bahan bakar Minyak)','nama_aplikasi');

/* Function  structure for function  `SPLIT_STR` */

/*!50003 DROP FUNCTION IF EXISTS `SPLIT_STR` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` FUNCTION `SPLIT_STR`(`X` VARCHAR(255), `delim` VARCHAR(12), `pos` INT) RETURNS varchar(255) CHARSET latin1
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(X, delim, pos),
       LENGTH(SUBSTRING_INDEX(X, delim, pos -1)) + 1),
       delim, '') */$$
DELIMITER ;

/* Procedure structure for procedure `save_user` */

/*!50003 DROP PROCEDURE IF EXISTS  `save_user` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `save_user`(in p_role_id char(30), in p_kd_user varchar(20), in p_nama_user varchar(50),
    in p_username varchar(100), in p_pwd varchar(100), in p_email varchar(50), in p_level char(1), in p_kode_level varchar(50),
    in p_isaktif char(10), in p_cd_user varchar(100), IN p_id_user varchar(20))
BEGIN
	declare _count int default 0;
	DECLARE `_rollback` BOOL DEFAULT 0;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET `_rollback` = 1;
	START TRANSACTION;
	
	select count(*) into _count 
	from m_user where USERNAME =  p_username;
	if _count = 1 and p_id_user = '' then
		select 'RC00' as RCDB, 'Username is Exist' as PESANDB from dual;
	else
		if p_id_user = '' then
			select count(*) into _count
			from m_user;
			
			insert into m_user (id_user, `ROLES_ID`, `KD_USER`, `NAMA_USER`, `USERNAME`, `PWD_USER`, `EMAIL_USER`,
			`LEVEL_USER`, `KODE_LEVEL`, `ISAKTIF_USER`, `CD_USER`, `CD_BY_USER`)
			values ((_count + 1), p_role_id, p_kd_user, p_nama_user, p_username, md5(p_pwd), p_email, p_level, p_kode_level,
			p_isaktif, curdate(), p_cd_user);
			IF `_rollback` THEN
				ROLLBACK;
				SELECT 'RC00' AS RCDB, 'GAGAL SIMPAN DATA' AS PESANDB
				from DUAL;
			ELSE
				COMMIT;
				SELECT 'RC01' AS RCDB, 'User Berhasil disimpan' AS PESANDB
				FROM DUAL;
			END IF;	
		ELSE
			UPDATE m_user
			set ROLES_ID = p_role_id,
			KD_USER = p_kd_user,
			NAMA_USER = p_nama_user ,
			PWD_USER = md5(p_pwd) ,
			EMAIL_USER =  p_email,
			`LEVEL_USER` = p_level ,
			`KODE_LEVEL` = p_kode_level,
			`ISAKTIF_USER` = p_isaktif,
			`UD_USER` = curdate()
			where `ID_USER` = p_id_user;
			
			IF `_rollback` THEN
				ROLLBACK;
				SELECT 'RC00' AS RCDB, 'GAGAL UPDATE DATA' AS PESANDB
				FROM DUAL;
			ELSE
				COMMIT;
				SELECT 'RC01' AS RCDB, 'User Berhasil dirubah' AS PESANDB
				FROM DUAL;
			END IF;	
		END IF;
	end if;
	
    END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
