<?php
class Town extends Admin_Controller {

    private $return_url="/admin/town/view";

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
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=4;
        $total_rows=$this->town_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links(); 
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["list"] = $this->town_model->get_town_list($per_page, $page);        
        $data['title'] = uri_string(); 
        
        // as daar data is
        if ($data["list"]) {  
            $data['heading']=ftableHeading(array_keys($data['list'][key($data['list'])]));
        }
        
        // load view;
        $this->load->view($this->header_url, $data);
        $this->load->view($this->view_url, $data);
        $this->load->view($this->footer_url);
    }
    
}