/*==============================================================*/
/* DBMS name:      Sybase AS Anywhere 9                         */
/* Created on:     03.06.2022 14:31:14                          */
/*==============================================================*/


if exists(select 1 from sys.sysforeignkey where role='FK_TIKETY_UPRAVUJI_KATEGORI') then
    alter table TIKETY
       delete foreign key FK_TIKETY_UPRAVUJI_KATEGORI
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_TIKETY_ZADAVAJI_UZIVATEL') then
    alter table TIKETY
       delete foreign key FK_TIKETY_ZADAVAJI_UZIVATEL
end if;

if exists(select 1 from sys.sysforeignkey where role='FK_TIKETY_ZPRACOVAV_TECHNICI') then
    alter table TIKETY
       delete foreign key FK_TIKETY_ZPRACOVAV_TECHNICI
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='KATEGORIE_PK'
     and t.table_name='KATEGORIE'
) then
   drop index KATEGORIE.KATEGORIE_PK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='TECHNICI_PK'
     and t.table_name='TECHNICI'
) then
   drop index TECHNICI.TECHNICI_PK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='TIKETY_PK'
     and t.table_name='TIKETY'
) then
   drop index TIKETY.TIKETY_PK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='UPRAVUJI_FK'
     and t.table_name='TIKETY'
) then
   drop index TIKETY.UPRAVUJI_FK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='ZADAVAJI_FK'
     and t.table_name='TIKETY'
) then
   drop index TIKETY.ZADAVAJI_FK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='ZPRACOVAVAJI_FK'
     and t.table_name='TIKETY'
) then
   drop index TIKETY.ZPRACOVAVAJI_FK
end if;

if exists(
   select 1 from sys.sysindex i, sys.systable t
   where i.table_id=t.table_id 
     and i.index_name='UZIVATELE_PK'
     and t.table_name='UZIVATELE'
) then
   drop index UZIVATELE.UZIVATELE_PK
end if;

if exists(
   select 1 from sys.systable 
   where table_name='KATEGORIE'
     and table_type in ('BASE', 'GBL TEMP')
) then
    drop table KATEGORIE
end if;

if exists(
   select 1 from sys.systable 
   where table_name='TECHNICI'
     and table_type in ('BASE', 'GBL TEMP')
) then
    drop table TECHNICI
end if;

if exists(
   select 1 from sys.systable 
   where table_name='TIKETY'
     and table_type in ('BASE', 'GBL TEMP')
) then
    drop table TIKETY
end if;

if exists(
   select 1 from sys.systable 
   where table_name='UZIVATELE'
     and table_type in ('BASE', 'GBL TEMP')
) then
    drop table UZIVATELE
end if;

/*==============================================================*/
/* Table: KATEGORIE                                             */
/*==============================================================*/
create table KATEGORIE 
(
    ID_KATEGORIE         integer                        not null auto_increment,
    NAZEV                varchar(100),
    POPIS                varchar(1000),
    constraint PK_KATEGORIE primary key (ID_KATEGORIE)
);

/*==============================================================*/
/* Index: KATEGORIE_PK                                          */
/*==============================================================*/
create unique index KATEGORIE_PK on KATEGORIE (
ID_KATEGORIE ASC
);

/*==============================================================*/
/* Table: TECHNICI                                              */
/*==============================================================*/
create table TECHNICI 
(
    ID_TECHNIKA          integer                        not null auto_increment,
    USERNAME             varchar(100),
    JMENO                varchar(100),
    PRIJMENI             varchar(100),
    HESLO                varchar(1000),
    constraint PK_TECHNICI primary key (ID_TECHNIKA)
);

/*==============================================================*/
/* Index: TECHNICI_PK                                           */
/*==============================================================*/
create unique index TECHNICI_PK on TECHNICI (
ID_TECHNIKA ASC
);

/*==============================================================*/
/* Table: TIKETY                                                */
/*==============================================================*/
create table TIKETY 
(
    ID_TIKETU            integer                        not null auto_increment,
    ID_UZIVATELE         integer,
    ID_KATEGORIE         integer,
    ID_TECHNIKA          integer,
    NAZEV                varchar(100),
    POPIS                varchar(1000),
    STAV                 varchar(100),
    constraint PK_TIKETY primary key (ID_TIKETU)
);

/*==============================================================*/
/* Index: TIKETY_PK                                             */
/*==============================================================*/
create unique index TIKETY_PK on TIKETY (
ID_TIKETU ASC
);

/*==============================================================*/
/* Index: ZADAVAJI_FK                                           */
/*==============================================================*/
create  index ZADAVAJI_FK on TIKETY (
ID_UZIVATELE ASC
);

/*==============================================================*/
/* Index: ZPRACOVAVAJI_FK                                       */
/*==============================================================*/
create  index ZPRACOVAVAJI_FK on TIKETY (
ID_TECHNIKA ASC
);

/*==============================================================*/
/* Index: UPRAVUJI_FK                                           */
/*==============================================================*/
create  index UPRAVUJI_FK on TIKETY (
ID_KATEGORIE ASC
);

/*==============================================================*/
/* Table: UZIVATELE                                             */
/*==============================================================*/
create table UZIVATELE 
(
    USERNAME             varchar(100),
    JMENO                varchar(100),
    PRIJMENI             varchar(100),
    ODDELENI             varchar(100),
    HESLO                varchar(1000),
    ID_UZIVATELE         integer                        not null auto_increment,
    constraint PK_UZIVATELE primary key (ID_UZIVATELE)
);

/*==============================================================*/
/* Index: UZIVATELE_PK                                          */
/*==============================================================*/
create unique index UZIVATELE_PK on UZIVATELE (
ID_UZIVATELE ASC
);

alter table TIKETY
   add constraint FK_TIKETY_UPRAVUJI_KATEGORI foreign key (ID_KATEGORIE)
      references KATEGORIE (ID_KATEGORIE)
      on update restrict
      on delete restrict;

alter table TIKETY
   add constraint FK_TIKETY_ZADAVAJI_UZIVATEL foreign key (ID_UZIVATELE)
      references UZIVATELE (ID_UZIVATELE)
      on update restrict
      on delete restrict;

alter table TIKETY
   add constraint FK_TIKETY_ZPRACOVAV_TECHNICI foreign key (ID_TECHNIKA)
      references TECHNICI (ID_TECHNIKA)
      on update restrict
      on delete restrict;

