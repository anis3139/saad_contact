<?php

/**
 * Get all contact
 *
 * @param $args array
 *
 * @return array
 */
function wp_contacts_get_all_contact($args = array())
{
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args($args, $defaults);
    $cache_key = 'contact-all';
    $items     = wp_cache_get($cache_key, 'wp_contacts');

    if (false === $items) {
        $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'contacts ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number']);

        wp_cache_set($cache_key, $items, 'wp_contacts');
    }

    return $items;
}

/**
 * Fetch all contact from database
 *
 * @return array
 */
function wp_contacts_get_contact_count()
{
    global $wpdb;

    return (int) $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'contacts');
}

/**
 * Fetch a single contact from database
 *
 * @param int   $id
 *
 * @return array
 */
function wp_contacts_get_contact($id = 0)
{
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'contacts WHERE id = %d', $id));
}

/**
 * Insert a new contact
 *
 * @param array $args
 */
function wp_contacts_insert_contact($args = array())
{
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'name' => '',
        'email' => '',
        'phone' => '',
        'subject' => '',
        'message' => '',
        'created_by' => '',

    );

    $args       = wp_parse_args($args, $defaults);
    $table_name = $wpdb->prefix . 'contacts';

    // some basic validation
    if (empty($args['name'])) {
        return new WP_Error('no-name', __('No Name provided.', 'wp_contacts'));
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset($args['id']);

    if (! $row_id) {

        

        // insert a new
        if ($wpdb->insert($table_name, $args)) {
            return $wpdb->insert_id;
        }
    } else {

        // do update method here
        if ($wpdb->update($table_name, $args, array( 'id' => $row_id ))) {
            return $row_id;
        }
    }

    return false;
}

function wp_contacts_delete($id)
{
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'contacts',
        [ 'id' => $id ],
        [ '%d' ]
    );
}
