<?php

namespace WP_Contacts\Admin;

use WP_Contacts\Admin\Menu;
use WP_Contacts\Admin\Form_Handler;

/**
 * The admin class
 */
class Admin
{

    /**
     * Initialize the class
     */
    public function __construct()
    {
        new Menu();
        new Form_Handler();
    }
   
}
