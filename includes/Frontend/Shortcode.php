<?php

namespace Saad_Contacts\Frontend;

use Saad_Contacts\Admin\Form_Handler;

/**
 * Shortcode handler class
 */
class Shortcode
{

    /**
     * Initializes the class
     */
    public function __construct()
    {
        add_shortcode('wp-contacts', [ $this, 'render_shortcode' ]);
        add_action('init', [$this, 'submit_contact']);
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode($atts, $content = '')
    {
        $content=include(dirname(__FILE__) . '/views/wp_contact_new.php');
        return  $content;
    }

    public function submit_contact()
    {
        if (! isset($_POST['wp_contact'])) {
            return;
        }

        if (! wp_verify_nonce($_POST['_wpnonce'], 'wp_contacts')) {
            die(__('Are you cheating?', 'wp_contacts'));
        }

        if (! current_user_can('read')) {
            wp_die(__('Permission Denied!', 'wp_contacts'));
        }

         
        $page_url = home_url('contacts');

        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
        $message = isset($_POST['message']) ? wp_kses_post($_POST['message']) : '';
        $created_by = isset($_POST['created_by']) ? intval($_POST['created_by']) : 0;

        // some basic validation
        if (! $name) {
            $errors[] = __('Error: Name is required', 'wp_contacts');
        }

        // bail out if error found
        if ($errors) {
            $first_error = reset($errors);
            $redirect_to = add_query_arg(array( 'error' => $first_error ), $page_url);
            wp_safe_redirect($redirect_to);
            exit;
        }

        $fields = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'created_by' => $created_by,
        );

 
        $insert_id = wp_contacts_insert_contact($fields);
        

        if (is_wp_error($insert_id)) {
            $redirect_to = add_query_arg(array( 'message' => 'error' ), $page_url);
        } else {
            $redirect_to = add_query_arg(array( 'message' => 'success' ), $page_url);
        }

        wp_safe_redirect($redirect_to);

        exit;
    }
}
