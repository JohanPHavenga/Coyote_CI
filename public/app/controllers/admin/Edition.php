<?php

class Edition extends Admin_Controller {

    private $return_url = "/admin/edition/view";
    private $create_url = "/admin/edition/create";

    public function __construct() {
        parent::__construct();
        $this->load->model('edition_model');
        $this->load->model('file_model');
    }

    public function _remap($method, $params = array()) {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            $this->view($params);
        }
    }

    // LIST VIEW
    public function view() {
        // load helpers / libraries
        $this->load->library('table');
        // unset dashboard return url session
        $this->session->unset_userdata('dashboard_return_url');

        $this->data_to_view["edition_data"] = $this->edition_model->get_edition_list();
        $this->data_to_view['heading'] = ["ID", "Edition Name", "Status", "Affiliation", "Edition Date", "Event Name", "Actions"];

        $this->data_to_view['create_link'] = $this->create_url;
        $this->data_to_header['title'] = "List of Editions";
        $this->data_to_header['crumbs'] = [
                    "Home" => "/admin",
                    "Editions" => "/admin/edition",
                    "List" => "",
        ];

        $this->data_to_header['page_action_list'] = [
                    [
                        "name" => "Add Edition",
                        "icon" => "calendar",
                        "uri" => "edition/create/add",
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
        $this->load->view("/admin/edition/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

    // THE BIG CREATE METHOD - ADD and EDIT
    public function create($action, $id = 0) {
        // additional models
        $this->load->model('sponsor_model');
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('race_model');
        $this->load->model('url_model');
        $this->load->model('file_model');
        $this->load->model('asamember_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->helper('file');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('table');

        // set return url to session should it exists
        if ($this->session->has_userdata('dashboard_return_url')) { $this->return_url = $this->session->dashboard_return_url; }

        // set data
        $this->data_to_header['title'] = "Edition Input Page";
        $this->data_to_view['action'] = $action;
        $this->data_to_view['form_url'] = $this->create_url . "/" . $action;

        $this->data_to_header['css_to_load'] = array(
            "plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css",
            "plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css",
            "plugins/bootstrap-summernote/summernote.css",
        );

        $this->data_to_footer['js_to_load'] = array(
            "plugins/moment.min.js",
            "plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js",
            "plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
            "plugins/bootstrap-summernote/summernote.min.js",
        );

        $this->data_to_footer['scripts_to_load'] = array(
            "scripts/admin/components-date-time-pickers.js",
            "scripts/admin/components-editors.js",
        );

        // GET DATA TO SEND TO VIEW
        $this->data_to_view['contact_dropdown'] = $this->user_model->get_user_dropdown(3);
        $this->data_to_view['sponsor_dropdown'] = $this->sponsor_model->get_sponsor_dropdown();
        $this->data_to_view['event_dropdown'] = $this->event_model->get_event_dropdown();
//        $this->data_to_view['status_dropdown']=$this->event_model->get_status_dropdown();
        $this->data_to_view['status_dropdown'] = $this->event_model->get_status_list("main");
        $this->data_to_view['results_status_dropdown'] = $this->event_model->get_status_list("results");
        $this->data_to_view['asamember_list'] = $this->asamember_model->get_asamember_list(true);

        if ($action == "edit") {
            $this->data_to_view['edition_detail'] = $this->edition_model->get_edition_detail($id);
            $this->data_to_view['race_list'] = $this->race_model->get_race_list($id);
            $this->data_to_view['url_list'] = $this->url_model->get_url_list("edition", $id);
            $this->data_to_view['file_list'] = $this->file_model->get_file_list("edition", $id);
            $this->data_to_view['file_list_by_type'] = $this->file_model->get_file_list("edition", $id, true);
            $this->data_to_view['form_url'] = $this->create_url . "/" . $action . "/" . $id;
            // set edition_return_url for races
            $this->session->set_userdata('edition_return_url', "/" . uri_string());
            $this->data_to_view['event_edit_url'] = "/admin/event/create/edit/".$this->data_to_view['edition_detail']['event_id'];
        } else {
            $this->data_to_view['edition_detail']['edition_status'] = 1;
            $this->data_to_view['edition_detail']['edition_results_status'] = 10; // not loaded
            $this->data_to_view['edition_detail']['edition_info_isconfirmed']=0;
            $this->data_to_view['edition_detail']['edition_isfeatured']=0;
        }

        // set default contact
        if (empty($this->data_to_view['edition_detail']['user_id'])) {
            $this->data_to_view['edition_detail']['user_id'] = 60;
        }
        // set default sponsor
        if (empty($this->data_to_view['edition_detail']['sponsor_id'])) {
            $this->data_to_view['edition_detail']['sponsor_id'] = 4;
        }

        // set validation rules
        $this->form_validation->set_rules('edition_name', 'Edition Name', 'trim|required|min_length[5]|callback_name_check',array('name_check' => 'Enter a valid year at the end of the Edition Name'));
        $this->form_validation->set_rules('event_id', 'Event', 'required|numeric|greater_than[0]', ["greater_than" => "Please select an event"]);
        $this->form_validation->set_rules('edition_status', 'Edition status', 'required');
        $this->form_validation->set_rules('edition_date', 'Start date', 'required');
        $this->form_validation->set_rules('edition_address', 'Address', 'required');
        $this->form_validation->set_rules('latitude_num', 'Latitude', 'trim|required|numeric');
        $this->form_validation->set_rules('longitude_num', 'Longitude', 'trim|required|numeric');
        $this->form_validation->set_rules('sponsor_id', 'Sponsor', 'required|numeric|greater_than[0]', ["greater_than" => "Please select a sponsor"]);
        $this->form_validation->set_rules('user_id', 'Contact Person', 'required|numeric|greater_than[0]', ["greater_than" => "Please select a Contact Person"]);

        // load correct view
        if ($this->form_validation->run() === FALSE) {
            $this->data_to_view['return_url'] = $this->return_url;
            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        } else {
//            wts($_FILES);
//            wts($this->input->post());
//            die();
            $id = $this->edition_model->set_edition($action, $id, [], false);
            if ($id) {
                $alert = "<b>".$this->input->post('edition_name') . "</b> has been successfully saved";
                $status = "success";
                if ($action=="edit") {
                    if ($this->input->post('edition_status')!==$this->data_to_view['edition_detail']['edition_status']) {
                        $this->race_status_update(array_keys($this->data_to_view['race_list']),$this->input->post('edition_status'));
                        $alert.="<br>Status change on races also actioned";
                    }
                }                
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
                $this->return_url = base_url("admin/edition/create/edit/" . $id);
            }

            redirect($this->return_url);
        }
    }
    
    public function race_status_update($race_id_arr, $status_id) {        
        $this->load->model('race_model');
        return $this->race_model->update_race_status($race_id_arr,$status_id);
    }
    
    public function name_check($str)
    {
        $year= substr($str, -4);
        $valid = true;

        if (strtotime($year) === false) {
            $valid = false;
        }
        return $valid;
    }

    private function upload_file($params) {
        $file_data = $_FILES[$params['field']];
        // set default return
        $return['success'] = false;
        $return['alert_status'] = "warning";
        $return['alert_text'] = "Error uploading a file: " . $file_data['name'];

        // check folder
        $upload_path = $this->check_upload_folder($params['edition_id']);

        // set upload config
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $params['allowed_types'];
        $config['max_size'] = $params['max_size'];
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($params['field'])) {
            $error = array('error' => $this->upload->display_errors());
            $return['alert_text'] = "Issue uploading a file: " . strip_tags($error['error']);
        } else {
            $return['success'] = true;
            $return['data'] = $this->upload->data();
            $return['filename'] = $file_data['name'];
            $return['alert_text'] = "File has been uploaded";
            $return['alert_status'] = "success";
        }
        return $return;
    }

    // WRITE FILE DETAILS TO DB    
    private function set_file($file_data, $filetype_id, $edition_id) {
        $params = [
            "id_type" => "edition_id",
            "id" => $edition_id,
            "filetype_id" => $filetype_id,
            "data" => $file_data,
            "debug" => true,
        ];
        $id = $this->file_model->set_file($params);
    }

    public function remove_file($edition_id, $file_id) {

        // get file detail for nice delete message
        $file_detail = $this->file_model->get_file_detail($file_id);
        $file_path = "./uploads/edition/" . $edition_id . "/" . $file_detail['file_name'];
        // delete record
        $db_del = $this->file_model->remove_file($file_id, $file_path);

        if ($db_del) {
            $msg = "File has successfully been removed: " . $file_detail['file_name'];
            $status = "success";
        } else {
            $msg = "Error in deleting the record:'.$file_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect("/admin/edition/create/edit/" . $edition_id);
    }

    //CHECK AND CREATE UPLOAD FOLDER
    private function check_upload_folder($id) {
        $upload_path = "./uploads/edition/" . $id;
        if (!file_exists($upload_path)) {
            if (!mkdir($upload_path, 0777, true)) {
                return false;
            }
        }
        return $upload_path;
    }

    // OLD UPLOAD FILE
//    private function upload_logo_file($id, $files, $post) {
//                
//        $return['alert_text']="Edition information has been updated";
//        $return['alert_status']="success";
//        
//        if (empty($files['edition_logo_upload']['name'])) {
//            return $return;
//        }
//        
//        $config['upload_path']    = "./uploads/admin/edition/".$id;
//        if (!file_exists($config['upload_path'])) {
//            if (!mkdir($config['upload_path'], 0777, true)) {
//                die('Failed to create folders...');
//            }
////            echo "The directory ".$config['upload_path']." was successfully created.";
//        } else {
////            echo "The directory ".$config['upload_path']." exists.";
//        }
//        
//        $config['allowed_types']  = 'jpg|gif|png';
//        $config['max_size']       = 2048;
//        $this->upload->initialize($config);
//
//        if ( ! $this->upload->do_upload('edition_logo_upload'))
//        {
//            $error = array('error' => $this->upload->display_errors());            
//            $return['alert_text']="Issue uploading the logo file: ".strip_tags($error['error']);
//            $return['alert_status']="danger";
//        }
//        else
//        {
//            $data = $this->upload->data();
//            $return['filename']=$data['file_name'];
//        }
//        
//        return $return;
//    }
    // DELETE EDITION
    public function delete($edition_id = 0) {


        if (($edition_id == 0) AND ( !is_int($edition_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: ' . $edition_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get edition detail for nice delete message
        $edition_detail = $this->edition_model->get_edition_detail($edition_id);
        // delete record
        $db_del = $this->edition_model->remove_edition($edition_id);

        if ($db_del) {
            $msg = "Edition has successfully been deleted: " . $edition_detail['edition_name'];
            $status = "success";
        } else {
            $msg = "Error in deleting the record:'.$edition_id";
            $status = "danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }

    // MAKE A COPY OF AN OLD EDITION
    public function copy($id) {
        $this->load->model('user_model');
        $this->load->model('event_model');
        $this->load->model('race_model');
        $this->load->model('asamember_model');

        // get data
        $race_list = $this->race_model->get_race_list($id);
        $edition_detail = $this->edition_model->get_edition_detail($id);

        // create new edition data
        $name = substr($edition_detail['edition_name'], 0, -5);
        $year = substr($edition_detail['edition_name'], -4);
        $year++;
        $edition_data['edition_name'] = $name . " " . $year;
        $edition_data['edition_status'] = 2;
        $edition_data['edition_date'] = date("Y-m-d H:i:s", strtotime("+1 years", strtotime($edition_detail['edition_date'])));
        ;
        $edition_data['edition_address'] = $edition_detail['edition_address'];
        $edition_data['event_id'] = $edition_detail['event_id'];
        $edition_data['latitude_num'] = $edition_detail['latitude_num'];
        $edition_data['longitude_num'] = $edition_detail['longitude_num'];
        $edition_data['user_id'] = $edition_detail['user_id'];
        $edition_data['edition_asa_member'] = $edition_detail['edition_asa_member'];

        $e_id = $this->edition_model->set_edition("add", NULL, $edition_data, false);

        // create new races
        foreach ($race_list as $race) {
            $race_data['race_distance'] = $race['race_distance'];
            $race_data['race_time_start'] = $race['race_time_start'];
            $race_data['race_status'] = $race['race_status'];
            $race_data['racetype_id'] = $race['racetype_id'];
            $race_data['edition_id'] = $e_id;

            $r_id = $this->race_model->set_race("add", NULL, $race_data, false);
        }

        if ($e_id) {
            $alert = "Edition information has been successfully added";
            $status = "success";
            $return_url = base_url("admin/edition/create/edit/" . $e_id);
        } else {
            $alert = "Error trying to add <b>" . $edition_data['edition_name'] . "</b> to the database";
            $status = "danger";
            $return_url = base_url("admin/dashboard");
        }

        $this->session->set_flashdata([
            'alert' => $alert,
            'status' => $status,
        ]);

        redirect($return_url);
        die();
    }

    // temp method - fix wehere end-date is empty
    function end_date_fix() {
        // function to port old URLs from fields directly on Edition to URl table
        $this->load->model('edition_model');
        $edition_list = $this->edition_model->get_edition_list();
        $n = 0;
        $r = 0;
        foreach ($edition_list as $e_id => $edition) {
            if (strtotime($edition['edition_date_end']) < 1) {

                $update = $this->edition_model->update_field($e_id, "edition_date_end", $edition['edition_date']);
                $n++;
            }
        }

        echo "Done<br>";
        echo $n . " dates were updated<br>";
    }
    
    // temp method - fix wehere results status
    function results_status_fix() {
        // function to port old URLs from fields directly on Edition to URl table
        $this->load->model('edition_model');
        $edition_list = $this->edition_model->get_edition_list();
        $l = 0;
        $nl = 0;
        foreach ($edition_list as $e_id => $edition) {
            if ($edition['edition_results_isloaded']) {
                $update = $this->edition_model->update_field($e_id, "edition_results_status", 11);
                $l++;
            } else {
                $update = $this->edition_model->update_field($e_id, "edition_results_status", 10);
                $nl++;
            }
        }

        echo "Done<br>";
        echo "<b>". $nl . "</b> statuse were updated to NOT LOADED<br>";
        echo "<b>". $l . "</b> statuse were updated to LOADED<br>";
    }
    
     // create slugs for all the editions
    function generate_slugs() {
        // function to port old URLs from fields directly on Edition to URl table
        $this->load->model('edition_model');
        $edition_list = $this->edition_model->get_edition_list();
        $n = 0;
        foreach ($edition_list as $e_id => $edition) {
            $this->edition_model->update_field($e_id, "edition_slug", url_title($edition['edition_name']));
            $n++;
        }

        echo "Done<br>";
        echo "<b>". $n . "</b> slugs were updated<br>";
    }

}
