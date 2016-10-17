/*
Navicat MySQL Data Transfer

Source Server         : 192.168.20.126
Source Server Version : 50629
Source Host           : 192.168.20.126:3336
Source Database       : tj_oa

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2016-10-14 15:16:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ud_usernodiary
-- ----------------------------
DROP TABLE IF EXISTS `ud_usernodiary`;
CREATE TABLE `ud_usernodiary` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一自增ID',
  `BYNAME` varchar(255) CHARACTER SET gbk DEFAULT '' COMMENT '人员工号',
  `T_Date` date DEFAULT NULL,
  `typeName` int(1) DEFAULT NULL,
  `AddDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3787 DEFAULT CHARSET=ascii;
