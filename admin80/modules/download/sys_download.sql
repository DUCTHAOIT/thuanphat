/*
MySQL Data Transfer
Source Host: localhost
Source Database: mangochi
Target Host: localhost
Target Database: mangochi
Date: 11/5/2008 12:07:25 PM
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for sys_download
-- ----------------------------
CREATE TABLE `sys_download` (
  `id` int(11) NOT NULL auto_increment,
  `name` text,
  `des` text,
  `file_name` varchar(255) default NULL,
  `no` int(11) NOT NULL default '0',
  `lang` varchar(5) NOT NULL default 'vn',
  `ctrl` bigint(5) default '1',
  `catID` int(11) default NULL,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records 
-- ----------------------------
