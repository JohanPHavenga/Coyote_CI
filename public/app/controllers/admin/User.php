<?php
class User extends Admin_Controller {

    private $return_url="/admin/user";
    private $create_url="/admin/user/create";
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        
        $this->data_to_view['side_menu_arr']=[
            "home"=>[
                "url"=>"home",
                "text"=>"Overview",
                "icon"=>"home",
                "class"=>"",
                ],
            "view"=>[
                "url"=>"view",
                "text"=>"List",
                "icon"=>"info",
                "class"=>"",
                ],
            "import"=>[
                "url"=>"import",
                "text"=>"Import",
                "icon"=>"cloud-upload",
                "class"=>"",
                ],            
        ];
    }
    
    public function _remap($method, $params = array())
    {        
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }   
        else 
        {
            $this->home($params);
        }
    }
    
    public function home() {
        $this->data_to_view['title'] = "Users"; 
        $this->data_to_view['side_menu_arr']['home']['class']="active";
        
         // load view
        $this->load->view($this->header_url, $this->data_to_view);
        $this->load->view("/admin/user/home", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_view);
    }
    
    public function import($submit=NULL) {
        
        $this->load->helper('form');
        $this->load->library('upload');
        
        $this->data_to_view['title'] = "Import Users"; 
        $this->data_to_view['form_url']="/admin/user/import/submit"; 
        $this->data_to_view['side_menu_arr']['import']['class']="active"; 
        
        $config['upload_path']          = $this->upload_path;
        $config['allowed_types']        = 'csv';
        $config['max_size']             = 8192;
        $this->upload->initialize($config);
        
        if ( ! $this->upload->do_upload('userfile'))
        {
            if (!empty($submit)) 
            {
                $this->data_to_view['error'] = $this->upload->display_errors();
            }
            
            $this->load->view($this->header_url, $this->data_to_view);
            $this->load->view("/admin/user/import", $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_view);
        }
        else 
        {
            // TO DO. WRITE a CSV parser
            $this->data_to_view['file_meta_data'] = $this->upload->data();
            $this->data_to_view['file_data'] = $this->csv_handler($this->upload->data('full_path'));                
            
            $this->load->view($this->header_url, $this->data_to_view);
            $this->load->view("/admin/user/import_success", $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_view);
        }

    }
    
    public function import_done() {
        // load helpers / libraries
        $this->load->helper('form');
        wts($config);

        $this->data_to_view['title'] = "Import Complete"; 
        $this->data_to_view['side_menu_arr']['import']['class']="active";
        
        if ( ! $this->upload->do_upload('userfile'))
        {
                $this->data_to_view['form_url']="/admin/user/import_done";   
                $this->data_to_view['error'] = $this->upload->display_errors();
                
//                wts($this->upload->data);

                $this->load->view($this->header_url, $this->data_to_view);
                $this->load->view('/admin/user/import', $this->data_to_view);
                $this->load->view($this->footer_url, $this->data_to_view);
        }
        else
        {
                $this->data_to_view['upload_data'] = $this->upload->data();

                $this->load->view($this->header_url, $this->data_to_view);
                $this->load->view('/admin/user/import_success', $this->data_to_view);
                $this->load->view($this->footer_url, $this->data_to_view);
        }

    }
    
   
    
    public function view() {  
        // load helpers / libraries
        $this->load->library('table'); 
        
        // pagination      
        // pagination config
        $per_page=50;
        $uri_segment=4;
        $total_rows=$this->user_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);                
        
        // pagination init
        $this->load->library("pagination");        
        $this->pagination->initialize($config);
        $this->data_to_view["pagination"]=$this->pagination->create_links();  
        
        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        
        $this->data_to_view["list"] = $this->user_model->get_user_list($per_page, $page);
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_view['delete_arr']=["controller"=>"user","id_field"=>"user_id"];
        $this->data_to_view['title'] = uri_string(); 
        
        // as daar data is
        if ($this->data_to_view["list"]) { 
             $this->data_to_view['heading']=ftableHeading(array_keys($this->data_to_view['list'][key($this->data_to_view['list'])]),2);
        }
        
        // load view
        $this->load->view($this->header_url, $this->data_to_view);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url);
    }
    
    
    public function create($action, $id=0) {  
        // additional models
        $this->load->model('club_model');
        $this->load->model('role_model');
            
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_view['title'] = uri_string();  
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;     
        
//        $this->data_to_view['js_to_load']=array("select2.js");
//        $this->data_to_view['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
//        $this->data_to_view['css_to_load']=array("select2.css","select2-bootstrap.css");
                
        $this->data_to_view['club_dropdown']=$this->club_model->get_club_dropdown(); 
        $this->data_to_view['role_dropdown']=$this->role_model->get_role_dropdown(); 
        
        if ($action=="edit") 
        {
        $this->data_to_view['user_detail']=$this->user_model->get_user_detail($id);   
        $this->data_to_view['user_detail']['role_id']=$this->role_model->get_role_list_per_user($id);   
        $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
        }
        
        // set validation rules
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('user_surname', 'User Surame', 'required');
        $this->form_validation->set_rules('club_id', 'Club', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a club for the user"]);
        $this->form_validation->set_rules('role_id[]', 'Role', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            if ($action=="add") { $this->data_to_view['user_detail']['role_id'][]=2; }
            $this->data_to_view['return_url']=$this->return_url;
            $this->load->view($this->header_url, $this->data_to_view);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_view);
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
            
            redirect($this->return_url);  
        }
    }
    
    
    public function delete($confirm=false) {
        
        $id=$this->encryption->decrypt($this->input->post('user_id'));
        
        if ($id==0) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);  
            die();
        }
                
        if ($confirm=='confirm') 
        {
            $db_del=$this->user_model->remove_user($id);            
            if ($db_del)
            {
                $msg="Event has been deleted";
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