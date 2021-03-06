/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100417
 Source Host           : localhost:3306
 Source Schema         : intranet

 Target Server Type    : MariaDB
 Target Server Version : 100417
 File Encoding         : 65001

 Date: 04/08/2021 16:34:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `surname` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `contact_number` varchar(18) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `start_date` datetime(0) NULL DEFAULT NULL,
  `active` tinyint(1) NULL DEFAULT 0,
  `employee_code` varchar(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `id`(`id`) USING BTREE,
  UNIQUE INDEX `code`(`employee_code`) USING BTREE,
  INDEX `active`(`start_date`, `active`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (2, 'Charl', 'Payne', 'maxp@isa.co.za', '011 012 1254', '2021-07-06 12:24:41', 1, 'MDU782');
INSERT INTO `employee` VALUES (3, 'testName', 'testSurname', 'testName@gmail.com', '011 032 7788', '2017-07-04 17:18:35', 1, 'TES003');
INSERT INTO `employee` VALUES (4, 'John', 'Wick', 'john@isa.co.za', '011 078 0760', '2017-10-12 10:28:12', 1, 'JOH004');
INSERT INTO `employee` VALUES (5, 'Max', 'Payne', 'maxp@isa.co.za', '011 012 1254', '2018-01-13 13:20:10', 1, 'MAX005');

-- ----------------------------
-- Table structure for employee_groups
-- ----------------------------
DROP TABLE IF EXISTS `employee_groups`;
CREATE TABLE `employee_groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NULL DEFAULT NULL,
  `group_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_id`(`employee_id`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE,
  CONSTRAINT `employeeid` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `groupid` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee_groups
-- ----------------------------
INSERT INTO `employee_groups` VALUES (3, 3, 1);
INSERT INTO `employee_groups` VALUES (4, 4, 1);
INSERT INTO `employee_groups` VALUES (5, 5, 1);
INSERT INTO `employee_groups` VALUES (7, 3, 2);
INSERT INTO `employee_groups` VALUES (8, 4, 2);
INSERT INTO `employee_groups` VALUES (10, 2, 1);
INSERT INTO `employee_groups` VALUES (11, 2, 2);

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 'Admin');
INSERT INTO `groups` VALUES (2, 'Technical');

SET FOREIGN_KEY_CHECKS = 1;
