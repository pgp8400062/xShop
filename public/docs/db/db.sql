CREATE TABLE `cart` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mall_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sku_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `order` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号',
  `subject` varchar(255) NOT NULL DEFAULT '' COMMENT '订单标题',
  `buyer_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '买家id',
  `mall_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品总价',
  `final_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单最终价格',
  `add_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '增加费用',
  `minus_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '减少的费用',
  `discount_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠价格',
  `postage_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费',
  `ship_address_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发货地址id',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `create_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '创建ip',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `order_history` (
  `history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` varchar(64) NOT NULL DEFAULT '' COMMENT '订单号',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `operator` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作者 0为系统',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '时间',
  PRIMARY KEY (`history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `order_status` (
  `order_status_id` tinyint(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(30) NOT NULL DEFAULT '' COMMENT '状态',
  `status_text` varchar(15) NOT NULL DEFAULT '' COMMENT '中文描述',
  PRIMARY KEY (`order_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `product` (
  `product_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `mall_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺id',
  `product_type` enum('VIRTUAL','ENTITY') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ENTITY' COMMENT '商品类型, VIRTUAL:虚拟物品,ENTITY:实物',
  `subject` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `intro` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '商品简介',
  `maket_price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '市场价',
  `sale_price` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '售价',
  `cover_image` text COLLATE utf8_unicode_ci NOT NULL COMMENT '主图',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `stock_enable` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用库存',
  `status` enum('ON','OFF') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ON' COMMENT '状态 ON:在售 OFF:下架',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `product_detail` (
  `product_id` int(11) unsigned NOT NULL COMMENT '商品id',
  `detail` mediumtext NOT NULL COMMENT '商品详情',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `product_sku` (
  `sku_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `sku_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'sku编码',
  `sale_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '售价',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`sku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `gender` enum('MALE','FEMALE','UNKNOWN') NOT NULL DEFAULT 'UNKNOWN' COMMENT '性别',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

CREATE TABLE `user_third_relation` (
  `relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `third_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '第三方ID',
  `via` tinyint(3) unsigned NOT NULL COMMENT '第三方渠道',
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户和第三方用户对应关系表';

CREATE TABLE `user_third_wechat` (
  `third_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(30) NOT NULL DEFAULT '' COMMENT 'app_id',
  `open_id` varchar(60) NOT NULL DEFAULT '' COMMENT 'open_id',
  `union_id` varchar(60) NOT NULL DEFAULT '' COMMENT 'union_id',
  `scope` varchar(30) NOT NULL DEFAULT '' COMMENT '作用域',
  `extra` text COMMENT '额外信息',
  `create_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  PRIMARY KEY (`third_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='第三方微信授权表';