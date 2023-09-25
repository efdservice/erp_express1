ALTER TABLE `riders`
ADD COLUMN `VID`  int(11) NULL AFTER `updated_at`;

ALTER TABLE `riders`
ADD COLUMN `visa_sponsor`  varchar(100) NULL AFTER `VID`,
ADD COLUMN `visa_occupation`  varchar(100) NULL AFTER `visa_sponsor`;


ALTER TABLE `riders`
ADD COLUMN `status`  tinyint(2) NULL DEFAULT 1 AFTER `visa_occupation`;


ALTER TABLE `journal_vouchers`
MODIFY COLUMN `trans_date`  varchar(50) NOT NULL AFTER `id`,
MODIFY COLUMN `posting_date`  varchar(50) NULL DEFAULT '' AFTER `trans_date`;

ALTER TABLE `transactions`
MODIFY COLUMN `trans_date`  varchar(50) NOT NULL AFTER `trans_acc_id`,
MODIFY COLUMN `posting_date`  varchar(50) NOT NULL AFTER `trans_date`;

ALTER TABLE `payment_vouchers`
MODIFY COLUMN `trans_date`  varchar(50) NOT NULL AFTER `id`,
MODIFY COLUMN `posting_date`  varchar(50) NULL DEFAULT '' AFTER `trans_date`;

ALTER TABLE `receipt_vouchers`
MODIFY COLUMN `trans_date`  varchar(50) NOT NULL AFTER `id`,
MODIFY COLUMN `posting_date`  varchar(50) NULL DEFAULT '' AFTER `trans_date`;