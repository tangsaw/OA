/*
Navicat MySQL Data Transfer

Source Server         : 192.168.20.126
Source Server Version : 50629
Source Host           : 192.168.20.126:3336
Source Database       : tj_oa

Target Server Type    : MYSQL
Target Server Version : 50629
File Encoding         : 65001

Date: 2016-10-14 15:16:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ud_userdiary
-- ----------------------------
DROP TABLE IF EXISTS `ud_userdiary`;
CREATE TABLE `ud_userdiary` (
  `BYNAME` varchar(255) CHARACTER SET gbk DEFAULT '' COMMENT '人员工号',
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '唯一自增ID',
  `User_Dept` varchar(50) CHARACTER SET gbk DEFAULT NULL,
  `isSat` bit(1) DEFAULT b'0' COMMENT '是否是周六',
  `isSun` bit(1) DEFAULT b'0' COMMENT '是否是周日',
  `isClass` int(11) DEFAULT '3' COMMENT '1普通人员，2中层人员，3高层人员',
  `typeName` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=ascii;
