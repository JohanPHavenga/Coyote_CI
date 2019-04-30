<?php

class Emailmerge extends Admin_Controller {

    private $return_url = "/admin/emailmerge/view";
    private $create_url = "/admin/emailmerge/create";

    public function __construct() {
        parent::__construct();
        $this->load->model('emailmerge_model');
        $this->ini_array = parse_ini_file("server_config.ini", true);
    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            redirect($this->return_url);
        }
    }

    public function view() {
        // load helpers / libraries
        $this->load->library('table');
        $this->data_to_view['heading'] = ["ID", "Subject", "Status", "Recipient Count", "Actions"];
        $this->data_to_header['title'] = "List of Mail Merges";

        $this->data_to_view["emailmerge_data"] = $this->emailmerge_model->get_emailmerge_list();
        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['page_action_list'] = [
            [
                "name" => "Create Merge",
                "icon" => "envelope-open",
                "uri" => "emailmerge/wizard",
            ],
        ];
        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "Email Merge" => "/admin/emailmerge",
            "List" => "",
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
        $this->load->view("/admin/emailmerge/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

    public function wizard() {
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('emailtemplate_model');
        $this->load->model('usersubscription_model');

        // set data
        $this->data_to_header['title'] = $this->data_to_view['title'] = "Setup Mail Merge";
        $this->data_to_view['action'] = "add";
        $this->data_to_view['form_url'] = "/admin/emailmerge/wizard";

        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "Email Merge" => "/admin/emailmerge",
            "Wizard" => "",
        ];

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

        $this->data_to_view['emailtemplate_dropdown'] = $this->emailtemplate_model->get_emailtemplate_dropdown();
        $this->data_to_view['linked_to_dropdown'] = $this->emailmerge_model->get_linked_to_dropdown(7);
        $this->data_to_view['linked_to_list'] = $this->emailmerge_model->get_linked_to_list(7);

        // unset linked to we are not using for now
        $unset_arr = [1, 3, 4, 5, 6];
        foreach ($unset_arr as $unset) {
            $name = $this->data_to_view['linked_to_list'][$unset];
            unset($this->data_to_view['linked_to_list'][$unset]);
            unset($this->data_to_view['linked_to_dropdown'][$name]);
        }

        // dynamically get drop downs using the linked_to_table
        foreach ($this->data_to_view['linked_to_list'] as $linked_to_id => $linked_to_name) {
            $dropdown = $linked_to_name . "_dropdown";
            $model = $linked_to_name . "_model";
            $method = "get_" . $linked_to_name . "_dropdown";

            $this->load->model($model);
            $this->data_to_view[$dropdown] = $this->$model->$method();
            $this->data_to_view[$dropdown][0] = "All";
        }

        // set validation rules
        $this->form_validation->set_rules('linked_to', 'Linked To', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view("/admin/emailmerge/wizard", $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {
            // SET merge
            $emailtemplate = $this->emailtemplate_model->get_emailtemplate_detail($this->input->post('emailtemplate_id'));
            // get type of ID to use and get USER list
            $id_name=$this->input->post('linked_to')."_id";
            $user_arr = $this->usersubscription_model->get_usersubscription_list($this->input->post('linked_to'),$this->input->post($id_name));
            foreach ($user_arr as $user) {
                $user_list[]=$user['user_id'];
            }
            $user_str=implode(",", $user_list);
            // create email merge
            $merge_data = array (
                "emailmerge_status" => 4,
                "emailmerge_subject" => $emailtemplate['emailtemplate_name'],
                "emailmerge_body" => $emailtemplate['emailtemplate_body'],
                "emailmerge_recipients" => $user_str,
                "emailmerge_linked_to" => $this->input->post('linked_to'),
                "linked_id" => $this->input->post($id_name),
            );
            $emailmerge_id = $this->emailmerge_model->set_emailmerge("add", 0, $merge_data);
            
//            wts($_POST);
//            wts($emailtemplate);
//            wts($user_list);
//            wts($merge_data);

            redirect($this->create_url."/edit/".$emailmerge_id);
        }
    }

    public function create($action, $id = 0) {
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('user_model');
        // set data
        $this->data_to_header['title'] = $this->data_to_view['title'] = "Mail Merge Edit";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_url'] = $this->create_url . "/" . $action . "/" . $id;
        
        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "Email Merge" => "/admin/emailmerge",
            "Edit" => "",
        ];

        $this->data_to_header['css_to_load'] = array("plugins/bootstrap-summernote/summernote.css",);
        $this->data_to_footer['js_to_load'] = array("plugins/moment.min.js", "plugins/bootstrap-summernote/summernote.min.js",);
        $this->data_to_footer['scripts_to_load'] = array("scripts/admin/components-editors.js",);

       
        if ($action == "edit") {
            $this->data_to_view['emailmerge_detail'] = $this->emailmerge_model->get_emailmerge_detail($id);
            $user_arr=explode(",",$this->data_to_view['emailmerge_detail']['emailmerge_recipients']);
//            $this->data_to_view['user_dropdown'] = $this->user_model->get_user_dropdown(NULL, $user_arr);
            $this->data_to_view['user_dropdown'] = $this->user_model->get_user_dropdown();
        } else {
            die("please use wizard");
        }

        // set validation rules
        $this->form_validation->set_rules('emailmerge_subject', 'Subject', 'required');
        $this->form_validation->set_rules('emailmerge_body', 'Body', 'required');
        $this->form_validation->set_rules('emailmerge_recipients[]', 'Recipients', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {
            $recipient_arr=$this->input->post('emailmerge_recipients');
            asort($recipient_arr);
            $recipient_str=implode(",",$recipient_arr);
            $data = array(
                'emailmerge_subject' => $this->input->post('emailmerge_subject'),
                'emailmerge_body' => $this->input->post('emailmerge_body'),
                'emailmerge_recipients' => $recipient_str,
            );
            $return_id = $this->emailmerge_model->set_emailmerge($action, $id, $data);

            if ($return_id) {
                $alert = "Mail Merge has been " . $action . "ed";
                $status = "success";

                // take person back to the right screen
                switch ($this->input->post('save-btn')) {
                    case "save_only":
                        $this->return_url = base_url("admin/emailmerge/create/edit/" . $return_id);
                        break;
                    case "merge":
                        $run_merge=$this->merge($return_id);
                        break;
                }
            } else {
                $alert = "Error committing to the database";
                $status = "danger";
            }

            $this->session->set_flashdata([
                'alert' => $alert,
                'status' => $status,
            ]);
            redirect($this->return_url);
        }
    }

    public function delete($emailmerge_id = 0) {

        if (($emailmerge_id == 0) AND ( !is_int($emailmerge_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $emailmerge_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get emailmerge detail for nice delete message
        $emailmerge_detail = $this->emailmerge_model->get_emailmerge_detail($emailmerge_id);
        // delete record
        $db_del = $this->emailmerge_model->remove_emailmerge($emailmerge_id);

        if ($db_del) {
            $msg = "Email has successfully been deleted: <b>" . $emailmerge_detail['emailmerge_name'] . "</b>";
            $status = "warning";
        } else {
            $msg = "Error in deleting the record:'.$emailmerge_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }
    
    

    public function fill_variables($return_text, $data_arr) {
        // to replace %name% with name in data_arr etc.
        $return_text = str_replace("%name%", $data_arr['name'], $return_text);
        $return_text = str_replace("%surname%", $data_arr['surname'], $return_text);
        $return_text = str_replace("%email%", $data_arr['email'], $return_text);
        
        $newsletter_data = $this->fetch_newsletter_data();
        $return_text = str_replace("%events_past%", $this->formulate_newsletter_table($newsletter_data['past'],"past"), $return_text, true);
        $return_text = str_replace("%events_future%", $this->formulate_newsletter_table($newsletter_data['future'],"future"), $return_text, true);
        
        return $return_text;
    }

    public function set_merge_data($user, $linked_to, $linked_id) {
        // set main return array
        $merge_data = array(
            'name' => $user['user_name'],
            'surname' => $user['user_surname'],
            'email' => $user['user_email'],
        );
        // switch on the linked type
        switch ($linked_to) {
            case "newsletter":
                break;
            case "edition":
                $this->load->model('edition_model');
                $merge_data['edition_name'] = $this->edition_model->get_edition_name_from_id($linked_id);
                break;
            default:
                die("linked to not defined");
                break;
        }
        return $merge_data;
    }

    public function merge($emailmerge_id) {
        // load user model
        $this->load->model('user_model');
        $this->load->model('emailque_model');
        // get the data
        $emailmerge_data = $this->emailmerge_model->get_emailmerge_detail($emailmerge_id);
        // get recipient list
        $recipient_list = explode(",", $emailmerge_data['emailmerge_recipients']);
        // loop through recipients
        foreach ($recipient_list as $user_id) {
            $user_data = $this->user_model->get_user_detail($user_id);
            $merge_data = $this->set_merge_data($user_data, $emailmerge_data['emailmerge_linked_to'], $emailmerge_data['linked_id']);
            $emailque_data = array(
                'emailque_subject' => $emailmerge_data['emailmerge_subject'],
                'emailque_to_address' => $user_data['user_email'],
                'emailque_to_name' => $user_data['user_name'] . " " . $user_data['user_surname'],
                'emailque_body' => $this->fill_variables($emailmerge_data['emailmerge_body'], $merge_data),
                'emailque_status' => 5,
                'emailque_from_address' => $this->ini_array['email']['from_address'],
                'emailque_from_name' => $this->ini_array['email']['from_name'],
            );
//            $email_list[$user_id]=$emailque_data;
            $emailque_id = $this->emailque_model->set_emailque("add", 0, $emailque_data);
        }

        if ($emailque_id) {
            $msg = "Merge was successfuly completed";
            $status = "success";
            $this->set_status($emailmerge_id, 8); // 8 = completed
        } else {
            $msg = "Error creating merge:'.$emailmerge_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
//        redirect($this->return_url);
    }

    public function set_status($emailmerge_id, $status_id) {
        $id = $this->emailmerge_model->set_emailmerge("edit", $emailmerge_id, ["emailmerge_status" => $status_id]);
    }

}
