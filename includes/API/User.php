<?php
namespace Saad_Contacts\API;

use Saad_Contacts\DB;
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

        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            [
                'args'   => [
                    'id' => [
                        'description' => __('Unique identifier for the object.'),
                        'type'        => 'integer',
                    ],
                ],
                [
                    'methods'             => WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_item' ],
                    'args'                => [
                        'context' => $this->get_context_param([ 'default' => 'view' ]),
                    ],
                ],
                'schema' => [ $this, 'get_item_schema' ],
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
        $args = [];
        $params = $this->get_collection_params();

        foreach ($params as $key => $value) {
            if (isset($request[ $key ])) {
                $args[ $key ] = $request[ $key ];
            }
        }
        // change `per_page` to `number`
        $args['number'] = $args['per_page'];
        $args['offset'] = $args['number'] * ($args['page'] - 1);
        
        // unset others
        unset($args['per_page']);
        unset($args['page']);
        
        $users=  DB::get( 'users', $args); 

        foreach ($users as $user) {
            $response = $this->prepare_item_for_response($user, $request);
            $data[]   = $this->prepare_response_for_collection($response);
        }

        $total     = intval(DB::count('users'));
        $max_pages = ceil($total / (int) $args['number']);

        $response = rest_ensure_response($data);

        $response->header('X-WP-Total', (int) $total);
        $response->header('X-WP-TotalPages', (int) $max_pages);

        return rest_ensure_response($response);
    }

    /**
    * Retrieves one item from the collection.
    *
    * @param \WP_REST_Request $request
    *
    * @return \WP_Error|\WP_REST_Response
    */
    public function get_item($request)
    {
        $user = $this->get_user($request['id']);
        
        $response = $this->prepare_item_for_response($user, $request);
        $response = rest_ensure_response($response);
    
        return $response;
    }
    /**
    * Get the address, if the ID is valid.
    *
    * @param int $id Supplied ID.
    *
    * @return Object|\WP_Error
    */
    protected function get_user($id)
    {
        $user = DB::get_by_id('users', $id);

        if (! $user) {
            return new \WP_Error(
                'rest_user_invalid_id',
                __('Invalid user ID.'),
                [ 'status' => 404 ]
            );
        }

        return $user;
    }

    /**
     * Prepares the item for the REST response.
     *
     * @param mixed           $item    WordPress representation of the item.
     * @param \WP_REST_Request $request Request object.
     *
     * @return \WP_Error|WP_REST_Response
     */
    public function prepare_item_for_response($item, $request)
    {
        $data   = [];
        $fields = $this->get_fields_for_response($request);

        $fields = $this->get_fields_for_response($request);
       
        if (in_array('id', $fields, true)) {
            $data['id'] = (int) $item->ID;
        }

        if (in_array('user_login', $fields, true)) {
            $data['user_login'] = $item->user_login;
        }

        if (in_array('user_nicename', $fields, true)) {
            $data['user_nicename'] = $item->user_nicename;
        }

        if (in_array('user_email', $fields, true)) {
            $data['user_email'] = $item->user_email;
        }

        if (in_array('user_url', $fields, true)) {
            $data['user_url'] = $item->user_url;
        }

        if (in_array('user_activation_key', $fields, true)) {
            $data['user_activation_key'] = $item->user_activation_key;
        }

        if (in_array('display_name', $fields, true)) {
            $data['display_name'] = $item->display_name;
        }

        if (in_array('user_status', $fields, true)) {
            $data['user_status'] = $item->user_status;
        }

        if (in_array('user_registered', $fields, true)) {
            $data['user_registered'] = mysql_to_rfc3339($item->user_registered);
        }

        $context = ! empty($request['context']) ? $request['context'] : 'view';
        $data    = $this->filter_response_by_context($data, $context);

        $response = rest_ensure_response($data);
        $response->add_links($this->prepare_links($item));

        return $response;
    }

   

    /**
     * Retrieves the user schema, conforming to JSON Schema.
     *
     * @return array
     */
    public function get_item_schema()
    {
        if ($this->schema) {
            return $this->add_additional_fields_schema($this->schema);
        }

        $schema = [
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'user',
            'type'       => 'object',
            'properties' => [
                'id' => [
                    'description' => __('Unique identifier for the object.'),
                    'type'        => 'integer',
                    'context'     => [ 'view' ],
                    'readonly'    => true,
                ],
                'user_login' => [
                    'description' => __('Name of the user.'),
                    'type'        => 'string',
                    'context'     => [ 'view' ],
                    'required'    => true,
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'user_nicename' => [
                    'description' => __('Nice Name of the user.'),
                    'type'        => 'string',
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ],
                ],
                'user_email' => [
                    'description' => __('Email number of the user.'),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'user_url' => [
                    'description' => __('User URL of the user.'),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_text_field',
                    ],
                ],
                'user_activation_key' => [
                    'description' => __('User activation key of the user.'),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ],
                ],
                'display_name' => [
                    'description' => __('Display name of the user.'),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ],
                ],
                'user_status' => [
                    'description' => __('User status of the user.'),
                    'type'        => 'string',
                    'required'    => true,
                    'context'     => [ 'view', 'edit' ],
                    'arg_options' => [
                        'sanitize_callback' => 'sanitize_textarea_field',
                    ],
                ],
                'user_registered' => [
                    'description' => __("The date the object was user registered, in the site's timezone."),
                    'type'        => 'string',
                    'format'      => 'date-time',
                    'context'     => [ 'view' ],
                    'readonly'    => true,
                ],
            ]
        ];

        $this->schema = $schema;

        return $this->add_additional_fields_schema($this->schema);
    }

    /**
    * Prepares links for the request.
    *
    * @param \WP_Post $post Post object.
    *
    * @return array Links for the given post.
    */
    protected function prepare_links($item)
    {
        $base = sprintf('%s/%s', $this->namespace, $this->rest_base);

        $links = [
            'self' => [
                'href' => rest_url(trailingslashit($base) . $item->id),
            ],
            'collection' => [
                'href' => rest_url($base),
            ],
        ];

        return $links;
    }

    /**
     * Retrieves the query params for collections.
     *
     * @return array
     */
    public function get_collection_params()
    {
        $params = parent::get_collection_params();

        unset($params['search']);

        return $params;
    }
}
