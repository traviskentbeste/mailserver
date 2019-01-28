CREATE TABLE `user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(128) COLLATE utf8_bin DEFAULT NULL,
`domain_id` int(11) DEFAULT '0',
`email` varchar(128) COLLATE utf8_bin DEFAULT NULL,
`password` varchar(128) COLLATE utf8_bin DEFAULT NULL,
`active` int(11) DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_bin;
