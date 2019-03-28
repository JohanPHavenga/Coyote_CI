<?php

class Emailtemplate extends Admin_Controller {

    private $return_url = "/admin/emailtemplate/view";
    private $create_url = "/admin/emailtemplate/create";

    public function __construct() {
        parent::__construct();
        $this->load->model('emailtemplate_model');
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
        $this->data_to_view['heading'] = ["ID", "Template Name", "Linked To", "Actions"];
        $this->data_to_header['title'] = "List of email templates";

        $this->data_to_view["emailtemplate_data"] = $this->emailtemplate_model->get_emailtemplate_list();
        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['page_action_list'] = [
            [
                "name" => "Compose Email",
                "icon" => "envelope-open",
                "uri" => "emailtemplate/create/add",
            ],
        ];
        $this->data_to_header['crumbs'] = [
            "Home" => "/admin",
            "Users" => "/admin/emailtemplate",
            "List" => "",
        ];

        // set $action array in controller instead of view
        if (!(empty($this->data_to_view["emailtemplate_data"]))) {
            foreach ($this->data_to_view["emailtemplate_data"] as $emailtemplate_id => $data_entry) {
                // first set normal action array
                $this->data_to_view['action_array'][$emailtemplate_id] = [
                    [
                        "url" => "/admin/emailtemplate/create/edit/" . $data_entry['emailtemplate_id'],
                        "text" => "Edit",
                        "icon" => "icon-pencil",
                    ],
                    [
                        "url" => "/admin/emailtemplate/delete/" . $data_entry['emailtemplate_id'],
                        "text" => "Delete",
                        "icon" => "icon-close",
                        "confirmation_text" => "<b>Are you sure?</b>",
                    ],
                ];

                switch ($data_entry['emailtemplate_status']) {
                    case 4: // draft
                        break;
                    case 5: // pending
                        unset($this->data_to_view['action_array'][$emailtemplate_id]);
                        $this->data_to_view['action_array'][$emailtemplate_id][0] = [
                            "url" => "/admin/emailtemplate/status/$emailtemplate_id/4",
                            "text" => "Cancel send",
                            "icon" => "icon-ban",
                        ];
                        break;
                    case 6: // send
                        $this->data_to_view['action_array'][$emailtemplate_id][0] = [
                            "url" => "/admin/emailtemplate/resend/" . $data_entry['emailtemplate_id'],
                            "text" => "Resend Email",
                            "icon" => "icon-envelope",
                        ];
                        break;
                    case 7: // failed
                        $this->data_to_view['action_array'][$emailtemplate_id][0] = [
                            "url" => "/admin/emailtemplate/resend/" . $data_entry['emailtemplate_id'],
                            "text" => "Resend Email",
                            "icon" => "icon-envelope",
                        ];
                        break;
                    default:
                        break;
                }
            }
        }

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
        $this->load->view("/admin/emailtemplate/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

    public function create($action, $id = 0) {
        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');
        // set data
        $this->data_to_header['title'] = "Email Compose";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_url'] = $this->create_url . "/" . $action;

        $this->data_to_header['css_to_load'] = array("plugins/bootstrap-summernote/summernote.css",);
        $this->data_to_footer['js_to_load'] = array("plugins/moment.min.js", "plugins/bootstrap-summernote/summernote.min.js",);
        $this->data_to_footer['scripts_to_load'] = array("scripts/admin/components-editors.js",);

        if ($action == "edit") {
            $this->data_to_view['emailtemplate_detail'] = $this->emailtemplate_model->get_emailtemplate_detail($id);
            $this->data_to_view['form_url'] = $this->create_url . "/" . $action . "/" . $id;
        } else {
            $this->data_to_view['emailtemplate_detail']['emailtemplate_status'] = 4;
        }
        // set return URL
        $this->return_url = "/admin/emailtemplate/view/" . $this->data_to_view['emailtemplate_detail']['emailtemplate_status'];
        // set validation rules
        $this->form_validation->set_rules('emailtemplate_subject', 'Subject', 'required');
        $this->form_validation->set_rules('emailtemplate_to_address', 'To Address', 'required|valid_email');
        $this->form_validation->set_rules('emailtemplate_body', 'Email body', 'required');

        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {
            switch ($this->input->post('save-btn')) {
                case "save_only":
                case "save_close":
                    $mail_status = 4;
                    break;
                case "send_mail":
                    $mail_status = 5;
                    break;
            }
            $data = array(
                'emailtemplate_subject' => $this->input->post('emailtemplate_subject'),
                'emailtemplate_to_address' => $this->input->post('emailtemplate_to_address'),
                'emailtemplate_to_name' => $this->input->post('emailtemplate_to_name'),
                'emailtemplate_body' => $this->input->post('emailtemplate_body'),
                'emailtemplate_status' => $mail_status,
                'emailtemplate_from_address' => $this->ini_array['email']['from_address'],
                'emailtemplate_from_name' => $this->ini_array['email']['from_name'],
            );
            $set = $this->emailtemplate_model->set_emailtemplate($action, $id, $data);
            if ($set) {
                $alert = "Email has been " . $action . "ed";
                $status = "success";
            } else {
                $alert = "Error committing to the database";
                $status = "danger";
            }

            // take person back to the right screen
            switch ($this->input->post('save-btn')) {
                case "save_only":
                    $this->return_url = base_url("admin/emailtemplate/create/edit/" . $id);
                    break;
                case "send_mail":
                    $this->return_url = base_url("admin/emailtemplate/view/5");
                    $alert = "Email set to pending";
                    $status = "warning";
                    break;
            }

            $this->session->set_flashdata([
                'alert' => $alert,
                'status' => $status,
            ]);
            redirect($this->return_url);
        }
    }

    public function delete($emailtemplate_id = 0) {

        if (($emailtemplate_id == 0) AND ( !is_int($emailtemplate_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $emailtemplate_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get emailtemplate detail for nice delete message
        $emailtemplate_detail = $this->emailtemplate_model->get_emailtemplate_detail($emailtemplate_id);
        // delete record
        $db_del = $this->emailtemplate_model->remove_emailtemplate($emailtemplate_id);

        if ($db_del) {
            $msg = "Email has successfully been deleted: " . $emailtemplate_detail['emailtemplate_subject'];
            $status = "warning";
        } else {
            $msg = "Error in deleting the record:'.$emailtemplate_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }

    // change status with URL call
    public function status($emailtemplate_id, $emailtemplate_status) {
        $range = [4, 5, 6, 7];
        $valid_id = $this->emailtemplate_model->check_id($emailtemplate_id);
        if ((in_array($emailtemplate_status, $range)) && ($valid_id)) {
            $status_update = $this->emailtemplate_model->set_emailtemplate_status($emailtemplate_id, $emailtemplate_status);
            if ($status_update) {
                $msg = "Email status successfully updated";
                $status = "success";
                $this->return_url = base_url("admin/emailtemplate/view/$emailtemplate_status");
            } else {
                $msg = "Update to database failed";
                $status = "danger";
                $this->return_url = base_url("admin/emailtemplate/view/4");
            }
        } else {
            $msg = "Status not in range or invalid ID";
            $status = "danger";
            $this->return_url = base_url("admin/emailtemplate/view/4");
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }

    // resend email by copy
    public function resend($emailtemplate_id) {
        $new_id = $this->emailtemplate_model->copy_email($emailtemplate_id);
        $status_update = $this->emailtemplate_model->set_emailtemplate_status($new_id, 4);
        if ($status_update) {
            $msg = "Email successfully copied";
            $status = "success";
            $this->return_url = base_url("admin/emailtemplate/create/edit/$new_id");
        } else {
            $msg = "Email copy failed";
            $status = "danger";
            $this->return_url = base_url("admin/emailtemplate/view/4");
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }

}
