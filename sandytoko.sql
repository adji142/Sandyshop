/*
 Navicat Premium Data Transfer

 Source Server         : MYSQL_SRV_DEV
 Source Server Type    : MySQL
 Source Server Version : 50552
 Source Host           : localhost:3306
 Source Schema         : sandytoko

 Target Server Type    : MySQL
 Target Server Version : 50552
 File Encoding         : 65001

 Date: 11/08/2019 23:16:52
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `items` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0,
  `shipped` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES (31, '[{\"id\":\"PP001\",\"size\":\"\",\"quantity\":8},{\"id\":\"PP002\",\"size\":\"\",\"quantity\":4}]', '2019-09-10 06:54:50', 0, 0);
INSERT INTO `cart` VALUES (32, '[{\"id\":\"PP002\",\"size\":\"\",\"quantity\":\"5\"},{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"2\"}]', '2019-09-10 17:12:56', 0, 0);
INSERT INTO `cart` VALUES (33, '[{\"id\":\"PP002\",\"size\":\"\",\"quantity\":\"13\"}]', '2019-09-10 17:25:06', 0, 0);
INSERT INTO `cart` VALUES (34, '[{\"id\":\"PP002\",\"size\":\"\",\"quantity\":\"6\"}]', '2019-09-10 17:30:09', 1, 0);
INSERT INTO `cart` VALUES (35, '[{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"3\"}]', '2019-09-10 17:35:59', 1, 0);
INSERT INTO `cart` VALUES (36, '[{\"id\":\"PP002\",\"size\":\"\",\"quantity\":\"2\"},{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"3\"}]', '2019-09-10 17:40:02', 1, 0);
INSERT INTO `cart` VALUES (37, '[{\"id\":\"PP002\",\"size\":\"\",\"quantity\":\"4\"}]', '2019-09-10 17:43:20', 1, 0);
INSERT INTO `cart` VALUES (38, '[{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"1\"}]', '2019-09-10 17:44:29', 1, 0);
INSERT INTO `cart` VALUES (39, '[{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"3\"}]', '2019-09-10 17:45:44', 1, 0);
INSERT INTO `cart` VALUES (40, '[{\"id\":\"PP001\",\"size\":\"\",\"quantity\":\"1\"}]', '2019-09-10 17:46:31', 1, 0);

-- ----------------------------
-- Table structure for kategori
-- ----------------------------
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori`  (
  `id_kategori` int(5) NOT NULL AUTO_INCREMENT,
  `Nama_kategori` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `parent` int(5) NULL DEFAULT NULL,
  PRIMARY KEY (`id_kategori`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kategori
-- ----------------------------
INSERT INTO `kategori` VALUES (1, 'A', NULL);
INSERT INTO `kategori` VALUES (2, 'Test2', 0);
INSERT INTO `kategori` VALUES (3, 'Test', 2);

-- ----------------------------
-- Table structure for kota
-- ----------------------------
DROP TABLE IF EXISTS `kota`;
CREATE TABLE `kota`  (
  `id_kota` int(5) NOT NULL AUTO_INCREMENT,
  `nama_kota` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ongkos_kirim` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`id_kota`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kota
-- ----------------------------
INSERT INTO `kota` VALUES (1, 'yogyakarta', 15000);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id_orders` int(255) NOT NULL AUTO_INCREMENT,
  `status_order` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tgl_order` date NULL DEFAULT NULL,
  `id_customer` int(5) NULL DEFAULT NULL,
  `status_ekspedisi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `no_resi` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ongkoskirim` decimal(9, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id_orders`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, 'Di Bayar', '2019-08-11', 1, '', '', 15000.00);
INSERT INTO `orders` VALUES (2, 'Di Bayar', '2019-08-11', 2, '', '', 15000.00);
INSERT INTO `orders` VALUES (3, 'Di Bayar', '2019-08-11', 3, '', '', 15000.00);
INSERT INTO `orders` VALUES (4, 'Di Bayar', '2019-08-11', 4, '', '', 15000.00);
INSERT INTO `orders` VALUES (5, 'Di Bayar', '2019-08-11', 5, '', '', 15000.00);
INSERT INTO `orders` VALUES (6, 'Di Bayar', '2019-08-11', 6, '', '', 15000.00);
INSERT INTO `orders` VALUES (7, 'Di Bayar', '2019-08-11', 7, '', '', 15000.00);

-- ----------------------------
-- Table structure for ordersdetail
-- ----------------------------
DROP TABLE IF EXISTS `ordersdetail`;
CREATE TABLE `ordersdetail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NULL DEFAULT NULL,
  `id_produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jumlah` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ordersdetail
-- ----------------------------
INSERT INTO `ordersdetail` VALUES (1, 1, 'PP002', 6);
INSERT INTO `ordersdetail` VALUES (2, 2, 'PP001', 3);
INSERT INTO `ordersdetail` VALUES (3, 3, 'PP002', 2);
INSERT INTO `ordersdetail` VALUES (4, 3, 'PP001', 3);
INSERT INTO `ordersdetail` VALUES (5, 4, 'PP002', 4);
INSERT INTO `ordersdetail` VALUES (6, 5, 'PP001', 1);
INSERT INTO `ordersdetail` VALUES (7, 6, 'PP001', 3);
INSERT INTO `ordersdetail` VALUES (8, 7, 'PP001', 1);

-- ----------------------------
-- Table structure for pembelian
-- ----------------------------
DROP TABLE IF EXISTS `pembelian`;
CREATE TABLE `pembelian`  (
  `id_kustomer` int(5) NOT NULL AUTO_INCREMENT,
  `Password` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Email` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `id_kota` int(5) NULL DEFAULT NULL,
  `kodepos` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `provinsi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `negara` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_kustomer`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pembelian
-- ----------------------------
INSERT INTO `pembelian` VALUES (1, '$2y$10$1HoYAt51UMgcHQwxbYpToel5/4oIlo9fRyelLWt8fEjuI1u2C4b2e', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21', 'admin', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (2, '$2y$10$l5ZK0d7oJ2cY1uoK3xbXG.Pi7.ddzcVEilXSoXiSC47BAuEVTS/lC', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21', 'prasetyoajiw@gmail.com', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (3, '$2y$10$hMgt5LIdmg6r41Ai8pMqcOD7GMa2hMwOUBWTfy.COj/IxejuzVs7e', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21, 081325058258', 'adjia7x@gmail.com', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (4, '$2y$10$hca1HEg6PndwrAnfK8zB6eMPRryFb0SvHUm6/qN66j9pfwl1D1zAS', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21, 081325058258, 081325058258', 'admin@admin.admin', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (5, '$2y$10$bFAtmkMzmY6r/Jmi0ir1JeCeck1.blKvzB6SzVQWrB.hQ91GGUHhi', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21, 081325058258', 'admin123@asd.asd', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (6, '$2y$10$qoH8yxaANGuVlSHapiExhOQyg7U8RCaP81einlxB3tABW0z5Q9CzC', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21', 'admin.asd@asd.asd', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');
INSERT INTO `pembelian` VALUES (7, '$2y$10$hMZYquoPSzv1r.KJDVnYqOmaGIlOR7OMivVK0hMTLUKEfNWi/U7k.', 'Prasetyo Aji Wibowo', 'Bibisluhur RT07/21, 081325058258, 081325058258, 081325058258', 'adminasd@asd.asd', 'street2', 1, '57135', 'Jawa Tengah', 'Indonesia');

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id_produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `id_kategori` int(5) NULL DEFAULT NULL,
  `nama_produk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deskripsi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `Harga` int(20) NULL DEFAULT NULL,
  `Stok` int(5) NULL DEFAULT NULL,
  `Berat` decimal(5, 2) NULL DEFAULT NULL,
  `Tgl_masuk` date NULL DEFAULT NULL,
  `gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `Dibeli` int(5) NULL DEFAULT NULL,
  `Diskon` int(5) NULL DEFAULT NULL,
  `supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `deleted` bit(1) NULL DEFAULT NULL COMMENT '0: normal, 1 : deleted',
  `featured` tinyint(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_produk`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES ('PP001', 3, '1234567', '1asd', 150000, 15, 55.00, NULL, '/SandyShop/images/products2032e2ef57324dd24a146d841c59f50f.png', 11, 0, 'SP1660820480', b'0', 1);
INSERT INTO `produk` VALUES ('PP002', 3, 'qwerty', 'aaaa', 150000, 15, 55.00, NULL, '/SandyShop/images/productsae6e0738685e9c0f2da3ec493f96dab8.png', 12, 10, 'SP1660820480', b'0', 1);

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id_supplier` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `supplier` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `telepon` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `tglmasuk` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_supplier`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('SP1660820480', 'Indah', 'solo', '0819', 'nais', '2019-08-09');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `join_date` datetime NULL DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (4, 'yoga pratama', 'ypratama424@gmail.com', '$2y$10$/vHxkekh2IxP2ZpROT4eG.zCZVeKc5ImeMec33uvg97eD.LJMb0hy', '2018-01-29 19:00:15', '2018-05-29 16:11:17', 'admin,editor');
INSERT INTO `users` VALUES (5, 'yoga pratama', 'prasetyoajiw@gmail.com', '$2y$10$/vHxkekh2IxP2ZpROT4eG.zCZVeKc5ImeMec33uvg97eD.LJMb0hy', '2018-01-29 19:00:15', '2019-08-11 22:01:01', 'admin,editor');
INSERT INTO `users` VALUES (6, 'Prasetyo Aji Wibowo', 'adjia7x@gmail.com', '$2y$10$hMgt5LIdmg6r41Ai8pMqcOD7GMa2hMwOUBWTfy.COj/IxejuzVs7e', '2019-08-11 17:40:24', '2019-08-11 17:40:24', 'user');
INSERT INTO `users` VALUES (7, 'Prasetyo Aji Wibowo', 'admin@admin.admin', '$2y$10$hca1HEg6PndwrAnfK8zB6eMPRryFb0SvHUm6/qN66j9pfwl1D1zAS', '2019-08-11 17:43:38', '2019-08-11 17:43:38', 'user');
INSERT INTO `users` VALUES (8, 'Prasetyo Aji Wibowo', 'admin123@asd.asd', '$2y$10$bFAtmkMzmY6r/Jmi0ir1JeCeck1.blKvzB6SzVQWrB.hQ91GGUHhi', '2019-08-11 17:44:43', '2019-08-11 17:44:43', 'user');
INSERT INTO `users` VALUES (9, 'Prasetyo Aji Wibowo', 'admin.asd@asd.asd', '$2y$10$qoH8yxaANGuVlSHapiExhOQyg7U8RCaP81einlxB3tABW0z5Q9CzC', '2019-08-11 17:45:58', '2019-08-11 17:45:58', 'user');
INSERT INTO `users` VALUES (10, 'Prasetyo Aji Wibowo', 'adminasd@asd.asd', '$2y$10$hMZYquoPSzv1r.KJDVnYqOmaGIlOR7OMivVK0hMTLUKEfNWi/U7k.', '2019-08-11 17:46:51', '2019-08-11 17:46:51', 'user');

SET FOREIGN_KEY_CHECKS = 1;
