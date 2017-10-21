/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 10.1.19-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `master_depo` (
	`ID_DEPO` varchar (60),
	`KD_DEPO` varchar (60),
	`ID_PEMASOK` varchar (60),
	`NAMA_DEPO` varchar (450),
	`LAT_DEPO` varchar (300),
	`LOT_DEPO` varchar (300),
	`ALAMAT_DEPO` varchar (450),
	`FLAG_DEPO` char (3),
	`UD_DEPO` date ,
	`CD_DEPO` date ,
	`CD_BY_DEPO` varchar (300),
	`ISAKTIF_DEPO` char (3)
); 
insert into `master_depo` (`ID_DEPO`, `KD_DEPO`, `ID_PEMASOK`, `NAMA_DEPO`, `LAT_DEPO`, `LOT_DEPO`, `ALAMAT_DEPO`, `FLAG_DEPO`, `UD_DEPO`, `CD_DEPO`, `CD_BY_DEPO`, `ISAKTIF_DEPO`) values('001','001','002','Depo Cilacap','121','55','Cilacap',NULL,NULL,NULL,NULL,NULL);
insert into `master_depo` (`ID_DEPO`, `KD_DEPO`, `ID_PEMASOK`, `NAMA_DEPO`, `LAT_DEPO`, `LOT_DEPO`, `ALAMAT_DEPO`, `FLAG_DEPO`, `UD_DEPO`, `CD_DEPO`, `CD_BY_DEPO`, `ISAKTIF_DEPO`) values('002','002','001','Depot Depok','122','r121','Depok',NULL,NULL,NULL,NULL,NULL);
