<?php

class Delete extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('formulate');
            
    }
    
    public function _remap($params)
    {        
        $this->delete($params);
    }
    
    
    private function delete($params) {
        $decrypt=$this->encryption->decrypt(base64_decode($this->uri->segment(3)));
        $decrypt_arr= explode("|", $decrypt);
        $data['controller']=$decrypt_arr[0];
        $data['id_field']=$decrypt_arr[1];
        $data['id']=$this->encryption->encrypt($decrypt_arr[2]);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data["title"]="Delete Confirmation";
        
//        wts($data);
//        echo $decrypt_arr[2];
                
        $this->load->view('templates/header_admin', $data);
        $this->load->view('admin/delete', $data);
        $this->load->view('templates/footer_admin');
    }    
}    
