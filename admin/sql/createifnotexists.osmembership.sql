CREATE TABLE IF NOT EXISTS `#__osmembership_categories` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NULL,
    `description` TEXT NULL,
    `published` TINYINT UNSIGNED NULL,
    PRIMARY KEY(`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_field_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_messages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message_key` VARCHAR(50) NULL,
  `message` TEXT NULL,
  PRIMARY KEY(`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_states` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL DEFAULT '1',
  `state_name` varchar(64) DEFAULT NULL,
  `state_3_code` char(10) DEFAULT NULL,
  `state_2_code` char(10) DEFAULT NULL,
  PRIMARY KEY (`state_id`),
  UNIQUE KEY `state_3_code` (`country_id`,`state_3_code`),
  UNIQUE KEY `state_2_code` (`country_id`,`state_2_code`),
  KEY `idx_country_id` (`country_id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_k2items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_type` varchar(50) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `sent_to` tinyint(4) NOT NULL DEFAULT '0',
  `email` varchar(100) DEFAULT '0',
  `subject` varchar(255) DEFAULT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `title` varchar(224) DEFAULT NULL,
  `attachment` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8`;
CREATE TABLE IF NOT EXISTS `#__osmembership_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `vies` tinyint(3) unsigned DEFAULT 0,
  `published` tinyint(3) unsigned DEFAULT 0,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_sefurls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md5_key` text,
  `query` text,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_urls` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `plan_id` INT NULL,
  `url` TEXT NULL,
  PRIMARY KEY(`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_schedulecontent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `number_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_schedule_k2items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `number_days` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `#__osmembership_coupon_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET `utf8`;