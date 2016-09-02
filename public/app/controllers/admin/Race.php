<?php
class Race extends Admin_Controller {

    private $return_url="/admin/race";
    private $create_url="/admin/race/create";
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('race_model');
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
        $total_rows=$this->race_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();          
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        
        $data["list"] = $this->race_model->get_race_list($per_page, $page);
        $data['create_link']=$this->create_url;
        $data['delete_arr']=["controller"=>"race","id_field"=>"race_id"];
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
        $this->load->model('edition_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = uri_string();  
        $data['action']=$action;
        $data['form_url']=$this->create_url."/".$action;      
        
        $data['js_to_load']=array("moment.js", "bootstrap-datetimepicker.min.js");
        $data['js_script_to_load']="$('#datetimepicker1').datetimepicker({format: 'YYYY/MM/DD HH:mm'});";
        $data['css_to_load']=array("bootstrap-datetimepicker.min.css");
        
                
        $data['edition_dropdown']=$this->edition_model->get_edition_dropdown(); 
        $data['status_dropdown']=$this->race_model->get_status_dropdown();
        
        if ($action=="edit") 
        {
        $data['race_detail']=$this->race_model->get_race_detail($id);    
        $data['form_url']=$this->create_url."/".$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('race_name', 'Race Name', 'required');
        $this->form_validation->set_rules('race_distance', 'Race distance', 'required|numeric');
        $this->form_validation->set_rules('race_date', 'Race date', 'required');
        $this->form_validation->set_rules('race_status', 'Race status', 'required');
        $this->form_validation->set_rules('edition_id', 'Edition', 'required|numeric|greater_than[0]',["greater_than"=>"Please select an edition"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view($this->header_url, $data);
            $this->load->view($this->create_url, $data);
            $this->load->view($this->footer_url);
        }
        else
        {
            $db_write=$this->race_model->set_race($action, $id);
            if ($db_write)
            {
                $alert="Race has been updated";
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
        
        $id=$this->encryption->decrypt($this->input->post('race_id'));
        
        if ($id==0) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);  
            die();
        }
                
        if ($confirm=='confirm') 
        {
            $db_del=$this->race_model->remove_race($id);            
            if ($db_del)
            {
                $msg="Race has been deleted";
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