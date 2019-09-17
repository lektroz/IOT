ALTER TABLE `#__iot_io_list` ADD `max` VARCHAR(50) NOT NULL DEFAULT '' AFTER `io`;

ALTER TABLE `#__iot_io_list` ADD `min` VARCHAR(50) NOT NULL DEFAULT '' AFTER `max`;
