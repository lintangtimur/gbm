/*
SQLyog Community v12.4.3 (64 bit)
MySQL - 10.1.19-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `t_perhitungan` (
	`ID_PERHITUNGAN` int (11),
	`Periode` int (11),
	`Type` varchar (90),
	`SLOC` varchar (30),
	`ID_PEMASOK` varchar (60),
	`blth` varchar (180),
	`sulfur` varchar (180),
	`alphahsd` varchar (180),
	`alphamfo` varchar (180),
	`tanggal` datetime ,
	`tanggal_awal` datetime ,
	`tanggal_akhir` datetime ,
	`Harga` varchar (450),
	`FOB1` varchar (450),
	`FOB2` varchar (450),
	`rmopshsd` varchar (180),
	`rmopsmfo` varchar (180),
	`hsdppn` varchar (180),
	`hsdnoppn` varchar (180),
	`mfoppn` varchar (180),
	`mfonoppn` varchar (180)
); 
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('1',NULL,NULL,NULL,NULL,'January 2017','0.9827','107','109.50','2017-09-27 03:27:30','2016-10-28 00:00:00','2016-10-28 00:00:00','12983','829464','4071715','60.76','286.41','5742','5220','4337','3942');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('2',NULL,NULL,NULL,NULL,'February 2017','0.9827','107','109.50','2017-09-27 03:27:53','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('3',NULL,NULL,NULL,NULL,'March 2017','0.9827','107','109.50','2017-09-27 03:28:06','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('4',NULL,NULL,NULL,NULL,'April 2017','0.9827','107','109.50','2017-09-27 03:28:25','2016-10-26 00:00:00','2016-10-26 00:00:00','12932','826478','4082908','60.78','288.33','5721','5201','4349','3953');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('5',NULL,NULL,NULL,NULL,'May 2017','0.9827','107','109.50','2017-09-27 03:28:39','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('6',NULL,NULL,NULL,NULL,'June 2017','0.9827','107','109.50','2017-09-27 03:28:55','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('7',NULL,NULL,NULL,NULL,'July 2017','0.9827','107','109.50','2017-09-27 03:29:01','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('8',NULL,NULL,NULL,NULL,'August 2017','0.9827','107','109.50','2017-09-27 03:29:09','2016-10-27 00:00:00','2016-10-27 00:00:00','12962','828259','4076767','60.77','287.23','5734','5212','4342','3947');
insert into `t_perhitungan` (`ID_PERHITUNGAN`, `Periode`, `Type`, `SLOC`, `ID_PEMASOK`, `blth`, `sulfur`, `alphahsd`, `alphamfo`, `tanggal`, `tanggal_awal`, `tanggal_akhir`, `Harga`, `FOB1`, `FOB2`, `rmopshsd`, `rmopsmfo`, `hsdppn`, `hsdnoppn`, `mfoppn`, `mfonoppn`) values('9',NULL,NULL,NULL,NULL,'September 2017','0.9827','107','109.50','2017-09-27 03:30:17','2016-10-26 00:00:00','2016-10-26 00:00:00','12932','826478','4082908','60.78','288.33','5721','5201','4349','3953');
