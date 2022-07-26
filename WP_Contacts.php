<?php
/**
 * Plugin Name: WP Contacts
 * Description: contact form
 * Plugin URI: https://github.com/anis3139
 * Author: Anichur Rahaman
 * Author URI: https://github.com/anis3139
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class WP_Contacts
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

        register_activation_hook(__FILE__, [ $this, 'activate' ]);

        add_action('plugins_loaded', [ $this, 'init_plugin' ]);
    }

    /**
     * Initializes a singleton instance
     *
     * @return \WeDevs_Academy
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
        define('WP_CONTACT_VERSION', self::version);
        define('WP_CONTACT_FILE', __FILE__);
        define('WP_CONTACT_PATH', __DIR__);
        define('WP_CONTACT_URL', plugins_url('', WP_CONTACT_FILE));
        define('WP_CONTACT_ASSETS', WP_CONTACT_URL . '/assets');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {
        if (is_admin()) {
            new WP_Contacts\Admin\Admin();
        } else {
            new WP_Contacts\Frontend\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new WP_Contacts\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 *
 * @return \WeDevs_Academy
 */
function wp_contacts()
{
    return WP_Contacts::init();
}

// kick-off the plugin
wp_contacts();
