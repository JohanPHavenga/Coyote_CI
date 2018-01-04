<?php
class Town extends Admin_Controller {

    private $return_url="/admin/town";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('town_model');

    }

    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->view();
        }
    }

    public function view($id = FALSE) {
        // load helpers / libraries
        $this->load->library('table');

        $url_disect=$this->url_disect();

        // pagination
        // pagination config
        $per_page=50;
        $uri_segment=count($url_disect['url_string_arr']);
        $total_rows=$this->town_model->record_count();
        $config=fpaginationConfig($this->return_url, $per_page, $total_rows, $uri_segment);

        // pagination init
        $this->load->library("pagination");
        $this->pagination->initialize($config);
        $this->data_to_view["pagination"]=$this->pagination->create_links();

        // set data
        $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $this->data_to_view["list"] = $this->town_model->get_town_list($per_page, $page);
        $this->data_to_header['title'] = "List of Towns";

        // as daar data is
        if ($this->data_to_view["list"]) {
            $this->data_to_view['heading']=ftableHeading(array_keys($this->data_to_view['list'][key($this->data_to_view['list'])]));
        }

        // load view;
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function json($ss='') {
        if (empty($ss)) { die("No search string passed"); }
        $this->data_to_view["search_result"]=$this->town_model->town_search($ss);
        $this->load->view("/admin/json", $this->data_to_view);
    }

}
