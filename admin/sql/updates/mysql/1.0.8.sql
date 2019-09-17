ALTER TABLE `#__iot_io_list` CHANGE `board_name` `board_name` INT(64) NOT NULL DEFAULT 0;

ALTER TABLE `#__iot_io_list` ADD `io` INT(1) NOT NULL DEFAULT 0 AFTER `gain`;
