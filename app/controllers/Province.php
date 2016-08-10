<?php
class Province extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('province_model');
            
    }
    
    public function _remap($method, $params = array())
    {        
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }   
        else 
        {
            $this->view();
        }
    }
    
    public function view($id = FALSE) {
        
        $data['province_list'] = $this->province_model->get_province_list($id);
        $data['heading']= array_keys($data['province_list'][0]);
        $data['title'] = uri_string(); 
        
        $this->load->library('table'); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('province/view', $data);
        $this->load->view('templates/footer');
    }
    
}