CREATE TABLE IF NOT EXISTS `#__com_iot_data` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`name` VARCHAR(64) NOT NULL DEFAULT '',
	`params` text NOT NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`),
	KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

ALTER TABLE `#__com_iot_engineering_unit` CHANGE `mytextvalue` `eng_unit` VARCHAR(50) NOT NULL DEFAULT '';

ALTER TABLE `#__com_iot_engineering_unit` ADD `symbol` VARCHAR(50) NOT NULL DEFAULT '' AFTER `name`;

ALTER TABLE `#__com_iot_io_list` CHANGE `mytextvalue` `board_name` VARCHAR(64) NOT NULL DEFAULT '';

CREATE TABLE IF NOT EXISTS `#__com_iot_io_list` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
	`alias` CHAR(64) NOT NULL DEFAULT '',
	`board_name` VARCHAR(64) NOT NULL DEFAULT '',
	`datatype` TINYINT(1) NOT NULL DEFAULT 0,
	`description` TEXT NOT NULL,
	`engineering_unit` INT(11) NULL DEFAULT 0,
	`gain` FLOAT(7) NOT NULL DEFAULT 0,
	`name` VARCHAR(64) NOT NULL DEFAULT '',
	`offset` FLOAT(7) NOT NULL DEFAULT 0,
	`pointone` FLOAT(7) NOT NULL DEFAULT 0,
	`pointtwo` FLOAT(7) NOT NULL DEFAULT 0,
	`scaling` INT(1) NOT NULL DEFAULT 0,
	`params` text NOT NULL,
	`published` TINYINT(3) NOT NULL DEFAULT 1,
	`created_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,
	`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`checked_out` int(11) unsigned NOT NULL DEFAULT 0,
	`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`version` INT(10) unsigned NOT NULL DEFAULT 1,
	`hits` INT(10) unsigned NOT NULL DEFAULT 0,
	`access` INT(10) unsigned NOT NULL DEFAULT 0,
	`ordering` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY  (`id`),
	KEY `idx_access` (`access`),
	KEY `idx_checkout` (`checked_out`),
	KEY `idx_createdby` (`created_by`),
	KEY `idx_modifiedby` (`modified_by`),
	KEY `idx_state` (`published`),
	KEY `idx_pointone` (`pointone`),
	KEY `idx_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

ALTER TABLE `#__com_iot_board` CHANGE `mytextvalue` `board_name` VARCHAR(64) NOT NULL DEFAULT '';

ALTER TABLE `#__com_iot_board` CHANGE `mytextvalue` `mac_address` VARCHAR(100) NULL DEFAULT '';

ALTER TABLE `#__com_iot_board` CHANGE `mytextvalue` `unique_code` VARCHAR(255) NOT NULL DEFAULT '';
