<?php
class Event extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->data_to_header['section']="events";
    }

    // check if method exists, if not calls "view" method
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->detail($method, $params = array());
        }
    }


    public function calendar($year=NULL)
    {
        // load helpers / libraries
        $this->load->library('table');

        $this->data_to_header['title']="Events Calendar";
        $this->data_to_view["race_summary"] = $this->event_model->get_event_list_summary("2000-01-01");

        $this->data_to_header['css_to_load']=array();
        $this->data_to_footer['js_to_load']=array();
        $this->data_to_footer['scripts_to_load']=array();

        // set title bar
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_header['title'],
                "crumbs"=>$this->crumbs_arr,
            ]);

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/event/calendar", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function detail($edition_name_encoded) {
        // as daar nie 'n edition_name deurgestuur word nie
        if ($edition_name_encoded=="index") { redirect("/event/calendar");  }

        $edition_name=urldecode($edition_name_encoded);

        $this->load->model('edition_model');
        $this->load->model('race_model');

        $edition_id=$this->edition_model->get_edition_id_from_name($edition_name);

        if (!$edition_id)
        {
            // if name cannot be matched to an edition
            $this->session->set_flashdata([
                'alert'=>"Error trying to load the event details. Please try selecting it again from the list below.",
                'status'=>"danger",
                ]);
            redirect("/event/calendar");
        }
        else
        {
            $this->data_to_header['title']=$edition_name;
        }

        // set data to view
        $this->data_to_header['css_to_load']=array();
        $this->data_to_footer['js_to_load']=array();
        $this->data_to_footer['scripts_to_load']=array();

        // get event details
        $this->data_to_view['event_detail']=$this->edition_model->get_edition_detail_full($edition_id);
        $this->data_to_view['event_detail']['race_list']=$this->race_model->get_race_list(100,0,$edition_id);

        $crumbs=[
            "Details"=>"",
            "Events"=>"/event/calendar",
            "Home"=>"/",
        ];

        // set title bar
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_view['event_detail']['event_name'],
                "sub_title"=>date("Y",strtotime($this->data_to_view['event_detail']['edition_date']))." Edition",
                "crumbs"=>$crumbs,
            ]);


        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/event/detail", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

    }


}
