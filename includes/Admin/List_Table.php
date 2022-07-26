<?php
namespace WP_Contacts\Admin;

if (! class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class List_Table extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'contact',
            'plural'   => 'contacts',
            'ajax'     => false
        ));
    }

    public function get_table_classes()
    {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    public function no_items()
    {
        _e('no contact found', 'wp_contacts');
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'name':
                return $item->name;

            case 'email':
                return $item->email;

            case 'phone':
                return $item->phone;

            case 'subject':
                return $item->subject;

            case 'message':
                return $item->message;

            case 'created_by':
                return $item->created_by;

            case 'created_at':
                return $item->created_at;

            default:
                return isset($item->$column_name) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    public function get_columns()
    {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'name'      => __('Name ', 'wp_contacts'),
            'email'      => __('Email', 'wp_contacts'),
            'phone'      => __('Phone Number', 'wp_contacts'),
            'subject'      => __('Subject', 'wp_contacts'),
            'message'      => __('Message', 'wp_contacts'),
            'created_by'      => __('Created By', 'wp_contacts'),
            'created_at'      => __('Date', 'wp_contacts'),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_name($item)
    {
        $actions           = array();
        $actions['edit']   = sprintf('<a href="%s" data-id="%d" title="%s">%s</a>', admin_url('admin.php?page=contacts&action=edit&id=' . $item->id), $item->id, __('Edit this item', 'wp_contacts'), __('Edit', 'wp_contacts'));
        $actions['delete'] = sprintf(
            '<a href="%s" class="submitdelete" onclick="return confirm(\'Are you sure?\');" title="%s">%s</a>',
            wp_nonce_url(
                admin_url('admin-post.php?action=wp-delete-contact&id=' . $item->id),
                'wp-delete-contact'
            ),
            $item->id,
            __('Delete', 'wp_contacts'),
            __('Delete', 'wp_contacts')
        );
         

        return sprintf('<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url('admin.php?page=contacts&action=view&id=' . $item->id), $item->name, $this->row_actions($actions));
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array( 'name', true ),
        );

        return $sortable_columns;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item->id
        );
    }

    /**
     * Render the created by user column
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_created_by($item)
    {
        $user=get_user_by('id', $item->created_by);
        return $user->user_firstname .' '. $user->user_lastname;
    }

    /**
     * Render the created time
     *
     * @param  object  $item
     *
     * @return string
     */
    public function column_created_at($item)
    {
        $created_at= date('M d, Y H:i a', strtotime($item->created_at));
        return "<strong>{$created_at}</strong>";
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_()
    {
        $status_links   = array();
        $base_link      = admin_url('admin.php?page=sample-page');

        foreach ($this->counts as $key => $value) {
            $class = ($key == $this->page_status) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf('<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg(array( 'status' => $key ), $base_link), $class, $value['label'], $value['count']);
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    public function prepare_items()
    {
        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 10;
        $current_page          = $this->get_pagenum();
        $offset                = ($current_page -1) * $per_page;
        $this->page_status     = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if (isset($_REQUEST['orderby']) && isset($_REQUEST['order'])) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = wp_contacts_get_all_contact($args);

        $this->set_pagination_args(array(
            'total_items' => wp_contacts_get_contact_count(),
            'per_page'    => $per_page
        ));
    }


    /**
     * Set the bulk actions
     *
     * @return array
     */
    public function get_bulk_actions()
    {
        return array(
            'delete' => __('Delete', 'wp-contacts'),
        );
    }

    /**
     * Prepare bulk delete
     *
     * @return void
     */
    public function process_bulk_action()
    {
        if ('delete'===$this->current_action()) {
            foreach ($_GET['contact'] as $id) {
                $result=wp_contacts_delete($id);
            }
            if ($result) {
                $redirected_to = admin_url('admin.php?page=contacts&contact-deleted=true');
            } else {
                $redirected_to = admin_url('admin.php?page=contacts&contact-deleted=false');
            }
            wp_redirect($redirected_to);
            exit;
        }
    }
}
