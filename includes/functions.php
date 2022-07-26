<?php

/**
 * Get all contact
 *
 * @param $args array
 *
 * @return array
 */
function get_all_saad_contact($args = array())
{
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'DESC',
    );

    $args      = wp_parse_args($args, $defaults);
    $cache_key = 'contact-all';
    $items     = wp_cache_get($cache_key, 'saad_contacts');

    if (false === $items) {
        $items = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'saad_contacts ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number']);

        wp_cache_set($cache_key, $items, 'saad_contacts');
    }

    return $items;
}

/**
 * Fetch all contact from database
 *
 * @return array
 */
function saad_contact_count()
{
    global $wpdb;

    return (int) $wpdb->get_var('SELECT COUNT(*) FROM ' . $wpdb->prefix . 'saad_contacts');
}

/**
 * Fetch a single contact from database
 *
 * @param int   $id
 *
 * @return array
 */
function get_saad_contact_by_id($id = 0)
{
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'saad_contacts WHERE id = %d', $id));
}

/**
 * Insert a new contact
 *
 * @param array $args
 */
function saad_contact_insert($args = array())
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
    $table_name = $wpdb->prefix . 'saad_contacts';

    // some basic validation
    if (empty($args['name'])) {
        return new WP_Error('no-name', __('No Name provided.', 'saad_contacts'));
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

function saad_contact_delete($id)
{
    global $wpdb;

    return $wpdb->delete(
        $wpdb->prefix . 'saad_contacts',
        [ 'id' => $id ],
        [ '%d' ]
    );
}
