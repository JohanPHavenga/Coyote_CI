<?php
class Dashboard extends Admin_Controller {

    // check if method exists, if not calls "view" method
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

    public function view($page = 'dashboard')
    {
        if ( ! file_exists(APPPATH.'views/admin/dashboard/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        $this->view_url="admin/dashboard/".$page;

        $this->data_to_header['title'] = ucfirst($page);
        $this->data_to_header['crumbs'] =
                   [
                   "Home"=>"/admin",
                   "Dashboard"=>"",
                   ];
        
        $this->data_to_footer['js_to_load']=array(
            );

        if ($page=="dashboard") {
            $this->load->model('event_model');
            $event_count=$this->event_model->record_count();
            
            $this->load->model('edition_model');
            $edition_count=$this->edition_model->record_count();
            
            $this->load->model('race_model');
            $race_count=$this->race_model->record_count();
            
            $this->data_to_view['dashboard_stats_list']=
                    [
                        [
                        "text"=>"Number of Events",
                        "number"=>$event_count,
                        "font-color"=>"green-sharp",
                        "icon"=>"icon-pie-chart", 
                        "uri"=>"/admin/event/view",
                        ],
                        [
                        "text"=>"Number of Editions",
                        "number"=>$edition_count,
                        "font-color"=>"red-haze",
                        "icon"=>"icon-pie-chart", 
                        "uri"=>"/admin/edition/view",
                        ], 
                        [
                        "text"=>"Number of Races",
                        "number"=>$race_count,
                        "font-color"=>"blue-sharp",
                        "icon"=>"icon-pie-chart", 
                        "uri"=>"/admin/race/view",
                        ],
                        //font-purple-soft
                    ];
            
            // actions on the toolbar
            $this->data_to_header['page_action_list']=
                    [
                        [
                            "name"=>"Add Event",
                            "icon"=>"rocket",
                            "uri"=>"event/create/add",
                        ],
                        [
                            "name"=>"Add Edition",
                            "icon"=>"calendar",
                            "uri"=>"edition/create/add",
                        ],
                        [
                            "name"=>"Add Race",
                            "icon"=>"trophy",
                            "uri"=>"race/create/add",
                        ],
                    ];
        }

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }


    public function search() {
        $page = "search";
        $this->view_url="admin/dashboard/".$page;

        $this->data_to_header['title'] = ucfirst($page);

        $this->load->view($this->header_url, $this->data_to_header);
        $this->load->view($this->view_url, $this->data_to_view);
        $this->load->view($this->footer_url, $this->data_to_footer);
    }

}
