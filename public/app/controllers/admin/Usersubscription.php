<?php

class Usersubscription extends Admin_Controller {

    private $return_url = "/admin/usersubscription";
    private $create_url = "/admin/usersubscription/create";

    public function __construct() {
        parent::__construct();
        $this->load->model('usersubscription_model');
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

        $this->data_to_view["usersubscription_data"] = $this->usersubscription_model->get_usersubscription_list();
        $this->data_to_view['heading'] = ["User", "Linked To Type", "Linked To Name", "Actions"];

        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['title'] = "List of User Subscriptions";

        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "User Subscriptions" => "/admin/usersubscription",
            "List" => "",
        ];

        $this->data_to_header['page_action_list'] = [
            [
                "name" => "Add URL",
                "icon" => "link",
                "uri" => "usersubscription/create/add",
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
        $this->load->view($this->header_usersubscription, $this->data_to_header);
        $this->load->view("/admin/usersubscription/view", $this->data_to_view);
        $this->load->view($this->footer_usersubscription, $this->data_to_footer);
    }

    public function create($action, $id = 0, $linked_type = NULL) {

        // set return usersubscription to session should it exists
        if ($this->session->has_userdata('edition_return_usersubscription')) {
            $this->return_usersubscription = $this->session->edition_return_usersubscription;
        }

        // additional models
        $this->load->model('usersubscriptiontype_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_header['title'] = "URL Input Page";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_usersubscription'] = $this->create_usersubscription . "/" . $action;

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

        $this->data_to_view['usersubscriptiontype_dropdown'] = $this->usersubscriptiontype_model->get_usersubscriptiontype_dropdown();
        $this->data_to_view['linked_to_dropdown'] = $this->usersubscriptiontype_model->get_linked_to_dropdown();
        $this->data_to_view['linked_to_list'] = $this->usersubscriptiontype_model->get_linked_to_list();

        // dynamically get drop downs using the linked_to_table
        foreach ($this->data_to_view['linked_to_list'] as $linked_to_id => $linked_to_name) {
            $dropdown = $linked_to_name . "_dropdown";
            $model = $linked_to_name . "_model";
            $method = "get_" . $linked_to_name . "_dropdown";

            $this->load->model($model);
            $this->data_to_view[$dropdown] = $this->$model->$method();
        }

        if ($action == "edit") {
            $this->data_to_view['usersubscription_detail'] = $this->usersubscription_model->get_usersubscription_detail($id);
            $this->data_to_view['form_usersubscription'] = $this->create_usersubscription . "/" . $action . "/" . $id;
        } else {
            if ($id > 0) {
                $this->data_to_view['usersubscription_detail']['linked_id'] = $id;
                $this->data_to_view['usersubscription_detail']['usersubscription_linked_to'] = $linked_type;
            }
        }

//        wts($this->data_to_view['usersubscription_detail']);
        // set validation rules
        $this->form_validation->set_rules('usersubscription_name', 'URL Name', 'required|valid_usersubscription');
        $this->form_validation->set_rules('usersubscriptiontype_id', 'URL Type', 'required|greater_than[0]', ["greater_than" => "Please select a URL Type"]);


        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_usersubscription'] = $this->return_usersubscription;
            $this->load->view($this->header_usersubscription, $this->data_to_header);
            $this->load->view($this->create_usersubscription, $this->data_to_view);
            $this->load->view($this->footer_usersubscription, $this->data_to_footer);
        } else {
            // SET URL
            $id = $this->usersubscription_model->set_usersubscription($action, $id);
            // set the results flag
            $results_link_arr = ['edition', 'race'];
            if (in_array($this->input->post("usersubscription_linked_to"), $results_link_arr)) {
                $id_type = $this->input->post("usersubscription_linked_to") . "_id";
                $linked_id = $this->input->post($id_type);
                $set = $this->set_results_flag($this->input->post("usersubscription_linked_to"), $linked_id);
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
                $this->return_usersubscription = base_usersubscription("admin/usersubscription/create/edit/" . $id);
            }

            redirect($this->return_usersubscription);
        }
    }

    public function delete($usersubscription_id = 0) {

        // set return usersubscription to session should it exists
        if ($this->session->has_userdata('edition_return_usersubscription')) {
            $this->return_usersubscription = $this->session->edition_return_usersubscription;
        }

        if (($usersubscription_id == 0) AND ( !is_int($usersubscription_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $usersubscription_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_usersubscription);
            die();
        }

        // get usersubscription detail for nice delete message
        $usersubscription_detail = $this->usersubscription_model->get_usersubscription_detail($usersubscription_id);
        // delete record
        $db_del = $this->usersubscription_model->remove_usersubscription($usersubscription_id);

        // check results flag
        $results_link_arr = ['edition', 'race'];
        if (in_array($usersubscription_detail['usersubscription_linked_to'], $results_link_arr)) {
            $set = $this->set_results_flag($usersubscription_detail['usersubscription_linked_to'], $usersubscription_detail['linked_id']);
        }

        if ($db_del) {
            $msg = "URL has successfully been deleted: " . $usersubscription_detail['usersubscription_name'];
            $status = "success";
        } else {
            $msg = "Error in deleting the record:'.$usersubscription_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_usersubscription);
    }

    function exists($linked_type, $linked_id, $usersubscriptiontype_id) {
        return $this->usersubscription_model->exists($linked_type, $linked_id, $usersubscriptiontype_id);
    }

    function port() {
        // function to port old URLs from fields directly on Edition to URl table
        $this->load->model('edition_model');
        $this->load->model('usersubscriptiontype_model');

        $edition_list = $this->edition_model->get_edition_list();
        $usersubscriptiontype_list = $this->usersubscriptiontype_model->get_usersubscriptiontype_list();

        $usersubscription_map_arr = [
            "edition_usersubscription" => 1,
            "edition_usersubscription_entry" => 5,
            "edition_usersubscription_flyer" => 2,
            "edition_usersubscription_results" => 4,
        ];
        $n = 0;
        $r = 0;
        foreach ($edition_list as $e_id => $edition) {
            foreach ($usersubscription_map_arr as $old_field => $map_id) {
                if ($edition[$old_field] && !$this->exists("edition", $e_id, $map_id)) {
                    $usersubscription_data = array(
                        'usersubscription_name' => $edition[$old_field],
                        'usersubscriptiontype_id' => $map_id,
                        'usersubscription_linked_to' => "edition",
                        'linked_id' => $e_id,
                    );
                    $set = $this->usersubscription_model->set_usersubscription("add", 0, $usersubscription_data, false);
                    $n++;
                }

                if ($edition[$old_field] && $map_id == 4) {
                    $r++;
                    $set_results_flag = $this->usersubscription_model->set_results_flag("edition", $e_id, 1);
                }
            }
        }

        echo "Done<br>";
        echo $n . " records added to URL table<br>";
        echo $r . " results flags set<br>";
    }

}
