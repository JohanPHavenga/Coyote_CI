<?php
class Entry extends Admin_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('entry_model');
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
            redirect('/entry/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/entry/view";
        $total_rows=$this->entry_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["entry_list"] = $this->entry_model->get_entry_list($per_page, $page);
        $data['create_link']="/entry/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        $data['entry_list_formatted']=[];
        if ($data["entry_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['entry_list'][0]),2);
            
            foreach ($data['entry_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['entry_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/entry/delete/".$entry['entry_id'], "delete", "danger", "xs");
                $data['entry_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('entry/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('race_model');
        $this->load->model('user_model');
        $this->load->model('club_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' a entry';
        $data['action']=$action;
        $data['form_url']='entry/create/'.$action;      
        
//        $data['js_to_load']=array("select2.js");
//        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
//        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
        
        $data['js_to_load']=array("moment.js", "bootstrap-datetimepicker.min.js");
        $data['js_script_to_load']="$('.entry_time').datetimepicker({format: 'HH:mm:ss'});";
        $data['css_to_load']=array("bootstrap-datetimepicker.min.css");
                
        $data['race_dropdown']=$this->race_model->get_race_dropdown();
        $data['user_dropdown']=$this->user_model->get_user_dropdown();
        $data['club_dropdown']=$this->club_model->get_club_dropdown(); 
        
        if ($action=="edit") 
        {
        $data['entry_detail']=$this->entry_model->get_entry_detail($id);        
        $data['form_url']='entry/create/'.$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('entry_number', 'Race Number', 'required');
        $this->form_validation->set_rules('race_id', 'Race', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a Race"]);
        $this->form_validation->set_rules('user_id', 'User', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a User"]);
        $this->form_validation->set_rules('club_id', 'Club', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a Club"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('entry/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->entry_model->set_entry($action, $id);
            if ($db_write)
            {
                $alert="Entry has been updated";
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
            
            redirect('entry/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('entry/view');  
            die();
        }
        
        $data['title'] = 'Delete a entry';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            $db_del=$this->entry_model->remove_entry($id);
            
            if ($db_del)
            {
                $msg="Entry has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('entry/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('entry/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}