ALTER TABLE `user` ADD `credentials` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `user` ADD `disclosures` TEXT NULL AFTER `credentials`;

ALTER TABLE `sessions` ADD `agenda` TEXT NULL AFTER `description`;

ALTER TABLE `user_project_access` CHANGE `level` `level` ENUM('attendee','moderator','presenter','admin','exhibitor') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `sponsor_booth_admin` DROP `project_id`;
ALTER TABLE `your_conference_live`.`sponsor_booth_admin` ADD UNIQUE `admin_per_booth` (`user_id`, `booth_id`);

ALTER TABLE `sessions` ADD `zoom_link` TEXT NULL DEFAULT NULL AFTER `presenter_embed_code`;

ALTER TABLE `sponsor_booth` ADD `created_on` DATETIME NULL AFTER `level`, ADD `created_by` INT NULL AFTER `created_on`, ADD `updated_on` DATETIME NULL AFTER `created_by`, ADD `updated_by` INT NULL AFTER `updated_on`;

