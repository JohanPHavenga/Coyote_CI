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
    public $upload_path="./uploads/admin/";

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


    function url_disect()
    {
        $url_info=[];
        $url_info["base_url"]=base_url();
        $url_info["url_string"]=uri_string();
        $url_info["url_string_arr"]=explode("/",uri_string());

        return $url_info;
    }

    function csv_handler($file_path)
    {
        $csv = array_map('str_getcsv', file($file_path));
        array_walk($csv, function(&$a) use ($csv) {
          $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        return $csv;
    }

    function csv_data_for_import($file_data)
    {
        foreach ($file_data as $entity) {
            //reset($entity);

            $id = array_shift($entity);

            foreach ($entity as $key => $value) {
                if (!empty($value)) {
                    $user_data[$key]=$value;
                }
            }

            // get ID - set action
            if ($id>0) {
                $action="edit";
            } else {
                $action="add";
                $id=0;
                if (isset($sum_data[$action])) { $id=max(array_keys($sum_data[$action]))+1; }
            }

            $sum_data[$action][$id]=$user_data;
            unset($user_data);
        }

        return $sum_data;
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
