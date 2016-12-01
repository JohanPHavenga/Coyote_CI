<?php
class Events extends Frontend_Controller {

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
            $this->list_events($method, $params = array());
        }
    }


    public function list_events($year=NULL)
    {
        // load helpers / libraries
        $this->load->library('table');

        $this->data_to_header['title']="Events List";
        $this->data_to_view["race_summary"] = $this->event_model->get_event_list_summary("2000-01-01");

        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/events/list", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

}
