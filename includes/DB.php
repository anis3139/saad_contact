<?php
namespace Saad_Contacts;

class DB
{
    /**
     * Get all contact
     *
     * @param $args array
     *
     * @return array
     */
    public static function get($table, $args = array())
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table;
        $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'DESC',
        );
 
        $args      = wp_parse_args($args, $defaults);
        
        $items = $wpdb->get_results('SELECT * FROM ' . $table_name .' ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number']);
        
        return $items;
    }


    /**
     * Fetch all contact from database
     *
     * @return array
     */
    public static function count($table)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table;
        return (int) $wpdb->get_var('SELECT COUNT(*) FROM ' . $table_name);
    }

    /**
     * Fetch a single contact from database
     *
     * @param int   $id
     *
     * @return array
     */
    public static function get_by_id($table, $id = 0)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table;
        return $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $table_name .' WHERE id = %d', $id));
    }

    /**
     * Insert a new contact
     *
     * @param array $args
     */
    public static function insert($table, $args = array())
    {
        global $wpdb;
 
        $table_name = $wpdb->prefix . $table;

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

    /**
     * Delete items
     *
     * @param [type] $table
     * @param [type] $id
     * @return void
     */
    public static function delete($table, $id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table;
        return $wpdb->delete(
            $table_name,
            [ 'id' => $id ],
            [ '%d' ]
        );
    }
}
