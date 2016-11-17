/*
Navicat MySQL Data Transfer

Source Server         : MySQL
Source Server Version : 100113
Source Host           : 127.0.0.1:3306
Source Database       : db_umrah

Target Server Type    : MYSQL
Target Server Version : 100113
File Encoding         : 65001

Date: 2016-11-17 21:40:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_nama` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(30) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `is_active` int(1) NOT NULL,
  `is_parent` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', 'Master', '#', 'fa fa-home fa-lg', '1', '1', '0', '2016-11-08 20:52:03', '2016-11-08 20:52:03', null, '');
INSERT INTO `menu` VALUES ('53', 'Dokumen', 'm_dokument', 'fa', '1', '1', '1', '2016-11-08 20:53:55', null, null, '');
INSERT INTO `menu` VALUES ('54', 'Periode', 'M_periode', 'fa', '2', '1', '1', '2016-11-08 20:56:36', null, null, '');
INSERT INTO `menu` VALUES ('55', 'Sales', 'M_sales', 'fa', '3', '1', '1', '2016-11-08 20:57:06', null, null, '');
INSERT INTO `menu` VALUES ('56', 'Customer', 'M_customer', 'fa', '4', '1', '58', '2016-11-08 20:58:09', null, null, '');
INSERT INTO `menu` VALUES ('57', 'User', 'user', 'fa', '4', '1', '1', '2016-11-08 20:58:09', null, null, null);
INSERT INTO `menu` VALUES ('58', 'Transaksi', '#', 'fa fa-list fa-lg', '4', '1', '0', '2016-11-08 20:58:09', null, null, null);
INSERT INTO `menu` VALUES ('59', 'Dokumen', 't_document', 'fa', '4', '1', '58', '2016-11-08 20:58:09', null, null, null);
INSERT INTO `menu` VALUES ('60', 'Pembayaran', 't_payment', 'fa', '4', '1', '58', '2016-11-08 20:58:09', null, null, null);

-- ----------------------------
-- Table structure for m_customer
-- ----------------------------
DROP TABLE IF EXISTS `m_customer`;
CREATE TABLE `m_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(50) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `customer_birth_place` varchar(20) DEFAULT NULL,
  `customer_birth_date` date DEFAULT NULL,
  `customer_gender` varchar(1) DEFAULT NULL,
  `customer_jobs` varchar(100) DEFAULT NULL,
  `customer_passport_no` varchar(100) DEFAULT NULL,
  `customer_passport_date` date DEFAULT NULL,
  `customer_img` varchar(255) DEFAULT NULL,
  `kota_id` int(11) DEFAULT NULL,
  `kecamatan_id` int(11) DEFAULT NULL,
  `propinsi_id` int(11) DEFAULT NULL,
  `periode_id` int(11) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `periode_id` (`periode_id`),
  KEY `sales_id` (`sales_id`),
  CONSTRAINT `m_customer_ibfk_1` FOREIGN KEY (`periode_id`) REFERENCES `m_periode` (`id`),
  CONSTRAINT `m_customer_ibfk_2` FOREIGN KEY (`sales_id`) REFERENCES `m_sales` (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_customer
-- ----------------------------
INSERT INTO `m_customer` VALUES ('4', 'mamad', 'surabaya', 'mimin', 'surabaya', '2010-02-02', 'l', 'tukang', '12345', '2016-11-09', '180dc1a09fcec142144809e9cd4fba0b575f3a74.png', '0', '0', '0', '1', '1', '2016-11-12 06:13:53', null, null);

-- ----------------------------
-- Table structure for m_dokument
-- ----------------------------
DROP TABLE IF EXISTS `m_dokument`;
CREATE TABLE `m_dokument` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(500) DEFAULT NULL,
  `document_quantity` int(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_dokument
-- ----------------------------
INSERT INTO `m_dokument` VALUES ('1', 'Foto', '2', '2016-11-12 05:38:24', null, null);
INSERT INTO `m_dokument` VALUES ('2', 'ktp', '1', '2016-11-12 05:52:31', null, null);
INSERT INTO `m_dokument` VALUES ('3', 'kartu keluarga', '1', '2016-11-12 05:52:48', null, null);

-- ----------------------------
-- Table structure for m_periode
-- ----------------------------
DROP TABLE IF EXISTS `m_periode`;
CREATE TABLE `m_periode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `depart_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_periode
-- ----------------------------
INSERT INTO `m_periode` VALUES ('1', 'periode 1', '2010-02-01', '2010-03-01', '20', '2000000', 'abc', '2016-11-12 05:55:16', null, null);

-- ----------------------------
-- Table structure for m_sales
-- ----------------------------
DROP TABLE IF EXISTS `m_sales`;
CREATE TABLE `m_sales` (
  `sales_id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_name` varchar(255) DEFAULT NULL,
  `sales_telp` varchar(255) DEFAULT NULL,
  `sales_address` varchar(255) DEFAULT NULL,
  `sales_img` varchar(255) DEFAULT NULL,
  `sales_mail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sales_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of m_sales
-- ----------------------------
INSERT INTO `m_sales` VALUES ('1', 'Bukyan', '123456789', 'sumenep', '6d063e2a84b83104b8aa891cc656ebf946a66501.png', 'bulyan@mail.com', '2016-11-12 06:02:31', null, null);

-- ----------------------------
-- Table structure for t_document
-- ----------------------------
DROP TABLE IF EXISTS `t_document`;
CREATE TABLE `t_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_RELATIONSHIP_6` (`document_id`),
  KEY `ID_PELANGGAN` (`customer_id`),
  CONSTRAINT `t_document_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `m_customer` (`customer_id`),
  CONSTRAINT `t_document_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `m_dokument` (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_document
-- ----------------------------
INSERT INTO `t_document` VALUES ('1', '1', '4', '0', '1', '2016-11-17 02:26:45', '2016-11-17 14:18:31', null);
INSERT INTO `t_document` VALUES ('2', '2', '4', '23', '1', '2016-11-17 02:26:45', '2016-11-17 14:18:31', null);
INSERT INTO `t_document` VALUES ('3', '3', '4', '1', '0', '2016-11-17 02:27:08', '2016-11-17 14:18:32', null);

-- ----------------------------
-- Table structure for t_payment
-- ----------------------------
DROP TABLE IF EXISTS `t_payment`;
CREATE TABLE `t_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `no_transaction` varchar(10) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_value` int(11) DEFAULT NULL,
  `payment_kurs_dollar` int(3) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_ibfk_1` (`customer_id`),
  CONSTRAINT `t_payment_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `m_customer` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of t_payment
-- ----------------------------
INSERT INTO `t_payment` VALUES ('9', '4', null, '2016-11-17 21:15:24', '100000', null, '2016-11-17 15:15:24', null, null);
INSERT INTO `t_payment` VALUES ('10', '4', null, '2016-11-17 21:15:29', '200000', null, '2016-11-17 15:15:29', null, null);
INSERT INTO `t_payment` VALUES ('11', '4', null, '2016-11-17 21:15:52', '200000', null, '2016-11-17 15:15:52', null, null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `ID_USER` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PRIVILLAGE` int(11) DEFAULT NULL,
  `USERNAME` varchar(250) DEFAULT NULL,
  `PASSWORD` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `FK_RELATIONSHIP_1` (`ID_PRIVILLAGE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- View structure for v_payment
-- ----------------------------
DROP VIEW IF EXISTS `v_payment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER  VIEW `v_payment` AS SELECT
m_customer.customer_id,
m_periode.cost,
(
		SELECT
			SUM(payment_value)
		FROM
			t_payment a
		WHERE
			a.customer_id = customer_id
	) AS bayar,
(
		cost - (
			SELECT
				SUM(payment_value)
			FROM
				t_payment a
			WHERE
				a.customer_id = customer_id
		)
	) AS sisa,
m_customer.created_at,
m_customer.updated_at,
m_customer.deleted_at
FROM
	m_customer
LEFT JOIN m_periode ON m_customer.periode_id = m_periode.id ;
