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
-----------------
DELETE FROM `permissions` WHERE (`id`='17');

UPDATE `permissions` SET `name`='riders_document' WHERE (`id`='112');

UPDATE `permissions` SET `name`='bikes_status' WHERE (`id`='120');
UPDATE `permissions` SET `name`='sims_status' WHERE (`id`='136');
--------08-12-2023--------------

ALTER TABLE `payment_vouchers`
ADD COLUMN `voucher_type`  tinyint(2) NULL DEFAULT 5 AFTER `updated_at`;

ALTER TABLE `payment_vouchers`
ADD COLUMN `payment_reason`  varchar(100) NULL AFTER `voucher_type`;
------------------
ALTER TABLE `transactions`
MODIFY COLUMN `narration`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `rec_date`;
---------------------
ALTER TABLE `sims`
ADD COLUMN `sim_emi`  varchar(100) NULL AFTER `status`,
ADD COLUMN `sim_vendor`  bigint(20) NULL AFTER `sim_emi`;
--------------
ALTER TABLE `journal_vouchers`
MODIFY COLUMN `amount`  decimal(20,2) NULL AFTER `payment_type`;
ALTER TABLE `payment_vouchers`
MODIFY COLUMN `amount`  decimal(20,2) NULL AFTER `payment_type`;

ALTER TABLE `rider_invoices`
MODIFY COLUMN `total_amount`  double(20,2) NULL DEFAULT 0.00 AFTER `descriptions`;


ALTER TABLE `payment_vouchers`
ADD COLUMN `billing_month`  date NULL AFTER `payment_reason`;

ALTER TABLE `transactions`
ADD COLUMN `billing_month`  date NULL AFTER `updated_at`;

ALTER TABLE `journal_vouchers`
ADD COLUMN `billing_month`  date NULL AFTER `month`;

ALTER TABLE `rider_invoices`
ADD COLUMN `billing_month`  date NULL AFTER `updated_at`;

-----------------

ALTER TABLE `sim_charges`
ADD COLUMN `billing_month`  date NULL AFTER `updated_at`;

ALTER TABLE `riders`
ADD COLUMN `passport_handover`  varchar(50) NULL AFTER `fleet_supervisor`;


ALTER TABLE `vouchers`
ADD COLUMN `toll_gate`  varchar(50) NULL AFTER `Created_By`,
ADD COLUMN `trip_date`  datetime NULL AFTER `toll_gate`,
ADD COLUMN `direction`  varchar(255) NULL AFTER `trip_date`;

ALTER TABLE `vouchers`
ADD COLUMN `lease_company`  bigint(20) NULL AFTER `direction`;
---------------
ALTER TABLE `vouchers`
ADD COLUMN `Updated_By`  int(11) NULL AFTER `lease_company`;
-------------

ALTER TABLE `rider_invoices`
ADD COLUMN `gaurantee`  varchar(255) NULL AFTER `billing_month`;
------------

ALTER TABLE `vouchers`
ADD COLUMN `attach_file`  varchar(255) NULL AFTER `Updated_By`;
-----------------------------

ALTER TABLE `bike_histories`
ADD COLUMN `contract`  varchar(255) NULL AFTER `warehouse`;

--------------
ALTER TABLE `riders`
ADD COLUMN `noon_no`  varchar(100) NULL AFTER `passport_handover`,
ADD COLUMN `wps`  varchar(100) NULL AFTER `noon_no`,
ADD COLUMN `c3_card`  varchar(100) NULL AFTER `wps`;

ALTER TABLE `bikes`
ADD COLUMN `traffic_file_number`  varchar(100) NULL AFTER `warehouse`,
ADD COLUMN `emirates`  varchar(100) NULL AFTER `traffic_file_number`;



ALTER TABLE `bikes`
MODIFY COLUMN `company`  int(11) NOT NULL AFTER `engine`;








