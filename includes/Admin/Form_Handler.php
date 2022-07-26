<?php
namespace Saad_Contacts\Admin;

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler
{

    /**
     * Hook 'em all
     */
    public function __construct()
    {
        add_action('admin_init', array( $this, 'handle_form' ));
        add_action('admin_post_wp-delete-contact', [ $this, 'handle_delete' ]);
    }

    /**
     * Handle the contact new and edit form
     *
     * @return void
     */
    public function handle_form()
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

        $errors   = array();
        $page_url = admin_url('admin.php?page=contacts');
        $field_id = isset($_POST['field_id']) ? intval($_POST['field_id']) : 0;

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

        // New or edit?
        if (! $field_id) {
            $insert_id = wp_contacts_insert_contact($fields);
        } else {
            $fields['id'] = $field_id;

            $insert_id = wp_contacts_insert_contact($fields);
        }

        if (is_wp_error($insert_id)) {
            $redirect_to = add_query_arg(array( 'message' => 'error' ), $page_url);
        } else {
            $redirect_to = add_query_arg(array( 'message' => 'success' ), $page_url);
        }

        wp_safe_redirect($redirect_to);
        exit;
    }

    public function handle_delete()
    {
        if (! wp_verify_nonce($_REQUEST['_wpnonce'], 'wp-delete-contact')) {
            wp_die('Are you cheating?');
        }

        if (! current_user_can('manage_options')) {
            wp_die('Are you cheating?');
        }

        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        var_dump($id);
        if (wp_contacts_delete($id)) {
            $redirected_to = admin_url('admin.php?page=contacts&contact-deleted=true');
        } else {
            $redirected_to = admin_url('admin.php?page=contacts&contact-deleted=false');
        }

        wp_redirect($redirected_to);
        exit;
    }
}

new Form_Handler();
