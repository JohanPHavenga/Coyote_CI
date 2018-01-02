<?php
class Quote_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("quotes");
        }
        
        public function get_quote_list()
        {            
            $this->db->select("quotes.*");
            $this->db->from("quotes");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row['quote_quote'];
                }
                return $data;
            }
            return false;

        }      
      
        
}