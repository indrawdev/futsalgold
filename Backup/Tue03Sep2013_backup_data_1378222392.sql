DROP TABLE `2padmin`;

CREATE TABLE `2padmin` (
  `Nama` varchar(255) collate latin1_general_ci NOT NULL,
  `Username` varchar(255) collate latin1_general_ci NOT NULL,
  `Password` varchar(255) collate latin1_general_ci NOT NULL,
  `Jabatan` varchar(255) collate latin1_general_ci NOT NULL,
  `Level` int(10) NOT NULL,
  `Foto` blob NOT NULL,
  `Temp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `2padmin` VALUES("Admin","admin","admin","Supervisor","-1","","2013-09-02 20:43:42","1");
INSERT INTO `2padmin` VALUES("Op2","op2","op1","Operator","1","","2013-09-03 20:52:56","38");
INSERT INTO `2padmin` VALUES("Op1","op1","op1","Operator","1","","2013-09-03 20:53:01","35");
INSERT INTO `2padmin` VALUES("Op3","op3","op3","Operator","1","","2013-09-03 20:53:07","60");



DROP TABLE `2pbackup`;

CREATE TABLE `2pbackup` (
  `ID` int(11) NOT NULL auto_increment,
  `DBPath` varchar(255) collate latin1_general_ci NOT NULL,
  `ToPath` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `2pbackup` VALUES("1","E:\\xampp\\mysql\\data\\pointofsalenew","E:\\Aplikasi\\PointOfSaleNew\\Backup PointOfSale");



DROP TABLE `daftar lapangan`;

CREATE TABLE `daftar lapangan` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(50) collate latin1_general_ci NOT NULL,
  `NamaLapangan` varchar(100) collate latin1_general_ci default '-',
  `Ukuran` varchar(100) collate latin1_general_ci default '-',
  `Kondisi` varchar(100) collate latin1_general_ci default '-',
  `HargaSewa1` int(50) default '0',
  `HargaSewa2` int(50) default '0',
  `HargaSewa3` int(50) default '0',
  `HargaSewa4` int(50) default '0',
  `HargaSewa5` int(50) default '0',
  `Member` int(10) default '0',
  `NonMember` int(10) default '0',
  `Waktu` datetime default NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar lapangan` VALUES("1","L-001","Lapangan Euro","16x26","Baik","80000","125000","70000","115000","0","72000","200","0000-00-00 00:00:00","2013-09-03 15:00:20");
INSERT INTO `daftar lapangan` VALUES("2","L-002","Lapangan Olimpico","15x25","Baik","70000","100000","60000","90000","0","10","100","0000-00-00 00:00:00","2013-09-03 15:00:30");



DROP TABLE `daftar pelanggan`;

CREATE TABLE `daftar pelanggan` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci default '-',
  `NamaPenyewa` varchar(255) collate latin1_general_ci default '-',
  `NamaTeam` varchar(255) collate latin1_general_ci default NULL,
  `Alamat` text collate latin1_general_ci,
  `Kota` varchar(255) collate latin1_general_ci default '-',
  `Telepon` varchar(255) collate latin1_general_ci default '-',
  `Fax` varchar(255) collate latin1_general_ci default '-',
  `HP` varchar(255) collate latin1_general_ci default '-',
  `Email` varchar(255) collate latin1_general_ci default '-',
  `Website` varchar(255) collate latin1_general_ci default '-',
  `Main` int(50) default '0',
  `Waktu` datetime default NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar pelanggan` VALUES("8","C-001","Nama1","xxx","","Kota1","Telepon1","-","-","-","-","3","2013-04-17 11:33:57","2013-09-02 21:24:51");
INSERT INTO `daftar pelanggan` VALUES("9","C-002","Nama2","","","Kota2","Telepon2","-","-","-","-","0","2013-04-17 11:33:57","2013-09-02 21:24:58");
INSERT INTO `daftar pelanggan` VALUES("10","C-003","Nama3","","","Kota3","Telepon3","-","-","-","-","2","2013-04-17 11:33:57","2013-09-02 21:25:05");



DROP TABLE `lic`;

CREATE TABLE `lic` (
  `ID` int(11) NOT NULL auto_increment,
  `Serial` varchar(100) collate latin1_general_ci NOT NULL,
  `Kode` varchar(100) collate latin1_general_ci NOT NULL,
  `Status` varchar(50) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `lic` VALUES("2","MS-121675810","90acc730d6cd99fd4916b6a93293f839","Registered","0000-00-00 00:00:00","2013-04-22 19:26:26");



DROP TABLE `persewaan lapangan - detail`;

CREATE TABLE `persewaan lapangan - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(50) collate latin1_general_ci NOT NULL,
  `NamaLapangan` varchar(100) collate latin1_general_ci default NULL,
  `TglSewa` date default NULL,
  `JamSewa` time default NULL,
  `HargaSewa` int(50) default '0',
  `Status` varchar(50) collate latin1_general_ci default NULL,
  `IDM` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `persewaan lapangan - detail` VALUES("1","L-001","Lapangan Euro","2013-09-03","15:00:00","70000","","3","0000-00-00 00:00:00","2013-09-03 22:14:19");
INSERT INTO `persewaan lapangan - detail` VALUES("4","L-001","Lapangan Euro","2013-09-03","14:00:00","","","4","0000-00-00 00:00:00","2013-09-03 22:21:49");



DROP TABLE `persewaan lapangan - master`;

CREATE TABLE `persewaan lapangan - master` (
  `ID` int(11) NOT NULL auto_increment,
  `No` int(50) NOT NULL,
  `No Faktur` varchar(100) collate latin1_general_ci default '0',
  `Faktur` varchar(100) collate latin1_general_ci default NULL,
  `Tgl` datetime default NULL,
  `Kode` varchar(100) collate latin1_general_ci default NULL,
  `Nama` varchar(100) collate latin1_general_ci default NULL,
  `Alamat` varchar(225) collate latin1_general_ci default NULL,
  `Kota` varchar(100) collate latin1_general_ci default NULL,
  `Telepon` varchar(100) collate latin1_general_ci default NULL,
  `Main` int(50) NOT NULL,
  `Total` int(50) default '0',
  `Bayar` int(50) default '0',
  `Sisa` int(50) default '0',
  `Sub Total` int(50) default '0',
  `Diskon` int(50) default '0',
  `Potongan` int(50) default '0',
  `Grand Total` int(50) default '0',
  `Kode Kasir` varchar(100) collate latin1_general_ci default NULL,
  `Nama Kasir` varchar(100) collate latin1_general_ci default NULL,
  `Status` varchar(50) collate latin1_general_ci NOT NULL default 'Status',
  `Hitung` varchar(50) collate latin1_general_ci NOT NULL default 'Hitung',
  `Cetak Struk` varchar(50) collate latin1_general_ci NOT NULL default 'Cetak Struk',
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `persewaan lapangan - master` VALUES("1","1","F-1","","2013-09-03 00:00:00","C-001","Nama1","","","","0","0","0","0","0","0","0","0","op1","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-03 20:53:54");
INSERT INTO `persewaan lapangan - master` VALUES("2","2","F-2","","2013-09-03 00:00:00","","","","","","0","0","0","0","0","0","0","0","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-03 20:57:52");
INSERT INTO `persewaan lapangan - master` VALUES("3","3","F-3","","2013-09-03 00:00:00","C-001","Nama1","","","","0","0","0","70000","70000","0","0","70000","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-03 22:14:19");



DROP TABLE `profile`;

CREATE TABLE `profile` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `NamaToko` varchar(255) collate latin1_general_ci default NULL,
  `Pemilik` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Alamat` text collate latin1_general_ci NOT NULL,
  `Kota` varchar(255) collate latin1_general_ci NOT NULL,
  `Telepon` varchar(255) collate latin1_general_ci NOT NULL,
  `Email` varchar(100) collate latin1_general_ci default '',
  `Foto` blob NOT NULL,
  `Serial` varchar(100) collate latin1_general_ci default NULL,
  `KeyCode` varchar(100) collate latin1_general_ci default NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `profile` VALUES("1","111","Digital Store","Digital Store","Jl. Candi Mendut","Malang","08123358290","digitalstorewebid@gmail.com","","","6087c53629ebe81f5303b0ae6be456eb","0000-00-00 00:00:00","2013-09-03 22:23:54");



