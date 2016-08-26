<?php
class Province extends Admin_Controller {    
    
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
        
        $data['title'] = uri_string(); 
        $data['list'] = $this->province_model->get_province_list($id);
        // as daar data is
        if ($data["list"]) { 
            $data['heading']=ftableHeading(array_keys($data['list'][key($data['list'])]));
        }
        
        $this->load->library('table'); 
        
        $this->load->view($this->header_url, $data);
        $this->load->view($this->view_url, $data);
        $this->load->view($this->footer_url);
    }
    
}