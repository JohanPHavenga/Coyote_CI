<?php
class Event extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('event_model');
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
            redirect('/event/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/event/view";
        $total_rows=$this->event_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["event_list"] = $this->event_model->get_event_list($per_page, $page);
        $data['create_link']="/event/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        if ($data["event_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['event_list'][0]),2);
            
            foreach ($data['event_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['event_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/event/delete/".$entry['event_id'], "delete", "danger", "xs");
                $data['event_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('event/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('town_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' an event';
        $data['action']=$action;
        $data['form_url']='event/create/'.$action;        
                
        $data['town_dropdown']=$this->town_model->get_town_dropdown();
        
        if ($action=="edit") 
        {
        $data['event_detail']=$this->event_model->get_event_detail($id);        
        $data['form_url']='event/create/'.$action."/".$id;
        }
        
        // set form
        $this->form_validation->set_rules('event_name', 'Event Name', 'required');
        $this->form_validation->set_rules('town_id', 'Town', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a town"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('event/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->event_model->set_event($action, $id);
            if ($db_write)
            {
                $alert="Event has been updated";
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
            
            redirect('event/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('event/view');  
            die();
        }
        
        $data['title'] = 'Delete an event';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            $db_del=$this->db->delete('events', array('event_id' => $id));
            if ($db_del)
            {
                $msg="Event has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('message', $msg);
            redirect('event/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('event/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}