<?php
namespace Saad_Contacts\API;

use WP_REST_Controller;
use WP_REST_Server;

class User extends WP_REST_Controller
{
    /**
    * Initialize the class
    */
    public function __construct()
    {
        $this->namespace = 'saad-users/v1';
        $this->rest_base = 'users';
    }

    /**
       * Registers the routes for the objects of the controller.
       *
       * @return void
       */
    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_items' ],
                    'args'                => $this->get_collection_params(),
                ],
                
            ]
        );
    }
 

    /**
     * Get users
     *
     * @param [type] $request
     * @return void
     */
    public function get_items($request)
    {
        global $wpdb;
        
        $users= $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'users');
        foreach ($users as $user) { 
            unset($user->user_pass);
        }
        return $users;
    }
}
