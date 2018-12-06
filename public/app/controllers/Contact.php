<?php
class Contact extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('edition_model');
        $this->data_to_header['section']="contact";
    }

    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->view($method, $params);
        }
    }

    public function view()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data_to_header['title'] = "Contact Us";

        // set validation rules
        $this->form_validation->set_rules('dname', 'Name', 'required');
        $this->form_validation->set_rules('demail', 'Email', 'required|valid_email');
//        $this->form_validation->set_rules('dphone', 'Phone', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('dmsg', 'Comment', 'required');
        
        // set title bar
        $this->data_to_header["title_bar"]=$this->render_topbar_html(
            [
                "crumbs"=>["Contact Us"=>"/contact","Home"=>"/"],
            ]);
        
        // get edition dropdown
        $this->data_to_view['edition_dropdown']=$this->edition_model->get_edition_dropdown(true);   

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->data_to_view['form_data']=$_POST;
            $this->data_to_view['email_send']=false;
            if (empty($this->data_to_view['form_data']['dto'])) {
                $this->data_to_view['form_data']['dto']="info@roadrunning.co.za";
            }

            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view('contact/view', $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
        else
        {
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $config['smtp_host'] = 'dandelion.aserv.co.za';
            $config['smtp_port'] = '465';
//            $config['bcc_batch_mode'] = true;
            $this->email->initialize($config);

            $this->email->from($this->input->post('demail'), $this->input->post('dname'));
            if ($this->input->post('dto')) {
                $this->email->to($this->input->post('dto'));
            } else {
                $this->email->to('info@roadrunning.co.za');
            }
            // add BCC
            $this->email->bcc($this->input->post('demail'),'info@roadrunning.co.za');

            $this->email->subject('RoadRunning.co.za enquiry: '.$this->input->post('devent'));

            $msg_arr[]="Name: ".$this->input->post('dname');
            $msg_arr[]="Email: ".$this->input->post('demail');
            $msg_arr[]="Event: ".$this->input->post('devent');
            $msg_arr[]="Comment: ".$this->input->post('dmsg');
            $msg=implode("<br>",$msg_arr);

            $this->email->message($msg);

//            wts($this->email);
//            wts($this->input->post());
//            die();
            $this->email->send();

            $this->data_to_view['email_send']=true;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view('contact/view', $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
    }
}
