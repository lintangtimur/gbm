drop table if exists ADENDUM_KONTRAK_PEMASOK;

drop table if exists DATA_KONTRAK_PEMASOK;

drop table if exists DATA_KONTRAK_TRANSPORTIR;

drop table if exists DETAIL_JALUR_PASOKAN;

drop table if exists DET_KONTRAK_TRANS;

drop table if exists DET_TERA_TANGKI;

drop table if exists EVIDANCE_KONTRAK_PEMASOK;

drop table if exists MASTER_DEPO;

drop table if exists MASTER_LEVEL1;

drop table if exists MASTER_LEVEL2;

drop table if exists MASTER_LEVEL3;

drop table if exists MASTER_LEVEL4;

drop table if exists MASTER_PEMASOK;

drop table if exists MASTER_REGIONAL;

drop table if exists MASTER_TANGKI;

drop table if exists MASTER_TERA;

drop table if exists MASTER_TRANSPORTIR;

drop table if exists M_JNS_BHN_BKR;

/*==============================================================*/
/* Table: ADENDUM_KONTRAK_PEMASOK                               */
/*==============================================================*/
create table ADENDUM_KONTRAK_PEMASOK
(
   ID_ADENDUM_PEMASOK   varchar(5) not null,
   ID_KONTRAK_PEMASOK   varchar(5) not null,
   NO_ADENDUM_PEMASOK   varchar(20),
   TGL_ADENDUM_PEMASOK  date,
   JUDUL_ADENDUM_PEMASOK varchar(100),
   PERIODE_AWAL_ADENDUM_PEMASOK date,
   PERIODE_AKHIR_ADENMDUM_PEMASOK date,
   JENIS_AKHIR_ADENDUM_PEMASOK char(1),
   VOL_AKHIR_ADENDUM_PEMASOK int,
   ALPHA_ADENDUM_PEMASOK float,
   RP_ADENDUM_PEMASOK   int,
   PENJAMIN_ADENDUM_PEMASOK varchar(100),
   NO_PENJAMIN_ADENDUM_PEMASOK varchar(20),
   NOMINAL_ADENDUM_PEMASOK int,
   TGL_AKHIR_ADENDUM_PEMASOK date,
   KET_ADENDUM_PEMASOK  varchar(100),
   CD_ADENDUM_PEMASOK   date,
   CD_BY_ADENDUM_PEMASOK varchar(100),
   UD_ADENDUM_PEMASOK   date,
   primary key (ID_ADENDUM_PEMASOK)
);

/*==============================================================*/
/* Table: DATA_KONTRAK_PEMASOK                                  */
/*==============================================================*/
create table DATA_KONTRAK_PEMASOK
(
   ID_KONTRAK_PEMASOK   varchar(5) not null,
   NOPJBBM_KONTRAK_PEMASOK varchar(20),
   TGL_KONTRAK_PEMASOK  date,
   JUDUL_KONTRAK_PEMASOK varchar(100),
   PERIODE_AWAL_KONTRAK_PEMASOK date,
   PERIODE_AKHIR_KONTRAK_PEMASOK date,
   JENIS_KONTRAK_PEMASOK char(1),
   VOLUME_KONTRAK_PEMASOK int,
   ALPHA_KONTRAK_PEMASOK float,
   RUPIAH_KONTRAK_PEMASOK int,
   PENJAMIN_KONTRAK_PEMASOK varchar(100),
   NO_PENJAMIN_KONTRAK_PEMASOK varchar(100),
   NOMINAL_JAMINAN_KONTRAK int,
   TGL_BERAKHIR_JAMINAN_KONTRAK date,
   KET_KONTRAK_PEMASOK  varchar(100),
   CD_KONTRAK_PEMASOK   date,
   CD_BY_KONTRAK_PEMASOK varchar(100),
   UD_KONTRAK_PEMASOK   date,
   ISAKTIF_KONTRAK_PEMASOK char(1),
   primary key (ID_KONTRAK_PEMASOK)
);

