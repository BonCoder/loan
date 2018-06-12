/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50635
Source Host           : localhost:3306
Source Database       : loan

Target Server Type    : MYSQL
Target Server Version : 50635
File Encoding         : 65001

Date: 2018-03-16 14:10:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for loa_callback
-- ----------------------------
DROP TABLE IF EXISTS `loa_callback`;
CREATE TABLE `loa_callback` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `old_num` int(11) NOT NULL DEFAULT '0' COMMENT '已还期数',
  `new_num` int(11) DEFAULT NULL COMMENT '还剩期数',
  `loa_uid` int(11) DEFAULT NULL COMMENT '还款人ID',
  `sys_uid` int(11) DEFAULT NULL COMMENT '操作人ID',
  `start_t` datetime DEFAULT NULL COMMENT '开始还款日期',
  `last_t` datetime DEFAULT NULL COMMENT '上次还款日期',
  PRIMARY KEY (`id`),
  KEY `Index_callback` (`id`),
  KEY `FK_Reference_4` (`loa_uid`),
  KEY `FK_Reference_5` (`sys_uid`),
  CONSTRAINT `FK_Reference_4` FOREIGN KEY (`loa_uid`) REFERENCES `loa_user` (`id`),
  CONSTRAINT `FK_Reference_5` FOREIGN KEY (`sys_uid`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_callback
-- ----------------------------
INSERT INTO `loa_callback` VALUES ('1', '3', '9', '1', '1', '2018-03-13 00:00:00', '2018-03-13 16:27:05');
INSERT INTO `loa_callback` VALUES ('2', '3', '9', '1', '1', '2018-03-13 00:00:00', '2018-03-13 16:27:05');
INSERT INTO `loa_callback` VALUES ('5', '2', '10', '2', '1', '2018-03-14 10:34:30', '2018-03-14 10:34:32');
INSERT INTO `loa_callback` VALUES ('8', '0', '12', '6', '1', '2018-03-15 00:00:00', '2018-03-15 00:00:00');
INSERT INTO `loa_callback` VALUES ('9', '0', '24', '7', '1', '2018-03-01 00:00:00', '2018-03-01 00:00:00');
INSERT INTO `loa_callback` VALUES ('10', '0', '12', '8', '1', '2018-03-15 00:00:00', '2018-03-15 00:00:00');

-- ----------------------------
-- Table structure for loa_car
-- ----------------------------
DROP TABLE IF EXISTS `loa_car`;
CREATE TABLE `loa_car` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `plate` varchar(50) DEFAULT NULL COMMENT '车牌号',
  `ime` varchar(100) DEFAULT NULL COMMENT 'IME',
  `create_t` datetime DEFAULT NULL COMMENT '创建时间',
  `update_t` datetime DEFAULT NULL COMMENT '修改时间',
  `loa_uid` int(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`),
  KEY `Index_car` (`id`),
  KEY `FK_Reference_1` (`loa_uid`),
  CONSTRAINT `FK_Reference_1` FOREIGN KEY (`loa_uid`) REFERENCES `loa_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_car
-- ----------------------------
INSERT INTO `loa_car` VALUES ('3', '川A34521', 'WSG58A459', '2018-03-15 16:16:04', '2018-03-15 16:16:04', '6');
INSERT INTO `loa_car` VALUES ('4', '川A34522', 'WSG58A459', '2018-03-15 16:20:27', '2018-03-15 16:20:27', '7');
INSERT INTO `loa_car` VALUES ('5', '川A34521', 'WSG58A459', '2018-03-15 17:12:29', '2018-03-15 17:12:29', '8');

-- ----------------------------
-- Table structure for loa_interest
-- ----------------------------
DROP TABLE IF EXISTS `loa_interest`;
CREATE TABLE `loa_interest` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `interest` float DEFAULT NULL COMMENT '利率',
  `create_t` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_interest
-- ----------------------------
INSERT INTO `loa_interest` VALUES ('1', '0.05', '2018-03-14 11:35:28');
INSERT INTO `loa_interest` VALUES ('2', '0.08', '2018-03-14 11:36:07');
INSERT INTO `loa_interest` VALUES ('3', '0.1', '2018-03-14 11:36:09');
INSERT INTO `loa_interest` VALUES ('4', '0.15', '2018-03-14 11:36:14');
INSERT INTO `loa_interest` VALUES ('5', '0.2', '2018-03-14 11:36:17');

-- ----------------------------
-- Table structure for loa_overdue
-- ----------------------------
DROP TABLE IF EXISTS `loa_overdue`;
CREATE TABLE `loa_overdue` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `loa_call_id` int(11) DEFAULT NULL COMMENT '逾期贷款ID',
  `sys_uid` int(11) DEFAULT NULL COMMENT '操作人ID',
  `take_t` datetime DEFAULT NULL COMMENT '提取日期',
  `back_t` datetime DEFAULT NULL COMMENT '归还的日期',
  `money` varchar(50) DEFAULT NULL COMMENT '拖车费用',
  `type` int(11) DEFAULT NULL COMMENT '0:没拖车 1:在拖车 2:拖完车',
  PRIMARY KEY (`id`),
  KEY `Index_overdue` (`id`),
  KEY `FK_Reference_6` (`loa_call_id`),
  CONSTRAINT `FK_Reference_6` FOREIGN KEY (`loa_call_id`) REFERENCES `loa_callback` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_overdue
-- ----------------------------

-- ----------------------------
-- Table structure for loa_periods
-- ----------------------------
DROP TABLE IF EXISTS `loa_periods`;
CREATE TABLE `loa_periods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `number` int(11) DEFAULT NULL COMMENT '期数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_periods
-- ----------------------------
INSERT INTO `loa_periods` VALUES ('1', '12');
INSERT INTO `loa_periods` VALUES ('2', '24');
INSERT INTO `loa_periods` VALUES ('3', '36');

-- ----------------------------
-- Table structure for loa_user
-- ----------------------------
DROP TABLE IF EXISTS `loa_user`;
CREATE TABLE `loa_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(50) DEFAULT NULL COMMENT '姓名',
  `sex` int(11) DEFAULT NULL COMMENT '性别',
  `age` int(11) DEFAULT NULL COMMENT '年龄',
  `identity` varchar(50) DEFAULT NULL COMMENT '身份证号',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `pdf` varchar(100) DEFAULT NULL COMMENT 'PDF存放路径',
  `card` varchar(50) DEFAULT NULL COMMENT '银行卡号',
  `int_id` int(11) DEFAULT NULL COMMENT '利率',
  `pid` int(11) DEFAULT NULL COMMENT '贷款期数',
  `status` int(11) DEFAULT '1' COMMENT '1:待审核 2:审核成功 3:正在还款 4:还款成功',
  `sys_uid` int(11) DEFAULT NULL COMMENT '录入人员',
  `create_t` datetime DEFAULT NULL COMMENT '添加时间',
  `update_t` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `Index_loa_user` (`id`),
  KEY `FK_Reference_2` (`sys_uid`),
  CONSTRAINT `FK_Reference_2` FOREIGN KEY (`sys_uid`) REFERENCES `sys_user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of loa_user
-- ----------------------------
INSERT INTO `loa_user` VALUES ('1', '张三', '1', '24', '511024199512043113', '1888888888', '/public/pdf/jinhaidun_7.pdf', null, '1', '1', '1', '1', '2018-03-13 16:26:11', '2018-03-13 16:26:13');
INSERT INTO `loa_user` VALUES ('2', '李四', '2', '25', '511024199512043111', '1888888889', '/public/pdf/jinhaidun_7.pdf', null, '2', '1', '1', '1', '2018-03-13 16:26:11', '2018-03-13 16:26:13');
INSERT INTO `loa_user` VALUES ('6', '王五', '1', null, '511024199512043110', '1888888881', '/public/pdf/jinhaidun_6.pdf', null, '1', '1', '1', '1', '2018-03-15 16:16:04', '2018-03-15 16:16:04');
INSERT INTO `loa_user` VALUES ('7', '周六', '2', null, '511024199512043121', '1888888882', '/public/pdf/jinhaidun_7.pdf', null, '1', '2', '1', '1', '2018-03-15 16:20:27', '2018-03-15 16:20:27');
INSERT INTO `loa_user` VALUES ('8', '阿萨德', '1', null, '511024199512043110', '18888888889', '/public/pdf/jinhaidun_8.pdf', '123123123123123', '1', '1', '1', '1', '2018-03-15 17:12:29', '2018-03-15 17:12:29');

-- ----------------------------
-- Table structure for sys_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `sys_auth_rule`;
CREATE TABLE `sys_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `href` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `authopen` tinyint(2) NOT NULL DEFAULT '1',
  `icon` varchar(20) DEFAULT NULL COMMENT '样式',
  `pid` int(5) NOT NULL DEFAULT '0' COMMENT '父栏目ID',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `zt` int(1) DEFAULT NULL,
  `menustatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=274 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_auth_rule
-- ----------------------------
INSERT INTO `sys_auth_rule` VALUES ('3', 'User', '会员管理', '1', '1', '0', 'icon-user', '0', '0', '1447231507', '1', '1');
INSERT INTO `sys_auth_rule` VALUES ('1', 'System', '系统设置', '1', '1', '0', 'icon-cogs', '0', '5', '1446535750', '1', '1');
INSERT INTO `sys_auth_rule` VALUES ('2', 'System/system', '系统设置', '1', '1', '0', '', '1', '1', '1446535789', '1', '1');
INSERT INTO `sys_auth_rule` VALUES ('4', 'User/index', '会员列表', '1', '1', '0', '', '3', '10', '1447232085', '1', '1');
INSERT INTO `sys_auth_rule` VALUES ('5', 'User/add', '添加用户', '1', '1', '0', ' ', '3', '2', '1447232184', '1', '1');

-- ----------------------------
-- Table structure for sys_type
-- ----------------------------
DROP TABLE IF EXISTS `sys_type`;
CREATE TABLE `sys_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `t_name` varchar(50) DEFAULT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_type
-- ----------------------------
INSERT INTO `sys_type` VALUES ('1', '录入');
INSERT INTO `sys_type` VALUES ('2', '审核');
INSERT INTO `sys_type` VALUES ('3', '变更');
INSERT INTO `sys_type` VALUES ('4', '财务');
INSERT INTO `sys_type` VALUES ('5', '贷后管理');
INSERT INTO `sys_type` VALUES ('6', '催收');
INSERT INTO `sys_type` VALUES ('7', '结清');
INSERT INTO `sys_type` VALUES ('8', '管理员');

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `password` varchar(100) DEFAULT NULL COMMENT '密码',
  `salt` varchar(50) DEFAULT NULL COMMENT '盐',
  `type` int(11) DEFAULT NULL COMMENT '账户类型',
  `last_time` datetime DEFAULT NULL COMMENT '最近登录时间',
  `last_ip` varchar(50) DEFAULT NULL COMMENT '最近登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index_sys_user` (`id`),
  KEY `FK_Reference_3` (`type`),
  CONSTRAINT `FK_Reference_3` FOREIGN KEY (`type`) REFERENCES `sys_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_user
-- ----------------------------
INSERT INTO `sys_user` VALUES ('1', 'admin', 'm9TIMOkseU2VKgb9UBTcnhL6tqELPQq49QEfmQyKOYY=', 'gfqnphhwrlcsks4ooow0g0w48wgwgo8', '8', '2018-03-15 10:43:47', '127.0.0.1');
