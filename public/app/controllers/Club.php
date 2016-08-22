<?php
class Club extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('club_model');
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
            redirect('/club/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/club/view";
        $total_rows=$this->club_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["club_list"] = $this->club_model->get_club_list($per_page, $page);
        $data['create_link']="/club/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        if ($data["club_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['club_list'][0]),2);
            
            foreach ($data['club_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['club_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/club/delete/".$entry['club_id'], "delete", "danger", "xs");
                $data['club_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('club/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('town_model');
        $this->load->model('sponsor_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' a club';
        $data['action']=$action;
        $data['form_url']='club/create/'.$action;      
        
        $data['js_to_load']=array("select2.js");
        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $data['status_dropdown']=$this->club_model->get_status_dropdown();
        $data['town_dropdown']=$this->town_model->get_town_dropdown();
        $data['sponsor_dropdown']=$this->sponsor_model->get_sponsor_dropdown(); 
        
        if ($action=="edit") 
        {
        $data['club_detail']=$this->club_model->get_club_detail($id);        
        $data['form_url']='club/create/'.$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('club_name', 'Club Name', 'required');
        $this->form_validation->set_rules('club_status', 'Club Status', 'required');
        $this->form_validation->set_rules('town_id', 'Town', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a town"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('club/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->club_model->set_club($action, $id);
            if ($db_write)
            {
                $alert="Club has been updated";
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
            
            redirect('club/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('club/view');  
            die();
        }
        
        $data['title'] = 'Delete a club';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            $db_del=$this->club_model->remove_club($id);
            
            if ($db_del)
            {
                $msg="Club has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('club/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('club/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}