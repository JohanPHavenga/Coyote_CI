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
        
        public function get_province_dropdown() {
            $this->db->select("province_id, province_name");
            $this->db->from("provinces");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['province_id']] = $row['province_name'];
                }
//                return array_slice($data, 0, 500, true);
                return $data;
            }
            return false;
        }
        
        
}