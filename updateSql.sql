CREATE TABLE `33hao_wifi_white_list` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gw_id` int(10) unsigned NOT NULL COMMENT '网关ID',
  `wl_name` varchar(32) NOT NULL DEFAULT '' COMMENT '白名单描述',
  `wl_mac` varchar(32) NOT NULL,
  `wl_addtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网关白名单';

CREATE TABLE `33hao_wifi_gw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL COMMENT '路由所属用户',
  `gw_name` varchar(32) NOT NULL COMMENT '名称',
  `gw_account` varchar(64) NOT NULL DEFAULT '' COMMENT '网关ID',
  `gw_mac` varchar(32) NOT NULL COMMENT '路由MAC地址',
  `gw_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '网关外网IP',
  `gw_sys_uptime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '系统时间',
  `gw_sys_load` float(5,2) NOT NULL DEFAULT '0.00' COMMENT 'CPU百分比',
  `gw_sys_memfree` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '剩余内存',
  `gw_client_count` int(11) NOT NULL DEFAULT '0' COMMENT '在线客户端数量',
  `gw_type` varchar(64) NOT NULL DEFAULT '' COMMENT '网关类型',
  `gw_sv` varchar(64) NOT NULL DEFAULT '' COMMENT '固件版本',
  `gw_addtime` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `gw_member_id` (`member_id`) USING BTREE,
  KEY `gw_mac` (`gw_mac`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网关路由表';

