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
    
    public $data_to_view=[];
    
    public $view_url="/admin/list";
    public $header_url="/templates/admin/header";
    public $footer_url="/templates/admin/footer";
    public $profile_url="/admin/dashboard/profile";
    public $logout_url="/login/logout";
    
//    public $crumbs=[];
    
    function __construct()
    {
        parent::__construct();
        // Check login, load back end dependencies
        if (!$this->session->has_userdata('admin_logged_in'))
        {
            $this->session->set_flashdata([
                    'alert'=>"You are not logged in as an Admin. Please log in to continue.",
                    'status'=>"danger",
                    ]);
            redirect('/login/admin', 'refresh');
        }        
        
        // setup auto crumbs from URI
        $segs = $this->uri->segment_array();
        $crumb_uri= substr(base_url(),0,-1);
        $total_segments=$this->uri->total_segments();        
        for ($x = 1; $x <= $total_segments; $x++) {
            
            if (($x==$total_segments) || ($x==3))
            {
                $crumb_uri="";
            } else {
                $crumb_uri.="/".$segs[$x];     
            }
            
            if ($segs[$x]=="admin") { $segs[$x]="dashboard"; }
            if ($segs[$x]=="delete") { $this->data_to_view['crumbs']=[]; break; }
            
            $this->data_to_view['crumbs'][ucfirst($segs[$x])]=$crumb_uri;
            
            if ($x==3) { break; }
        } 
        
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