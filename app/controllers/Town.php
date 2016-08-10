<?php
class Town extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('town_model');
            
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
        // load helpers / libraries
        $this->load->helper('formulate');
        $this->load->library('table'); 
        
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/town/view";
        $total_rows=$this->town_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["town_list"] = $this->town_model->get_town_list($per_page, $page);        
        
        if ($data["town_list"]) {  
            $data['heading']=ftableHeading(array_keys($data['town_list'][0]));
        }
        
        $data['title'] = uri_string();  
        
         
        
        // load view;
        $this->load->view('templates/header', $data);
        $this->load->view('town/view', $data);
        $this->load->view('templates/footer');
    }
    
}