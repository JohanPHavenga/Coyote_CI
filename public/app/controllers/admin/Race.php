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
        
        $this->data_to_view["race_data"] = $this->race_model->get_race_list();
        $this->data_to_view['heading']=["ID","Edition","Race Type","Race Distance","Race Time","Race Fees","Status","Actions"];
        
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_header['title'] = "List of Races";
        $this->data_to_header['crumbs'] =
                   [
                   "Home"=>"/admin",
                   "Races"=>"/admin/race",
                   "List"=>"",
                   ];
        
        $this->data_to_header['page_action_list']=
                [
                    [
                        "name"=>"Add Race",
                        "icon"=>"trophy",
                        "uri"=>"race/create/add",
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
        $this->load->view("/admin/race/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }
    

    public function create($action, $id=0) {
        // additional models
        $this->load->model('edition_model');
        $this->load->model('racetype_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_header['title'] = "Race Input Page";
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_header['css_to_load']=array(
            "plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            "plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css",
            "plugins/bootstrap-summernote/summernote.css",
            );

        $this->data_to_header['js_to_load']=array(
            "plugins/moment.min.js",
            "plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js",
            "plugins/bootstrap-summernote/summernote.min.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/admin/components-date-time-pickers.js",
            "scripts/admin/components-editors.js",
            );


        $this->data_to_view['edition_dropdown']=$this->edition_model->get_edition_dropdown();        
        $this->data_to_view['status_dropdown']=$this->race_model->get_status_dropdown();
        $this->data_to_view['racetype_dropdown']=$this->racetype_model->get_racetype_dropdown();

        if ($action=="edit")
        {
            $this->data_to_view['race_detail']=$this->race_model->get_race_detail($id);
            $this->data_to_view['edition_detail']=$this->edition_model->get_edition_detail($this->data_to_view['race_detail']['edition_id']);
            $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
        } else {
            $this->data_to_view['race_detail']=[];
            $this->data_to_view['race_detail']['race_status']=1;
            $this->data_to_view['race_detail']['racetype_id']=4;
            if ($id>0) {
                $this->data_to_view['edition_detail']=$this->edition_model->get_edition_detail($id);
                $this->data_to_view['race_detail']['edition_id']=$id;
            }
        }

        // set validation rules
        $this->form_validation->set_rules('race_distance', 'Race distance', 'required|numeric');
        $this->form_validation->set_rules('race_time_start', 'Race time', 'required');
        $this->form_validation->set_rules('race_status', 'Race status', 'required');
        $this->form_validation->set_rules('edition_id', 'Edition', 'required|numeric|greater_than[0]',["greater_than"=>"Please select an edition"]);
        $this->form_validation->set_rules('race_fee_flat', "Race Flat Fee", 'numeric');
        $this->form_validation->set_rules('race_fee_senior_licenced', "Senior Race Fee Licenced", 'numeric');
        $this->form_validation->set_rules('race_fee_senior_unlicenced', "Senior Race Fee Unlicenced", 'numeric');
        $this->form_validation->set_rules('race_fee_junior_licenced', "Junior Race Fee Licenced", 'numeric');
        $this->form_validation->set_rules('race_fee_junior_unlicenced', "Junior Race Fee Unlicenced", 'numeric');
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
            $id=$this->race_model->set_race($action, $id, [], false);
            if ($id)
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
            
            // save_only takes you back to the edit page.
            if (array_key_exists("save_only", $_POST)) {
                $this->return_url=base_url("admin/race/create/edit/".$id);
            }  

            redirect($this->return_url);
        }
    }
    
     public function delete($race_id=0) {
        
//        echo $race_id;
//        exit();

        if (($race_id==0) AND (!is_int($race_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$race_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get race detail for nice delete message
        $race_detail=$this->race_model->get_race_detail($race_id);
        // delete record
        $db_del=$this->race_model->remove_race($race_id);
        
        if ($db_del)
        {
            $msg="Race has successfully been deleted: ".$race_detail['race_name'];
            $status="success";
        }
        else
        {
            $msg="Error in deleting the record:'.$race_id";
            $status="danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }


    public function delete_old($confirm=false) {

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
