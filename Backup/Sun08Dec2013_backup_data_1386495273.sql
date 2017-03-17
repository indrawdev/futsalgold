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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar pelanggan` VALUES("8","C-001","Nama1","xxx","","Kota1","Telepon1","-","-","-","-","3","2013-04-17 11:33:57","2013-09-02 21:24:51");
INSERT INTO `daftar pelanggan` VALUES("9","C-002","Nama2","","","Kota2","Telepon2","-","-","-","-","0","2013-04-17 11:33:57","2013-09-02 21:24:58");
INSERT INTO `daftar pelanggan` VALUES("10","C-003","Nama3","","","Kota3","Telepon3","-","-","-","-","2","2013-04-17 11:33:57","2013-09-02 21:25:05");



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
) ENGINE=MyISAM AUTO_INCREMENT=590 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar produk` VALUES("553","","P-001","Produk1","5","Buah","1","5000","6000","100","100","S-001","","","2013-04-16 23:33:53","2013-09-04 23:03:15");
INSERT INTO `daftar produk` VALUES("554","","P-002","Produk2","3","Buah","2","6000","7000","100","100","S-001","","","2013-04-16 20:52:05","2013-07-20 06:31:29");
INSERT INTO `daftar produk` VALUES("555","","P-003","Produk3","1","Buah","2.5","7000","8000","100","100","S-002","","","2013-04-24 14:59:49","2013-07-20 06:51:10");
INSERT INTO `daftar produk` VALUES("589","","P-004","Produk4","1","Buah","3","8000","9000","100","0","S-001","","","0000-00-00 00:00:00","2013-07-22 22:32:11");



DROP TABLE `daftar satuan`;

