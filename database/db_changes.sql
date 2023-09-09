ALTER TABLE `riders`
ADD COLUMN `VID`  int(11) NULL AFTER `updated_at`;

ALTER TABLE `riders`
ADD COLUMN `visa_sponsor`  varchar(100) NULL AFTER `VID`,
ADD COLUMN `visa_occupation`  varchar(100) NULL AFTER `visa_sponsor`;


ALTER TABLE `riders`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `visa_occupation`;