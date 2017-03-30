<?php
class Pages extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
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
            $this->view($method, $params = array());
        }


    }

    public function view($page = 'home')
    {
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        if ($page=="home") {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->data_to_header['section']="home";
            $this->data_to_header['title']="Running Event Listing Site";

            // get races for the next 3 months
            $race_summary=$this->event_model->get_event_list_summary($from="date_range",["date_from"=>date("Y-m-d"),"date_to"=>date("Y-m-d",strtotime("+3 months"))]);
            $this->data_to_view['race_list_html']=$this->render_races_accordian_html($race_summary, "Next 3 Months");

            $this->data_to_header['css_to_load']=array(
                "plugins/revo-slider/css/settings.css",
                "plugins/revo-slider/css/layers.css",
                "plugins/revo-slider/css/navigation.css",
                "plugins/cubeportfolio/css/cubeportfolio.min.css",
                );

            $this->data_to_footer['js_to_load']=array(
                "plugins/revo-slider/js/jquery.themepunch.tools.min.js",
                "plugins/revo-slider/js/jquery.themepunch.revolution.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.slideanims.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.layeranimation.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.navigation.min.js",
                "plugins/cubeportfolio/js/jquery.cubeportfolio.min.js",
                );

            $this->data_to_footer['scripts_to_load']=array(
                "scripts/revo-slider/slider-4.js",
                "scripts/events.js",
                );

        } else {
            $this->data_to_header['title'] = ucfirst($page); // Capitalize the first letter
        }

        // wts($this->data_to_footer);
        // exit();

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view('pages/'.$page, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

    
    public function search() {

        $this->data_to_view['search_results']=$this->event_model->get_event_list_summary($from="search",$params=["ss"=>$_GET['query']]);
            
        $this->data_to_header['section']="home";
        $this->data_to_header['title']="Event Search Results";

        $this->data_to_header['css_to_load']=array(
            );

        $this->data_to_footer['js_to_load']=array(
            );

        $this->data_to_footer['scripts_to_load']=array(
            );

        // set crumbs
        $crumbs=[
            "Search Results"=>"",
            "Home"=>"/",
        ];
        // set title bar
        $this->data_to_header["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_header['title'],
                "crumbs"=>$crumbs,
            ]);

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view('pages/search', $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }
    

    public function about() {

        $this->data_to_header['section']="home";
        $this->data_to_header['title']="About Us";

        $this->data_to_header['css_to_load']=array(
            "plugins/cubeportfolio/css/cubeportfolio.min.css",
            );

        $this->data_to_footer['js_to_load']=array(
            "plugins/cubeportfolio/js/jquery.cubeportfolio.min.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/events.js",
            );

        // set crumbs
        $crumbs=[
            "About Us"=>"",
            "Home"=>"/",
        ];
        // set title bar
        $this->data_to_header["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_header['title'],
                "crumbs"=>$crumbs,
            ]);

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view('pages/about', $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function my_404($page = 'home')
    {
        $this->output->set_status_header('404');
        $this->data_to_header['title']="Page not found";

        $crumbs=[
            "404"=>"",
            "Home"=>"/",
        ];

        // set title bar
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>"Page not found",
                "crumbs"=>$crumbs,
            ]);

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view('pages/404', $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function mailer()
    {

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->data_to_header['title'] = "Mailer"; // Capitalize the first letter
        $this->data_to_view['page'] = "mailer";

        // set validation rules
        $this->form_validation->set_rules('dname', 'Name', 'required');
        $this->form_validation->set_rules('demail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('dphone', 'Phone', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('dmsg', 'Comment', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
                $this->data_to_view['form_data']=$_POST;
                $this->data_to_view['email_send']=false;

                $this->load->view($this->header_url, $this->data_to_header);
                $this->load->view('pages/home', $this->data_to_view);
                $this->load->view($this->footer_url, $this->data_to_footer);
        }
        else
        {
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $config['smtp_host'] = 'mail.my-cupcakes.co.za';
            $this->email->initialize($config);

            $this->email->from($this->input->post('demail'), $this->input->post('dname'));
            $this->email->to('johan.havenga@gmail.com');
            $this->email->cc('monicahav@gmail.com');
            // $this->email->bcc('them@their-example.com');

            $this->email->subject('RoadRunning.co.za Comment');

            $msg_arr[]="Name: ".$this->input->post('dname');
            $msg_arr[]="Email: ".$this->input->post('demail');
            $msg_arr[]="Phone: ".$this->input->post('dphone');
            $msg_arr[]="Comment: ".$this->input->post('dmsg');
            $msg=implode("<br>",$msg_arr);

            $this->email->message($msg);

            $this->email->send();

            $this->data_to_view['email_send']=true;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view('pages/home', $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
    }
    
    
    // test for the new race page
    // to be deleted
    public function race() {

        $this->data_to_header['section']="home";
        $this->data_to_header['title']="Tygerberg 30km";

        // set crumbs
        $crumbs=[
            "Tygerberg 30km"=>"",
            "Events"=>"/event/calendar",
            "Home"=>"/",
        ];
        // set title bar
        $this->data_to_header["title_bar"]=$this->render_topbar_html(
            [
                "crumbs"=>$crumbs,
            ]);
        
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
            "http://maps.google.com/maps/api/js?sensor=true",
            "plugins/gmaps/gmaps.js",
//            "scripts/contact.js"
            );
        
        // script to add gmaps to the page
        $this->data_to_footer['scripts_to_display'][]="            
            var PageContact = function() {
            
                var _init = function() {
                    var mapbg = new GMaps({
                            div: '#gmapbg',
                            lat: -33.799011,
                            lng: 18.623957,
                            scrollwheel: false
                    });

                    mapbg.addMarker({
                            lat: -33.799011,
                            lng: 18.623957,
                            title: 'Your Location',
                            infoWindow: {
                                    content: '<h3>Tyger Run/Walk 2017</h3><p>25, Lorem Lis Street, Orange C, California, US</p>'
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
        
        $this->data_to_footer['lat']="3.118823";

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view('pages/race', $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

}
