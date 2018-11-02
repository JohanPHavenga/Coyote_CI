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
        $this->data_to_view['heading'] = ["ID", "URL", "URLtype", "Linked To", "ID", "Actions"];

        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['title'] = "List of URLs";

        $this->data_to_header['crumbs'] = [
                    "Home" => "/admin",
                    "Users" => "/admin/url",
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

    public function create($action, $id = 0) {
        // additional models
        $this->load->model('urltype_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_header['title'] = "URL Input Page";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_url'] = $this->create_url . "/" . $action;

        $this->data_to_header['css_to_load'] = array(
            "plugins/typeahead/typeahead.css"
        );

        $this->data_to_footer['js_to_load'] = array(
            "plugins/typeahead/handlebars.min.js",
            "plugins/typeahead/typeahead.bundle.min.js",
        );

        $this->data_to_footer['scripts_to_load'] = array(
            "scripts/admin/autocomplete.js",
            "scripts/admin/linked_to_hide_show.js",
        );

        $this->data_to_view['urltype_dropdown'] = $this->urltype_model->get_urltype_dropdown();
        $this->data_to_view['linked_to_dropdown'] = $this->urltype_model->get_linked_to_dropdown();
        $this->data_to_view['linked_to_list'] = $this->urltype_model->get_linked_to_list();

        // dynamically get drop downs using the linked_to_table
        foreach ($this->data_to_view['linked_to_list'] as $linked_to_id => $linked_to_name) {
            $dropdown = $linked_to_name . "_dropdown";
            $model = $linked_to_name . "_model";
            $method = "get_" . $linked_to_name . "_dropdown";

            $this->load->model($model);
            $this->data_to_view[$dropdown] = $this->$model->$method();
        }

        if ($action == "edit") {
            $this->data_to_view['url_detail'] = $this->url_model->get_url_detail($id);
            $this->data_to_view['form_url'] = $this->create_url . "/" . $action . "/" . $id;
        }

        // set validation rules
        $this->form_validation->set_rules('url_name', 'URL Name', 'required|valid_url');
        $this->form_validation->set_rules('urltype_id', 'URL Type', 'required|greater_than[0]', ["greater_than" => "Please select a URL Type"]);


        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {            
            // SET URL
            $id = $this->url_model->set_url($action, $id);
            // set the results flag
            $results_link_arr=['edition','race'];
            if (in_array($this->input->post("url_linked_to"),$results_link_arr)) {
                $id_type = $this->input->post("url_linked_to") . "_id";
                $linked_id = $this->input->post($id_type);
                $set = $this->set_results_flag($this->input->post("url_linked_to"), $linked_id);
            }
            
            if ($id) {
                $alert = "URL details has been " . $action . "ed";
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

    public function delete($url_id = 0) {

        if (($url_id == 0) AND ( !is_int($url_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $url_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get url detail for nice delete message
        $url_detail = $this->url_model->get_url_detail($url_id);
        // delete record
        $db_del = $this->url_model->remove_url($url_id);
        
        // check results flag
        $results_link_arr=['edition','race'];
        if (in_array($url_detail['url_linked_to'],$results_link_arr)) {
            $set = $this->set_results_flag($url_detail['url_linked_to'], $url_detail['linked_id']);
        }

        if ($db_del) {
            $msg = "URL has successfully been deleted: " . $url_detail['url_name'];
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
