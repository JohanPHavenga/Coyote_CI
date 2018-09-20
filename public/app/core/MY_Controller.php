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
        
//        wts($_SESSION);
//        exit();
        
        
        if (!$this->session->has_userdata('admin_logged_in'))
        {
            $this->session->set_flashdata([
                    'alert'=>"You are not logged in as an Admin. Please log in to continue.",
                    'status'=>"danger",
                    ]);
            redirect('/login/admin', 'refresh');
            exit();
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
//            wts($csv[0]);
//            wts($a);
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
                "seg0"=>['event'],
                "submenu"=>[
                    [
                    "text"=>"List All Events",
                    "url"=>'admin/event/view',
                    ],
                    [
                    "text"=>"Add Event",
                    "url"=>'admin/event/create/add',
                    ],
                    [
                    "text"=>"Import Events",
                    "url"=>'admin/event/import',
                    ],
                    [
                    "text"=>"Export Events",
                    "url"=>'admin/event/export',
                    ],
                ],
            ],
            // Editions
            [
                "text"=>"Editions",
                "url"=>'admin/edition',
                "icon"=>"calendar",
                "seg0"=>['edition'],
            ],
             // Races
            [
                "text"=>"Races",
                "url"=>'admin/race',
                "icon"=>"trophy",
                "seg0"=>['race'],                
            ],
            // Users
            [
                "text"=>"Users",
                "url"=>'admin/user',
                "icon"=>"users",
                "seg0"=>['user'],
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
                    "text"=>"List All Areas",
                    "url"=>'admin/area/view',
                    ],
                    [
                    "text"=>"List All Roles",
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
                    [
                    "text"=>"List All Racetypes",
                    "url"=>'admin/racetype/view',
                    ],
                    [
                    "text"=>"List All ASA Members",
                    "url"=>'admin/asamember/view',
                    ],
                    [
                    "text"=>"List All Quotes",
                    "url"=>'admin/quote/view',
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
        return ['race_id','race_name','race_distance','race_time_start','racetype_id'];
    }
    function get_contact_field_list() {
        return ['user_id','user_name','user_surname','user_email'];
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

        if (!isset($_SESSION['area_list'])) {
            $_SESSION['area_list'] = $this->get_area_list();
        }

        // Load shared resources here or in autoload.php
        $this->crumbs_arr=$this->set_crumbs();
        $this->data_to_header["title_bar"]=$this->render_topbar_html(["crumbs"=>$this->crumbs_arr]);
        $this->data_to_header["menu_array"]=$this->set_top_menu_array();
        $this->data_to_footer["area_list"]=$_SESSION['area_list'];
    }

    function set_top_menu_array() {
        return [
            // Dashboard
            [
                "text"=>"Home",
                "url"=> base_url(),
                "section"=>'home',
            ],
            // Events
            [
                "text"=>"Events",
                "url"=>base_url('/event/calendar'),
                "section"=>'events',
            ],
            // Events
            [
                "text"=>"Contact Us",
                "url"=>base_url('/pages/home/#contact'),
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
    
    function render_crumbs($crumb_arr) {
        // crumbs
        $return_html='<ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">';
        foreach ($crumb_arr as $display=>$url) {
            $return_html.='<li><a href="'.$url.'">'.urldecode($display).'</a></li>';
            if ($display!="Home") { $return_html.="<li>/</li>"; }
        }
        $return_html.='</ul>';

        return $return_html;
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

            $return_html .= $this->render_crumbs($params['crumbs']);
            
            

        $return_html.='</div>';
        $return_html.='</div>';

        return $return_html;
    }
    
    function get_bullet_color($params) {
        
        $return['color']="c-font-yellow";
        $return['text']="Gathering event inforamtion";
    
        if ($params['confirmed']) { 
            $return['color']="c-font-green-2"; 
            $return['text']="Event information confirmed";
        }
        
        if ($params['results']) { 
            $return['color']="c-font-yellow-1"; 
            $return['text']="Results Loaded";
        }
        
        return $return;
    }


    // generate html for the accordian holding event data

    function render_races_accordian_html($race_summary, $filter_title="All") {
        $this->load->model('race_model');            
        
//        wts($race_summary);
//        die();
        
        $return_html_arr=[];
        if ($race_summary) {
            
            $rand=rand(1,500);
            
            $return_html_arr[]='<div class="row c-page-faq-2">';

                $return_html_arr[]='<div class="col-sm-3 hidden-xs">';
                $return_html_arr[]='<ul class="nav nav-tabs c-faq-tabs" data-tabs="tabs">';
                    $return_html_arr[]='<li class="active"><a href="#all'.$rand.'" data-toggle="tab">'.$filter_title.'</a></li>';
                    $month_list=array_keys($race_summary);
                        foreach ($month_list as $month) {
                            $return_html_arr[]='<li><a href="#'.$month.$rand.'" data-toggle="tab">'.$month.'</a></li>';
                            //$return_html_arr[]='<div data-filter=".'.$month.'" class="cbp-filter-item"> '.$month.' </div>';
                        }
                    $return_html_arr[]='</ul></div>';
                    

                $return_html_arr[]='<div class="col-sm-9">';
                    $return_html_arr[]='<div class="tab-content">';


                    $return_html_arr[]='<div class="tab-pane active" id="all'.$rand.'">';
                        if ($filter_title=="Next 3 Months") {
                            $return_html_arr[]='<div class="c-content-title-1"><h3 class="c-font-uppercase c-font-bold">Events over the next 3 months</h3><div class="c-line-left"></div></div>';
                        }
                        $return_html_arr[]='<div class="c-content-accordion-1"><div class="panel-group" id="accordion'.$rand.'" role="tablist">';

                            $n=0;

                            foreach ($race_summary as $month=>$edition_list) {
                                foreach ($edition_list as $edition_id=>$edition) {
                                    
                                    // set bullet color
                                    $bullet_info = $this->get_bullet_color([
                                        "confirmed"=>$edition['edition_info_isconfirmed'],
                                        "results"=>$edition['edition_url_results']
                                    ]);                                    
                                    
                                    // set distance circles
                                    $badge="";
                                    foreach ($edition['distance_arr'] as $distance) {
                                        $color = $this->race_model->get_race_color($distance);
                                        $badge.="<span class='badge c-bg-$color'>".$distance."</span> ";
                                    }

                                    $return_html_arr[]='<div class="panel">';
                                        $return_html_arr[]='<div class="panel-heading" role="tab" id="heading'.$edition_id.'">';
                                            $return_html_arr[]='<h4 class="panel-title">';
                                                $return_html_arr[]='<a class="" data-toggle="collapse" data-parent="#accordion'.$rand.'" href="#collapse'.$edition_id.'" aria-expanded="true" aria-controls="collapse'.$edition_id.'">';
                                                $return_html_arr[]='<table class="accordian" style="width: 100%"><tr>';
                                                $return_html_arr[]='<td style="width: 10px;"><i class="'.$bullet_info['color'].' fa fa-check-circle-o" title="'.$bullet_info['text'].'"></i> </td>';
                                                $return_html_arr[]='<td>'.date("M j",strtotime($edition['edition_date'])).'</b> - '.substr($edition['edition_name'],0,-5).'</td>';
                                                $return_html_arr[]='<td class="badges hidden-xs">'.$badge.'</td>';
                                                $return_html_arr[]='</tr></table>';
                                                $return_html_arr[]='</a>';
                                            $return_html_arr[]='</h4>';
                                        $return_html_arr[]='</div>';
                                        if ($n==0) { $act="in"; } else { $act=""; }
                                        $return_html_arr[]='<div id="collapse'.$edition_id.'" class="panel-collapse collapse '.$act.'" role="tabpanel" aria-labelledby="heading'.$edition_id.'">';
                                            $return_html_arr[]='<div class="panel-body">';
                                            $return_html_arr[]='<p style="margin:0 0 5px;"><span class="visible-xs">'.$badge.'</span></p>';
                                            $return_html_arr[]='<p><b>When: </b>'.$edition['edition_date']."<br>";
                                            $return_html_arr[]='<b>Where: </b>'.$edition['town_name']."<br>";
                                            $return_html_arr[]='<b>Distances: </b>'.$edition['race_distance']."<br>";
//                                            $return_html_arr[]='<b>Time of day: </b>'.$edition['race_time_start']."<br>";
                                            $return_html_arr[]='<b>Start Times: </b>'.$edition['start_time']."<br>";
                                            $return_html_arr[]='<b>Info Status: </b>'.$bullet_info['text']."</p>";
                                            $return_html_arr[]='<p><a href="'.$edition['edition_url'].'" class="btn c-theme-btn c-btn-border-2x c-btn-square">DETAIL</a></p>';
                                            $return_html_arr[]='</div>';
                                        $return_html_arr[]='</div>';
                                    $return_html_arr[]='</div>';
                                    $n++;
                                }
                            }


                            $return_html_arr[]='</div></div>'; //c-content-accordion-1 + panel-group
                        $return_html_arr[]='</div>'; // tab-pane

                        $m=0;

                        // maande
                        foreach ($race_summary as $month=>$edition_list) {
                        $m++;
                            
                        $return_html_arr[]='<div class="tab-pane" id="'.$month.$rand.'">';
                            $return_html_arr[]='<div class="c-content-title-1"><h3 class="c-font-uppercase c-font-bold">Events in '.$month.'</h3><div class="c-line-left"></div></div>';
                            $return_html_arr[]='<div class="c-content-accordion-1"><div class="panel-group" id="accordion'.$month.$rand.'" role="tablist">';

                                    $n=0;
                                    foreach ($edition_list as $edition_id=>$edition) {
                                        
                                        // set bullet color
                                        $bullet_info = $this->get_bullet_color([
                                            "confirmed"=>$edition['edition_info_isconfirmed'],
                                            "results"=>$edition['edition_url_results']
                                        ]); 
                                    
                                        // set distance circles
                                        $badge="";
                                        foreach ($edition['distance_arr'] as $distance) {
                                            $color = $this->race_model->get_race_color($distance);
                                            $badge.="<span class='badge c-bg-$color'>".intval($distance)."</span> ";
                                        }

                                        $uid=$n.$edition_id;

                                        $return_html_arr[]='<div class="panel">';
                                            $return_html_arr[]='<div class="panel-heading" role="tab" id="heading'.$uid.'">';
                                                $return_html_arr[]='<h4 class="panel-title">';
                                                    $return_html_arr[]='<a class="" data-toggle="collapse" data-parent="#accordion'.$month.$rand.'" href="#collapse'.$uid.'" aria-expanded="true" aria-controls="collapse'.$uid.'">';
                                                    $return_html_arr[]='<table class="accordian" style="width: 100%"><tr>';
                                                    $return_html_arr[]='<td style="width: 10px;"><i class="'.$bullet_info['color'].' fa fa-check-circle-o" title="'.$bullet_info['text'].'"></i> </td>';
                                                    $return_html_arr[]='<td>'.date("M j",strtotime($edition['edition_date'])).'</b> - '.substr($edition['edition_name'],0,-5).'</td>';
                                                    $return_html_arr[]='<td class="badges hidden-xs">'.$badge.'</td>';
                                                $return_html_arr[]='</tr></table>';
                                                    $return_html_arr[]='</a>';
                                                $return_html_arr[]='</h4>';
                                            $return_html_arr[]='</div>';
                                            if ($n==0) { $act="in"; } else { $act=""; }
                                            $return_html_arr[]='<div id="collapse'.$uid.'" class="panel-collapse collapse '.$act.'" role="tabpanel" aria-labelledby="heading'.$uid.'">';
                                                $return_html_arr[]='<div class="panel-body">';
                                                $return_html_arr[]='<p style="margin:0 0 5px;"><span class="visible-xs">'.$badge.'</span></p>';
                                                $return_html_arr[]='<p><b>When: </b>'.$edition['edition_date']."<br>";
                                                $return_html_arr[]='<b>Where: </b>'.$edition['town_name']."<br>";
                                                $return_html_arr[]='<b>Distances: </b>'.$edition['race_distance']."<br>";
//                                                $return_html_arr[]='<b>Time of day: </b>'.$edition['race_time_start']."<br>";
                                                $return_html_arr[]='<b>Start Times: </b>'.$edition['start_time']."<br>";
                                                $return_html_arr[]='<b>Info Status: </b>'.$bullet_info['text']."</p>";
                                                $return_html_arr[]='<p><a href="'.$edition['edition_url'].'" class="btn c-theme-btn c-btn-border-2x c-btn-square">DETAIL</a></p>';
                                                $return_html_arr[]='</div>';
                                            $return_html_arr[]='</div>';
                                        $return_html_arr[]='</div>';

                                        $n++;
                                    }


                                $return_html_arr[]='</div></div>'; //c-content-accordion-1 + panel-group
                            $return_html_arr[]='</div>'; // tab-pane
                        }


                    $return_html_arr[]='</div>'; // tab-content
                $return_html_arr[]='</div>'; // close col-sm-9

            $return_html_arr[]='</div>'; // close row c-page-faq-2
        } else {
            $return_html_arr[]='<p>There is currently no event data to display. Please chack back again shortly.</p><p>&nbsp;</p>';
        }

        return implode("", $return_html_arr);
    }

    function render_races_table_html($race_summary, $page="other") {
        $return_html_arr=[];

        if ($race_summary) {
            $n=0;
            foreach ($race_summary as $month=>$edition_list) {

                if ($page=="home") {
                    $return_html_arr[]='<div class="c-content-title-1">';
                    $return_html_arr[]='<h3 class="c-font-34 c-center c-font-bold c-font-uppercase">Races in '.$month.'</h3>';
                    $return_html_arr[]='<div class="c-line-center c-theme-bg"></div>';
                    $return_html_arr[]='</div>';
                }


                $return_html_arr[]='<div class="table-responsive">';
                $return_html_arr[]='<table class="table table-bordered" style="margin-bottom: 40px;">';

                $return_html_arr[]="<thead>";
                if ($page!="home") {
                    $return_html_arr[]="<tr><th colspan='6' class='table-head-blue'>Races in $month</th></tr>";
                }
                $return_html_arr[]="<tr><th>Date</th><th>Event</th><th>Place</th><th>Race Distances</th><th>Time of Day</th><th></th></tr>";
                $return_html_arr[]="</thead>";

                $return_html_arr[]='<tbody>';

                                foreach ($edition_list as $edition_id=>$edition) {
                                    $return_html_arr[]= "<tr>";
                                        $return_html_arr[]= "<th scope='row'><a href='".$edition['edition_url']."'>".$edition['edition_date']."</a></th>";
                                        $return_html_arr[]= "<td>".$edition['edition_name']."</td>";
                                        $return_html_arr[]= "<td>".$edition['town_name']."</td>";
                                        $return_html_arr[]= "<td>".$edition['race_distance']."</td>";
                                        $return_html_arr[]= "<td>".$edition['race_time_start']."</td>";
                                        $return_html_arr[]= "<td style='padding: 2px; text-align: center;'><a href='".$edition['edition_url']."' class='btn c-theme-btn c-btn-border-2x c-btn-square'>DETAIL</a></td>";
                                    $return_html_arr[]= "</tr>";
                                }

                $return_html_arr[]='</tbody>';

                $return_html_arr[]='</table>';
                $return_html_arr[]='</div>';
            }

        } else {
            $return_html_arr[]='<p>There is currently no event data to display. Please chack back again shortly.</p><p>&nbsp;</p>';
        }

        return implode("", $return_html_arr);
    }


    function get_area_list() {
        $this->load->model('event_model');
        $area_list = $this->event_model->get_area_list();
        return $area_list;
    }
    
    

}
