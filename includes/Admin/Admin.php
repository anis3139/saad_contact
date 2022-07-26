<?php

namespace Saad_Contacts\Admin;

use Saad_Contacts\Admin\Menu;
use Saad_Contacts\Admin\Form_Handler;

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