/*==============================================================*/
/* Table: DATA_KONTRAK_TRANSPORTIR                              */
/*==============================================================*/
create table DATA_KONTRAK_TRANSPORTIR
(
   ID_KONTRAK_TRANS     int not null,
   ID_TRANSPORTIR       varchar(20) not null,
   KD_KONTRAK_TRANS     varchar(50),
   TGL_KONTRAK_TRANS    date,
   NILAI_KONTRAK_TRANS  int,
   KET_KONTRAK_TRANS    varchar(200),
   PATH_KONTRAK_TRANS   varchar(100),
   primary key (ID_KONTRAK_TRANS)
);

/*==============================================================*/
/* Table: DETAIL_JALUR_PASOKAN                                  */
/*==============================================================*/
create table DETAIL_JALUR_PASOKAN
(
   ID_DEPO              varchar(20) not null,
   SLOC                 varchar(10) not null,
   ID_JALUR_PASOKAN     varchar(5) not null,
   CD_JALUR_PASOKAN     date,
   UD_JALUR_PASOKAN     date,
   UD_BY_JALUR_PASOKAN  varchar(100),
   ISAKTIF_JALUR_PASOKAN char(1),
   primary key (ID_DEPO, SLOC, ID_JALUR_PASOKAN)
);

/*==============================================================*/
/* Table: DET_KONTRAK_TRANS                                     */
/*==============================================================*/
create table DET_KONTRAK_TRANS
(
   ID_KONTRAK_TRANS     int not null,
   SLOC                 varchar(10) not null,
   ID_DEPO              varchar(20) not null,
   ID_DET_KONTRAK_TRANS int not null,
   TYPE_KONTRAK_TRANS   char(1),
   HARGA_KONTRAK_TRANS  int,
   CD_DET_KONTRAK_TRANS date,
   CD_BY_DET_KONTRAK_TRANS varchar(100),
   UD_DET_KONTRAK_TRANS date,
   primary key (ID_KONTRAK_TRANS, SLOC, ID_DEPO, ID_DET_KONTRAK_TRANS)
);

/*==============================================================*/
/* Table: DET_TERA_TANGKI                                       */
/*==============================================================*/
create table DET_TERA_TANGKI
(
   ID_TANGKI            varchar(4) not null,
   ID_TERA              varchar(5) not null,
   ID_DET_TERA          varchar(5) not null,
   PATH_DET_TERA        varchar(100),
   TGL_DET_TERA         date,
   ISAKTIF_DET_TERA     char(1),
   CD_BY_DET_TERA       date,
   CD_DET_TERA          varchar(100),
   UD_DET_TERA          date,
   primary key (ID_TANGKI, ID_TERA, ID_DET_TERA)
);

/*==============================================================*/
/* Table: EVIDANCE_KONTRAK_PEMASOK                              */
/*==============================================================*/
create table EVIDANCE_KONTRAK_PEMASOK
(
   ID_EVIDANCE_PEMASOK  char(5) not null,
   ID_KONTRAK_PEMASOK   varchar(5) not null,
   PATH_EVIDANCE_PEMASOK varchar(100),
   CD_EVIDANCE_PEMASOK  date,
   CD_BY_EVIDANCE_PEMASOK varchar(100),
   primary key (ID_EVIDANCE_PEMASOK)
);

/*==============================================================*/
/* Table: MASTER_DEPO                                           */
/*==============================================================*/
create table MASTER_DEPO
(
   ID_DEPO              varchar(20) not null,
   ID_PEMASOK           varchar(20) not null,
   NAMA_DEPO            varchar(150),
   LAT_DEPO             varchar(100),
   LOT_DEPO             varchar(100),
   ALAMAT_DEPO          varchar(150),
   FLAG_DEPO            char(1),
   UD_DEPO              date,
   CD_DEPO              date,
   CD_BY_DEPO           varchar(100),
   ISAKTIF_DEPO         char(1),
   primary key (ID_DEPO)
);

