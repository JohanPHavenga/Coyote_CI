<?php
class Racetype extends Admin_Controller {

    private $return_url="/admin/racetype";
    private $create_url="/admin/racetype/create";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('racetype_model');
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
        $total_rows=$this->racetype_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);

        // pagination init
        $this->load->library("pagination");
        $this->pagination->initialize($config);
        $this->data_to_view["pagination"]=$this->pagination->create_links();


        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

        $this->data_to_view["list"] = $this->racetype_model->get_racetype_list($per_page, $page);
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_view['delete_arr']=["controller"=>"racetype","id_field"=>"racetype_id"];
        $this->data_to_view['title'] = uri_string();

        // as daar data is
        if ($this->data_to_view["list"]) {
             $this->data_to_view['heading']=ftableHeading(array_keys($this->data_to_view['list'][key($this->data_to_view['list'])]),2);
        }

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function create($action, $id=0) {
        // additional models
        $this->load->model('town_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_view['title'] = uri_string();
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_view['js_to_load']=array("select2.js");
        $this->data_to_view['js_script_to_load']='$(".autocomplete").select2({minimumInputLength: 2});';
        $this->data_to_view['css_to_load']=array("select2.css","select2-bootstrap.css");

        $this->data_to_view['status_dropdown']=$this->racetype_model->get_status_dropdown();
        $this->data_to_view['town_dropdown']=$this->town_model->get_town_dropdown();

        if ($action=="edit")
        {
        $this->data_to_view['racetype_detail']=$this->racetype_model->get_racetype_detail($id);
        $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
        }

        // set validation rules
        $this->form_validation->set_rules('racetype_name', 'Role Name', 'required');
        $this->form_validation->set_rules('racetype_status', 'Role Status', 'required');

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
            $db_write=$this->racetype_model->set_racetype($action, $id);
            if ($db_write)
            {
                $alert="Role has been updated";
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

        $id=$this->encryption->decrypt($this->input->post('racetype_id'));

        if ($id==0) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        if ($confirm=='confirm')
        {
            $db_del=$this->racetype_model->remove_racetype($id);
            if ($db_del)
            {
                $msg="Role has been deleted";
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
