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
        
        $this->data_to_view['title'] = uri_string(); 
        $this->data_to_view['list'] = $this->province_model->get_province_list($id);
        // as daar data is
        if ($this->data_to_view["list"]) { 
            $this->data_to_view['heading']=ftableHeading(array_keys($this->data_to_view['list'][key($this->data_to_view['list'])]));
        }
        
        $this->load->library('table'); 
        
        $this->load->view($this->header_url, $this->data_to_view);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_view);
    }
    
}