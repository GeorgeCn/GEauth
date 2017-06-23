-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.47 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.2.0.4947
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 tp 的数据库结构
CREATE DATABASE IF NOT EXISTS `tp` /*!40100 DEFAULT CHARACTER SET gbk */;
USE `tp`;


-- 导出  表 tp.think_admin 结构
CREATE TABLE IF NOT EXISTS `think_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loginname` varchar(50) NOT NULL DEFAULT '0' COMMENT '昵称',
  `pwd` varchar(32) NOT NULL DEFAULT '0',
  `mobile` varchar(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `email` varchar(50) NOT NULL DEFAULT '0' COMMENT '邮箱',
  `avatar` varchar(100) NOT NULL COMMENT '头像',
  `states` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态(1:正常  2:禁用)',
  `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后一次登录时间',
  `last_login_ip` varchar(20) NOT NULL COMMENT '最后一次登录IP',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk COMMENT='后台用户表';

-- 正在导出表  tp.think_admin 的数据：5 rows
/*!40000 ALTER TABLE `think_admin` DISABLE KEYS */;
REPLACE INTO `think_admin` (`id`, `loginname`, `pwd`, `mobile`, `email`, `avatar`, `states`, `last_login_time`, `last_login_ip`, `create_time`) VALUES
	(1, 'admin', '32ad489198552f45b73674ccf256afb5', '15699999999', '123456@qq.com', 'Public/Uploads/avatars/2017-05-09/59118f46a7477.jpg', 1, '0000-00-00 00:00:00', '127.0.0.1', '0000-00-00 00:00:00'),
	(2, 'test', '32ad489198552f45b73674ccf256afb5', '15688888888', '654321@qq.com', '', 1, '0000-00-00 00:00:00', '192.168.40.214', '0000-00-00 00:00:00'),
	(3, 'ceshi', '32ad489198552f45b73674ccf256afb5', '15688888888', '123@qq.com', '', 1, '2017-05-05 18:46:07', '', '0000-00-00 00:00:00'),
	(6, 'test', '97a81a4a1dad181aa3bb840541da531f', '15688888888', '654321@qq.com', '', 1, '2017-06-22 13:56:23', '', '0000-00-00 00:00:00'),
	(5, 'glx', '32ad489198552f45b73674ccf256afb5', '15677777777', '123@qq.com', 'Public/Uploads/avatars/2017-05-09/59118f46a7477.jpg', 1, '2017-05-09 17:43:34', '', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `think_admin` ENABLE KEYS */;


-- 导出  表 tp.think_auth_group 结构
CREATE TABLE IF NOT EXISTS `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `desc` char(100) NOT NULL DEFAULT '' COMMENT '角色描述',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '规则ID，以 ; 隔开 ',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 正在导出表  tp.think_auth_group 的数据：2 rows
/*!40000 ALTER TABLE `think_auth_group` DISABLE KEYS */;
REPLACE INTO `think_auth_group` (`id`, `title`, `desc`, `status`, `rules`, `create_time`) VALUES
	(1, '超级管理员', '', 1, '1;2;3', '0000-00-00 00:00:00'),
	(2, '管理员', '这是一个管理员的角色\r\n', 1, '1;2;3;', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `think_auth_group` ENABLE KEYS */;


-- 导出  表 tp.think_auth_group_access 结构
CREATE TABLE IF NOT EXISTS `think_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '角色id',
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 正在导出表  tp.think_auth_group_access 的数据：3 rows
/*!40000 ALTER TABLE `think_auth_group_access` DISABLE KEYS */;
REPLACE INTO `think_auth_group_access` (`uid`, `group_id`) VALUES
	(1, 1),
	(2, 1),
	(6, 2);
/*!40000 ALTER TABLE `think_auth_group_access` ENABLE KEYS */;


-- 导出  表 tp.think_auth_rule 结构
CREATE TABLE IF NOT EXISTS `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `condition` char(100) DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级ID ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 正在导出表  tp.think_auth_rule 的数据：9 rows
/*!40000 ALTER TABLE `think_auth_rule` DISABLE KEYS */;
REPLACE INTO `think_auth_rule` (`id`, `name`, `title`, `type`, `status`, `condition`, `pid`) VALUES
	(1, 'Home/Index/default', '用户模块', 1, 1, '', 0),
	(2, 'Home/Index/default1', '用户组', 1, 1, '', 1),
	(3, 'home\\role\\index1', '用户列表', 1, 1, '', 2),
	(4, 'home\\role\\default1', '管理组', 1, 1, '', 1),
	(5, 'home\\role\\index', '角色管理', 1, 1, '', 4),
	(6, 'home\\user\\index', '管理员', 1, 1, '', 4),
	(7, 'home\\menu\\default', '菜单模块', 1, 1, '', 0),
	(8, 'home\\menu\\default1', '后台菜单', 1, 1, '', 7),
	(9, 'home\\menu\\index', '菜单列表', 1, 1, '', 0);
/*!40000 ALTER TABLE `think_auth_rule` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
