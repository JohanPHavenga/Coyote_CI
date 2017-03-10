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
        $this->load->model('event_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_header['title'] = "Edition Input Page";
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_header['css_to_load']=array(
            "plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            );

        $this->data_to_footer['js_to_load']=array(
            "plugins/moment.min.js",
            "plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/admin/components-date-time-pickers.js",
            );

        $this->data_to_view['sponsor_dropdown']=$this->sponsor_model->get_sponsor_dropdown();
        $this->data_to_view['event_dropdown']=$this->event_model->get_event_dropdown();
        $this->data_to_view['status_dropdown']=$this->event_model->get_status_dropdown();

        if ($action=="edit")
        {
        $this->data_to_view['edition_detail']=$this->edition_model->get_edition_detail($id);
        $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
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
            $this->data_to_view['return_url']=$this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
        else
        {
            $db_write=$this->edition_model->set_edition($action, $id, [], false);
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
    
    

    public function delete_old($confirm=false) {

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
