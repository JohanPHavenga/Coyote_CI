<?php
// core/MY_Controller.php
/**
 * Base Controller
 *
 */
class MY_Controller extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        // Load any front-end only dependencies
    }

}

/**
 * Back end Controller
 *
 */
class Admin_Controller extends MY_Controller {

    public $data_to_header=[];
    public $data_to_view=[];
    public $data_to_footer=[];

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

            if ($segs[$x]=="admin") { $segs[$x]="home"; }
                        if ($segs[$x]=="dashboard") { continue; }
            if ($segs[$x]=="delete") { $this->data_to_header['crumbs']=[]; break; }

            $segs[$x]=str_replace("_"," ",$segs[$x]);
            $this->data_to_header['crumbs'][ucwords($segs[$x])]=$crumb_uri;

            if ($x==3) { break; }
        }

        $this->data_to_header['menu_array']=$this->set_admin_menu_array();

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

    function csv_flat_table_import($file_data)
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

    function set_admin_menu_array() {
        return [
            // Dashboard
            [
                "text"=>"Dashboard",
                "url"=>'admin',
                "icon"=>"home",
                "seg0"=>['dashboard'],
                "submenu"=>[
                    [
                    "text"=>"Dashboard",
                    "url"=>'admin/dashboard',
                    "icon"=>"bar-chart",
                    ],
                    [
                    "text"=>"Search",
                    "url"=>'admin/dashboard/search',
                    "icon"=>"magnifier",
                    ],
                ],
            ],
            // Events
            [
                "text"=>"Events",
                "url"=>'admin/event',
                "icon"=>"rocket",
                "seg0"=>['event','edition','race'],
                "submenu"=>[
                    [
                    "text"=>"List All Events",
                    "url"=>'admin/event/view',
                    ],
                    [
                    "text"=>"Import Events",
                    "url"=>'admin/event/import',
                    ],
                    [
                    "text"=>"Export Events",
                    "url"=>'admin/event/export',
                    ],
                    [
                    "text"=>"List All Editions",
                    "url"=>'admin/edition/view',
                    ],
                    [
                    "text"=>"List All Races",
                    "url"=>'admin/race/view',
                    ],
                ],
            ],
            // Users
            [
                "text"=>"Users",
                "url"=>'admin/user',
                "icon"=>"users",
                "seg0"=>['user','entry','asanumber'],
                "submenu"=>[
                    [
                    "text"=>"List All Users",
                    "url"=>'admin/user/view',
                    ],
                    [
                    "text"=>"List All Entries",
                    "url"=>'admin/entry/view',
                    ],
                    [
                    "text"=>"List All ASA Numbers",
                    "url"=>'admin/asanumber/view',
                    ],
                ],
            ],
            // Clubs
            [
                "text"=>"Clubs",
                "url"=>'admin/club',
                "icon"=>"badge",
                "seg0"=>['club'],
            ],
            // Sponsors
            [
                "text"=>"Sponsors",
                "url"=>'admin/sponsor',
                "icon"=>"wallet",
                "seg0"=>['sponsor'],
            ],
            // Static info
            [
                "text"=>"Static Info",
                "url"=>'admin/role',
                "icon"=>"settings",
                "seg0"=>['role','town','province'],
                "submenu"=>[
                    [
                    "text"=>"List All Role",
                    "url"=>'admin/role/view',
                    ],
                    [
                    "text"=>"List All Towns",
                    "url"=>'admin/town/view',
                    ],
                    [
                    "text"=>"List All Provinces",
                    "url"=>'admin/province/view',
                    ],
                ],
            ],
        ];

    }


    function get_event_field_list() {
        return ['event_id','event_name','town_id'];
    }
    function get_edition_field_list() {
        return ['edition_id','edition_name','edition_date','latitude_num','longitude_num','edition_url','edition_address'];
    }
    function get_race_field_list() {
        return ['race_id','race_name','race_distance','race_time'];
    }



}

/**
 * Default Front-end Controller
 *
 */
class Frontend_Controller extends MY_Controller {

    public $data_to_header=["section"=>""];
    public $data_to_view=[];
    public $data_to_footer=["admin_login"=>"/login/admin"];

    public $header_url='templates/header';
    public $footer_url='templates/footer';

    public $crumbs_arr=[];

    function __construct()
    {
        parent::__construct();
        // Load shared resources here or in autoload.php
        $this->crumbs_arr=$this->set_crumbs();
        $this->data_to_header["title_bar"]=$this->render_topbar_html(["crumbs"=>$this->crumbs_arr]);
        $this->data_to_header["menu_array"]=$this->set_top_menu_array();
    }

    function set_top_menu_array() {
        return [
            // Dashboard
            [
                "text"=>"Home",
                "url"=>'/',
                "section"=>'home',
            ],
            // Events
            [
                "text"=>"Events",
                "url"=>'/event/calendar',
                "section"=>'events',
            ],
            // Events
            [
                "text"=>"Contact Us",
                "url"=>"/#contact",
                "section"=>'',
            ],

        ];
    }

    function set_crumbs() {
        // setup auto crumbs from URI
        $segs = $this->uri->segment_array();
        $crumb_uri= substr(base_url(),0,-1);
        $total_segments=$this->uri->total_segments();
        $crumbs['Home']=base_url();
        for ($x = 1; $x <= $total_segments; $x++) {

            if (($x==$total_segments) || ($x==3))
            {
                $crumb_uri="";
            } else {
                $crumb_uri.="/".$segs[$x];
            }

            // make controller prural
            if ($x==1) { $segs[$x]= $segs[$x]."s"; }

            // if ($segs[$x]=="admin") { $segs[$x]="home"; }
            // if ($segs[$x]=="dashboard") { continue; }
            // if ($segs[$x]=="delete") { $this->data_to_header['crumbs']=[]; break; }

            $segs[$x]=str_replace("_"," ",$segs[$x]);
            $crumbs[ucwords($segs[$x])]=$crumb_uri;

            if ($x==3) { break; }
        }

        return array_reverse($crumbs);

    }

    function render_topbar_html($params) {
        if (isset($params['sub_title']))
        {
            $return_html='<div class="c-layout-breadcrumbs-1 c-subtitle c-fonts-uppercase c-fonts-bold">';
        } else {
            $return_html='<div class="c-layout-breadcrumbs-1 c-fonts-uppercase c-fonts-bold">';
        }
        $return_html.='<div class="container">';

            // heading
            $return_html.='<div class="c-page-title c-pull-left">';
                if (isset($params['title'])) { $return_html.='<h3 class="c-font-uppercase c-font-sbold">'.$params['title'].'</h3>'; }
                if (isset($params['sub_title'])) { $return_html.='<h4 class="">'.$params['sub_title'].'</h4>'; }
            $return_html.='</div>';

            // crumbs
            $return_html.='<ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">';
            foreach ($params['crumbs'] as $display=>$url) {
                $return_html.='<li><a href="'.$url.'">'.urldecode($display).'</a></li>';
                if ($display!="Home") { $return_html.="<li>/</li>"; }
            }
            $return_html.='</ul>';

        $return_html.='</div>';
        $return_html.='</div>';

        return $return_html;
    }

}