CREATE TABLE `daftar satuan` (
  `ID` int(11) NOT NULL auto_increment,
  `Satuan` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `daftar satuan` VALUES("1","KG");
INSERT INTO `daftar satuan` VALUES("2","Buah");
INSERT INTO `daftar satuan` VALUES("3","Botol");



DROP TABLE `daftar suplier`;

CREATE TABLE `daftar suplier` (
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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `daftar suplier` VALUES("21","S-003","Nama3","-","-","-","-","-","a@a.com","-","0000-00-00 00:00:00","2013-07-17 21:33:58");
INSERT INTO `daftar suplier` VALUES("13","S-002","Nama2","-","-","-","-","-","a@a.com","-","2012-12-24 11:10:10","2013-07-17 21:35:07");
INSERT INTO `daftar suplier` VALUES("12","S-001","Nama1","-","-","-","-","-","a@a.com","-","2012-12-24 11:10:01","2013-07-17 21:32:04");
INSERT INTO `daftar suplier` VALUES("22","S-004","Nama4","-","-","-","-","-","a@a.com","-","0000-00-00 00:00:00","2013-07-17 21:36:00");



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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `pembelian - detail` VALUES("1","P-001","Produk1","0","Buah","5000","1","0","0","0","5000","0","","0000-00-00 00:00:00","2013-09-05 20:52:40","1");
INSERT INTO `pembelian - detail` VALUES("2","P-002","Produk2","0","Buah","6000","1","0","0","0","6000","0","","0000-00-00 00:00:00","2013-09-05 22:33:06","2");



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
  `Hitung` varchar(50) collate latin1_general_ci default 'Hitung',
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `pembelian - master` VALUES("1","","B-1","0","0","0","0","0","0","0","5000","","5000","0","0","5000","admin","","S-001","","Pembelian","2013-09-05","1","Hitung","0000-00-00 00:00:00","2013-09-05 20:52:40");
INSERT INTO `pembelian - master` VALUES("2","","B-2","0","0","0","0","0","0","0","6000","","6000","0","0","6000","admin","","S-001","","Pembelian","2013-09-05","2","Hitung","0000-00-00 00:00:00","2013-09-05 22:33:07");



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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `penjualan - detail` VALUES("7","P-002","Produk2","1","Buah","6000","7000","1","0","0","0","6000","7000","0","0","","1","0000-00-00 00:00:00","2013-09-06 19:20:10");
INSERT INTO `penjualan - detail` VALUES("6","P-001","Produk1","1","Buah","5000","6000","1","0","0","0","5000","6000","0","0","","1","0000-00-00 00:00:00","2013-09-06 19:19:59");
INSERT INTO `penjualan - detail` VALUES("5","P-001","Produk1","1","Buah","5000","6000","1","0","0","0","5000","6000","0","0","","2","0000-00-00 00:00:00","2013-09-06 19:05:32");
INSERT INTO `penjualan - detail` VALUES("8","P-001","Produk1","1","Buah","5000","6000","5","0","0","10","25000","27000","0","0","","2","0000-00-00 00:00:00","2013-09-06 19:24:49");
INSERT INTO `penjualan - detail` VALUES("9","P-003","Produk3","1","Buah","7000","8000","1","0","0","0","7000","8000","0","0","","4","0000-00-00 00:00:00","2013-09-23 10:09:24");



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
  `Laba` int(100) default NULL,
  `Dibayar` int(11) NOT NULL default '0',
  `Kembali` int(11) NOT NULL default '0',
  `SisaDibayar` int(11) NOT NULL default '0',
  `Kode Kasir` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Nama Kasir` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Pelanggan` varchar(255) collate latin1_general_ci NOT NULL default '',
  `Nama Pelanggan` varchar(255) collate latin1_general_ci NOT NULL,
  `Kode Suplier` varchar(100) collate latin1_general_ci NOT NULL default '',
  `Nama Form` varchar(100) collate latin1_general_ci NOT NULL default 'Penjualan',
  `Tgl` date NOT NULL,
  `No` int(11) NOT NULL,
  `Hitung` varchar(50) collate latin1_general_ci default 'Hitung',
  `CetakStruk` varchar(50) collate latin1_general_ci default 'Cetak Struk',
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `penjualan - master` VALUES("1","","J-1","0","0","0","0","0","0","0","11000","13000","13000","2000","0","0","13000","admin","","C-001","","","Penjualan","2013-09-05","1","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-06 19:23:47");
INSERT INTO `penjualan - master` VALUES("2","","J-2","10","0","0","0","0","0","0","30000","33000","29700","-300","0","0","33000","admin","","C-002","","","Penjualan","2013-09-05","2","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-06 19:26:25");
INSERT INTO `penjualan - master` VALUES("3","","J-3","0","0","0","0","0","0","0","0","0","0","","0","0","0","op1","","","","","Penjualan","2013-09-06","3","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-06 19:45:31");
INSERT INTO `penjualan - master` VALUES("4","","J-4","0","0","0","0","0","0","0","7000","8000","8000","1000","0","0","8000","op1","","","","","Penjualan","2013-09-06","4","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-23 10:09:25");



DROP TABLE `persewaan lapangan - detail`;

CREATE TABLE `persewaan lapangan - detail` (
  `ID` int(11) NOT NULL auto_increment,
  `Kode` varchar(50) collate latin1_general_ci NOT NULL,
  `NamaLapangan` varchar(100) collate latin1_general_ci default NULL,
  `TglSewa` date default NULL,
  `JamSewa` time default NULL,
  `HargaSewa` int(50) default '0',
  `Status` varchar(50) collate latin1_general_ci default NULL,
  `Hitung` varchar(50) collate latin1_general_ci default 'Hitung',
  `IDM` int(11) NOT NULL,
  `Waktu` datetime NOT NULL,
  `Stamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `persewaan lapangan - detail` VALUES("5","L-001","Lapangan Euro","2013-09-03","07:00:00","70000","","Hitung","3","0000-00-00 00:00:00","2013-09-03 22:46:24");
INSERT INTO `persewaan lapangan - detail` VALUES("4","L-001","Lapangan Euro","2013-09-03","14:00:00","0","","Hitung","4","0000-00-00 00:00:00","2013-09-03 22:21:49");
INSERT INTO `persewaan lapangan - detail` VALUES("6","L-001","Lapangan Euro","2013-09-03","08:00:00","115000","","Hitung","2","0000-00-00 00:00:00","2013-09-03 22:47:02");
INSERT INTO `persewaan lapangan - detail` VALUES("37","L-001","Lapangan Euro","2013-09-04","12:00:00","70000","","Hitung","5","0000-00-00 00:00:00","2013-09-04 19:17:08");
INSERT INTO `persewaan lapangan - detail` VALUES("36","L-002","Lapangan Olimpico","2013-09-03","11:00:00","60000","","Hitung","1","0000-00-00 00:00:00","2013-09-04 01:14:06");
INSERT INTO `persewaan lapangan - detail` VALUES("38","L-001","Lapangan Euro","2013-09-05","12:00:00","70000","","Hitung","5","0000-00-00 00:00:00","2013-09-05 21:34:48");
INSERT INTO `persewaan lapangan - detail` VALUES("44","L-001","Lapangan Euro","2013-09-06","23:00:00","80000","","Hitung","6","0000-00-00 00:00:00","2013-09-06 15:59:59");
INSERT INTO `persewaan lapangan - detail` VALUES("46","L-001","Lapangan Euro","2013-09-06","20:00:00","80000","","Hitung","6","0000-00-00 00:00:00","2013-09-06 16:00:31");



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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

INSERT INTO `persewaan lapangan - master` VALUES("1","1","F-1","","2013-09-03 00:00:00","C-001","Nama1","","","","0","0","0","60000","60000","0","0","60000","op1","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-04 01:14:07");
INSERT INTO `persewaan lapangan - master` VALUES("2","2","F-2","","2013-09-03 00:00:00","","","","","","0","0","0","115000","115000","0","0","115000","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-03 22:48:35");
INSERT INTO `persewaan lapangan - master` VALUES("3","3","F-3","","2013-09-03 00:00:00","C-001","Nama1","","","","0","0","0","280000","280000","0","0","280000","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-04 00:40:29");
INSERT INTO `persewaan lapangan - master` VALUES("5","4","F-4","","2013-09-04 00:00:00","C-001","Nama1","","","","0","0","0","140000","140000","0","0","140000","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-05 22:04:31");
INSERT INTO `persewaan lapangan - master` VALUES("6","5","F-5","","2013-09-06 00:00:00","C-001","Nama1","","","","0","0","0","160000","160000","0","0","160000","admin","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-06 16:00:31");
INSERT INTO `persewaan lapangan - master` VALUES("7","6","F-6","","2013-09-06 00:00:00","","","","","","0","0","0","0","0","0","0","0","op1","","Booking","Hitung","Cetak Struk","0000-00-00 00:00:00","2013-09-06 19:55:13");



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

INSERT INTO `profile` VALUES("1","111","Digital Store","Digital Store","Jl. Candi Mendut","Malang","08123358290","digitalstorewebid@gmail.com","","","6087c53629ebe81f5303b0ae6be456eb","0000-00-00 00:00:00","2013-09-03 23:25:17");



