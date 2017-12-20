/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50720
Source Host           : 127.0.0.1:3306
Source Database       : history_jeemu

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2017-12-21 00:06:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for his_act
-- ----------------------------
DROP TABLE IF EXISTS `his_act`;
CREATE TABLE `his_act` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `show_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始展示时间',
  `show_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束展示时间',
  `bg_img_res_id` int(11) NOT NULL DEFAULT '0' COMMENT '背景图片',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1-上线；0-下线',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for his_addr
-- ----------------------------
DROP TABLE IF EXISTS `his_addr`;
CREATE TABLE `his_addr` (
  `id` int(11) NOT NULL,
  `lng` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `gaode_lng` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '高德经度',
  `gaode_lat` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '高德纬度',
  PRIMARY KEY (`id`),
  KEY `lng_normal` (`lng`),
  KEY `lat_normal` (`lat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for his_res
-- ----------------------------
DROP TABLE IF EXISTS `his_res`;
CREATE TABLE `his_res` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '绝对地址',
  `key` char(32) NOT NULL DEFAULT '' COMMENT 'md5(file);',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态；1-正常；0-删除',
  `insert_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for his_user
-- ----------------------------
DROP TABLE IF EXISTS `his_user`;
CREATE TABLE `his_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `nick` varchar(20) NOT NULL DEFAULT '' COMMENT '昵称',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别；1-男；2-女；0-未知',
  `headimg_res_id` int(11) NOT NULL DEFAULT '0' COMMENT '头像resid',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `salt` char(16) NOT NULL DEFAULT '',
  `openid` varchar(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1-正常；-1-删除；',
  `insert_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_phone` (`phone`),
  UNIQUE KEY `uniq_openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for his_user_address
-- ----------------------------
DROP TABLE IF EXISTS `his_user_address`;
CREATE TABLE `his_user_address` (
  `uid` int(11) NOT NULL,
  `country` varchar(20) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(20) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(20) NOT NULL DEFAULT '' COMMENT '城市',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '额外信息',
  `insert_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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