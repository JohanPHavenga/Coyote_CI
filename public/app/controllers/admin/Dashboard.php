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
    
    public function view($page = 'home')
    {
        if ( ! file_exists(APPPATH.'views/admin/dashboard/'.$page.'.php'))
        {
                // Whoops, we don't have a page for that!
                show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header_admin', $data);
        $this->load->view('admin/dashboard/'.$page, $data);
        $this->load->view('templates/footer_admin', $data);
    }
        
}