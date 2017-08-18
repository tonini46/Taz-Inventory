ALTER TABLE `clients` ADD `bank` VARCHAR( 255 ) NULL AFTER `website` ;
ALTER TABLE `clients` ADD `bank_account` VARCHAR( 255 ) NULL AFTER `bank` ;

ALTER TABLE `user_settings` ADD `bank` VARCHAR( 255 ) NULL AFTER `website` ;
ALTER TABLE `user_settings` ADD `bank_account` VARCHAR( 255 ) NULL AFTER `bank` ;
ALTER TABLE `user_settings` ADD `description` TEXT NULL AFTER `bank_account` ;

ALTER TABLE `invoices` CHANGE `number` `number` INT( 11 ) UNSIGNED NOT NULL ;
ALTER TABLE `user_settings` ADD `language_id` INT( 11 ) UNSIGNED NULL AFTER `user_id` ;


CREATE TABLE IF NOT EXISTS `invoice_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `number` int(11) unsigned DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `languages` (`id`, `name`, `short`) VALUES (NULL, 'English', 'en');


CREATE TABLE IF NOT EXISTS `invoice_receiveds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `invitations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `client_id` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;