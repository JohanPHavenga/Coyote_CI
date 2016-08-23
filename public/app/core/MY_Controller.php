<?php
// core/MY_Controller.php
/**
 * Base Controller
 * 
 */ 
class MY_Controller extends CI_Controller {
                      // or MX_Controller if you use HMVC, linked above
    function __construct()
    {
        parent::__construct();
        // Load shared resources here or in autoload.php
    }
}

/**
 * Back end Controller
 * 
 */ 
class Admin_Controller extends MY_Controller {
    
    public $view_url="/admin/list";
    public $header_url="/templates/header_admin";
    public $footer_url="/templates/footer_admin";
    
    function __construct()
    {
        parent::__construct();
        // Check login, load back end dependencies
    }
    
}

/**
 * Default Front-end Controller
 * 
 */ 
class Frontend_Controller extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        // Load any front-end only dependencies
    }
}