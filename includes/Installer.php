<?php

namespace Saad_Contacts;

/**
 * Installer class
 */
class Installer
{

    /**
     * Run the installer
     *
     * @return void
     */
    public function run()
    {
        $this->add_version();
        $this->create_tables();
    }

    /**
     * Add time and version on DB
     */
    public function add_version()
    {
        $installed = get_option('saad_contacts_installed');

        if (! $installed) {
            update_option('saad_contacts_installed', time());
        }

        update_option('saad_contacts_version', SAAD_CONTACT_VERSION);
    }

    /**
     * Create necessary database tables
     *
     * @return void
     */
    public function create_tables()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}saad_contacts` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(100) NOT NULL DEFAULT '',
          `email` varchar(100) DEFAULT NULL,
          `phone` varchar(30) DEFAULT NULL,
          `subject` varchar(255) DEFAULT NULL,
          `message` longtext DEFAULT NULL,
          `created_by` bigint(20) unsigned NOT NULL,
          `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`id`)
        ) $charset_collate";

        if (! function_exists('dbDelta')) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }

        dbDelta($schema);
    }
}
