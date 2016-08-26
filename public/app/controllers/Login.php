<?php
class Login extends Frontend_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
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
            $this->userlogin($method, $params = array());
        }
    } 
    
    public function userlogin()
    {
        
        $data['title'] = "User Login";
        $data['form_url'] = '/login/userlogin/submit';  
        $data['return_url'] = '/login';
        
        $data['css_to_load']=array("login.css");
        
        // set validation rules
        $this->form_validation->set_rules('user_username', 'Username', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('login/userlogin', $data);
            $this->load->view('templates/footer', $data);
        }
        else
        {
            $check_login=false;
            if ($check_login)
            {
                $alert="Login successfull";
                $status="success";
            }
            else 
            {
                $alert="Login Failed";
                $status="danger";
            }
            
            $this->session->set_flashdata([
                'alert'=>$alert,
                'status'=>$status,
                ]);
            
            redirect($data['return_url']);  
        }

    }
    
    public function admin()
    {

        $data['title'] = "Admin Login";

        $this->load->view('templates/header', $data);
        $this->load->view('login/adminlogin', $data);
        $this->load->view('templates/footer', $data);
    }
        
}