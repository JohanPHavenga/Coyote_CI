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
