ALTER TABLE `user` ADD `credentials` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `user` ADD `disclosures` TEXT NULL AFTER `credentials`;
