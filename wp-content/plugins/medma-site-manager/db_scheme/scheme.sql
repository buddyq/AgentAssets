
CREATE TABLE `aa_medma_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `primaryadmin_id` bigint(20) unsigned NOT NULL,
  `code` char(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aa_medma_group_user` (
  `group_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  UNIQUE KEY (`group_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aa_medma_theme` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `theme_system_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `aa_medma_group_theme` (
  `group_id` bigint(20) unsigned NOT NULL,
  `theme_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY (`group_id`, `theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
