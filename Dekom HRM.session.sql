CREATE TABLE `purchase_invoices` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `invoice_id` bigint(20) unsigned NOT NULL,
    `issue_date` date NOT NULL,
    `due_date` date NOT NULL,
    `send_date` date DEFAULT NULL,
    `client` int(11) NOT NULL DEFAULT '0',
    `project` int(11) NOT NULL DEFAULT '0',
    `tax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `status` int(11) NOT NULL,
    `description` text COLLATE utf8mb4_unicode_ci,
    `created_by` int(11) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
);
CREATE TABLE `suppliers` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL DEFAULT '0',
    `client_id` int(11) NOT NULL DEFAULT '0',
    `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_by` int(11) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)