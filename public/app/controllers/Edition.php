<?php
class Edition extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('edition_model');
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
            redirect('/edition/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/edition/view";
        $total_rows=$this->edition_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["edition_list"] = $this->edition_model->get_edition_list($per_page, $page);
        $data['create_link']="/edition/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        $data['edition_list_formatted']=[];
        if ($data["edition_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['edition_list'][0]),2);
            
            foreach ($data['edition_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['edition_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/edition/delete/".$entry['edition_id'], "delete", "danger", "xs");
                $data['edition_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('edition/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('sponsor_model');
        $this->load->model('event_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' an edition';
        $data['action']=$action;
        $data['form_url']='edition/create/'.$action;      
        
        $data['js_to_load']=array("select2.js");
        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $data['sponsor_dropdown']=$this->sponsor_model->get_sponsor_dropdown(); 
        $data['event_dropdown']=$this->event_model->get_event_dropdown(); 
        $data['status_dropdown']=$this->event_model->get_status_dropdown();
        
        if ($action=="edit") 
        {
        $data['edition_detail']=$this->edition_model->get_edition_detail($id);        
        $data['form_url']='edition/create/'.$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('edition_name', 'Edition Name', 'required');
        $this->form_validation->set_rules('edition_status', 'Edition status', 'required');
        $this->form_validation->set_rules('edition_date', 'Edition date', 'required');
        $this->form_validation->set_rules('event_id', 'Event', 'required|numeric|greater_than[0]',["greater_than"=>"Please select an event"]);
        $this->form_validation->set_rules('sponsor_id', 'Sponsor', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a sponsort"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('edition/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->edition_model->set_edition($action, $id);
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
            
            redirect('edition/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('edition/view');  
            die();
        }
        
        $data['title'] = 'Delete an edition';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            
            $db_del=$this->edition_model->remove_edition($id);
            
            if ($db_del)
            {
                $msg="Event has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('edition/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('edition/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}