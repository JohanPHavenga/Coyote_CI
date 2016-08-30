<?php
class Edition extends Admin_Controller {

    private $return_url="/admin/edition/view";
    private $create_url="/admin/edition/create";
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('edition_model');            
    }
    
    public function _remap($method, $params = array())
    {        
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }   
        else 
        {
            $this->view($params);
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=4;
        $total_rows=$this->edition_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        
        $data["list"] = $this->edition_model->get_edition_list($per_page, $page);
        $data['create_link']=$this->create_url;
        $data['delete_arr']=["controller"=>"edition","id_field"=>"edition_id"];
        $data['title'] = uri_string(); 
        
        // as daar data is
        if ($data["list"]) { 
            $data['heading']=ftableHeading(array_keys($data['list'][key($data['list'])]),2);
        }
        
        // load view
        $this->load->view($this->header_url, $data);
        $this->load->view($this->view_url, $data);
        $this->load->view($this->footer_url);
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('sponsor_model');
        $this->load->model('event_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = uri_string();  
        $data['action']=$action;
        $data['form_url']=$this->create_url."/".$action;       
        
//        $data['js_to_load']=array("select2.js");
//        $data['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
//        $data['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $data['sponsor_dropdown']=$this->sponsor_model->get_sponsor_dropdown(); 
        $data['event_dropdown']=$this->event_model->get_event_dropdown(); 
        $data['status_dropdown']=$this->event_model->get_status_dropdown();
        
        if ($action=="edit") 
        {
        $data['edition_detail']=$this->edition_model->get_edition_detail($id);         
        $data['form_url']=$this->create_url."/".$action."/".$id;
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
            $this->load->view($this->header_url, $data);
            $this->load->view($this->create_url, $data);
            $this->load->view($this->footer_url);
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
            
            redirect($this->return_url);  
        }
    }
    
    
    public function delete($confirm=false) {
        
        $id=$this->encryption->decrypt($this->input->post('edition_id'));
        
        if ($id==0) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);  
            die();
        }
                
        if ($confirm=='confirm') 
        {
            $db_del=$this->edition_model->remove_edition($id);            
            if ($db_del)
            {
                $msg="Edition has been deleted";
                $status="success";
            }
            else 
            {
                $msg="Error committing to the database ID:'.$id";
                $status="danger";
            }

            $this->session->set_flashdata('alert', $msg);
            $this->session->set_flashdata('status', $status);
            redirect($this->return_url);                
        }
        else 
        {
            $this->session->set_flashdata('alert', 'Cannot delete record');
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);  
            die();
        }
    }        
        
        
    
}