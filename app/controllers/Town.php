<?php
class Town extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('town_model');
            $this->load->library("pagination");
            
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
        $config=set_pagenation_config("town",$this->town_model->record_count());
        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["town_list"] = $this->town_model->get_town_list($config["per_page"], $page);
        
        
        $data["links"] = $this->pagination->create_links();        
        $data['heading']= array_keys($data['town_list'][0]);
        $data['title'] = uri_string(); 
        
        $this->load->library('table'); 
        
        $this->load->view('templates/header', $data);
        $this->load->view('town/view', $data);
        $this->load->view('templates/footer');
    }
    
}