-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 09 日 06:55
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sq_weixin123`
--

-- --------------------------------------------------------

--
-- 表的结构 `oa_access`
--

CREATE TABLE IF NOT EXISTS `oa_access` (
  `role_id` smallint(6) unsigned NOT NULL COMMENT '组id',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点id',
  `level` tinyint(1) NOT NULL COMMENT '节点表等级',
  `pid` smallint(6) NOT NULL COMMENT '节点表父亲id',
  `module` varchar(50) DEFAULT NULL COMMENT '模块名',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='为组授权—(为组添加节点功能)';

--
-- 转存表中的数据 `oa_access`
--

INSERT INTO `oa_access` (`role_id`, `node_id`, `level`, `pid`, `module`) VALUES
(1, 1, 1, 0, 'OA系统_Home'),
(1, 3, 3, 2, '内容显示_tables'),
(1, 2, 2, 1, '内容管理_Content'),
(1, 4, 2, 1, '主页管理_Index'),
(1, 5, 3, 4, '主页_index'),
(1, 3, 3, 2, '每日任务_tables'),
(1, 17, 3, 2, '修改_update'),
(2, 1, 1, 0, 'OA系统_Home'),
(2, 2, 2, 1, NULL),
(2, 3, 3, 2, NULL),
(2, 17, 3, 2, NULL),
(2, 4, 2, 1, NULL),
(2, 5, 3, 4, NULL),
(1, 6, 2, 1, NULL),
(1, 16, 3, 6, NULL),
(1, 13, 3, 6, NULL),
(1, 14, 3, 6, NULL),
(1, 18, 3, 6, NULL),
(1, 19, 3, 6, NULL),
(1, 20, 3, 6, NULL),
(1, 21, 3, 6, NULL),
(1, 22, 3, 6, NULL),
(1, 23, 3, 6, NULL),
(1, 24, 3, 6, NULL),
(1, 25, 3, 6, NULL),
(1, 26, 3, 6, NULL),
(1, 27, 3, 6, NULL),
(1, 28, 2, 1, NULL),
(1, 29, 3, 28, NULL),
(1, 30, 3, 28, NULL),
(1, 31, 3, 28, NULL),
(1, 32, 3, 28, NULL),
(1, 33, 2, 1, NULL),
(1, 35, 3, 2, NULL),
(1, 36, 3, 2, NULL),
(2, 35, 3, 2, NULL),
(2, 36, 3, 2, NULL),
(1, 37, 3, 28, NULL),
(4, 1, 1, 0, NULL),
(4, 2, 2, 1, NULL),
(4, 4, 2, 1, NULL),
(4, 38, 3, 28, NULL),
(4, 28, 2, 1, NULL),
(4, 3, 3, 2, NULL),
(4, 17, 3, 2, NULL),
(4, 35, 3, 2, NULL),
(4, 36, 3, 2, NULL),
(4, 5, 3, 4, NULL),
(4, 29, 3, 28, NULL),
(4, 30, 3, 28, NULL),
(4, 31, 3, 28, NULL),
(4, 32, 3, 28, NULL),
(4, 37, 3, 28, NULL),
(1, 38, 3, 28, NULL),
(1, 39, 2, 1, NULL),
(1, 40, 3, 39, NULL),
(2, 39, 2, 1, NULL),
(2, 40, 3, 39, NULL),
(4, 39, 2, 1, NULL),
(4, 40, 3, 39, NULL),
(1, 41, 3, 39, NULL),
(2, 41, 3, 39, NULL),
(4, 41, 3, 39, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `oa_comment`
--

CREATE TABLE IF NOT EXISTS `oa_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `tid` int(10) unsigned NOT NULL COMMENT '评论所属主题id',
  `uid` int(10) unsigned NOT NULL COMMENT '评论人',
  `content` text NOT NULL COMMENT '评论内容',
  `voice` int(10) unsigned DEFAULT NULL COMMENT '评论声音id',
  `time` int(10) unsigned NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `oa_comment`
--

INSERT INTO `oa_comment` (`id`, `tid`, `uid`, `content`, `voice`, `time`) VALUES
(1, 1, 1, 'aaaaaaaaaa', 2, 0),
(2, 1, 1, 'bbbbb', 3, 0),
(3, 1, 1, 'cccccc', 4, 0),
(4, 2, 1, 'cccccc', 4, 0);

-- --------------------------------------------------------

--
-- 表的结构 `oa_file`
--

