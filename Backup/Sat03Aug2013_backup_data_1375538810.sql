DROP TABLE `2padmin`;

CREATE TABLE `2padmin` (
  `Nama` varchar(255) collate latin1_general_ci NOT NULL,
  `Username` varchar(255) collate latin1_general_ci NOT NULL,
  `Password` varchar(255) collate latin1_general_ci NOT NULL,
  `Jabatan` varchar(255) collate latin1_general_ci NOT NULL,
  `Foto` blob NOT NULL,
  `Temp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `ID` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `2padmin` VALUES("Admin","admin","admin","Supervisor","","2013-04-17 01:33:55","1");
INSERT INTO `2padmin` VALUES("Op2","op2","op1","Operator","","2013-04-17 01:34:02","38");
INSERT INTO `2padmin` VALUES("Op1","op1","op1","Operator","","2013-04-17 01:33:59","35");
INSERT INTO `2padmin` VALUES("Op3","op3","op3","Operator","","2013-08-03 21:04:29","60");



DROP TABLE `2pbackup`;

CREATE TABLE `2pbackup` (
  `ID` int(11) NOT NULL auto_increment,
  `DBPath` varchar(255) collate latin1_general_ci NOT NULL,
  `ToPath` varchar(255) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `2pbackup` VALUES("1","E:\\xampp\\mysql\\data\\pointofsalenew","E:\\Aplikasi\\PointOfSaleNew\\Backup PointOfSale");



DROP TABLE `beban`;

CREATE TABLE `beban` (
  `ID` int(11) NOT NULL auto_increment,
  `Keterangan` varchar(100) collate latin1_general_ci NOT NULL,
  `Jumlah` int(100) NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `Tgl` datetime NOT NULL,
  `Kode Kasir` varchar(100) collate latin1_general_ci NOT NULL,
  `IDS` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




DROP TABLE `daftar pelanggan`;

CREATE TABLE `daftar pelanggan` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama` varchar(255) collate latin1_general_ci NOT NULL,
  `Alamat` varchar(255) collate latin1_general_ci NOT NULL,
  `Kota` varchar(255) collate latin1_general_ci NOT NULL,
  `Telepon` varchar(255) collate latin1_general_ci NOT NULL,
  `Fax` varchar(255) collate latin1_general_ci NOT NULL,
  `HP` varchar(255) collate latin1_general_ci NOT NULL,
  `Email` varchar(255) collate latin1_general_ci NOT NULL,
  `Website` varchar(255) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar pelanggan` VALUES("1","C-001","Nama1","Alamat1","Kota1","Telepon1","Fax1","HP1","a@a.com","Website1","2013-04-24 15:00:08","2013-08-03 19:48:42");
INSERT INTO `daftar pelanggan` VALUES("7","C-002","Nama2","Alamat2","Kota2","Telepon2","Fax2","HP2","a@a.com","Website2","0000-00-00 00:00:00","2013-07-17 21:32:50");
INSERT INTO `daftar pelanggan` VALUES("8","C-003","Nama3","Alamat3","Kota3","Telepon3","Fax3","Hp3","a@a.com","-","0000-00-00 00:00:00","2013-08-03 19:47:49");



DROP TABLE `daftar produk`;

CREATE TABLE `daftar produk` (
  `ID` int(11) NOT NULL auto_increment,
  `TglStok` varchar(50) collate latin1_general_ci NOT NULL,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL,
  `Isi` int(11) NOT NULL,
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Berat` double default NULL,
  `Harga Pokok` int(11) NOT NULL,
  `Harga Jual` int(11) NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `Jumlah Total` int(11) NOT NULL,
  `Supplier` varchar(100) collate latin1_general_ci NOT NULL,
  `Departemen` varchar(50) collate latin1_general_ci NOT NULL,
  `Foto` blob NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=621 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar produk` VALUES("553","","P-001","Produk1","5","Buah","1","5000","6000","100","100","S-001","","","2013-04-16 23:33:53","2013-07-20 06:00:06");
INSERT INTO `daftar produk` VALUES("554","","P-002","Produk2","3","Buah","2","6000","7000","100","100","S-001","","","2013-04-16 20:52:05","2013-07-20 06:31:29");
INSERT INTO `daftar produk` VALUES("555","","P-003","Produk3","1","Buah","2.5","7000","8000","100","100","S-002","","","2013-04-24 14:59:49","2013-07-20 06:51:10");
INSERT INTO `daftar produk` VALUES("589","","P-004","Produk4","1","Buah","3","8000","9000","100","0","S-001","","","0000-00-00 00:00:00","2013-07-22 22:32:11");



DROP TABLE `daftar supplier`;

CREATE TABLE `daftar supplier` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama` varchar(255) collate latin1_general_ci NOT NULL,
  `Alamat` varchar(255) collate latin1_general_ci NOT NULL,
  `Kota` varchar(255) collate latin1_general_ci NOT NULL,
  `Telepon` varchar(255) collate latin1_general_ci NOT NULL,
  `Fax` varchar(255) collate latin1_general_ci NOT NULL,
  `HP` varchar(255) collate latin1_general_ci NOT NULL,
  `Email` varchar(255) collate latin1_general_ci NOT NULL,
  `Website` varchar(255) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar supplier` VALUES("21","S-003","Nama3","-","-","-","-","-","a@a.com","-","0000-00-00 00:00:00","2013-07-17 21:33:58");
INSERT INTO `daftar supplier` VALUES("13","S-002","Nama2","-","-","-","-","-","a@a.com","-","2012-12-24 11:10:10","2013-07-17 21:35:07");
INSERT INTO `daftar supplier` VALUES("12","S-001","Nama1","-","-","-","-","-","a@a.com","-","2012-12-24 11:10:01","2013-07-17 21:32:04");
INSERT INTO `daftar supplier` VALUES("22","S-004","Nama4","-","-","-","-","-","a@a.com","-","0000-00-00 00:00:00","2013-07-17 21:36:00");



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



DROP TABLE `master transaksi`;

CREATE TABLE `master transaksi` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Tgl` datetime NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




DROP TABLE `mutasikeluar - detail`;

CREATE TABLE `mutasikeluar - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL,
  `Isi` double NOT NULL,
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Harga Beli` int(11) NOT NULL,
  `Jumlah` double NOT NULL,
  `Total Jumlah` double NOT NULL,
  `Berat` double NOT NULL default '0',
  `Diskon` int(11) NOT NULL,
  `Total HP` int(100) NOT NULL,
  `Retur` int(11) NOT NULL default '0',
  `User` varchar(100) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `IDM` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `mutasikeluar - detail` VALUES("1","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-07-28 11:17:24","1");
INSERT INTO `mutasikeluar - detail` VALUES("2","P-004","Produk4","1","Buah","8000","1","1","3","0","8000","0","","0000-00-00 00:00:00","2013-07-28 11:17:28","1");
INSERT INTO `mutasikeluar - detail` VALUES("3","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-07-28 11:17:59","2");
INSERT INTO `mutasikeluar - detail` VALUES("4","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:44:25","3");
INSERT INTO `mutasikeluar - detail` VALUES("5","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-08-03 20:44:31","3");
INSERT INTO `mutasikeluar - detail` VALUES("6","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-08-03 20:44:40","3");
INSERT INTO `mutasikeluar - detail` VALUES("7","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:50:14","4");
INSERT INTO `mutasikeluar - detail` VALUES("8","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-08-03 20:50:19","4");
INSERT INTO `mutasikeluar - detail` VALUES("9","P-004","Produk4","1","Buah","8000","1","1","3","0","8000","0","","0000-00-00 00:00:00","2013-08-03 20:50:25","4");



DROP TABLE `mutasikeluar - master`;

CREATE TABLE `mutasikeluar - master` (
  `ID` int(11) NOT NULL auto_increment,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `No Faktur` varchar(255) collate latin1_general_ci NOT NULL,
  `Diskon` double NOT NULL default '0',
  `Ppn` int(11) NOT NULL default '0',
  `Ongkir` int(11) NOT NULL default '0',
  `Paking` int(11) NOT NULL default '0',
  `Lain - lain` int(11) NOT NULL default '0',
  `Hutang` int(100) NOT NULL default '0',
  `Total Berat` int(11) NOT NULL default '0',
  `Total HP` int(100) NOT NULL default '0',
  `Grand Total` int(11) NOT NULL default '0',
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Pembelian',
  `Tgl` date NOT NULL,
  `No` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `mutasikeluar - master` VALUES("1","1","","0","0","0","0","0","0","4","13000","13000","0","0","0","admin","","S-001","","Pembelian","2013-07-27","1","0000-00-00 00:00:00","2013-07-28 11:17:30");
INSERT INTO `mutasikeluar - master` VALUES("2","2","","0","0","0","0","0","0","2","6000","6000","0","0","0","admin","","S-001","","Pembelian","2013-07-28","2","0000-00-00 00:00:00","2013-07-28 11:18:01");
INSERT INTO `mutasikeluar - master` VALUES("3","1","","0","0","0","0","0","0","6","19000","19000","0","0","0","op1","","S-001","","Pembelian","2013-07-29","1","0000-00-00 00:00:00","2013-08-03 20:44:45");
INSERT INTO `mutasikeluar - master` VALUES("4","2","","0","0","0","0","0","0","7","20000","20000","0","0","0","admin","","S-001","","Pembelian","2013-08-03","2","0000-00-00 00:00:00","2013-08-03 20:50:28");
INSERT INTO `mutasikeluar - master` VALUES("5","3","","0","0","0","0","0","0","0","0","0","0","0","0","admin","","S-001","","Pembelian","2013-08-03","3","0000-00-00 00:00:00","2013-08-03 20:50:35");



DROP TABLE `mutasimasuk - detail`;

CREATE TABLE `mutasimasuk - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL,
  `Isi` double NOT NULL,
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Harga Beli` int(11) NOT NULL,
  `Jumlah` double NOT NULL,
  `Total Jumlah` double NOT NULL,
  `Berat` double NOT NULL default '0',
  `Diskon` int(11) NOT NULL,
  `Total HP` int(100) NOT NULL,
  `Retur` int(11) NOT NULL default '0',
  `User` varchar(100) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `IDM` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `mutasimasuk - detail` VALUES("1","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-07-28 11:06:46","1");
INSERT INTO `mutasimasuk - detail` VALUES("2","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-07-28 11:06:50","1");
INSERT INTO `mutasimasuk - detail` VALUES("3","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-07-28 11:11:07","2");
INSERT INTO `mutasimasuk - detail` VALUES("4","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:17:04","3");
INSERT INTO `mutasimasuk - detail` VALUES("5","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-08-03 20:17:09","3");
INSERT INTO `mutasimasuk - detail` VALUES("6","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:19:21","4");
INSERT INTO `mutasimasuk - detail` VALUES("7","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:32:46","4");
INSERT INTO `mutasimasuk - detail` VALUES("8","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:43:06","5");
INSERT INTO `mutasimasuk - detail` VALUES("9","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-08-03 20:43:12","5");
INSERT INTO `mutasimasuk - detail` VALUES("10","P-004","Produk4","1","Buah","8000","1","1","3","0","8000","0","","0000-00-00 00:00:00","2013-08-03 20:43:18","5");
INSERT INTO `mutasimasuk - detail` VALUES("11","P-001","Produk1","5","Buah","5000","1","5","1","0","5000","0","","0000-00-00 00:00:00","2013-08-03 20:48:52","6");
INSERT INTO `mutasimasuk - detail` VALUES("12","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-08-03 20:48:58","6");
INSERT INTO `mutasimasuk - detail` VALUES("13","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-08-03 20:49:04","6");



DROP TABLE `mutasimasuk - master`;

CREATE TABLE `mutasimasuk - master` (
  `ID` int(11) NOT NULL auto_increment,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `No Faktur` varchar(255) collate latin1_general_ci NOT NULL,
  `Diskon` double NOT NULL default '0',
  `Ppn` int(11) NOT NULL default '0',
  `Ongkir` int(11) NOT NULL default '0',
  `Paking` int(11) NOT NULL default '0',
  `Lain - lain` int(11) NOT NULL default '0',
  `Hutang` int(100) NOT NULL default '0',
  `Total Berat` double NOT NULL default '0',
  `Total HP` int(100) NOT NULL default '0',
  `Total HJ` int(100) default NULL,
  `Grand Total` int(11) NOT NULL default '0',
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Pembelian',
  `Tgl` date NOT NULL,
  `No` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `mutasimasuk - master` VALUES("1","1","","0","0","0","0","0","0","3","11000","0","11000","0","0","0","admin","","S-002","","Pembelian","2013-07-27","1","0000-00-00 00:00:00","2013-07-28 11:07:43");
INSERT INTO `mutasimasuk - master` VALUES("2","2","","0","0","0","0","0","0","2.5","7000","0","7000","0","0","0","admin","","S-001","","Pembelian","2013-07-28","2","0000-00-00 00:00:00","2013-07-28 11:11:09");
INSERT INTO `mutasimasuk - master` VALUES("3","1","","0","0","0","0","0","0","3","11000","","11000","0","0","0","op1","","S-001","","Pembelian","2013-07-29","1","0000-00-00 00:00:00","2013-08-03 20:17:14");
INSERT INTO `mutasimasuk - master` VALUES("4","2","","0","0","0","0","0","0","0","0","","0","0","0","0","admin","","S-001","","Pembelian","2013-08-03","2","0000-00-00 00:00:00","2013-08-03 20:17:18");
INSERT INTO `mutasimasuk - master` VALUES("5","3","","0","0","0","0","0","0","6","19000","","19000","0","0","0","admin","","S-001","","Pembelian","2013-08-03","3","0000-00-00 00:00:00","2013-08-03 20:43:22");
INSERT INTO `mutasimasuk - master` VALUES("6","4","","0","0","0","0","0","0","5.5","18000","","18000","0","0","0","admin","","S-001","","Pembelian","2013-08-03","4","0000-00-00 00:00:00","2013-08-03 20:49:07");
INSERT INTO `mutasimasuk - master` VALUES("7","5","","0","0","0","0","0","0","0","0","","0","0","0","0","admin","","S-001","","Pembelian","2013-08-03","5","0000-00-00 00:00:00","2013-08-03 20:49:12");



DROP TABLE `pembelian - detail`;

CREATE TABLE `pembelian - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL,
  `Isi` double NOT NULL,
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Harga Beli` int(11) NOT NULL,
  `Jumlah` double NOT NULL,
  `Total Jumlah` double NOT NULL,
  `Berat` double NOT NULL default '0',
  `Diskon` int(11) NOT NULL,
  `Total HP` int(100) NOT NULL,
  `Retur` int(11) NOT NULL default '0',
  `User` varchar(100) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `IDM` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `pembelian - detail` VALUES("1","P-001","Produk1","5","Buah","5000","10","5","1","0","50000","0","","0000-00-00 00:00:00","2013-07-27 11:50:44","1");
INSERT INTO `pembelian - detail` VALUES("2","P-004","Produk4","1","Buah","8000","1","1","3","0","8000","0","","0000-00-00 00:00:00","2013-07-27 12:00:46","2");
INSERT INTO `pembelian - detail` VALUES("3","P-001","Produk1","5","Buah","5000","3","15","1","0","15000","0","","0000-00-00 00:00:00","2013-07-28 13:54:02","2");
INSERT INTO `pembelian - detail` VALUES("5","P-002","Produk2","3","Buah","6000","1","3","2","0","6000","0","","0000-00-00 00:00:00","2013-08-03 20:15:03","3");
INSERT INTO `pembelian - detail` VALUES("6","P-003","Produk3","1","Buah","7000","1","1","2.5","0","7000","0","","0000-00-00 00:00:00","2013-08-03 20:15:10","3");



DROP TABLE `pembelian - master`;

CREATE TABLE `pembelian - master` (
  `ID` int(11) NOT NULL auto_increment,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `No Faktur` varchar(255) collate latin1_general_ci NOT NULL,
  `Diskon` double NOT NULL default '0',
  `Ppn` int(11) NOT NULL default '0',
  `Ongkir` int(11) NOT NULL default '0',
  `Paking` int(11) NOT NULL default '0',
  `Lain - lain` int(11) NOT NULL default '0',
  `Hutang` int(100) NOT NULL default '0',
  `Total Berat` double NOT NULL default '0',
  `Total HP` int(100) NOT NULL default '0',
  `Total HJ` int(100) default NULL,
  `Grand Total` int(11) NOT NULL default '0',
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Pembelian',
  `Tgl` date NOT NULL,
  `No` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `pembelian - master` VALUES("1","1","","10","0","0","0","0","0","1","50000","0","45000","0","0","0","admin","","S-002","","Pembelian","2013-07-25","1","0000-00-00 00:00:00","2013-07-28 13:53:42");
INSERT INTO `pembelian - master` VALUES("2","2","","0","0","10000","0","0","0","3","8000","0","18000","0","0","0","admin","","S-001","","Pembelian","2013-07-27","2","0000-00-00 00:00:00","2013-07-27 12:01:33");
INSERT INTO `pembelian - master` VALUES("3","1","","0","0","0","0","0","0","4.5","13000","","13000","0","0","0","op1","","S-001","","Pembelian","2013-07-29","1","0000-00-00 00:00:00","2013-08-03 20:15:22");
INSERT INTO `pembelian - master` VALUES("4","2","","0","0","0","0","0","0","0","0","","0","0","0","0","admin","","S-001","","Pembelian","2013-08-03","2","0000-00-00 00:00:00","2013-08-03 20:15:31");



DROP TABLE `penjualan - detail`;

CREATE TABLE `penjualan - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Isi` double NOT NULL default '1',
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Harga Pokok` int(11) NOT NULL default '0',
  `Harga Jual` int(11) NOT NULL default '0',
  `Jumlah` double NOT NULL default '1',
  `Total Jumlah` double NOT NULL default '0',
  `Berat` double NOT NULL default '0',
  `Diskon` double NOT NULL default '0',
  `Total HP` int(11) default '0',
  `Total HJ` int(11) default '0',
  `Saldo` int(11) default '0',
  `Retur` int(10) NOT NULL default '0',
  `User` varchar(100) collate latin1_general_ci NOT NULL,
  `IDM` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `penjualan - detail` VALUES("1","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","1","0000-00-00 00:00:00","2013-07-29 22:36:08");
INSERT INTO `penjualan - detail` VALUES("2","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","2","0000-00-00 00:00:00","2013-07-29 22:44:52");
INSERT INTO `penjualan - detail` VALUES("3","P-004","Produk4","1","Buah","8000","9000","1","1","3","0","8000","9000","0","0","","2","0000-00-00 00:00:00","2013-07-29 22:44:55");
INSERT INTO `penjualan - detail` VALUES("4","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","2","0000-00-00 00:00:00","2013-07-29 22:44:58");
INSERT INTO `penjualan - detail` VALUES("5","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","3","0000-00-00 00:00:00","2013-07-29 22:45:06");
INSERT INTO `penjualan - detail` VALUES("6","P-003","Produk3","1","Buah","7000","8000","1","1","2.5","0","7000","8000","0","0","","3","0000-00-00 00:00:00","2013-07-29 22:45:10");
INSERT INTO `penjualan - detail` VALUES("7","P-003","Produk3","1","Buah","7000","8000","1","1","2.5","0","7000","8000","0","0","","3","0000-00-00 00:00:00","2013-07-29 22:45:14");
INSERT INTO `penjualan - detail` VALUES("8","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","4","0000-00-00 00:00:00","2013-07-29 22:46:45");
INSERT INTO `penjualan - detail` VALUES("9","P-003","Produk3","1","Buah","7000","8000","1","1","2.5","0","7000","8000","0","0","","4","0000-00-00 00:00:00","2013-07-29 22:46:51");
INSERT INTO `penjualan - detail` VALUES("10","P-004","Produk4","1","Buah","8000","9000","1","1","3","0","8000","9000","0","0","","4","0000-00-00 00:00:00","2013-07-29 22:46:57");
INSERT INTO `penjualan - detail` VALUES("11","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","5","0000-00-00 00:00:00","2013-07-29 22:47:05");
INSERT INTO `penjualan - detail` VALUES("12","P-001","Produk1","5","Buah","5000","6000","1","5","1","0","5000","6000","0","0","","7","0000-00-00 00:00:00","2013-08-02 19:56:07");
INSERT INTO `penjualan - detail` VALUES("16","P-002","Produk2","3","Buah","6000","7000","1","3","2","0","6000","7000","0","0","","7","0000-00-00 00:00:00","2013-08-03 18:21:02");
INSERT INTO `penjualan - detail` VALUES("15","P-004","Produk4","1","Buah","8000","9000","1","1","3","0","8000","9000","0","0","","7","0000-00-00 00:00:00","2013-08-02 21:01:36");
INSERT INTO `penjualan - detail` VALUES("17","P-001","Produk1","-5","Buah","-5000","-6000","-5","25","1","0","0","0","0","-1","","8","0000-00-00 00:00:00","2013-08-03 20:07:10");
INSERT INTO `penjualan - detail` VALUES("18","P-003","Produk3","1","Buah","7000","8000","1","1","2.5","10","7000","8000","0","0","","8","0000-00-00 00:00:00","2013-08-03 20:07:22");



DROP TABLE `penjualan - master`;

CREATE TABLE `penjualan - master` (
  `ID` int(11) NOT NULL auto_increment,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `No Faktur` varchar(255) collate latin1_general_ci NOT NULL,
  `Diskon` double NOT NULL default '0',
  `Ppn` int(11) NOT NULL default '0',
  `Ongkir` int(11) NOT NULL default '0',
  `Paking` int(11) NOT NULL default '0',
  `Lain - lain` int(11) NOT NULL default '0',
  `Piutang` int(100) NOT NULL default '0',
  `Total Berat` double NOT NULL default '0',
  `Total HP` int(100) NOT NULL default '0',
  `Total HJ` int(100) NOT NULL default '0',
  `Grand Total` int(11) NOT NULL default '0',
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Pelanggan` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Nama Pelanggan` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Sewa` varchar(100) collate latin1_general_ci NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Penjualan',
  `Tgl` date NOT NULL,
  `No` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `penjualan - master` VALUES("1","1","","0","0","0","0","0","0","1","5000","6000","6000","0","0","0","admin","","C-001","","","Penjualan","2013-07-29","1","0000-00-00 00:00:00","2013-07-29 22:46:05");
INSERT INTO `penjualan - master` VALUES("2","2","","0","0","0","0","0","0","5","18000","21000","21000","0","0","0","admin","","C-001","","","Penjualan","2013-07-29","2","0000-00-00 00:00:00","2013-07-29 22:46:08");
INSERT INTO `penjualan - master` VALUES("3","3","","0","0","0","0","0","0","6","19000","22000","22000","0","0","0","admin","","C-001","","","Penjualan","2013-07-29","3","0000-00-00 00:00:00","2013-07-29 22:46:02");
INSERT INTO `penjualan - master` VALUES("4","1","","0","0","0","0","0","0","6.5","20000","23000","23000","0","0","0","op1","","C-001","","","Penjualan","2013-07-29","1","0000-00-00 00:00:00","2013-07-29 22:46:59");
INSERT INTO `penjualan - master` VALUES("5","2","","0","0","0","0","0","0","1","5000","6000","6000","0","0","0","op1","","C-001","","","Penjualan","2013-07-29","2","0000-00-00 00:00:00","2013-07-29 22:47:06");
INSERT INTO `penjualan - master` VALUES("6","3","","0","0","0","0","0","0","0","0","0","0","0","0","0","admin","","C-001","","","Penjualan","2013-07-31","3","0000-00-00 00:00:00","2013-07-31 03:41:05");
INSERT INTO `penjualan - master` VALUES("7","4","","0","0","0","0","0","0","4","13000","15000","15000","0","0","0","admin","","C-001","","","Penjualan","2013-07-31","4","0000-00-00 00:00:00","2013-08-02 21:02:47");
INSERT INTO `penjualan - master` VALUES("8","5","","0","0","10000","0","0","0","3.5","-18000","-22800","-12800","0","0","0","admin","","C-002","","","Penjualan","2013-08-03","5","0000-00-00 00:00:00","2013-08-03 20:11:29");



DROP TABLE `profile`;

CREATE TABLE `profile` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `NamaToko` varchar(255) collate latin1_general_ci default NULL,
  `Pemilik` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Alamat` varchar(255) collate latin1_general_ci NOT NULL,
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

INSERT INTO `profile` VALUES("1","111","Digital Store","Digital Store","Jl. Candi Mendut","Malang","08123358290","digitalstorewebid@gmail.com","","","6087c53629ebe81f5303b0ae6be456eb","0000-00-00 00:00:00","2013-08-03 21:04:41");



DROP TABLE `retur - detail`;

CREATE TABLE `retur - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Barang` varchar(255) collate latin1_general_ci NOT NULL,
  `Isi` double NOT NULL,
  `Satuan` varchar(255) collate latin1_general_ci NOT NULL,
  `Harga Beli` int(11) NOT NULL,
  `Jumlah` double NOT NULL,
  `Total Jumlah` double NOT NULL,
  `Diskon` int(11) NOT NULL,
  `Total HP` int(100) NOT NULL,
  `User` varchar(100) collate latin1_general_ci NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `IDM` int(11) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;




DROP TABLE `retur - master`;

CREATE TABLE `retur - master` (
  `ID` int(11) NOT NULL auto_increment,
  `Faktur` varchar(100) collate latin1_general_ci NOT NULL,
  `No Faktur` varchar(255) collate latin1_general_ci NOT NULL,
  `Diskon` double NOT NULL default '0',
  `Ppn` int(11) NOT NULL default '0',
  `Ongkir` int(11) NOT NULL default '0',
  `Paking` int(11) NOT NULL default '0',
  `Lain - lain` int(11) NOT NULL default '0',
  `Hutang` int(100) NOT NULL default '0',
  `Total Berat` int(11) NOT NULL default '0',
  `Total HP` int(100) NOT NULL default '0',
  `Grand Total` int(11) NOT NULL default '0',
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Supplier` varchar(255) collate latin1_general_ci NOT NULL,
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Pembelian',
  `Tgl` datetime NOT NULL,
  `No` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `retur - master` VALUES("3","1","FMM-1","0","0","0","0","0","0","0","0","0","0","0","0","pks","PKS","","","Pembelian","2012-12-04 00:00:00","1","2012-12-04 22:04:11","2012-12-04 22:04:11");



