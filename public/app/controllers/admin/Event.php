<?php
class Event extends Admin_Controller {

    private $return_url="/admin/event";
    private $create_url="/admin/event/create";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
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
        
        $this->data_to_view["event_data"] = $this->event_model->get_event_list();
        $this->data_to_view['heading']=["ID","Event Name","Status","Date Created","Town","Areas","Actions"];
        
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_view['delete_arr']=["controller"=>"event","id_field"=>"event_id"];
        $this->data_to_header['title'] = "List of Events";
        $this->data_to_header['crumbs'] =
                   [
                   "Home"=>"/admin",
                   "Events"=>"/admin/event",
                   "List"=>"",
                   ];
        
        $this->data_to_header['page_action_list']=
                [
                    [
                        "name"=>"Add Event",
                        "icon"=>"rocket",
                        "uri"=>"event/create/add",
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
        $this->load->view("/admin/event/view", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function create($action, $id=0) {
        // additional models
        $this->load->model('town_model');
        $this->load->model('club_model');

        // load helpers / libraries
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set data
        $this->data_to_header['title'] = "Event Input Page";
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_header['css_to_load']=array(
            "plugins/typeahead/typeahead.css"
            );

        $this->data_to_footer['js_to_load']=array(
            "plugins/typeahead/handlebars.min.js",
            "plugins/typeahead/typeahead.bundle.min.js",
            );

        $this->data_to_footer['scripts_to_load']=array(
            "scripts/admin/autocomplete.js",
            );

        $this->data_to_view['status_dropdown']=$this->event_model->get_status_dropdown();
//        $this->data_to_view['town_dropdown']=$this->town_model->get_town_dropdown();
        $this->data_to_view['club_dropdown']=$this->club_model->get_club_dropdown();

        if ($action=="edit")
        {
        $this->data_to_view['event_detail']=$this->event_model->get_event_detail($id);
        $this->data_to_view['form_url']=$this->create_url."/".$action."/".$id;
        }

        // set validation rules
        $this->form_validation->set_rules('event_name', 'Event Name', 'required');
        $this->form_validation->set_rules('event_status', 'Event Status', 'required');
        $this->form_validation->set_rules('town_id', 'Town', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a town"]);

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
            $db_write=$this->event_model->set_event($action, $id);
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

    
    public function delete($event_id=0) {
        
//        echo $event_id;
//        exit();

        if (($event_id==0) AND (!is_int($event_id))) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$event_id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        // get event detail for nice delete message
        $event_detail=$this->event_model->get_event_detail($event_id);
        // delete record
        $db_del=$this->event_model->remove_event($event_id);
        
        if ($db_del)
        {
            $msg="Event has successfully been deleted: ".$event_detail['event_name'];
            $status="success";
        }
        else
        {
            $msg="Error in deleting the record:'.$event_id";
            $status="danger";
        }

        $this->session->set_flashdata('alert', $msg);
        $this->session->set_flashdata('status', $status);
        redirect($this->return_url);
    }
       
    

    public function delete_old($confirm=false) {

        $id=$this->encryption->decrypt($this->input->post('event_id'));

        if ($id==0) {
            $this->session->set_flashdata('alert', 'Cannot delete record: '.$id);
            $this->session->set_flashdata('status', 'danger');
            redirect($this->return_url);
            die();
        }

        if ($confirm=='confirm')
        {
            $db_del=$this->event_model->remove_event($id);
            if ($db_del)
            {
                $msg="Event has been deleted";
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


    public function import($submit=NULL) {

        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->library('table');

        $this->data_to_header['title'] = "Import Events";
        $this->data_to_view['form_url']="/admin/event/import/confirm";

        $config['upload_path']          = $this->upload_path;
        $config['allowed_types']        = 'csv';
        $config['max_size']             = 8192;
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload('eventfile'))
        {
            if (!empty($submit))
            {
                $this->data_to_view['error'] = $this->upload->display_errors();
            }

            $this->load->view($this->header_url, $this->data_to_header);
            $this->load->view("/admin/event/import", $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_footer);
        }
        else
        {
            if ($submit=="confirm") {
                // get file data and meta data
                // $this->data_to_view['file_meta_data'] = $this->upload->data();
                $file_data = $this->csv_handler($this->upload->data('full_path'));
                $_SESSION['import_event_data']=$this->formulate_events_data($file_data);

                // send to view
                $this->data_to_view['import_event_data']=$_SESSION['import_event_data'];

                $this->load->view($this->header_url, $this->data_to_header);
                $this->load->view("/admin/event/import", $this->data_to_view);
                $this->load->view($this->footer_url, $this->data_to_footer);

            } else {
                die("Upload failure");
            }

        }

    }


    function run_import() {
        // debug not to write to DB
        $debug=0;

        $this->load->model('edition_model');
        $this->load->model('race_model');

        $event_data=$edition_data=$race_data=[];

        // EVENTS
        foreach ($_SESSION['import_event_data'] as $event_action=>$event_list) {

            foreach ($event_list as $event_id=>$event) {

                // set die event_data array
                $event_field_list=$this->get_event_field_list();
                foreach ($event_field_list as $event_field) {
                    // as daar 'n value is
                    if ($event[$event_field]) {
                        $event_data[$event_field]=$event[$event_field];
                    }
                }
                // write to DB
                if (!empty($event_data)) {
                    $event_id=$this->event_model->set_event($event_action, $event_id, $event_data, $debug);
                }



                // EDITIONS
                foreach ($event['edition_data'] as $edition_action=>$edition_list) {

                    foreach ($edition_list as $edition_id=>$edition) {
                        // set die edition_data array
                        $edition_field_list=$this->get_edition_field_list();
                        foreach ($edition_field_list as $edition_field) {
                            // as daar 'n value is
                            if ($edition[$edition_field]) {
                                $edition_data[$edition_field]=$edition[$edition_field];
                            }
                        }

                        // write to DB
                        if (!empty($edition_data)) {
                            $edition_data['event_id']=$event_id;
                            $edition_id=$this->edition_model->set_edition($edition_action, $edition_id, $edition_data, $debug);
                        }


                        // RACES
                        foreach ($edition['race_data'] as $race_action=>$race_list) {

                            foreach ($race_list as $race_id=>$race) {
                                // set die race_data array
                                $race_field_list=$this->get_race_field_list();
                                foreach ($race_field_list as $race_field) {
                                    // as daar 'n value is
                                    if ($race[$race_field]) {
                                        $race_data[$race_field]=$race[$race_field];
                                    }
                                }

                                // write to DB
                                if (!empty($race_data)) {
                                    $race_data['edition_id']=$edition_id;
                                    $race_id=$this->race_model->set_race($race_action, $race_id, $race_data, $debug);
                                }

                                unset($race_data);
                            }
                        }

                        unset($edition_data);
                    }
                }

                unset($event_data);
            }
        }

        // go to view
        $this->session->set_flashdata([
            'alert'=>"Upload Successfull",
            'status'=>"success",
            ]);

        $this->data_to_header['crumbs'] =
                   [
                   "Home"=>"/admin",
                   "Event"=> "/admin/event",
                   "Import"=> "/admin/event/import",
                   "Success"=> "",
                   ];

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/admin/event/import_success", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

        // wts($_SESSION['import_event_data']);
        // die("i run");
    }


    public function export() {

        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->model('edition_model');

        $this->data_to_header['title'] = "Export Events";
        $this->data_to_view['form_url']="/admin/event/run_export";

        $this->data_to_view['time_period'] = $this->edition_model->get_timeperiod();
        $this->data_to_view['time_period']['all'] = "All Data";

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/admin/event/export", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

    }


    public function run_export() {
        $date_from=NULL;
        $date_to=NULL;

        $this->load->dbutil();
        $this->load->helper('download');

        $date=$this->input->post('time_period');
        // set filename
        if ($date) {
            if ($date=="all") {
                $filename="events_all.csv";
                $date_from="2016-01-01";
                $date_to=NULL;
            } else {
                $filename="events_".str_replace("-","",$date).".csv";
                $date_from=$date."-01";
                $date_to=date("Y-m-t", strtotime($date_from));

            }
        } else {
            $filename="events_generic.csv";
        }

        // get events field list to sync up with the import
        $event_field_arr=$this->get_event_field_list();
        foreach ($event_field_arr as $field) {
            if ($field=="event_id") { $field="events.event_id"; }
            if ($field=="town_id") { $field="towns.town_id"; }
            $field_arr[]=$field;
        }
        // add town name to make it easy for the user
        $field_arr[]="town_name";

        // get editions field list to sync up with the import
        $edition_field_arr=$this->get_edition_field_list();
        foreach ($edition_field_arr as $field) {
            if ($field=="edition_id") { $field="editions.edition_id"; }
            if ($field=="latitude_num") { $field="editions.latitude_num"; }
            if ($field=="longitude_num") { $field="editions.longitude_num"; }
            $field_arr[]=$field;
        }
        // get events field list to sync up with the import
        $race_field_arr=$this->get_race_field_list();
        foreach ($race_field_arr as $field) {
            $field_arr[]=$field;
        }

        /* get the object   */
        $export = $this->event_model->get_event_list_data($field_arr, $date_from, $date_to);
        /*  pass it to db utility function  */
        $new_report = $this->dbutil->csv_from_result($export);
        /*  Force download the file */
        force_download($filename, $new_report);
        /*  Done    */

    }





    // IDEE
    // doen event data. pass volle array na edition formualte met die paramater for key field. bring dan array terug met alle editions in daardie

    private function formulate_events_data($event_data) {
        $this->load->model('town_model');

        $return_arr=[];
        $event_field_list=$this->get_event_field_list();

        $n=0;
        foreach ($event_data as $le) {
            $n++;
            // as daaar 'n event ID is
            if ($le['event_id']) {
                $event_action="edit";
                $event_key_field="event_id";
            } else {
                $event_action="add";
                $event_key_field="event_name";
            }
            $event_key_value=trim($le[$event_key_field]);

            // set event level data
            foreach ($event_field_list as $event_field) {
                if (($event_field=='town_id')&&($le[$event_field]<1)) {
                    $le[$event_field]=$this->town_model->get_town_id($le['town_name']);
                }
                $return_arr[$event_action][$event_key_value][$event_field]=trim($le[$event_field]);
            }

            // add edition information
            $edition_data=$this->formulate_edition_data($event_data, $event_key_field, $event_key_value);
            $return_arr[$event_action][$event_key_value]['edition_data']=$edition_data;

        }

        return $return_arr;

    }

    private function formulate_edition_data($event_data, $event_key_field, $event_key_value) {
        $edition_field_list=$this->get_edition_field_list();

        foreach ($event_data as $le) {
            if (trim($le[$event_key_field])==$event_key_value) {
                if ($le['edition_id']) {
                    $edition_action="edit";
                    $edition_key_field="edition_id";
                } else {
                    $edition_action="add";
                    $edition_key_field="edition_name";
                }
                $edition_key_value=trim($le[$edition_key_field]);

                // set event level data
                foreach ($edition_field_list as $edition_field) {
                    $return_arr[$edition_action][$edition_key_value][$edition_field]=$le[$edition_field];
                }

                // add race information
                $race_data=$this->formulate_race_data($event_data, $edition_key_field, $edition_key_value);
                $return_arr[$edition_action][$edition_key_value]['race_data']=$race_data;

                // add race information
                $race_data=$this->formulate_race_data($event_data, $edition_key_field, $edition_key_value);
                $return_arr[$edition_action][$edition_key_value]['race_data']=$race_data;


            }
        }
        // // set edition level data
        // foreach ($edition_field_list as $edition_field) {
        //     $return_arr[$edition_field]=$le[$edition_field];
        // }

        return $return_arr;
    }

    private function formulate_race_data($event_data, $edition_key_field, $edition_key_value) {
        $race_field_list=$this->get_race_field_list();

        foreach ($event_data as $le) {
            if (trim($le[$edition_key_field])==$edition_key_value) {
                if ($le['race_id']) {
                    $race_action="edit";
                    $race_key_field="race_id";
                } else {
                    $race_action="add";
                    $race_key_field="race_name";
                }
                $race_key_value=trim($le[$race_key_field]);

                // set event level data
                foreach ($race_field_list as $race_field) {
                    $return_arr[$race_action][$race_key_value][$race_field]=$le[$race_field];
                }

                // full list item
                // $return_arr[$race_action][$race_key_value]['full_list_item']=$le;
            }
        }

        return $return_arr;
    }

}
