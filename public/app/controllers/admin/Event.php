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

        // pagination
        // pagination config
        $per_page=50;
        $uri_segment=4;
        $total_rows=$this->event_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);

        // pagination init
        $this->load->library("pagination");
        $this->pagination->initialize($config);
        $data["pagination"]=$this->pagination->create_links();

        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;

        $this->data_to_view["list"] = $this->event_model->get_event_list($per_page, $page);
        $this->data_to_view['create_link']=$this->create_url;
        $this->data_to_view['delete_arr']=["controller"=>"event","id_field"=>"event_id"];
        $this->data_to_header['title'] = "List of Events";

        // as daar data is
        if ($this->data_to_view["list"]) {
             $this->data_to_view['heading']=ftableHeading(array_keys($this->data_to_view['list'][key($this->data_to_view['list'])]),1);
        }

        $this->data_to_view['url']=$this->url_disect();

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view($this->view_url, $this->data_to_view);
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
        $this->data_to_view['title'] = uri_string();
        $this->data_to_view['action']=$action;
        $this->data_to_view['form_url']=$this->create_url."/".$action;

        $this->data_to_view['css_to_load']=array(
            "plugins/typeahead/typeahead.css"
            );

        $this->data_to_view['js_to_load']=array(
            "plugins/typeahead/handlebars.min.js",
            "plugins/typeahead/typeahead.bundle.min.js",
            );

        $this->data_to_view['scripts_to_load']=array(
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


    public function delete($confirm=false) {

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
                $sum_data=$this->formulate_events_data($file_data);

                // set to session
                $_SESSION['sum_data']=$sum_data;
                // send to view
                $this->data_to_view['sum_data']=$sum_data;

                $this->load->view($this->header_url, $this->data_to_header);
                $this->load->view("/admin/event/import", $this->data_to_view);
                $this->load->view($this->footer_url, $this->data_to_footer);

            } else {
                die("Upload failure");
            }

        }

    }

    // IDEE
    // doen event data. pass volle array na edition formualte met die paramater for key field. bring dan array terug met alle editions in daardie

    private function formulate_events_data($event_data) {

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
                $return_arr[$event_action][$event_key_value][$event_field]=$le[$event_field];
            }

            // add edition information
            $edition_data=$this->formulate_edition_data($event_data, $event_key_field, $event_key_value);
            $return_arr[$event_action][$event_key_value]['edition_data']=$edition_data;

            // if ($le['edition_id']) {
            //     $edition_action="edit";
            //     $edition_key_field="edition_id";
            // } else {
            //     $edition_action="add";
            //     $edition_key_field="edition_name";
            // }
            // $return_arr[$event_action][$le[$event_key_field]]['edition_data'][$edition_action][$le[$edition_key_field]] = $edition_data;
            //
            //
            // // add race information
            // $race_data=$this->formulate_race_data($le);
            //
            // if ($le['race_id']) {
            //     $race_action="edit";
            //     $race_key_field="race_id";
            // } else {
            //     $race_action="add";
            //     $race_key_field="race_name";
            // }
            // $return_arr[$event_action][$le[$event_key_field]]['edition_data'][$edition_action][$le[$edition_key_field]]['race_data'][$race_action][$le[$race_key_field]] = $race_data;
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

    private function get_event_field_list() {
        return ['event_id','event_name'];
    }
    private function get_edition_field_list() {
        return ['edition_id','edition_name','edition_date','edition_address','edition_gps'];
    }
    private function get_race_field_list() {
        return ['race_id','race_name','race_distance','race_time'];
    }



}
