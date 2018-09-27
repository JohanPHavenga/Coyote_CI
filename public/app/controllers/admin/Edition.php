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
        // unset dashboard return url session
        $this->session->unset_userdata('dashboard_return_url');
        
        $this->data_to_view["edition_data"] = $this->edition_model->get_edition_list();
        $this->data_to_view['heading']=["ID","Edition Name","Status","Edition Date","Event Name","Actions"];
        
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_header['title'] = "List of Editions";
        $this->data_to_header['crumbs'] =
                   [
                   "Home"=>"/admin",
                   "Editions"=>"/admin/edition",
                   "List"=>"",
                   ];
        
        $this->data_to_header['page_action_list']=
                [
                    [
                        "name"=>"Add Edition",
                        "icon"=>"calendar",
                        "uri"=>"edition/create/add",
                    ],
                ];
        
        $this->data_to_view['url']=$this->url_disect();
        
        $this->data_to_header['css_to_load']=array(
            "plugins/datatables/datatables.min.css",
            "plugins/datatables/plugins/bootstrap/datatables.bootstrap.css",
            );

        $this->data_to_footer['js_to_load']=array(
            "scripts/admin/datatable.js",
            "plugins/datatables/datatables.min.js",
            "plugins/datatables/plugins/bootstrap/datatables.bootstrap.js",
            "plugins/bootstrap-confirmation/bootstrap-confirmation.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/admin/table-datatables-managed.js",
            );

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/admin/edition/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function create($action, $id=0) {
        // additional models
        $this->load->model('sponsor_model');
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('race_model');
        $this->load->model('asamember_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('table');

        // set return url to session should it exists
        if ($this->session->has_userdata('dashboard_return_url')) {
            $this->return_url = $this->session->dashboard_return_url;
        }

        // set data
        $this->data_to_header['title'] = "Edition Input Page";
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_header['css_to_load']=array(
            "plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            "plugins/bootstrap-summernote/summernote.css",
            );

        $this->data_to_footer['js_to_load']=array(
            "plugins/moment.min.js",
            "plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "plugins/bootstrap-summernote/summernote.min.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/admin/components-date-time-pickers.js",
            "scripts/admin/components-editors.js",
            );

        $this->data_to_view['contact_dropdown']=$this->user_model->get_user_dropdown(3);
        $this->data_to_view['sponsor_dropdown']=$this->sponsor_model->get_sponsor_dropdown();
        $this->data_to_view['event_dropdown']=$this->event_model->get_event_dropdown();
        $this->data_to_view['status_dropdown']=$this->event_model->get_status_dropdown();
        $this->data_to_view['asamember_list']=$this->asamember_model->get_asamember_list(true);

        if ($action=="edit")
        {            
            $this->data_to_view['race_list']=$this->race_model->get_race_list(NULL, NULL, $id);
            $this->data_to_view['edition_detail']=$this->edition_model->get_edition_detail($id);
            $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
            // set edition_return_url for races
            $this->session->set_userdata('edition_return_url', "/".uri_string());     
        } else {
            $this->data_to_view['edition_detail']['edition_status']=1;
        }
        
        // set default contact
        if (empty($this->data_to_view['edition_detail']['user_id'])) { $this->data_to_view['edition_detail']['user_id']=60; }        
        // set default sponsor
        if (empty($this->data_to_view['edition_detail']['sponsor_id'])) { $this->data_to_view['edition_detail']['sponsor_id']=4; }

        // set validation rules
        $this->form_validation->set_rules('edition_name', 'Edition Name', 'required');
        $this->form_validation->set_rules('edition_status', 'Edition status', 'required');
        $this->form_validation->set_rules('edition_date', 'Edition date', 'required');
        $this->form_validation->set_rules('edition_url', 'URL', 'valid_url');
        $this->form_validation->set_rules('event_id', 'Event', 'required|numeric|greater_than[0]',["greater_than"=>"Please select an event"]);
        $this->form_validation->set_rules('sponsor_id', 'Sponsor', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a sponsor"]);
        $this->form_validation->set_rules('user_id', 'Contact Person', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a Contact Person"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->data_to_view['return_url']=$this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
        else
        {                
            $id=$this->edition_model->set_edition($action, $id, [], false);
            if ($id)
            {             
//                wts($_FILES);
//                wts($_POST);
//                die();                
                $return=$this->upload_logo_file($id, $_FILES, $_POST);     
                
                // site filename in DB
                if (isset($return['filename'])) {
                    $id=$this->edition_model->set_edition("edit", $id, ["edition_logo"=>$return['filename']], false);
                }
                
                $alert=$return['alert_text'];
                $status=$return['alert_status'];
            } else {
                $alert="Error committing to the database";
                $status="danger";
            }            

            $this->session->set_flashdata([
                'alert'=>$alert,
                'status'=>$status,
                ]);

            // save_only takes you back to the edit page.
            if (array_key_exists("save_only", $_POST)) {
                $this->return_url=base_url("admin/edition/create/edit/".$id);
            }  
            
            redirect($this->return_url);
        }
    }
    
    public function copy($e_id) {
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('race_model');
        $this->load->model('asamember_model');
        wts("hallo world");
        die();
    }

    private function upload_logo_file($id, $files, $post) {
                
        $return['alert_text']="Edition information has been updated";
        $return['alert_status']="success";        
        
        if (empty($files['edition_logo_upload']['name'])) {
            return $return;
        }
        
        $config['upload_path']    = "./uploads/admin/edition/".$id;        
        if (!file_exists($config['upload_path'])) {
            if (!mkdir($config['upload_path'], 0777, true)) {
                die('Failed to create folders...');
            }            
//            echo "The directory ".$config['upload_path']." was successfully created.";
        } else {
//            echo "The directory ".$config['upload_path']." exists.";
        }
        
        $config['allowed_types']  = 'jpg|gif|png';
        $config['max_size']       = 2048;
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('edition_logo_upload'))
        {
            $error = array('error' => $this->upload->display_errors());            
            $return['alert_text']="Issue uploading the logo file: ".strip_tags($error['error']);
            $return['alert_status']="danger";
        }
        else
        {
            $data = $this->upload->data();
            $return['filename']=$data['file_name'];
        }
        
        return $return;
    }
    
    
    public function delete($edition_id=0) {
        
//        echo $edition_id;
//        exit();

        if (($edition_id==0) AND (!is_int($edition_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$edition_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get edition detail for nice delete message
        $edition_detail=$this->edition_model->get_edition_detail($edition_id);
        // delete record
        $db_del=$this->edition_model->remove_edition($edition_id);
        
        if ($db_del)
        {
            $msg="Edition has successfully been deleted: ".$edition_detail['edition_name'];
            $status="success";
        }
        else
        {
            $msg="Error in deleting the record:'.$edition_id";
            $status="danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }


}