/*==============================================================*/
/* Table: MASTER_LEVEL1                                         */
/*==============================================================*/
create table MASTER_LEVEL1
(
   COCODE               varchar(10) not null,
   ID_REGIONAL          varchar(2) not null,
   LEVEL1               varchar(50),
   DESCRIPTION_LVL1     varchar(50),
   IS_AKTIF_LVL1        char(1),
   primary key (COCODE)
);

/*==============================================================*/
/* Table: MASTER_LEVEL2                                         */
/*==============================================================*/
create table MASTER_LEVEL2
(
   PLANT                varchar(10) not null,
   COCODE               varchar(10) not null,
   LEVEL2               varchar(50),
   DESCRIPTION_LVL2     varchar(100),
   IS_AKTIF_LVL2        char(1),
   primary key (PLANT)
);

/*==============================================================*/
/* Table: MASTER_LEVEL3                                         */
/*==============================================================*/
create table MASTER_LEVEL3
(
   PLANT                varchar(10) not null,
   STORE_SLOC           varchar(10) not null,
   LEVEL3               varchar(50),
   DESCRIPTION_LVL3     varchar(100),
   IS_AKTIF_LVL3        char(1),
   primary key (PLANT, STORE_SLOC)
);

/*==============================================================*/
/* Table: MASTER_LEVEL4                                         */
/*==============================================================*/
create table MASTER_LEVEL4
(
   SLOC                 varchar(10) not null,
   PLANT                varchar(10),
   STORE_SLOC           varchar(10),
   LEVEL4               varchar(50),
   DESCRIPTION_LVL4     varchar(50),
   IS_AKTI_LVL4         char(1),
   LAT_LVL4             varchar(100),
   LOT_LVL4             varchar(100),
   primary key (SLOC)
);

/*==============================================================*/
/* Table: MASTER_PEMASOK                                        */
/*==============================================================*/
create table MASTER_PEMASOK
(
   ID_PEMASOK           varchar(20) not null,
   KODE_PEMASOK         varchar(50) not null,
   NAMA_PEMASOK         varchar(50),
   CD_PEMASOK           date,
   CD_BY_PEMASOK        varchar(100),
   UD_PEMASOK           date,
   ISAKTIF_PEMASOK      char(1),
   primary key (ID_PEMASOK)
);

/*==============================================================*/
/* Table: MASTER_REGIONAL                                       */
/*==============================================================*/
create table MASTER_REGIONAL
(
   ID_REGIONAL          varchar(2) not null,
   NAMA_REGIONAL        varchar(50),
   primary key (ID_REGIONAL)
);

/*==============================================================*/
/* Table: MASTER_TANGKI                                         */
/*==============================================================*/
create table MASTER_TANGKI
(
   ID_TANGKI            varchar(4) not null,
   ID_JNS_BHN_BKR       varchar(5) not null,
   SLOC                 varchar(10) not null,
   NAMA_TANGKI          varchar(50),
   VOLUME_TANGKI        int,
   DEADSTOCK_TANGKI     int,
   CD_TANGKI            date,
   UD_TANGKI            date,
   STOCKEFEKTIF_TANGKI  int,
   UD_BY_TANGKI         varchar(100),
   primary key (ID_TANGKI)
);

/*==============================================================*/
/* Table: MASTER_TERA                                           */
/*==============================================================*/
create table MASTER_TERA
(
   ID_TERA              varchar(5) not null,
   NAMA_TERA            varchar(100),
   CD_TERA              date,
   CD_BY_TERA           varchar(100),
   UD_TERA              date,
   ISAKTIF_TERA         char(1),
   primary key (ID_TERA)
);

/*==============================================================*/
/* Table: MASTER_TRANSPORTIR                                    */
/*==============================================================*/
create table MASTER_TRANSPORTIR
(
   ID_TRANSPORTIR       varchar(20) not null,
   KD_TRANSPORTIR       varchar(50),
   NAMA_TRANSPORTIR     varchar(50),
   KET_TRANSPORTIR      varchar(150),
   primary key (ID_TRANSPORTIR)
);

