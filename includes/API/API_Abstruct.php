<?php
namespace Saad_Contacts\API;

use WP_REST_Controller;

abstract class API_Abstruct extends WP_REST_Controller
{
    public $namespace = 'saad-contacts/v1';
}
