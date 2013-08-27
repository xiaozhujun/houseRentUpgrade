/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50533
Source Host           : localhost:3306
Source Database       : house_rent

Target Server Type    : MYSQL
Target Server Version : 50533
File Encoding         : 65001

Date: 2013-08-27 15:00:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceid` varchar(100) NOT NULL DEFAULT '',
  `provincename` varchar(255) NOT NULL DEFAULT '',
  `cityid` varchar(100) NOT NULL DEFAULT '',
  `cityname` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_city_cityid` (`cityid`),
  KEY `idx_city_pidctid` (`provinceid`,`cityid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('1', '1', '北京', '1', '北京');

-- ----------------------------
-- Table structure for college
-- ----------------------------
DROP TABLE IF EXISTS `college`;
CREATE TABLE `college` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of college
-- ----------------------------

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------

-- ----------------------------
-- Table structure for friend
-- ----------------------------
DROP TABLE IF EXISTS `friend`;
CREATE TABLE `friend` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fromUser` bigint(20) DEFAULT NULL,
  `toUser` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend
-- ----------------------------

-- ----------------------------
-- Table structure for friend_apply
-- ----------------------------
DROP TABLE IF EXISTS `friend_apply`;
CREATE TABLE `friend_apply` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fromUser` bigint(20) DEFAULT NULL,
  `toUser` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `updateTime` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `authInfo` varchar(255) DEFAULT NULL,
  `replyInfo` varchar(255) DEFAULT NULL,
  `fromRealName` varchar(255) DEFAULT NULL,
  `toRealName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of friend_apply
-- ----------------------------

-- ----------------------------
-- Table structure for house_info
-- ----------------------------
DROP TABLE IF EXISTS `house_info`;
CREATE TABLE `house_info` (
  `houseId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL COMMENT '用户id',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `purpose` int(4) NOT NULL DEFAULT '1' COMMENT 'rent_in:1;rent_out:2',
  `rentType` int(4) NOT NULL DEFAULT '0' COMMENT '111:一室一厅一卫；311:三室一厅一卫...',
  `price` int(4) NOT NULL DEFAULT '0',
  `area` int(4) NOT NULL DEFAULT '0' COMMENT '面积',
  `remark` varchar(1024) NOT NULL DEFAULT '' COMMENT '用户备注描述',
  `detailDescription` text NOT NULL COMMENT '详细描述，类似与物品详情页',
  `region` int(4) NOT NULL DEFAULT '1' COMMENT '用户大地址，到城市下面的区',
  `contactPerson` varchar(256) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `contactPhone` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人电话',
  `contactQQ` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人qq',
  `contactWeixin` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人weixin',
  `contactEmail` varchar(50) NOT NULL DEFAULT '' COMMENT '联系人email',
  `decoration` varchar(512) NOT NULL DEFAULT '' COMMENT '装修情况',
  `furniture` varchar(512) NOT NULL DEFAULT '' COMMENT '家具，家电配置情况',
  `request` varchar(512) NOT NULL DEFAULT '' COMMENT '对对方的要求',
  `createTime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `attentionCount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注数量',
  `room` int(11) DEFAULT NULL,
  `parlor` int(11) DEFAULT NULL,
  `washroom` int(11) DEFAULT NULL,
  `maxFloor` int(11) DEFAULT NULL,
  `currentFloor` int(11) DEFAULT NULL,
  `viewCount` bigint(20) DEFAULT NULL,
  `applyCount` bigint(20) DEFAULT NULL,
  `transferTime` datetime DEFAULT NULL,
  `community` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`houseId`),
  KEY `idx_house` (`houseId`),
  KEY `idx_inputtime` (`createTime`),
  KEY `idx_house_userid` (`houseId`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of house_info
-- ----------------------------
INSERT INTO `house_info` VALUES ('1', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '3', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376716137', '0', '3', '1', '1', '25', '22', '0', null, '2013-08-31 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('2', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '1', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376716199', '0', '3', '1', '1', '25', '22', '0', null, '2013-08-31 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('3', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '1', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376716724', '0', '3', '1', '1', '25', '22', '0', null, '0000-00-00 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('4', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '2', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376716792', '0', '3', '1', '1', '25', '22', '0', null, '0000-00-00 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('5', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '3', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376716910', '0', '3', '1', '1', '25', '22', '0', null, '0000-00-00 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('6', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '4', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376717358', '0', '3', '1', '1', '25', '22', '0', null, '0000-00-00 00:00:00', '智学苑', '西二旗');
INSERT INTO `house_info` VALUES ('7', '56', '西二旗智学苑3居室', '1', '0', '5000', '120', '无', '请填写房源描述！', '1', '肖竹军', '18211177261', '346012526', '346012526', '346012526@qq.com', '好', '齐全', '无', '1376717402', '0', '3', '1', '1', '25', '22', '0', null, '0000-00-00 00:00:00', '智学苑', '西二旗');

-- ----------------------------
-- Table structure for house_photo
-- ----------------------------
DROP TABLE IF EXISTS `house_photo`;
CREATE TABLE `house_photo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `photoURL` varchar(255) DEFAULT NULL,
  `houseId` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of house_photo
-- ----------------------------
INSERT INTO `house_photo` VALUES ('1', null, '/Public/upload/1376714959.jpg', null, null);
INSERT INTO `house_photo` VALUES ('2', null, '/Public/upload/1376714980.jpg', null, null);
INSERT INTO `house_photo` VALUES ('3', '56', '/Public/upload/1376715044.jpg', null, null);
INSERT INTO `house_photo` VALUES ('4', '56', '/Public/upload/1376716361.jpg', null, null);
INSERT INTO `house_photo` VALUES ('5', '56', '/Public/upload/1376716370.jpg', null, null);
INSERT INTO `house_photo` VALUES ('6', '56', '/Public/upload/1376716651.jpg', '5', null);
INSERT INTO `house_photo` VALUES ('7', '56', '/Public/upload/1376716658.jpg', '5', null);
INSERT INTO `house_photo` VALUES ('8', '56', '/Public/upload/1376717333.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('9', '56', '/Public/upload/1376717340.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('10', '56', '/Public/upload/1376717344.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('11', '56', '/Public/upload/1376717386.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('12', '56', '/Public/upload/1376717389.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('13', '56', '/Public/upload/1376717391.jpg', '7', null);
INSERT INTO `house_photo` VALUES ('14', '56', '/Public/upload/1377445200.png', null, null);
INSERT INTO `house_photo` VALUES ('15', '56', '/Public/upload/1377445207.png', null, null);

-- ----------------------------
-- Table structure for province
-- ----------------------------
DROP TABLE IF EXISTS `province`;
CREATE TABLE `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceid` varchar(100) NOT NULL DEFAULT '',
  `provincename` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_province_provinceid` (`provinceid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of province
-- ----------------------------
INSERT INTO `province` VALUES ('1', '1', '北京');

-- ----------------------------
-- Table structure for region
-- ----------------------------
DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provinceid` varchar(100) NOT NULL DEFAULT '',
  `provincename` varchar(255) NOT NULL DEFAULT '',
  `cityid` varchar(100) NOT NULL DEFAULT '',
  `cityname` varchar(255) NOT NULL DEFAULT '',
  `areaid` varchar(100) NOT NULL DEFAULT '',
  `areaname` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_city_cityid` (`cityid`),
  KEY `idx_city_pidctid` (`provinceid`,`cityid`),
  KEY `idx_city_areaid` (`provinceid`,`cityid`,`areaid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of region
-- ----------------------------
INSERT INTO `region` VALUES ('1', '1', '北京', '1', '北京', '1', '东城');
INSERT INTO `region` VALUES ('2', '1', '北京', '1', '北京', '2', '西城');
INSERT INTO `region` VALUES ('3', '1', '北京', '1', '北京', '3', '崇文');
INSERT INTO `region` VALUES ('4', '1', '北京', '1', '北京', '4', '宣武');
INSERT INTO `region` VALUES ('5', '1', '北京', '1', '北京', '5', '朝阳');
INSERT INTO `region` VALUES ('6', '1', '北京', '1', '北京', '6', '丰台');
INSERT INTO `region` VALUES ('7', '1', '北京', '1', '北京', '7', '石景山');
INSERT INTO `region` VALUES ('8', '1', '北京', '1', '北京', '8', '海淀');
INSERT INTO `region` VALUES ('9', '1', '北京', '1', '北京', '9', '门头沟');
INSERT INTO `region` VALUES ('10', '1', '北京', '1', '北京', '10', '房山');
INSERT INTO `region` VALUES ('11', '1', '北京', '1', '北京', '11', '通州');
INSERT INTO `region` VALUES ('12', '1', '北京', '1', '北京', '12', '顺义');
INSERT INTO `region` VALUES ('13', '1', '北京', '1', '北京', '13', '昌平');
INSERT INTO `region` VALUES ('14', '1', '北京', '1', '北京', '14', '大兴');
INSERT INTO `region` VALUES ('15', '1', '北京', '1', '北京', '15', '平谷');
INSERT INTO `region` VALUES ('16', '1', '北京', '1', '北京', '16', '怀柔');
INSERT INTO `region` VALUES ('17', '1', '北京', '1', '北京', '17', '密云');
INSERT INTO `region` VALUES ('18', '1', '北京', '1', '北京', '18', '延庆');

-- ----------------------------
-- Table structure for target_house
-- ----------------------------
DROP TABLE IF EXISTS `target_house`;
CREATE TABLE `target_house` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of target_house
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activateCode` varchar(255) DEFAULT NULL,
  `codeEffectTime` datetime DEFAULT NULL,
  `activeTime` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0' COMMENT '用户默认状态为0，激活状态为1',
  `createTime` datetime DEFAULT NULL,
  `invitor` bigint(20) DEFAULT NULL,
  `realName` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `identifyNum` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('56', 'xiaozhujun', 'e10adc3949ba59abbe56e057f20f883e', '346012526@qq.com', null, null, '2013-05-13 09:02:58', '1', '2013-05-13 01:45:44', null, '肖竹军', '18211177261', null);

-- ----------------------------
-- Table structure for user_college
-- ----------------------------
DROP TABLE IF EXISTS `user_college`;
CREATE TABLE `user_college` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `collegeId` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_college
-- ----------------------------

-- ----------------------------
-- Table structure for user_company
-- ----------------------------
DROP TABLE IF EXISTS `user_company`;
CREATE TABLE `user_company` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `companyId` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_company
-- ----------------------------

-- ----------------------------
-- Table structure for user_invitation_code
-- ----------------------------
DROP TABLE IF EXISTS `user_invitation_code`;
CREATE TABLE `user_invitation_code` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `invitationCode` varchar(255) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  `codeEffectTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_invitation_code
-- ----------------------------
INSERT INTO `user_invitation_code` VALUES ('1', '56', 'a75ad313aa9fe8754974a8ddceb7a9d8', '2013-05-14 11:15:34', '2013-05-17 11:15:34');
INSERT INTO `user_invitation_code` VALUES ('2', null, 'f9a5095311a518c88ae14a1c394a828e', '2013-05-14 11:17:20', '2013-05-17 11:17:20');
INSERT INTO `user_invitation_code` VALUES ('3', null, '2ea76b5b73c50642099b594c6d0d83aa', '2013-05-14 11:19:19', '2013-05-17 11:19:19');
INSERT INTO `user_invitation_code` VALUES ('4', null, 'ddba00b6255a95ece07fd7e0261de792', '2013-05-14 11:21:50', '2013-05-17 11:21:50');
INSERT INTO `user_invitation_code` VALUES ('5', '56', '559f5db94baa13b51ef8a623c72065ad', '2013-05-14 11:23:13', '2013-05-17 11:23:13');
INSERT INTO `user_invitation_code` VALUES ('6', '56', '235cc069f144a37fda0d4333f7277793', '2013-05-19 16:41:56', '2013-05-22 16:41:56');

-- ----------------------------
-- Table structure for user_target_house
-- ----------------------------
DROP TABLE IF EXISTS `user_target_house`;
CREATE TABLE `user_target_house` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `targetHouseId` bigint(20) DEFAULT NULL,
  `createTime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_target_house
-- ----------------------------
