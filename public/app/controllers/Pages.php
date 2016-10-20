<?php
class Pages extends Frontend_Controller {

    // check if method exists, if not calls "view" method
    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method))
        {
            return call_user_func_array(array($this, $method), $params);
        }
        else
        {
            $this->view($method, $params = array());
        }


    }

    public function view($page = 'home')
    {
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['page'] = $page;

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

    public function mailer() {
        // set validation rules
        $this->form_validation->set_rules('dname', 'Your Name', 'required');
        $this->form_validation->set_rules('demail', 'Your Email', 'required|valid_email');
        $this->form_validation->set_rules('edition_date', 'Edition date', 'required');
        $this->form_validation->set_rules('event_id', 'Event', 'required|numeric|greater_than[0]',["greater_than"=>"Please select an event"]);
        $this->form_validation->set_rules('sponsor_id', 'Sponsor', 'required|numeric|greater_than[0]',["greater_than"=>"Please select a sponsort"]);

        // load correct view
        if ($this->form_validation->run() === FALSE)
        {
            $this->data_to_view['return_url']=$this->return_url;
            $this->load->view($this->header_url, $this->data_to_view);
            $this->load->view($this->create_url, $this->data_to_view);
            $this->load->view($this->footer_url, $this->data_to_view);
        }
        else
        {
        }
    }

}
