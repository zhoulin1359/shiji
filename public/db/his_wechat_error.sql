/*
Navicat MySQL Data Transfer

Source Server         : docker
Source Server Version : 80003
Source Host           : 127.0.0.1:3306
Source Database       : history_jeemu

Target Server Type    : MYSQL
Target Server Version : 80003
File Encoding         : 65001

Date: 2017-12-20 19:53:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for his_wechat_error
-- ----------------------------
DROP TABLE IF EXISTS `his_wechat_error`;
CREATE TABLE `his_wechat_error` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `api` varchar(50) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态；0-初始态；1-已处理',
  `insert_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