/*==============================================================*/
/* Table: M_JNS_BHN_BKR                                         */
/*==============================================================*/
create table M_JNS_BHN_BKR
(
   ID_JNS_BHN_BKR       varchar(5) not null,
   NAMA_JNS_BHN_BKR     varchar(50),
   KODE_JNS_BHN_BKR     varchar(50),
   primary key (ID_JNS_BHN_BKR)
);


alter table ADENDUM_KONTRAK_PEMASOK add constraint FK_RELATIONSHIP_25 foreign key (ID_KONTRAK_PEMASOK)
      references DATA_KONTRAK_PEMASOK (ID_KONTRAK_PEMASOK) on delete restrict on update restrict;

alter table DATA_KONTRAK_TRANSPORTIR add constraint FK_RELATIONSHIP_13 foreign key (ID_TRANSPORTIR)
      references MASTER_TRANSPORTIR (ID_TRANSPORTIR) on delete restrict on update restrict;

alter table DETAIL_JALUR_PASOKAN add constraint FK_RELATIONSHIP_11 foreign key (ID_DEPO)
      references MASTER_DEPO (ID_DEPO) on delete restrict on update restrict;

alter table DETAIL_JALUR_PASOKAN add constraint FK_RELATIONSHIP_12 foreign key (SLOC)
      references MASTER_LEVEL4 (SLOC) on delete restrict on update restrict;

alter table DET_KONTRAK_TRANS add constraint FK_RELATIONSHIP_14 foreign key (ID_KONTRAK_TRANS)
      references DATA_KONTRAK_TRANSPORTIR (ID_KONTRAK_TRANS) on delete restrict on update restrict;

alter table DET_KONTRAK_TRANS add constraint FK_RELATIONSHIP_15 foreign key (SLOC)
      references MASTER_LEVEL4 (SLOC) on delete restrict on update restrict;

alter table DET_KONTRAK_TRANS add constraint FK_RELATIONSHIP_23 foreign key (ID_DEPO)
      references MASTER_DEPO (ID_DEPO) on delete restrict on update restrict;

alter table DET_TERA_TANGKI add constraint FK_RELATIONSHIP_21 foreign key (ID_TANGKI)
      references MASTER_TANGKI (ID_TANGKI) on delete restrict on update restrict;

alter table DET_TERA_TANGKI add constraint FK_RELATIONSHIP_22 foreign key (ID_TERA)
      references MASTER_TERA (ID_TERA) on delete restrict on update restrict;

alter table EVIDANCE_KONTRAK_PEMASOK add constraint FK_RELATIONSHIP_24 foreign key (ID_KONTRAK_PEMASOK)
      references DATA_KONTRAK_PEMASOK (ID_KONTRAK_PEMASOK) on delete restrict on update restrict;

alter table MASTER_DEPO add constraint FK_RELATIONSHIP_8 foreign key (ID_PEMASOK)
      references MASTER_PEMASOK (ID_PEMASOK) on delete restrict on update restrict;

alter table MASTER_LEVEL1 add constraint FK_RELATIONSHIP_5 foreign key (ID_REGIONAL)
      references MASTER_REGIONAL (ID_REGIONAL) on delete restrict on update restrict;

alter table MASTER_LEVEL2 add constraint FK_RELATIONSHIP_1 foreign key (COCODE)
      references MASTER_LEVEL1 (COCODE) on delete restrict on update restrict;

alter table MASTER_LEVEL3 add constraint FK_RELATIONSHIP_2 foreign key (PLANT)
      references MASTER_LEVEL2 (PLANT) on delete restrict on update restrict;

alter table MASTER_LEVEL4 add constraint FK_RELATIONSHIP_6 foreign key (PLANT, STORE_SLOC)
      references MASTER_LEVEL3 (PLANT, STORE_SLOC) on delete restrict on update restrict;

alter table MASTER_TANGKI add constraint FK_RELATIONSHIP_20 foreign key (ID_JNS_BHN_BKR)
      references M_JNS_BHN_BKR (ID_JNS_BHN_BKR) on delete restrict on update restrict;

alter table MASTER_TANGKI add constraint FK_RELATIONSHIP_9 foreign key (SLOC)
      references MASTER_LEVEL4 (SLOC) on delete restrict on update restrict;
