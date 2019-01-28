CREATE TABLE `aliases` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`domainname_id` int(11) DEFAULT NULL,
`source` varchar(128) COLLATE utf8_bin DEFAULT NULL,
`destination` varchar(128) COLLATE utf8_bin DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_bin;
