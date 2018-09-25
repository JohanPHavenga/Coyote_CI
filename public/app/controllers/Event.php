<?php
class Event extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->data_to_header['section']="events";
    }

    // check if method exists, if not calls "view" method
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->detail($method, $params = array());
        }
    }


    public function calendar($year=NULL)
    {
        // load helpers / libraries
        $this->load->library('table');

        $this->data_to_header['title']="Running Race Event Calendar";
        $this->data_to_header['meta_description']="List of upcoming road running race events";
        $this->data_to_header['keywords']="Calendar, Races, Events, Listing, Race, Run, Marathon, Half-Marathon, 10k, Fun Run";

        // get race info
        $upcoming_race_summary = $this->event_model->get_event_list_summary($from="date_range",$params=["date_from"=>date("Y-m-d")]);
        $past_date = date("Y-m-d", strtotime("-11 months", time()));
        $past_race_summary = $this->event_model->get_event_list_summary($from="date_range",$params=["date_from"=>$past_date,"date_to"=>date("Y-m-d"),"sort"=>"DESC"]);
        // render html
        $this->data_to_view['upcoming_race_list_html']=$this->render_races_accordian_html($upcoming_race_summary);
        $this->data_to_view['past_race_list_html']=$this->render_races_accordian_html($past_race_summary);

        // set title bar
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_header['title'],
                "crumbs"=>$this->crumbs_arr,
            ]);

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/event/calendar", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function detail($edition_name_encoded) {
        // get race and edition models
        $this->load->model('edition_model');
        $this->load->model('race_model');
                        
        // as daar nie 'n edition_name deurgestuur word nie
        if ($edition_name_encoded=="index") { redirect("/event/calendar");  }

        // decode die edition name uit die URL en kry ID
        $edition_name=urldecode($edition_name_encoded);
        $edition_id=$this->edition_model->get_edition_id_from_name($edition_name);

        // edition in session vir contact form
        $edition_name=str_replace("-", " ", $edition_name);
        $this->session->set_flashdata([
            "last_visited_event"=>$edition_name
        ]);

        if (!$edition_id)
        {
            // if name cannot be matched to an edition
            $this->session->set_flashdata([
                'alert'=>" We had trouble finding the event '<b>".$edition_name."</b>'. Please try selecting the correct event from the list below.",
                'status'=>"danger",
                ]);
            redirect("/event/calendar");
            die();
        }
        
        $this->data_to_header['title']=$edition_name;

        // set data to view
        $this->data_to_header['css_to_load']=array(
            "plugins/cubeportfolio/css/cubeportfolio.min.css",
            "plugins/owl-carousel/assets/owl.carousel.css",
            "plugins/fancybox/jquery.fancybox.css",
            "plugins/slider-for-bootstrap/css/slider.css",
            );

        $this->data_to_footer['js_to_load']=array(
            "plugins/cubeportfolio/js/jquery.cubeportfolio.min.js",
            "plugins/owl-carousel/owl.carousel.min.js",
            "plugins/fancybox/jquery.fancybox.pack.js",
            "plugins/smooth-scroll/jquery.smooth-scroll.js",
            "plugins/slider-for-bootstrap/js/bootstrap-slider.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            GOOGLE_MAP_URL,
            "plugins/gmaps/gmaps.js",
            );

        // get event details
        $this->data_to_view['event_detail']=$this->edition_model->get_edition_detail_full($edition_id);     
        $this->data_to_view['event_detail']['race_list']=$this->race_model->get_race_list(100,0,$edition_id);
        $this->data_to_view['event_detail']['summary']=$this->event_model->get_event_list_summary("id",["event_id"=>$this->data_to_view['event_detail']['event_id']]);
        // get next an previous races
        $this->data_to_view['next_race_list']=$this->race_model->get_next_prev_race_list($this->data_to_view['event_detail']['race_list'], 'next');
        $this->data_to_view['prev_race_list']=$this->race_model->get_next_prev_race_list($this->data_to_view['event_detail']['race_list'], 'prev');
        // get url for Google Calendar
        $this->data_to_view['event_detail']['google_cal_url']=$this->google_cal(
                [
                    "edition_name"=>$this->data_to_view['event_detail']['edition_name'],
                    "edition_date"=>$this->data_to_view['event_detail']['edition_date'],
                    "race_list"=>$this->data_to_view['event_detail']['race_list'],
                    "url"=>"http://www.roadrunning.co.za".urlencode($this->data_to_view['event_detail']['summary']['edition_url']),
                    "address"=>$this->data_to_view['event_detail']['edition_address'].", ".$this->data_to_view['event_detail']['town_name'],
                ]
                );
        
        // get other stuff
        $this->data_to_footer['scripts_to_display'][]=$this->formulate_gmap_script($this->data_to_view['event_detail']);
        $this->data_to_view['notice']=$this->formulate_detail_notice($this->data_to_view['event_detail']);
        $this->data_to_header['meta_description']=$this->formulate_meta_description($this->data_to_view['event_detail']['summary']);        
        $this->data_to_header['keywords']=$this->formulate_keywords($this->data_to_view['event_detail']['summary']);     
        $this->data_to_view['structured_data']=$this->formulate_structured_data($this->data_to_view['event_detail']);
        $this->data_to_view['event_detail']['main_url']=$this->get_main_url($this->data_to_view['event_detail']);
        
        
        // set title bar
        // remove firt element in  crumbs_arr, and replace with generic text        
        array_shift($this->crumbs_arr);
        $this->crumbs_arr=["Event Details"=>""]+$this->crumbs_arr;
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "crumbs"=>$this->crumbs_arr,
            ]);

        // set box color - this is for the zebra lines
        $box_color_arr[0]='';
        $box_color_arr[1]='c-bg-grey-1'; 
        $bc=0;
        $this->data_to_view['box_color']=$box_color_arr[$bc];

        // -------------------------------------------------------------------------------------------------
        // LOAD VIEWS         
        // -------------------------------------------------------------------------------------------------
        // HEADER
        $this->load->view($this->header_url, $this->data_to_header);

        // $this->load->view("/event/detail", $this->data_to_view);
        $this->load->view("/event/detail_head", $this->data_to_view);
        $this->load->view("/event/detail_event_heading", $this->data_to_view);

        // Google Add
        $this->load->view("/event/google_ad", $this->data_to_view);
        $bc=!$bc;  $this->data_to_view['box_color']=$box_color_arr[$bc];

        // Entry Detail
        if (strlen($this->data_to_view['event_detail']['edition_entry_detail'])>10) {
            $this->load->view("/event/detail_event_info_entry", $this->data_to_view);
            $bc=!$bc;
            $this->data_to_view['box_color']= $box_color_arr[$bc];
        } 

        // Race detail
        $this->load->view("/event/detail_event_info_races", $this->data_to_view);
        // check race_list size. If uneven number, change box_color
        $num_races=sizeof($this->data_to_view['event_detail']['race_list']);
        if ($num_races % 2) {
            $bc=!$bc;
            $this->data_to_view['box_color']= $box_color_arr[$bc];
        }

        // Event description
        if (strlen($this->data_to_view['event_detail']['edition_description'])>10) {
            $this->load->view("/event/detail_event_info_description", $this->data_to_view);
            $bc=!$bc;
            $this->data_to_view['box_color']= $box_color_arr[$bc];
        } 

        // Google Add
        $this->load->view("/event/google_ad_bottom", $this->data_to_view);
        $bc=!$bc;  $this->data_to_view['box_color']=$box_color_arr[$bc];

        // Detail footer
        $this->load->view("/event/detail_footer", $this->data_to_view);

        //FOOTER
        $this->load->view($this->footer_url, $this->data_to_footer);

    }
    
    
    function get_main_url($event_detail) {
        $main_url='';
        if ($event_detail['edition_url_entry']) {
            $main_url=$event_detail['edition_url_entry'];
        } elseif ($event_detail['edition_url']) {
            $main_url=$event_detail['edition_url_entry'];
        } elseif ($event_detail['edition_url_flyer']) {
            $main_url=$event_detail['edition_url_flyer'];
        }
        return $main_url;
    }
    
    function formulate_meta_description($event_detail_summary) {
        $return= "The annual ".
                $event_detail_summary['event_name']." in ".
                $event_detail_summary['town_name']." on ".
                $event_detail_summary['edition_date'].". ".
                $event_detail_summary['race_time_start']." race including the follwing distances: ".
                $event_detail_summary['race_distance'];
        return $return;
    }
    
    function formulate_keywords($event_detail_summary) {
        $return="";
        $name_secs=explode(" ", $event_detail_summary['event_name']);
        // event name
        foreach ($name_secs as $sec) { $return.="$sec,";}         
        // distance
        foreach ($event_detail_summary['distance_arr'] as $dis) { $return.="$dis"."km,";} 
        foreach ($event_detail_summary['distance_arr'] as $dis) { $return.="$dis"."k,";} 
        $return.="Race,Event,Running,Run";
        return $return;
    }
    
    
    function formulate_detail_notice($event_detail) {
        // check if events is in the past
        $return='';
        if ($event_detail['edition_date'] < date("Y-m-d")) {
            $msg="<strong>Please note:</strong> You are viewing an event that has already taken place. <a href='../' style='color: #e73d4a; text-decoration: underline;'>Click here</a> to view a list of upcoming events.";
            $return="<div class='alert alert-danger' role='alert' style='margin-bottom:0'><div class='container'>$msg</div></div>";
        } elseif ($event_detail['edition_info_isconfirmed']) {
            $msg="The information for this event has been <strong>confirmed</strong>. ";
            if ($event_detail['edition_url_flyer']) { 
                $msg.="Please see the <a target='_blank' href='".$event_detail['edition_url_flyer']."' style='color: #27a4b0; text-decoration: underline;'>Race Flyer</a> for the full information set as supplied by the event organisers."; 
            } elseif ($event_detail['edition_url']) {
                $msg.="Please see the <a target='_blank' href='".$event_detail['edition_url']."' style='color: #27a4b0; text-decoration: underline;'>Race Website</a> for more information set as supplied by the event organisers."; 
            }
            $return="<div class='alert alert-success' role='alert' style='margin-bottom:0'><div class='container'>$msg</div></div>";
        }
        return $return;
    }
    
    function formulate_gmap_script($event_detail) {
        $map_long=$event_detail['longitude_num'];
        
        $return="var PageContact = function() {
            
                var _init = function() {
                    var mapbg = new GMaps({
                            div: '#gmapbg',
                            lat: ".$event_detail['latitude_num'].",
                            lng: ".$map_long.",
                            scrollwheel: false
                    });

                    mapbg.addMarker({
                            lat: ".$event_detail['latitude_num'].",
                            lng: ".$event_detail['longitude_num'].",
                            title: '". html_escape($event_detail['edition_address'])."',
                            infoWindow: {
                                    content: '<h3>".html_escape($event_detail['edition_name'])."</h3><p>".html_escape($event_detail['edition_address'])."</p>'
                            }
                    });
                }

                return {
                    init: function() {
                        _init();
                    }

                };
            }();

            $(document).ready(function() {
                PageContact.init();
            });";
        
        return $return;
    }
    
    
    function ics($edition_id) {

        $this->load->model('edition_model');
        $this->load->model('race_model');

        $edition_info['event_detail']=$this->edition_model->get_edition_detail_full($edition_id);
        $edition_info['event_detail']['race_list']=$this->race_model->get_race_list(100,0,$edition_id);


        $this->data_to_view['summary']=$edition_info['event_detail']['edition_name'];
        // get time
        $date=$edition_info['event_detail']['edition_date'];
        $time="23:59:00";
        foreach ($edition_info['event_detail']['race_list'] as $race) {
            $race_time=$race['race_time_start'];
            if ($race_time<$time) { $time=$race_time; }
        }
        $this->data_to_view['datestart']=strtotime(str_replace("00:00:00",$time,$date));
        $this->data_to_view['dateend']=$this->data_to_view['datestart']+(5*60*60);
        $this->data_to_view['address']=$edition_info['event_detail']['edition_address'];
        $this->data_to_view['uri']="http://www.roadrunning.co.za/event/".urlencode(str_replace("'","",$edition_info['event_detail']['edition_name']));
        $this->data_to_view['description']='';
        $this->data_to_view['filename']='RoadRunning_Event_'.$edition_id.".ics";
        $this->data_to_view['uid']=$edition_id;

        $this->load->view("/scripts/ics", $this->data_to_view);

        // wts($this->data_to_view);
        // wts($edition_info);
        // die($edition_id);

    }
    
    function google_cal($params) {
        $base_url="http://www.google.com/calendar/event?action=TEMPLATE&trp=true";
        
        // text
        $text=$params['edition_name'];
        
        // dates
        $date=$params['edition_date'];
        $time="23:59:00";
        foreach ($params['race_list'] as $race) {
            $race_time=$race['race_time_start'];
            if ($race_time<$time) { $time=$race_time; }
        }
        $sdate=strtotime(str_replace("00:00:00",$time,$date));
        $edate=$sdate+(5*60*60);
        
        $dates=fdateToCal($sdate)."/".fdateToCal($edate);
        
//        20170402T053000Z/20170402T103000Z
//        20170326T060000/20170326T100000";        
        
        $sprop="website:".$params['url'];
        $details="website:".$params['url'];
        $location=urlencode($params['address']);
            
        return $base_url."&text=".$text."&dates=".$dates."&details=".$details."&location=".$location;
    }

    
    function formulate_structured_data($event_detail) {
        $start_date=date("Y-m-d", strtotime($event_detail['edition_date']));
        
        $h[]='<script type="application/ld+json">';
        $h[]='{';
            $h[]='"@context": "http://schema.org",';
            $h[]='"@type": "SportsEvent",';
            $h[]='"name": "'.$event_detail['edition_name'].'",';
            $h[]='"startDate": "'.$start_date.'",';
            $h[]='"location": { ';
                $h[]='"@type": "Place",';
                $h[]='"name": "'.$event_detail['edition_address'].'",';
                $h[]='"address": { ';
                    $h[]='"@type": "PostalAddress",';
                    $h[]='"streetAddress": "'.$event_detail['edition_address'].'",';
                    $h[]='"addressLocality": "'.$event_detail['town_name'].'",';
                    $h[]='"addressRegion": "WC",';
                    $h[]='"addressCountry": "ZA"';
                $h[]='}';
            $h[]='},';
            $h[]='"description": "Join us for the annual '.$event_detail['event_name'].' road running race in '.$event_detail['town_name'].'.",';
            if ($event_detail['edition_logo']) {
                $img_url=base_url("uploads/admin/edition/".$event_detail['edition_id']."/".$event_detail['edition_logo']);
                $h[]='"image": "'.$img_url.'",';
            }
            
            $h[]='"subEvent": [ ';  
            
                foreach ($event_detail['race_list'] as $race) {
                    if (!empty($race['race_name'])) {
                        $rn=$race['race_name'];
                    } else {
                        $rn=fraceDistance($race['race_distance'])." ".$race['racetype_name'];  
                    }
                    if ($race['race_fee_flat']>0) {
                        $price=$race['race_fee_flat'];
                    } elseif ($race['race_fee_senior_licenced']>0) {
                        $price=$race['race_fee_senior_licenced'];
                    } else {
                        $price=0;
                    }                    
                    if ($race['race_date']>0) {                        
                        $race_start_date=date("Y-m-d", strtotime($race['race_date']));
                    } else {
                        $race_start_date=$start_date;
                    }

                    $today_date=date("Y-m-d").'T'."00:00:00+02:00";
                    
                    $h[]='{';
                    $h[]='"@type": "SportsEvent",';
                    $h[]='"name": "'.$rn.'",';
                    $h[]='"startDate": "'.$race_start_date.'T'.$race['race_time_start'].'+02:00",';
                    if ($race['race_time_end']) {
                        $h[]='"endDate": "'.$race_start_date.'T'.$race['race_time_end'].'+02:00",';
                    }
                    $h[]='"location": { ';
                        $h[]='"@type": "Place",';
                        $h[]='"name": "'.$event_detail['edition_address'].'",';
                        $h[]='"address": { ';
                            $h[]='"@type": "PostalAddress",';
                            $h[]='"streetAddress": "'.$event_detail['edition_address'].'",';
                            $h[]='"addressLocality": "'.$event_detail['town_name'].'",';
                            $h[]='"addressRegion": "WC",';
                            $h[]='"addressCountry": "ZA"';
                        $h[]='}';
                    if ($price>0) {
                        $h[]='},';
                        $h[]='"offers": { ';
                            $h[]='"@type": "Offer",';
                            $h[]='"price": "'.$price.'",';
                            $h[]='"priceCurrency": "ZAR",';
                            if ($event_detail['edition_url_entry']) {
                                $h[]='"url": "'.$event_detail['edition_url_entry'].'",';
                                $h[]='"availability": "http://schema.org/InStock",';
                                $h[]='"validFrom": "'.$today_date.'"';
                            }
                        $h[]='}';
                    } else {
                        $h[]='}';   
                    }
                    
                    // loose comma at the end of the last one
                    if ($race === end($event_detail['race_list'])) {
                        $h[]='}';
                    } else {
                        $h[]='},';
                    }
                }
            
            $h[]=']';
            
        $h[]='}';
        $h[]='</script>';
        
        $html=implode("\n\r", $h);
        
    //    echo $html;
    //    wts($event_detail);
    //    die();
        
        return $html;
    }


}
