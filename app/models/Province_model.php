<?php
class Province_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        
        public function get_province_list($id = FALSE)
        {
            if ($id === FALSE)
            {
                $query = $this->db->get('provinces');
                return $query->result_array();
            }

            $query = $this->db->get_where('provinces', array('province_id' => $id));
            return $query->result_array();
        }
        
        
}