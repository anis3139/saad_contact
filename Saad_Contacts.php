<?php
/**
 * Plugin Name: Saad Contacts
 * Description: Contact Management Plugin for WordPress
 * Plugin URI: https://github.com/anisAronno/saad_contacts
 * Author: Anichur Rahaman
 * Author URI: https://anichur.com
 * Version: 2.0.3
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

use Saad_Contacts\Admin\Admin;
use Saad_Contacts\API;
use Saad_Contacts\Frontend\Frontend;
use Saad_Contacts\Installer;

if (! defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Saad_Contacts
{
    /**
     * Plugin version
     *
     * @var string
     */
    public const version = '2.0.0';

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();
        $this->appsero_init_tracker_saad_contact_forms();

        register_activation_hook(__FILE__, [ $this, 'activate' ]);

        add_action('plugins_loaded', [ $this, 'init_plugin' ]);
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Saad_Contacts
     */
    public static function init()
    {
        static $instance = false;

        if (! $instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('SAAD_CONTACT_VERSION', self::version);
        define('SAAD_CONTACT_FILE', __FILE__);
        define('SAAD_CONTACT_PATH', __DIR__);
        define('SAAD_CONTACT_URL', plugins_url('', SAAD_CONTACT_FILE));
        define('SAAD_CONTACT_ASSETS', SAAD_CONTACT_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {
        if (is_admin()) {
            new Admin();
        } else {
            new Frontend();
        }
        new API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new Installer();
        $installer->run();
    }




    /**
     * Initialize the plugin tracker
     *
     * @return void
     */
    public function appsero_init_tracker_saad_contact_forms()
    {
        if (! class_exists('Appsero\Client')) {
            require_once __DIR__ . '/appsero/src/Client.php';
        }

        $client = new Appsero\Client('581ab831-05ab-4169-8988-00d8b2eabb82', 'Saad Contacts', __FILE__);

        // Active insights
        $client->insights()->init();

        // Active automatic updater
        $client->updater();
    }


}

/**
 * Initializes the main plugin
 *
 * @return \Saad_Contacts
 */
function saad_contacts()
{
    return Saad_Contacts::init();
}

// kick-off the plugin
saad_contacts();
