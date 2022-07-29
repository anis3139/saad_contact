<?php
/**
 * Plugin Name: Saad Contacts
 * Description: Contact Management Plugin for WordPress
 * Plugin URI: https://github.com/anis3139
 * Author: Anichur Rahaman
 * Author URI: https://github.com/anis3139
 * Version: 1.1.1
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
    const version = '1.0';

    /**
     * Class construcotr
     */
    private function __construct()
    {
        $this->define_constants();
        $this->appsero_init_tracker_saad_contacts();

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
    public function appsero_init_tracker_saad_contacts()
    {
        if (! class_exists('Appsero\Client')) {
            require_once __DIR__ . '/appsero/src/Client.php';
        }

        $client = new Appsero\Client('370c673e-8695-4975-a5df-62ba84134b13', 'saad contacts', __FILE__);

        // Active insights
        $client->insights()->init();

        // Active automatic updater
        $client->updater();

        // Active license page and checker
        $args = array(
        'type'       => 'options',
        'menu_title' => 'saad contacts',
        'page_title' => 'saad contacts Settings',
        'menu_slug'  => 'saad_contacts_settings',
    );
        $client->license()->add_settings_page($args);
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
