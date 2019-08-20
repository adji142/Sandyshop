/*
 Navicat Premium Data Transfer

 Source Server         : koprasiwanitausahamandiri.com
 Source Server Type    : MySQL
 Source Server Version : 100225
 Source Host           : 83.136.216.91:3306
 Source Schema         : u6018530_tutorial

 Target Server Type    : MySQL
 Target Server Version : 100225
 File Encoding         : 65001

 Date: 09/08/2019 22:07:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `join_date` datetime(0) NOT NULL DEFAULT current_timestamp(0),
  `last_login` datetime(0) NOT NULL,
  `permissions` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (4, 'yoga pratama', 'ypratama424@gmail.com', '$2y$10$/vHxkekh2IxP2ZpROT4eG.zCZVeKc5ImeMec33uvg97eD.LJMb0hy', '2018-01-29 19:00:15', '2018-05-29 16:11:17', 'admin,editor');
INSERT INTO `users` VALUES (5, 'yoga pratama', 'prasetyoajiw@gmail.com', '$2y$10$/vHxkekh2IxP2ZpROT4eG.zCZVeKc5ImeMec33uvg97eD.LJMb0hy', '2018-01-29 19:00:15', '2019-07-22 15:16:00', 'user');

SET FOREIGN_KEY_CHECKS = 1;
