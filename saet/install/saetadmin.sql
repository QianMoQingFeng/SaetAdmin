/*
 Navicat Premium Data Transfer

 Source Server         : saetadmin
 Source Server Type    : MySQL
 Source Server Version : 80024
 Source Host           : 192.168.1.13:3306
 Source Schema         : saetadmin

 Target Server Type    : MySQL
 Target Server Version : 80024
 File Encoding         : 65001

 Date: 29/11/2022 16:01:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for st_admin
-- ----------------------------
DROP TABLE IF EXISTS `st_admin`;
CREATE TABLE `st_admin` (
  `aid` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分组ID',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '头像',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码',
  `salt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '密码盐',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机',
  `create_time` datetime DEFAULT NULL COMMENT '加入时间',
  `online_time` datetime DEFAULT NULL COMMENT '在线时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`aid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员列表';

-- ----------------------------
-- Records of st_admin
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for st_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `st_admin_group`;
CREATE TABLE `st_admin_group` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int NOT NULL DEFAULT '0' COMMENT '上级ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `rule_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '规则',
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '徽章',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` enum('normal','disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员分组';

-- ----------------------------
-- Records of st_admin_group
-- ----------------------------
BEGIN;
INSERT INTO `st_admin_group` (`id`, `pid`, `name`, `rule_ids`, `badge`, `create_time`, `update_time`, `status`) VALUES (1, 0, '超级管理员', '*', '', '2020-01-01 08:00:00', '2022-08-06 14:48:44', 'normal');
INSERT INTO `st_admin_group` (`id`, `pid`, `name`, `rule_ids`, `badge`, `create_time`, `update_time`, `status`) VALUES (2, 0, '技术组', '1,2,3,4', '', '2020-01-01 08:00:00', '2022-10-12 16:56:04', 'normal');
COMMIT;

-- ----------------------------
-- Table structure for st_admin_rule
-- ----------------------------
DROP TABLE IF EXISTS `st_admin_rule`;
CREATE TABLE `st_admin_rule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pid` int NOT NULL DEFAULT '0' COMMENT '上级',
  `addons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'system' COMMENT '来源插件',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则路径',
  `param` json DEFAULT NULL COMMENT '参数',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '描述',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `is_menu` int DEFAULT '0' COMMENT '是否菜单导航',
  `menu_type` enum('tab','window') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tab' COMMENT '菜单导航类型',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `weigh` int NOT NULL DEFAULT '0' COMMENT '权重',
  `status` enum('normal','disabled','skip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员规则';

-- ----------------------------
-- Records of st_admin_rule
-- ----------------------------
BEGIN;
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (1, 0, 'system', 'home/dashboard', NULL, '控制台', NULL, 'ri-group-line', 1, 'tab', NULL, '2022-09-21 16:46:26', 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (2, 0, 'system', 'config/index', NULL, '系统设置', NULL, 'ri-settings-2-fill', 0, 'tab', NULL, NULL, 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (3, 0, 'system', 'admin', NULL, '后台权限', NULL, 'ri-admin-fill', 1, 'tab', NULL, '2022-09-19 13:19:25', 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (4, 3, 'system', 'admin.admin/index', NULL, '管理员', NULL, 'ri-user-3-line', 1, 'tab', NULL, NULL, 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (5, 3, 'system', 'admin.group/index', NULL, '角色组', NULL, 'ri-group-line', 1, 'tab', NULL, NULL, 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (6, 3, 'system', 'admin.rule/index', NULL, '权限规则', NULL, 'ri-list-settings-fill', 1, 'tab', NULL, NULL, 0, 'normal');
INSERT INTO `st_admin_rule` (`id`, `pid`, `addons`, `url`, `param`, `title`, `desc`, `icon`, `is_menu`, `menu_type`, `create_time`, `update_time`, `weigh`, `status`) VALUES (7, 3, 'system', 'admin.token/index', NULL, 'Token密钥', NULL, 'ri-key-2-fill', 1, 'tab', NULL, NULL, 0, 'normal');
COMMIT;

-- ----------------------------
-- Table structure for st_admin_token
-- ----------------------------
DROP TABLE IF EXISTS `st_admin_token`;
CREATE TABLE `st_admin_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aid` int DEFAULT NULL COMMENT '管理员ID',
  `token` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Token',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '创建时间',
  `active_time` datetime DEFAULT NULL COMMENT '有效时间',
  `expire_time` datetime DEFAULT NULL COMMENT '过期时间',
  `expire_second` int DEFAULT NULL COMMENT '过期秒数',
  `is_temporary` int DEFAULT '1' COMMENT '是否临时',
  `app` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'free' COMMENT '执行应用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of st_admin_token
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for st_config
-- ----------------------------
DROP TABLE IF EXISTS `st_config`;
CREATE TABLE `st_config` (
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '分组',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '标题',
  `value` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '值',
  `option` varchar(5000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `type` enum('json','text','long-text','rich-text','image','array','select','radio','selects') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '类型',
  `weight` int DEFAULT NULL COMMENT '权重',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of st_config
-- ----------------------------
BEGIN;
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('ban_ip', 'system', '禁止IP', '[\"\"]', NULL, 'array', 10, NULL, '2022-11-04 20:07:06');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('beian', 'system', '备案号', '阿水大大', NULL, 'text', 15, '2022-10-28 20:56:16', '2022-10-28 20:56:16');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('color', 'admin_theme', '强调色', 'purple', '{\"purple\":\"紫色\",\"blue\":\"蓝色\",\"pink\":\"粉色\",\"error\":\"红色\",\"orange\":\"橙色\",\"yellow\":\"黄色\",\"green\":\"绿色\",\"invert\":\"简洁素雅\"}', 'select', 85, '2022-10-30 13:52:44', '2022-10-30 14:19:24');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('group', 'dict', '分组', '{\"system\":\"系统设置\",\"dict\":\"字典\",\"admin_theme\":\"后台主题\"}', NULL, 'json', 6, NULL, '2022-11-12 19:57:08');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('language', 'system', '语言', '{\"en\":\"英文\",\"cn\":\"中文\"}', NULL, 'json', 155, '2022-10-28 21:01:28', '2022-11-04 20:07:06');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('menu', 'admin_theme', '主菜单默认配置', '{\"collapse\":false,\"minimize\":false,\"menu_float\":false,\"minisize_auto\":true}', NULL, 'json', 125, '2022-10-30 14:46:43', '2022-11-05 16:21:15');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('menu_type', 'admin_theme', '菜单模式', 'main', '{\"main\":\"仅主菜单\",\"main-sub\":\"主副菜单模式\"}', 'radio', 115, '2022-10-30 14:41:44', '2022-10-31 20:14:09');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('side_type', 'admin_theme', '边栏布局', 'float', '{\"float\":\"悬浮\",\"fixed\":\"吸附\"}', 'radio', 95, '2022-10-30 14:33:43', '2022-10-31 20:08:48');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('site_desc', 'system', '站点介绍', 'SaetAdmin后台快速开发框架', NULL, 'long-text', 2, NULL, '2022-10-28 21:32:12');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('site_ico', 'system', '站点ICO', NULL, NULL, 'image', 4, NULL, '2022-10-27 14:22:36');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('site_logo', 'system', '站点LOGO', '/storage/2022/10/27/71da01da45be275fbc90b012d03ea122.png', NULL, 'image', 3, NULL, '2022-10-27 14:51:37');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('site_name', 'system', '站点名称', 'SaetAdmin后台快速开发框架', NULL, 'text', 1, NULL, '2022-10-28 20:50:40');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('submenu', 'admin_theme', '副菜单默认配置', '{\"collapse\":false}', NULL, 'json', 135, '2022-10-30 14:47:27', '2022-10-31 21:31:22');
INSERT INTO `st_config` (`name`, `group`, `title`, `value`, `option`, `type`, `weight`, `create_time`, `update_time`) VALUES ('theme', 'admin_theme', '主题色调', 'system', '{\"system\":\"跟随系统\",\"light\":\"浅色\",\"dark\":\"深色\"}', 'radio', 75, '2022-10-30 14:18:58', '2022-10-31 21:32:51');
COMMIT;

-- ----------------------------
-- Table structure for st_user
-- ----------------------------
DROP TABLE IF EXISTS `st_user`;
CREATE TABLE `st_user` (
  `uid` int NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `group_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '管理权限',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '用户名',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '头像',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码',
  `salt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '密码盐',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '手机',
  `create_time` datetime DEFAULT NULL COMMENT '加入时间',
  `online_time` datetime DEFAULT NULL COMMENT '在线时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户列表';

-- ----------------------------
-- Records of st_user
-- ----------------------------
BEGIN;
INSERT INTO `st_user` (`uid`, `group_ids`, `username`, `nickname`, `avatar`, `password`, `salt`, `email`, `mobile`, `create_time`, `online_time`, `update_time`) VALUES (1, '1', 'tes1t', 'testnick', NULL, '9e7e33692a935cfc6ba64acdfaf87646245cca6c', 'C5X8F4VZ', 'email@saet.i1o', '13888888888', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for st_user_group
-- ----------------------------
DROP TABLE IF EXISTS `st_user_group`;
CREATE TABLE `st_user_group` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int NOT NULL DEFAULT '0' COMMENT '上级ID',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '名称',
  `rule_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '规则',
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '徽章',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` enum('normal','disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员分组';

-- ----------------------------
-- Records of st_user_group
-- ----------------------------
BEGIN;
INSERT INTO `st_user_group` (`id`, `pid`, `name`, `rule_ids`, `badge`, `create_time`, `update_time`, `status`) VALUES (1, 0, '超级管理员', '*', '', '2020-01-01 08:00:00', '2022-08-06 14:48:44', 'normal');
INSERT INTO `st_user_group` (`id`, `pid`, `name`, `rule_ids`, `badge`, `create_time`, `update_time`, `status`) VALUES (2, 0, '技术组', '1,2,3,4', '', '2020-01-01 08:00:00', '2022-10-12 16:56:04', 'normal');
COMMIT;

-- ----------------------------
-- Table structure for st_user_rule
-- ----------------------------
DROP TABLE IF EXISTS `st_user_rule`;
CREATE TABLE `st_user_rule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pid` int NOT NULL DEFAULT '0' COMMENT '上级',
  `addons` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'system' COMMENT '来源插件',
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '规则路径',
  `param` json DEFAULT NULL COMMENT '参数',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '标题',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '描述',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '图标',
  `is_menu` int DEFAULT '0' COMMENT '是否菜单导航',
  `menu_type` enum('tab','window') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tab' COMMENT '菜单导航类型',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `weigh` int NOT NULL DEFAULT '0' COMMENT '权重',
  `status` enum('normal','disabled','skip') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='管理员规则';

-- ----------------------------
-- Records of st_user_rule
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for st_user_token
-- ----------------------------
DROP TABLE IF EXISTS `st_user_token`;
CREATE TABLE `st_user_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Token',
  `uid` int DEFAULT NULL COMMENT '管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '创建时间',
  `active_time` datetime DEFAULT NULL COMMENT '有效时间',
  `expire_time` datetime DEFAULT NULL COMMENT '过期时间',
  `expire_second` int DEFAULT NULL COMMENT '过期秒数',
  `is_temporary` int DEFAULT '1' COMMENT '是否临时',
  `app` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'free' COMMENT '执行应用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='用户Token';

-- ----------------------------
-- Records of st_user_token
-- ----------------------------
BEGIN;
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
