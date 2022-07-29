<?php
namespace Saad_Contacts\API;

use WP_REST_Controller;

abstract class Abstruct_Class extends WP_REST_Controller
{
    public $namespace = 'saad-contacts/v1';
}
