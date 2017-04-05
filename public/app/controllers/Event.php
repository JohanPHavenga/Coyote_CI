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

        $this->data_to_header['title']="Events Calendar";

        // get race info
        $upcoming_race_summary = $this->event_model->get_event_list_summary($from="date_range",$params=["date_from"=>date("Y-m-d")]);
        $past_race_summary = $this->event_model->get_event_list_summary($from="date_range",$params=["date_from"=>"2000-01-01","date_to"=>date("Y-m-d"),"sort"=>"DESC"]);
        // render html
        $this->data_to_view['upcoming_race_list_html']=$this->render_races_accordian_html($upcoming_race_summary);
        $this->data_to_view['past_race_list_html']=$this->render_races_accordian_html($past_race_summary);


        $this->data_to_header['css_to_load']=array();
        $this->data_to_footer['js_to_load']=array();
        $this->data_to_footer['scripts_to_load']=array();

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
        // as daar nie 'n edition_name deurgestuur word nie
        if ($edition_name_encoded=="index") { redirect("/event/calendar");  }

        $edition_name=urldecode($edition_name_encoded);

        $this->load->model('edition_model');
        $this->load->model('race_model');

        $edition_id=$this->edition_model->get_edition_id_from_name($edition_name);

        if (!$edition_id)
        {
            // if name cannot be matched to an edition
            $this->session->set_flashdata([
                'alert'=>"Error trying to load the event details. Please try selecting it again from the list below.",
                'status'=>"danger",
                ]);
            redirect("/event/calendar");
        }
        else
        {
            $this->data_to_header['title']=$edition_name;
        }

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
        $this->data_to_view['event_detail']['summary']=$this->event_model->get_event_list_summary(
                "id",
                ["event_id"=>$this->data_to_view['event_detail']['event_id']]
                );
        
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
        
        $map_long=$this->data_to_view['event_detail']['longitude_num'];
        
         // script to add gmaps to the page
        $this->data_to_footer['scripts_to_display'][]="            
            var PageContact = function() {
            
                var _init = function() {
                    var mapbg = new GMaps({
                            div: '#gmapbg',
                            lat: ".$this->data_to_view['event_detail']['latitude_num'].",
                            lng: ".$map_long.",
                            scrollwheel: false
                            
                    });

                    mapbg.addMarker({
                            lat: ".$this->data_to_view['event_detail']['latitude_num'].",
                            lng: ".$this->data_to_view['event_detail']['longitude_num'].",
                            title: '". html_escape($this->data_to_view['event_detail']['edition_address'])."',
                            infoWindow: {
                                    content: '<h3>".html_escape($this->data_to_view['event_detail']['edition_name'])."</h3><p>".html_escape($this->data_to_view['event_detail']['edition_address'])."</p>'
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

        // check if events is in the past
        $this->data_to_view['notice']='';
        if ($this->data_to_view['event_detail']['edition_date'] < date("Y-m-d")) {
            $this->data_to_view['notice']="<div class='alert alert-warning' role='alert'>Please note that you are viewing an event that has happend in the past.</div>";
        }


        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/event/detail", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

    }
    
    
    public function detail_old($edition_name_encoded) {
        // as daar nie 'n edition_name deurgestuur word nie
        if ($edition_name_encoded=="index") { redirect("/event/calendar");  }

        $edition_name=urldecode($edition_name_encoded);

        $this->load->model('edition_model');
        $this->load->model('race_model');

        $edition_id=$this->edition_model->get_edition_id_from_name($edition_name);

        if (!$edition_id)
        {
            // if name cannot be matched to an edition
            $this->session->set_flashdata([
                'alert'=>"Error trying to load the event details. Please try selecting it again from the list below.",
                'status'=>"danger",
                ]);
            redirect("/event/calendar");
        }
        else
        {
            $this->data_to_header['title']=$edition_name;
        }

        // set data to view
        $this->data_to_header['css_to_load']=array();
        $this->data_to_footer['js_to_load']=array();
        $this->data_to_footer['scripts_to_load']=array();

        // get event details
        $this->data_to_view['event_detail']=$this->edition_model->get_edition_detail_full($edition_id);
        $this->data_to_view['event_detail']['race_list']=$this->race_model->get_race_list(100,0,$edition_id);

        // check if events is in the past
        $this->data_to_view['notice']='';
        if ($this->data_to_view['event_detail']['edition_date'] < date("Y-m-d")) {
            $this->data_to_view['notice']="<div class='alert alert-warning' role='alert'>Please note that you are viewing an event that has happend in the past.</div>";
        }

        $crumbs=[
            "Details"=>"",
            "Events"=>"/event/calendar",
            "Home"=>"/",
        ];

        // set title bar
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_view['event_detail']['event_name'],
                "sub_title"=>date("Y",strtotime($this->data_to_view['event_detail']['edition_date']))." Edition",
                "crumbs"=>$crumbs,
            ]);


        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/event/detail", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

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



}
