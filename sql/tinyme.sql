/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100119
 Source Host           : localhost
 Source Database       : demo

 Target Server Type    : MariaDB
 Target Server Version : 100119
 File Encoding         : utf-8

 Date: 11/08/2017 03:30:41 AM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `tm_pages`
-- ----------------------------
DROP TABLE IF EXISTS `tm_pages`;
CREATE TABLE `tm_pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT 'user_id',
  `content` text COMMENT 'content',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tm_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `tm_tokens`;
CREATE TABLE `tm_tokens` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL COMMENT 'user_id',
  `token` varchar(100) DEFAULT NULL COMMENT 'token',
  `expire_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`) USING BTREE,
  KEY `uid_token` (`uid`,`token`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tm_users`
-- ----------------------------
DROP TABLE IF EXISTS `tm_users`;
CREATE TABLE `tm_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT 'email',
  `password` char(32) NOT NULL DEFAULT '' COMMENT 'password',
  `nickname` varchar(128) NOT NULL DEFAULT '' COMMENT 'nickname',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `tm_users`
-- ----------------------------
BEGIN;
INSERT INTO `tm_users` VALUES ('1', 'foo@example.com', '8f94604c843418f04c61839df661bbfe', 'foo_user', '2017-11-07 21:08:31', '2017-11-07 21:08:31'), ('2', 'bar@example.com', '8f94604c843418f04c61839df661bbfe', 'bar_user', '2017-11-07 21:08:31', '2017-11-07 21:08:31');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
