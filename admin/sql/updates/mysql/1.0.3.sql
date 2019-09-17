ALTER TABLE `#__iot_board` ADD `latitude` VARCHAR(50) NOT NULL DEFAULT 0 AFTER `description`;

ALTER TABLE `#__iot_board` ADD `longitude` VARCHAR(50) NOT NULL DEFAULT 0 AFTER `latitude`;

ALTER TABLE `#__iot_board` ADD `website` VARCHAR(100) NOT NULL DEFAULT '' AFTER `unique_code`;
