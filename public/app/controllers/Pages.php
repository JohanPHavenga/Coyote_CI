<?php
class Pages extends Frontend_Controller {

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

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['page'] = $page;

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function mailer() {

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = "Mailer"; // Capitalize the first letter
        $data['page'] = "mailer";

        // set validation rules
        $this->form_validation->set_rules('dname', 'Name', 'required');
        $this->form_validation->set_rules('demail', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('dphone', 'Phone', 'alpha_numeric_spaces');
        $this->form_validation->set_rules('dmsg', 'Comment', 'required|alpha_numeric_spaces');

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
<<<<<<< HEAD
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $this->email->initialize($config);

            $this->email->from($this->input->post('ename'), $this->input->post('demail'));
            $this->email->to('johan.havenga@gmail.com');
            // $this->email->cc('another@another-example.com');
            // $this->email->bcc('them@their-example.com');

            $this->email->subject('RoadRunning Comment');

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
            // $this->input->post('event_name')
=======
>>>>>>> refs/heads/Rework-to-Admin2
        }
    }

}
