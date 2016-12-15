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

        $this->load->helper('form');
        $this->load->library('form_validation');


        if ($page=="home") {
            $this->data_to_header['section']="home";
            $this->data_to_header['title']="Running Event Listing Site";
            $this->data_to_view['race_summary']=$this->get_event_list_summary();

            $this->data_to_header['css_to_load']=array(
                "plugins/revo-slider/css/settings.css",
                "plugins/revo-slider/css/layers.css",
                "plugins/revo-slider/css/navigation.css",

                );

            $this->data_to_footer['js_to_load']=array(
                "plugins/revo-slider/js/jquery.themepunch.tools.min.js",
                "plugins/revo-slider/js/jquery.themepunch.revolution.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.slideanims.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.layeranimation.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.navigation.min.js",
                "plugins/revo-slider/js/extensions/revolution.extension.video.min.js",
                );

            $this->data_to_footer['scripts_to_load']=array(
                "scripts/revo-slider/slider-4.js",
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


    private function get_event_list_summary()
    {
        return $this->event_model->get_event_list_summary(date("Y-m-d"));
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

}
