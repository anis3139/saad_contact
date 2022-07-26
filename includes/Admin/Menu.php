<?php
namespace Saad_Contacts\Admin;

/**
 * Admin Menu
 */
class Menu
{

    /**
     * Kick-in the class
     */
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'admin_menu' ));
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu()
    {

        /** Top Menu **/
        add_menu_page(__('Contacts', 'wp_contacts'), __('Contacts', 'wp_contacts'), 'manage_options', 'contacts', array( $this, 'plugin_page' ), 'dashicons-email-alt2', 15, null);

        add_submenu_page('contacts', __('Contacts', 'wp_contacts'), __('Contacts', 'wp_contacts'), 'manage_options', 'contacts', array( $this, 'plugin_page' ));
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : 'list';
        $id     = isset($_GET['id']) ? intval($_GET['id']) : 0;
        switch ($action) {
            case 'view':

                $template = dirname(__FILE__) . '/views/wp_contact-single.php';
                break;

            case 'edit':
                $template = dirname(__FILE__) . '/views/wp_contact-edit.php';
                break;

            case 'new':
                $template = dirname(__FILE__) . '/views/wp_contact-new.php';
                break;

            default:
                $template = dirname(__FILE__) . '/views/wp_contact-list.php';
                break;
        }

        if (file_exists($template)) {
            include $template;
        }
    }
}
