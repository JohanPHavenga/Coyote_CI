<?php
class Sponsor extends Admin_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('sponsor_model');
            $this->load->helper('formulate');
            
    }
    
    public function _remap($method, $params = array())
    {        
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }   
        else 
        {
//            $this->view();
            redirect('/sponsor/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/sponsor/view";
        $total_rows=$this->sponsor_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["sponsor_list"] = $this->sponsor_model->get_sponsor_list($per_page, $page);
        $data['create_link']="/sponsor/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        if ($data["sponsor_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['sponsor_list'][0]),2);
            
            foreach ($data['sponsor_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['sponsor_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/sponsor/delete/".$entry['sponsor_id'], "delete", "danger", "xs");
                $data['sponsor_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('sponsor/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('town_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' a sponsor';
        $data['action']=$action;
        $data['form_url']='sponsor/create/'.$action;      
        
        $data['js_to_load']=array("select2.js");
        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $data['status_dropdown']=$this->sponsor_model->get_status_dropdown();
        $data['town_dropdown']=$this->town_model->get_town_dropdown();
        
        if ($action=="edit") 
        {
        $data['sponsor_detail']=$this->sponsor_model->get_sponsor_detail($id);        
        $data['form_url']='sponsor/create/'.$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('sponsor_name', 'Sponsor Name', 'required');
        $this->form_validation->set_rules('sponsor_status', 'Sponsor Status', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('sponsor/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->sponsor_model->set_sponsor($action, $id);
            if ($db_write)
            {
                $alert="Sponsor has been updated";
                $status="success";
            }
            else 
            {
                $alert="Error committing to the database";
                $status="danger";
            }
            
            $this->session->set_flashdata([
                'alert'=>$alert,
                'status'=>$status,
                ]);
            
            redirect('sponsor/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('sponsor/view');  
            die();
        }
        
        $data['title'] = 'Delete a sponsor';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            $db_del=$this->sponsor_model->remove_sponsor($id);
            
            if ($db_del)
            {
                $msg="Sponsor has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('sponsor/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('sponsor/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}