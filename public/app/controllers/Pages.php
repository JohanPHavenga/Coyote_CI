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
            $data['title']="Running Event Listing Site";
            $data['race_summary']=$this->formualte_event_list_summary();
        } else {
            $data['title'] = ucfirst($page); // Capitalize the first letter
        }

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    private function formualte_event_list_summary()
    {
        // setup fields needed for summary call
        $field_arr=["event_name","editions.edition_id","edition_name","edition_date","town_name","race_distance","race_time"];
        return $this->event_model->get_event_list_summary($field_arr, date("Y-m-d"));
    }

    public function mailer()
    {

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Mailer"; // Capitalize the first letter
        $data['page'] = "mailer";

        // set validation rules
        $this->form_validation->set_rules('dname', 'Name', 'required');
        $this->form_validation->set_rules('demail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('dphone', 'Phone', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('dmsg', 'Comment', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
                $data['form_data']=$_POST;
                $data['email_send']=false;

                $this->load->view('templates/header', $data);
                $this->load->view('pages/home', $data);
                $this->load->view('templates/footer', $data);
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

            $data['email_send']=true;
            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('templates/footer', $data);
        }
    }

}