CREATE TABLE IF NOT EXISTS `oa_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint(1) NOT NULL COMMENT '文件类型：1图片、2声音',
  `thumbs` text NOT NULL COMMENT '缩略图类型：，号分割',
  `size` varchar(30) NOT NULL COMMENT '字节大小',
  `url` varchar(50) NOT NULL COMMENT '文件地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文件表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `oa_file`
--

INSERT INTO `oa_file` (`id`, `type`, `thumbs`, `size`, `url`) VALUES
(1, 1, '', '10000', '123456.pic'),
(2, 2, '', '100000', 'aaaa.mp3'),
(3, 2, '', '100000', 'bbbb.mp3'),
(4, 2, '', '100000', 'cccc.mp3');

-- --------------------------------------------------------

--
-- 表的结构 `oa_node`
--

CREATE TABLE IF NOT EXISTS `oa_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='节点表(1项目、2模块、3方法)的关系' AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `oa_node`
--

INSERT INTO `oa_node` (`id`, `name`, `title`, `status`, `remark`, `sort`, `pid`, `level`, `type`, `group_id`) VALUES
(1, 'Home', '拍拍管理系统', 1, NULL, NULL, 0, 1, 0, 0),
(2, 'Content', '任务管理', 1, NULL, NULL, 1, 2, 0, 0),
(3, 'tables', '每日任务', 1, NULL, NULL, 2, 3, 0, 0),
(4, 'Index', '主页管理', 1, NULL, NULL, 1, 2, 0, 0),
(5, 'index', '主页', 1, NULL, NULL, 4, 3, 0, 0),
(6, 'User', '用户权限管理', 1, NULL, NULL, 1, 2, 0, 0),
(16, 'status', '节点状态管理', 1, NULL, NULL, 6, 3, 0, 0),
(13, 'node', '节点列表', 1, NULL, NULL, 6, 3, 0, 0),
(14, 'nodeEdit', '节点编辑', 1, NULL, NULL, 6, 3, 0, 0),
(17, 'update', '修改', 1, NULL, NULL, 2, 3, 0, 0),
(18, 'user', '用户列表', 1, NULL, NULL, 6, 3, 0, 0),
(19, 'updateUser', '修改用户', 1, NULL, NULL, 6, 3, 0, 0),
(20, 'deleteUser', '编辑用户信息', 1, NULL, NULL, 6, 3, 0, 0),
(21, 'addUser', '添加用户', 1, NULL, NULL, 6, 3, 0, 0),
(22, 'group', '用户与组显示', 1, NULL, NULL, 6, 3, 0, 0),
(23, 'groupEdit', '组编辑', 1, NULL, NULL, 6, 3, 0, 0),
(24, 'groupUser', '添加用户到组', 1, NULL, NULL, 6, 3, 0, 0),
(25, 'power', '组权限管理', 1, NULL, NULL, 6, 3, 0, 0),
(26, 'powerUpdate', '修改权限', 1, NULL, NULL, 6, 3, 0, 0),
(27, 'userDetailed', '用户详细信息', 1, NULL, NULL, 6, 3, 0, 0),
(28, 'Project', '项目管理', 1, NULL, NULL, 1, 2, 0, 0),
(29, 'index', '项目列表', 1, NULL, NULL, 28, 3, 0, 0),
(30, 'edit', '项目编辑', 1, NULL, NULL, 28, 3, 0, 0),
(31, 'save', '数据保存', 1, NULL, NULL, 28, 3, 0, 0),
(32, 'PM', '项目负责', 1, NULL, NULL, 28, 3, 0, 0),
(35, 'select_data', '项目列表', 1, NULL, NULL, 2, 3, 0, 0),
(36, 'save', '价动修改', 1, NULL, NULL, 2, 3, 0, 0),
(37, 'projectDelete', '项目删除', 1, NULL, NULL, 28, 3, 0, 0),
(38, 'timeAxis', '时间轴', 1, NULL, NULL, 28, 3, 0, 0),
(39, 'Personal', '个人中心模块', 1, NULL, NULL, 1, 2, 0, 0),
(40, 'me', '个人中心首页', 1, NULL, NULL, 39, 3, 0, 0),
(41, 'meSave', '个人信息修改', 1, NULL, NULL, 39, 3, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `oa_papauser`
--

CREATE TABLE IF NOT EXISTS `oa_papauser` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `account` varchar(64) NOT NULL COMMENT '账户',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `last_login_time` int(10) unsigned NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(40) NOT NULL COMMENT '最后登录ip',
  `login_count` mediumint(8) unsigned NOT NULL COMMENT '登录次数',
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL COMMENT '修改时间',
  `user_type` tinyint(1) unsigned NOT NULL COMMENT '用户类型',
  `remark` varchar(500) DEFAULT NULL COMMENT '用户备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态:1启用：0禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='啪啪用户表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `oa_papauser`
--

INSERT INTO `oa_papauser` (`id`, `account`, `nickname`, `password`, `last_login_time`, `last_login_ip`, `login_count`, `create_time`, `update_time`, `user_type`, `remark`, `status`) VALUES
(1, 'user1', '业主', 'e10adc3949ba59abbe56e057f20f883e', 0, '', 0, 0, 0, 1, NULL, 1),
(2, 'user2', '监理师', 'e10adc3949ba59abbe56e057f20f883e', 0, '', 0, 0, 0, 2, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `oa_role`
--

CREATE TABLE IF NOT EXISTS `oa_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ename` varchar(5) DEFAULT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `ename` (`ename`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='组' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `oa_role`
--

INSERT INTO `oa_role` (`id`, `name`, `pid`, `status`, `remark`, `ename`, `create_time`, `update_time`) VALUES
(1, 'manager', 0, 1, '管理者', NULL, 0, 0),
(2, 'User', 0, 1, '用户组', NULL, 0, 0),
(4, 'leader', NULL, 0, '领导组', NULL, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `oa_role_user`
--

CREATE TABLE IF NOT EXISTS `oa_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL COMMENT '组id',
  `user_id` char(32) DEFAULT NULL COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='让用户隶属某个组';

--
-- 转存表中的数据 `oa_role_user`
--

INSERT INTO `oa_role_user` (`role_id`, `user_id`) VALUES
(1, '1');

-- --------------------------------------------------------

--
-- 表的结构 `oa_topic`
--

CREATE TABLE IF NOT EXISTS `oa_topic` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` tinyint(1) unsigned NOT NULL COMMENT '主题类型：1为拍拍说，2为项目',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '所属项目',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户id',
  `content` text COMMENT '主题内容',
  `voice` int(10) DEFAULT NULL COMMENT '声音地址id',
  `pic` int(10) DEFAULT NULL COMMENT '图片地址id',
  `time` int(10) NOT NULL COMMENT '发送时间',
  `new_comids` varchar(50) DEFAULT NULL COMMENT '最新3条评论id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0显示，1不显示）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主题id' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `oa_topic`
--

INSERT INTO `oa_topic` (`id`, `type`, `pid`, `user_id`, `content`, `voice`, `pic`, `time`, `new_comids`, `status`) VALUES
(1, 1, 1, 1, '123456789', 2, 1, 0, '1,2,3', 0);

-- --------------------------------------------------------

--
-- 表的结构 `oa_user`
--

CREATE TABLE IF NOT EXISTS `oa_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL COMMENT '账户',
  `nickname` varchar(50) NOT NULL COMMENT '称呢',
  `password` char(32) NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0' COMMENT '登陆次数',
  `email` varchar(50) NOT NULL COMMENT '联系方式',
  `remark` varchar(255) NOT NULL COMMENT '备注',
  `salary` int(6) unsigned DEFAULT '0' COMMENT '工资',
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1为启用，0为禁用）',
  `user_type` tinyint(1) unsigned DEFAULT '0' COMMENT '用户类型',
  `info` text NOT NULL,
  `sex` tinyint(1) unsigned DEFAULT NULL COMMENT '性别：1为男，0为女',
  `birthdays` date DEFAULT NULL COMMENT '生日',
  `age` int(3) DEFAULT NULL COMMENT '年龄',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员用户表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `oa_user`
--

INSERT INTO `oa_user` (`id`, `account`, `nickname`, `password`, `last_login_time`, `last_login_ip`, `login_count`, `email`, `remark`, `salary`, `create_time`, `update_time`, `status`, `user_type`, `info`, `sex`, `birthdays`, `age`) VALUES
(1, 'admin', '管理员大人', 'e10adc3949ba59abbe56e057f20f883e', 1370748214, '127.0.0.1', 10, '', '', 0, 0, 1370672053, 1, 0, '', 1, '0000-00-00', 0),
(2, 'user1', '用户1', 'e10adc3949ba59abbe56e057f20f883e', 1370672115, '180.172.128.120', 0, '13575135713', '用户1', 0, 1370620800, 0, 1, 0, '', NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
