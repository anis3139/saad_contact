<?php
namespace WP_Contacts\Frontend;

use WP_Contacts\Frontend\Shortcode;

class Frontend
{
    /**
    * Initialize the class
    */
    public function __construct()
    {
        new Shortcode();
    }
}
