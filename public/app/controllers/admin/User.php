<?php
class User extends Admin_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('user_model');
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
            redirect('/user/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/user/view";
        $total_rows=$this->user_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["user_list"] = $this->user_model->get_user_list($per_page, $page);
        $data['create_link']="/user/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        $data['user_list_formatted']=[];
        if ($data["user_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['user_list'][0]),2);
            
            foreach ($data['user_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['user_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/user/delete/".$entry['user_id'], "delete", "danger", "xs");
                $data['user_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('user/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('club_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' an user';
        $data['action']=$action;
        $data['form_url']='user/create/'.$action;      
        
//        $data['js_to_load']=array("select2.js");
//        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
//        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $data['club_dropdown']=$this->club_model->get_club_dropdown(); 
        
        if ($action=="edit") 
        {
        $data['user_detail']=$this->user_model->get_user_detail($id);        
        $data['form_url']='user/create/'.$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('user_surname', 'User Surame', 'required');
        $this->form_validation->set_rules('club_id', 'Club', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a club for the user"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('user/create', $data);
            $this->load->view('templates/footer');

        }
        else
        {
            $db_write=$this->user_model->set_user($action, $id);
            if ($db_write)
            {
                $alert="User has been updated";
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
            
            redirect('user/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('user/view');  
            die();
        }
        
        $data['title'] = 'Delete an user';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            
            $db_del=$this->user_model->remove_user($id);
            
            if ($db_del)
            {
                $msg="User has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('user/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('user/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}