/*
Navicat MySQL Data Transfer

Source Server         : docker
Source Server Version : 80003
Source Host           : 127.0.0.1:3306
Source Database       : history_jeemu

Target Server Type    : MYSQL
Target Server Version : 80003
File Encoding         : 65001

Date: 2017-12-20 19:53:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for his_sms
-- ----------------------------
DROP TABLE IF EXISTS `his_sms`;
CREATE TABLE `his_sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` char(6) NOT NULL DEFAULT '' COMMENT '验证码',
  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '有效时间',
  `insert_time` int(11) NOT NULL DEFAULT '0' COMMENT '插入时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1-有效；0-失效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
