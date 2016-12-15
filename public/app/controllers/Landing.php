<?php
class Landing extends Frontend_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->data_to_header['section']="landing";
    }

    // check if method exists, if not calls "page" method
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->page($method, $params = array());
        }
    }


    public function page($area) {
        // as daar nie 'n edition_name deurgestuur word nie
        if ($area=="index") { redirect("/event/calendar");  }
        $area_name=urldecode($area);

        $race_list=[];
        $race_list=$this->event_model->get_event_list_summary(date("Y-m-d"), NULL, $area_name);
        // wts($race_list);
        // die();

        if (empty($race_list))
        {
            $this->data_to_header['title']="No races";
        }
        else
        {
            $this->data_to_header['title']="Road Running Events in ".$area_name;
        }

        // set data to view
        $this->data_to_header['css_to_load']=array();
        $this->data_to_footer['js_to_load']=array();
        $this->data_to_footer['scripts_to_load']=array();

        // set data to the view
        $this->data_to_view["area"]=$area_name;
        $this->data_to_view["race_summary"]=$race_list;
        // set title bar
        $crumbs=[
            "Races in ".ucwords($area_name)=>"",
            "Home"=>"/",
        ];
        $this->data_to_view["title_bar"]=$this->render_topbar_html(
            [
                "title"=>$this->data_to_header['title'],
                "sub_title" => "List of upcoming road running events in and around ".ucwords($area_name)."",
                "crumbs"=>$crumbs,
            ]);


        // load view
        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view("/landing/page", $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);

    }


}
