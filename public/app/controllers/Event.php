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

    public function detail($edition_name_encoded) {
        // get race and edition models
        $this->load->model('edition_model');
        $this->load->model('race_model');
        $this->load->model('file_model');
        $this->load->model('url_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
                        
        // as daar nie 'n edition_name deurgestuur word nie
        if ($edition_name_encoded=="index") { redirect("/event/calendar");  }

        // decode die edition name uit die URL en kry ID
        $edition_name=get_edition_name_from_url($edition_name_encoded);
        $edition_data=$this->edition_model->get_edition_id_from_name($edition_name);
        
        // AS DIE NAAM WAT INKOM, NIE DIELFDE AS DIE OFFICIAL NAAM IS NIE, DAN DOEN HY 'N 301 REDIRECT.
        if ($edition_data['edition_name']!=$edition_name) {
            $url=get_url_from_edition_name(encode_edition_name($edition_data['edition_name']));
            redirect($url, 'location', 301);
        }
                
        $edition_id=$edition_data['edition_id'];               
        $edition_status=$edition_data['edition_status'];
        $edition_name=str_replace("-", " ", $edition_name);
        $this->session->set_flashdata(["last_visited_event"=>$edition_name]);    // edition in session vir contact form     
        
        // set edition names
        $e_names=$this->get_edition_name_from_status($edition_name, $edition_status);       
        if ($edition_status==2) { $this->data_to_header['meta_robots']="noindex, nofollow"; }
        
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
        
        $this->data_to_header['title']=$e_names['edition_name'];

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
        $this->data_to_view['event_detail']['edition_name']=$e_names['edition_name'];         
        $this->data_to_view['event_detail']['edition_name_clean']=$e_names['edition_name_clean'];        
        $this->data_to_view['event_detail']['edition_name_no_date']=$e_names['edition_name_no_date'];
        $this->data_to_view['event_detail']['race_list']=$this->race_model->get_race_list($edition_id);
        foreach ($this->data_to_view['event_detail']['race_list'] as $race_id => $race) {
            if ($race['race_status']==2) {
                unset($this->data_to_view['event_detail']['race_list'][$race_id]);
                continue;
            }
            $this->data_to_view['event_detail']['race_list'][$race_id]['file_list']=$this->file_model->get_file_list("race",$race_id,true);
            $this->data_to_view['event_detail']['race_list'][$race_id]['url_list']=$this->url_model->get_url_list("race",$race_id,true);
            $this->data_to_view['event_detail']['race_list'][$race_id]['race_name']=$this->get_race_name_from_status($race['race_name'],$race['race_distance'],$race['racetype_name'],$race['race_status']);
        }
        $this->data_to_view['event_detail']['file_list']=$this->file_model->get_file_list("edition",$edition_id,true);
        $this->data_to_view['event_detail']['summary']=$this->event_model->get_event_list_summary("id",["event_id"=>$this->data_to_view['event_detail']['event_id']]);
        $this->data_to_view['event_detail']['file_list']=$this->file_model->get_file_list("edition",$edition_id,true);
        $this->data_to_view['event_detail']['url_list']=$this->url_model->get_url_list("edition",$edition_id,true);
        $this->data_to_view['event_detail']['sponsor_url_list']=$this->url_model->get_url_list("sponsor",$this->data_to_view['event_detail']['sponsor_id'],false);
        $this->data_to_view['event_detail']['club_url_list']=$this->url_model->get_url_list("club",$this->data_to_view['event_detail']['club_id'],false);
        // get next an previous races
        if ($this->data_to_view['event_detail']['race_list']) {
        $this->data_to_view['next_race_list']=$this->race_model->get_next_prev_race_list($this->data_to_view['event_detail']['race_list'], 'next');
        $this->data_to_view['prev_race_list']=$this->race_model->get_next_prev_race_list($this->data_to_view['event_detail']['race_list'], 'prev');
        }
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
//        $this->data_to_view['structured_data']=$this->formulate_structured_data($this->data_to_view['event_detail']);
        
        $this->data_to_header['structured_data']=$this->load->view('/event/structured_data', $this->data_to_view, TRUE);
        
        // set buttons
        $this->data_to_view['event_detail']['calc_edition_urls']=$btn_data['calc_edition_urls']=$this->calc_urls_to_use($this->data_to_view['event_detail']['file_list'],$this->data_to_view['event_detail']['url_list']);   
        
        foreach ($this->data_to_view['event_detail']['race_list'] as $race_id => $race) {
            $race_urls=$this->calc_urls_to_use($race['file_list'],$race['url_list']);
            if ($race_urls) {
                $this->data_to_view['event_detail']['calc_race_urls'][$race_id]=$race_urls;
            }
        }
        
        
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
        $this->load->view("/event/detail_event_info_description", $this->data_to_view);
        $bc=!$bc;
        $this->data_to_view['box_color']= $box_color_arr[$bc];
        

        // Google Add
        $this->load->view("/event/google_ad_bottom", $this->data_to_view);
        $bc=!$bc;  $this->data_to_view['box_color']=$box_color_arr[$bc];

        // Detail footer
        $this->load->view("/event/detail_footer", $this->data_to_view);

        //FOOTER
        $this->load->view($this->footer_url, $this->data_to_footer);

    }
    
    function calc_urls_to_use($file_list,$url_list) {
        $calc_url_list=[];
        $this->load->model('urltype_model');
        $urltype_list=$this->urltype_model->get_urltype_list();
        
        // check eers vir flyer
        if (@$file_list[2]) { 
            $file_id = my_encrypt($file_list[2][0]['file_id']);
            $calc_url_list[0]=base_url("file/handler/".$file_id); 
        } elseif (@$url_list[2]) { 
            $calc_url_list[0]=$url_list[2][0]['url_name'];              
        }
        
        if (@$url_list[1]) { // dan website
            $calc_url_list[0]=$url_list[1][0]['url_name'];  
            $calc_url_list[1]=$url_list[1][0]['url_name'];              
        } 
        if (@$url_list[5]) { // dan online entry 
            $calc_url_list[0]=$url_list[5][0]['url_name'];  
            $calc_url_list[5]=$url_list[5][0]['url_name'];              
        } 
        
        $url_check_list=[2,3,4,6,7];
        foreach($url_check_list as $id) {
            if (@$file_list[$id]) {                            
                $file_id = my_encrypt($file_list[$id][0]['file_id']);
                $calc_url_list[$id]=base_url("file/handler/".$file_id);
            } elseif (@$url_list[$id]) {
                $calc_url_list[$id]=$url_list[$id][0]['url_name'];     
            }
        }
        
        return $calc_url_list;
    }
    
//    function get_main_url($event_detail) {
//        $main_url='';
//        if ($event_detail['edition_url_entry']) {
//            $main_url=$event_detail['edition_url_entry'];
//        } elseif ($event_detail['edition_url']) {
//            $main_url=$event_detail['edition_url_entry'];
//        } elseif ($event_detail['edition_url_flyer']) {
//            $main_url=$event_detail['edition_url_flyer'];
//        }
//        return $main_url;
//    }
    
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
        switch ($event_detail['edition_status']) {
            case 2:
                $msg="<strong>This event is set to DRAFT mode.</strong> All detail has not yet been confirmed";
                $return="<div class='alert alert-danger' role='alert' style='margin-bottom:0'><div class='container'>$msg</div></div>";
                break;
            case 3:
                $email=$event_detail['user_email'];
                $msg="<strong>This event has been CANCELLED.</strong> Please contact the event organisers for more detail on: <a href='mailto:$email' class='link' title='Email organisers'>$email</a>";
                $return="<div class='alert alert-danger' role='alert' style='margin-bottom:0'><div class='container'>$msg</div></div>";
                break;
            default:
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
                break;
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
        $edition_info['event_detail']['race_list']=$this->race_model->get_race_list($edition_id);


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
        $this->data_to_view['uri']=get_url_from_edition_name(encode_edition_name($edition_info['event_detail']['edition_name']));
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

    
//    function formulate_structured_data($event_detail) {
//        $header=array();
//        
//        $start_date=date("Y-m-d", strtotime($event_detail['edition_date']));
//        $end_date=date("Y-m-d", strtotime($event_detail['edition_date_end']));
//        
//        $header[]='<script type="application/ld+json">';
//        $header[]='{';        
//            $body[]='"@context": "http://schema.org",';
//            $body[]='"@type": "SportsEvent",';
//            $body[]='"name": "'.$event_detail['edition_name'].'",';
//            $body[]='"startDate": "'.$start_date.'",';
//            $body[]='"endDate": "'.$end_date.'",';
//            $body[]='"location": { ';
//                $body[]='"@type": "Place",';
//                $body[]='"name": "'.$event_detail['edition_address'].'",';
//                $body[]='"address": { ';
//                    $body[]='"@type": "PostalAddress",';
//                    $body[]='"streetAddress": "'.$event_detail['edition_address'].'",';
//                    $body[]='"addressLocality": "'.$event_detail['town_name'].'",';
//                    $body[]='"addressRegion": "WC",';
//                    $body[]='"addressCountry": "ZA"';
//                $body[]='}';
//            $body[]='},';
//            if ($event_detail['club_id']!=8) {
//                $body[]='"performer": { ';
//                    $body[]='"@type" : "Organization",';
//                    $body[]='"name" : "'.$event_detail['club_name'].'"';
//                    if (isset($event_detail['club_url_list'][0])) {
//                        $body[]=',"url" : "'.$event_detail['club_url_list'][0]['url_name'].'"';
//                    }
//                $body[]='},';
//            }
//            $body[]='"description": "Join us for the annual '.$event_detail['event_name'].' road running race in '.$event_detail['town_name'].'.",';
//            if (isset($event_detail['file_list'][1])) {
//                $img_url = base_url("uploads/edition/" . $event_detail['edition_id'] . "/" . $event_detail['file_list'][1][0]['file_name']);
//                $body[]='"image": "'.$img_url.'",';
//            }
//            
//            $sEvent[]='"subEvent": [ ';  
//            
//                foreach ($event_detail['race_list'] as $race) {
//                    if (!empty($race['race_name'])) {
//                        $rn=$race['race_name'];
//                    } else {
//                        $rn=fraceDistance($race['race_distance'])." ".$race['racetype_name'];  
//                    }
//                    if ($race['race_fee_flat']>0) {
//                        $price=$race['race_fee_flat'];
//                    } elseif ($race['race_fee_senior_licenced']>0) {
//                        $price=$race['race_fee_senior_licenced'];
//                    } else {
//                        $price=0;
//                    }                    
//                    if ($race['race_date']>0) {                        
//                        $race_start_date=date("Y-m-d", strtotime($race['race_date']));
//                    } else {
//                        $race_start_date=$start_date;
//                    }
//
//                    $today_date=date("Y-m-d").'T'."00:00:00+02:00";
//                    
//                    $sEvent[]='{';
////                    $sEvent[]='"@type": "SportsEvent",';
//                    $sEvent[]='"name": "'.$rn.'",';
//                    $sEvent[]='"startDate": "'.$race_start_date.'T'.$race['race_time_start'].'+02:00",';
//                    if ($race['race_time_end']>0) {
//                        $sEvent[]='"endDate": "'.$race_start_date.'T'.$race['race_time_end'].'+02:00",';
//                    }
//                    $sEvent[]='"location": { ';
//                        $sEvent[]='"@type": "Place",';
//                        $sEvent[]='"name": "'.$event_detail['edition_address'].'",';
//                        $sEvent[]='"address": { ';
//                            $sEvent[]='"@type": "PostalAddress",';
//                            $sEvent[]='"streetAddress": "'.$event_detail['edition_address'].'",';
//                            $sEvent[]='"addressLocality": "'.$event_detail['town_name'].'",';
//                            $sEvent[]='"addressRegion": "WC",';
//                            $sEvent[]='"addressCountry": "ZA"';
//                        $sEvent[]='}';
//                    if ($price>0) {
//                        $sEvent[]='},';
//                        $sEvent[]='"offers": { ';
//                            $sEvent[]='"@type": "Offer",';
//                            $sEvent[]='"price": "'.$price.'",';
//                            $sEvent[]='"priceCurrency": "ZAR"';
//                            if (isset($event_detail['url_list'][5])) {
//                                $url=$event_detail['url_list'][5][0]['url_name'];
//                                $sEvent[]=',"url": "'.$url.'",';
//                                $sEvent[]='"availability": "http://schema.org/InStock",';
//                                $sEvent[]='"validFrom": "'.$today_date.'"';
//                            } else {
//                                
//                                $sEvent[]=',"availability": "http://schema.org/InStock",';
//                                $sEvent[]='"validFrom": "'.$start_date.'"';
//                            }   
//                        $sEvent[]='},';
//                    } else {
//                        $sEvent[]='},';   
//                    }
//                    // performer
//                    if ($event_detail['club_id']!=8) {
//                        $sEvent[]='"performer": { ';
//                            $sEvent[]='"@type" : "Organization",';
//                            $sEvent[]='"name" : "'.$event_detail['club_name'].'"';
//                            if (isset($event_detail['club_url_list'][0])) {
//                                $sEvent[]=',"url" : "'.$event_detail['club_url_list'][0]['url_name'].'"';
//                            }
//                        $sEvent[]='}';
//                    }
//                    
//                    // loose comma at the end of the last one
//                    if ($race === end($event_detail['race_list'])) {
//                        $sEvent[]='}';
//                    } else {
//                        $sEvent[]='},';
//                    }
//                }
//            
//            $sEvent[]=']';
//            
//        $footer[]='}';
//        $footer[]='</script>';
//        
//        $html_array=array_merge($header,$body,$footer);
//        
////        $html_array=$header+$body+$sEvent+$footer;        
//        $html=implode("\n\r", $html_array);
//        
////        wts($sEvent);
////        die();
////        wts($html_array);
//        echo $html;
////        wts($event_detail);
//        die();
//        
//        return $html;
//    }


}
