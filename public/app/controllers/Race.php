<?php
class Race extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->model('race_model');
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
            redirect('/race/view', 'refresh');
        }
    }
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=3;
        $url=base_url()."/race/view";
        $total_rows=$this->race_model->record_count();
        $config=fpaginationConfig($url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();  
        
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $data["race_list"] = $this->race_model->get_race_list($per_page, $page);
        $data['create_link']="/race/create";
        $data['title'] = uri_string(); 
        
        // as daar data is
        $data['race_list_formatted']=[];
        if ($data["race_list"]) { 
            $data['heading']=ftableHeading(array_keys($data['race_list'][0]),2);
            
            foreach ($data['race_list'] as $entry):
                $entry[]=fbuttonLink($data['create_link']."/edit/".$entry['race_id'], "edit", "default", "xs");
                $entry[]=fbuttonLink("/race/delete/".$entry['race_id'], "delete", "danger", "xs");
                $data['race_list_formatted'][] = $entry;
            endforeach;
        }
        
        // load view
        $this->load->view('templates/header', $data);
        $this->load->view('race/view', $data);
        $this->load->view('templates/footer');
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('edition_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $data['title'] = ucfirst($action).' an race';
        $data['action']=$action;
        $data['form_url']='race/create/'.$action;      
        
        $data['js_to_load']=array("moment.js", "bootstrap-datetimepicker.min.js");
        $data['js_script_to_load']="$('#datetimepicker1').datetimepicker({format: 'YYYY/MM/DD HH:mm'});";
        $data['css_to_load']=array("bootstrap-datetimepicker.min.css");
        
                
        $data['edition_dropdown']=$this->edition_model->get_edition_dropdown(); 
        $data['status_dropdown']=$this->race_model->get_status_dropdown();
        
        if ($action=="edit") 
        {
        $data['race_detail']=$this->race_model->get_race_detail($id);        
        $data['form_url']='race/create/'.$action."/".$id;
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
            $this->load->view('templates/header', $data);
            $this->load->view('race/create', $data);
            $this->load->view('templates/footer');

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
            
            redirect('race/view');  
        }
    }
    
    
    public function delete($id=0, $confirm=false) {
        
        if ($id==0) {
            $this->session->set_flashdata('message', 'Cannot delete record');
            redirect('race/view');  
            die();
        }
        
        $data['title'] = 'Delete an race';
        $data['id']=$id;
        
        
        if ($confirm=='confirm') 
        {
            
            $db_del=$this->race_model->remove_race($id);
            
            if ($db_del)
            {
                $msg="Race has been deleted";
            }
            else 
            {
                $msg="Error committing to the database";
            }

            $this->session->set_flashdata('alert', $msg);
            redirect('race/view');          
        }
        else 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('race/delete', $data);
            $this->load->view('templates/footer');
        
        }
    }        
        
        
    
}