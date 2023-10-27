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

---------------------------------

ALTER TABLE `transactions`
MODIFY COLUMN `trans_date`  date NOT NULL AFTER `trans_acc_id`,
MODIFY COLUMN `posting_date`  date NULL AFTER `trans_date`;

ALTER TABLE `journal_vouchers`
MODIFY COLUMN `trans_date`  date NOT NULL AFTER `id`,
MODIFY COLUMN `posting_date`  date NULL  AFTER `trans_date`;

ALTER TABLE `transactions`
MODIFY COLUMN `trans_date`  date NOT NULL AFTER `trans_acc_id`,
MODIFY COLUMN `posting_date`  date NOT NULL AFTER `trans_date`;

ALTER TABLE `payment_vouchers`
MODIFY COLUMN `trans_date`  date NOT NULL AFTER `id`,
MODIFY COLUMN `posting_date`  date NULL AFTER `trans_date`;

--------------

ALTER TABLE `riders`
ADD COLUMN `TAID`  bigint(20) NULL AFTER `status`;
-----------------

ALTER TABLE `bike_histories`
ADD COLUMN `note_date`  datetime NULL AFTER `updated_at`;

ALTER TABLE `bike_histories`
MODIFY COLUMN `note_date`  date NULL DEFAULT NULL AFTER `updated_at`;
----------------------------------

ALTER TABLE `riders`
ADD COLUMN `fleet_supervisor`  varchar(50) NULL AFTER `TAID`;

ALTER TABLE `bikes`
ADD COLUMN `fleet_supervisor`  varchar(50) NULL AFTER `updated_at`;

ALTER TABLE `sims`
ADD COLUMN `fleet_supervisor`  varchar(50) NULL AFTER `updated_at`;

----------------------------------\

ALTER TABLE `bike_histories`
ADD COLUMN `warehouse`  varchar(50) NULL AFTER `note_date`;

ALTER TABLE `bike_histories`
MODIFY COLUMN `RID`  bigint(20) UNSIGNED NULL AFTER `BID`;

ALTER TABLE `bikes`
MODIFY COLUMN `RID`  bigint(20) UNSIGNED NULL AFTER `company`;

--------------

ALTER TABLE `bikes`
ADD COLUMN `warehouse`  varchar(50) NULL AFTER `fleet_supervisor`;

update `bikes` set `warehouse` = 'Active'

ALTER TABLE `sims`
ADD COLUMN `status`  varchar(50) NULL AFTER `fleet_supervisor`;

update `sims` set `status` = 'Active'






