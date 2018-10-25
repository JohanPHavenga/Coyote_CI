<?php

class Url extends Admin_Controller {

    private $return_url = "/admin/url";
    private $create_url = "/admin/url/create";

    public function __construct() {
        parent::__construct();
        $this->load->model('url_model');
    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            $this->view($params);
        }
    }

    public function view() {
        // load helpers / libraries
        $this->load->library('table');

        $this->data_to_view["url_data"] = $this->url_model->get_url_list();
        $this->data_to_view['heading'] = ["ID", "URL name", "URL ype", "Linked To", "ID", "Actions"];

        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['title'] = "List of URLs";
        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "Files" => "/admin/url",
            "List" => "",
        ];

        $this->data_to_header['page_action_list'] = [
            [
                "name" => "Add URL",
                "icon" => "link",
                "uri" => "url/create/add",
            ],
        ];

        $this->data_to_view['url'] = $this->url_disect();

        $this->data_to_header['css_to_load'] = array(
            "plugins/datatables/datatables.min.css",
            "plugins/datatables/plugins/bootstrap/datatables.bootstrap.css",
        );

        $this->data_to_footer['js_to_load'] = array(
            "scripts/admin/datatable.js",
            "plugins/datatables/datatables.min.js",
            "plugins/datatables/plugins/bootstrap/datatables.bootstrap.js",
            "plugins/bootstrap-confirmation/bootstrap-confirmation.js",
        );

        $this->data_to_footer['scripts_to_load'] = array(
            "scripts/admin/table-datatables-managed.js",
        );

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/admin/url/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

    public function create($action, $id=0) {
      
        // additional models
        $this->load->model('edition_model');
        $this->load->model('race_model');
        $this->load->model('sponsor_model');
        $this->load->model('club_model');
        $this->load->model('urltype_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('upload');

        // set data
        $this->data_to_header['title'] = "File Input Page";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_url'] = $this->create_url . "/" . $action;

        $this->data_to_header['css_to_load'] = array(
            "plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            "plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css",
            "plugins/bootstrap-summernote/summernote.css",
        );

        $this->data_to_header['js_to_load'] = array(
            "plugins/moment.min.js",
            "plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js",
            "plugins/bootstrap-summernote/summernote.min.js",
        );

        $this->data_to_footer['scripts_to_load'] = array(
            "scripts/admin/components-date-time-pickers.js",
            "scripts/admin/components-editors.js",
            "scripts/admin/linked_to_hide_show.js",
        );

        $this->data_to_view['edition_dropdown'] = $this->edition_model->get_edition_dropdown();
        $this->data_to_view['race_dropdown'] = $this->race_model->get_race_dropdown();
        $this->data_to_view['sponsor_dropdown'] = $this->sponsor_model->get_sponsor_dropdown();
        $this->data_to_view['club_dropdown'] = $this->club_model->get_club_dropdown();
        $this->data_to_view['urltype_dropdown'] = $this->urltype_model->get_urltype_dropdown();
        $this->data_to_view['linked_to_dropdown'] = $this->urltype_model->get_linked_to_dropdown();

        if ($action == "edit") {
            $this->data_to_view['url_detail'] = $this->url_model->get_url_detail($id);
            $this->data_to_view['form_url'] = $this->create_url . "/" . $action . "/" . $id;
        } else {
            $this->data_to_view['url_detail'] = [];
        }

        // set validation rules
        $this->form_validation->set_rules('url_name', 'URL Name', 'required|valid_url', ["valid_url" => "Please enter a valid URL"]);
        $this->form_validation->set_rules('urltype_id', 'URL Type', 'required|numeric|greater_than[0]', ["greater_than" => "Please select a valid URL type"]);

        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {
            $id=$this->race_model->set_url($action, $id, [], false);
       
            if ($id) {
                $alert = "File has been " . $action . "ed";
                $status = "success";
            } else {
                $alert = "Error committing to the database";
                $status = "danger";
            }

            $this->session->set_flashdata([
                'alert' => $alert,
                'status' => $status,
            ]);

            // save_only takes you back to the edit page.
            if (array_key_exists("save_only", $_POST)) {
                $this->return_url = base_url("admin/url/create/edit/" . $id);
            }

            redirect($this->return_url);
        }
    }

    private function upload_url($params) {
        $url_data = $_FILES['url_upload'];
        // set default return
        $return['success'] = false;
        $return['alert_status'] = "warning";
        $return['alert_text'] = "Error uploading a url: " . $url_data['name'];

        // check folder
        $upload_path = $this->check_upload_folder($params['linked_to'], $params[$params['id_type']]);

        // set upload config
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = "pdf|docx|doc|xls|xlsx|jpg|gif|jpeg|png";
        $config['max_size'] = "10240";
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($params['form_field'])) {
            $error = array('error' => $this->upload->display_errors());
            $return['alert_text'] = "Issue uploading a url: " . strip_tags($error['error']);
        } else {
            $return['success'] = true;
            $return['data'] = $this->upload->data();
            $return['urlname'] = $url_data['name'];
            $return['alert_text'] = "File has been uploaded";
            $return['alert_status'] = "success";
        }
        return $return;
    }

    //CHECK AND CREATE UPLOAD FOLDER
    private function check_upload_folder($linked_to, $id) {
        $upload_path = "./uploads/" . $linked_to . "/" . $id;
        if (!url_exists($upload_path)) {
            if (!mkdir($upload_path, 0777, true)) {
                return false;
            }
        }
        return $upload_path;
    }

    public function delete($url_id = 0) {

        if (($url_id == 0) || (!is_numeric($url_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $url_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get url detail for nice delete message
        $url_detail = $this->url_model->get_url_detail($url_id);
        
        // delete record        
        $url_path="./uploads/".$url_detail['url_linked_to']."/".$url_detail['linked_id']."/".$url_detail['url_name'];
        $db_del = $this->url_model->remove_url($url_id,$url_path);

        if ($db_del) {
            $msg = "File has successfully been deleted: " . $url_detail['url_name'];
            $status = "success";
        } else {
            $msg = "Error in deleting the record:'.$url_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }

}
