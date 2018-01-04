/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50720
Source Host           : 127.0.0.1:3306
Source Database       : history_jeemu

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2018-01-05 00:08:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for his_oil
-- ----------------------------
DROP TABLE IF EXISTS `his_oil`;
CREATE TABLE `his_oil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `content` text NOT NULL COMMENT '说明',
  `author_id` int(11) NOT NULL DEFAULT '0' COMMENT '作者id',
  `head_img_res_id` int(11) NOT NULL DEFAULT '0' COMMENT '头图id',
  `publish_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间（成品时间）',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1-正常；0-删除',
  `insert_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
