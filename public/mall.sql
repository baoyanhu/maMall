/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : 127.0.0.1:3306
 Source Schema         : mall

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 04/01/2021 12:32:36
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for mall_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_admin_user`;
CREATE TABLE `mall_admin_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '后端用户主键id',
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户名',
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户密码',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '用户状态 1正常 0删除',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建用户时间',
  `update_time` int(10) UNSIGNED NOT NULL COMMENT '更新用户时间',
  `last_login_time` int(10) UNSIGNED NOT NULL COMMENT '用户最后登陆时间',
  `last_login_ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户最后登录ip',
  `operate_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名索引'
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_admin_user
-- ----------------------------
INSERT INTO `mall_admin_user` VALUES (1, 'admin', '$2a$08$WWvKlMhXgkYwe1vdHCPGE.4DR76GQ8ny/Sj.BvWjCdAMJxCeuo9jC', 1, 1608728571, 1609729871, 1609729871, '127.0.0.1', 'admin');

-- ----------------------------
-- Table structure for mall_category
-- ----------------------------
DROP TABLE IF EXISTS `mall_category`;
CREATE TABLE `mall_category`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父类id',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '路径1,2,5',
  `create_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `operate_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `listorder` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_category
-- ----------------------------
INSERT INTO `mall_category` VALUES (19, '顶级分类1', 0, '', '', 1609648254, 1609648254, '', 1, 0);
INSERT INTO `mall_category` VALUES (20, '手机', 0, '', '', 1609651801, 1609651801, '', 1, 0);
INSERT INTO `mall_category` VALUES (21, '电脑', 0, '', '', 1609651920, 1609651920, '', 0, 0);
INSERT INTO `mall_category` VALUES (22, 'thinkpad', 21, '', '', 1609652054, 1609652054, '', 1, 0);
INSERT INTO `mall_category` VALUES (23, 'oneplus', 20, '', '', 1609652122, 1609652122, '', 1, 0);
INSERT INTO `mall_category` VALUES (24, '家具', 0, '', '', 1609652162, 1609652162, '', 1, 0);
INSERT INTO `mall_category` VALUES (33, 'oneplus7', 23, '', '', 1609652832, 1609652832, '', 1, 0);

-- ----------------------------
-- Table structure for mall_demo
-- ----------------------------
DROP TABLE IF EXISTS `mall_demo`;
CREATE TABLE `mall_demo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `create_time` datetime(0) NOT NULL,
  `update_time` datetime(0) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_demo
-- ----------------------------
INSERT INTO `mall_demo` VALUES (2, 'byh009', '与同仁堂', 2, '2020-12-22 15:34:58', '2020-12-24 15:35:00', 1);
INSERT INTO `mall_demo` VALUES (3, 'byh3', '发生的方式', 1, '2020-12-04 15:35:19', '2020-12-08 15:35:22', 0);
INSERT INTO `mall_demo` VALUES (4, 'byh4', '大萨达所多撒', 2, '2020-12-22 04:10:28', '2020-12-22 04:10:28', 1);
INSERT INTO `mall_demo` VALUES (5, 'byh4', '大萨达所多撒', 2, '2020-12-22 16:11:16', '2020-12-22 16:11:16', 1);

-- ----------------------------
-- Table structure for mall_user
-- ----------------------------
DROP TABLE IF EXISTS `mall_user`;
CREATE TABLE `mall_user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `ltype` tinyint(1) NOT NULL DEFAULT 0 COMMENT '登录方式 1手机号登录',
  `type` tinyint(1) NOT NULL DEFAULT 0 COMMENT '会话保存天数',
  `sex` tinyint(1) NOT NULL DEFAULT 0 COMMENT '性别',
  `create_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态 1正常 0删除',
  `operate_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '操作人',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE COMMENT '用户名索引',
  INDEX `number`(`phone_number`) USING BTREE COMMENT '手机号索引'
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mall_user
-- ----------------------------
INSERT INTO `mall_user` VALUES (2, 'byh2', '17647643764', '', 0, 2, 1, 1609126373, 1609647565, 1, '');
INSERT INTO `mall_user` VALUES (3, 'yunce-1764764376', '1764764376', '', 0, 2, 0, 1609646885, 1609646926, 1, '');
INSERT INTO `mall_user` VALUES (4, 'yunce-17647643761', '17647643761', '', 0, 2, 0, 1609646934, 1609646934, 1, '');
INSERT INTO `mall_user` VALUES (5, 'yunce-17647643761', '17647643761', '', 0, 2, 0, 1609646934, 1609646934, 1, '');

SET FOREIGN_KEY_CHECKS = 1;
