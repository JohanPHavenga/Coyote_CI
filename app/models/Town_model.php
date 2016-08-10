<?php
class Town_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("towns");
        }
        
        public function get_town_list($limit, $start)
        {
            $this->db->limit($limit, $start);
            
            $this->db->select("*");
            $this->db->from("towns");
            $this->db->join('provinces', 'provinces.province_id = towns.province_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;

        }        
        
        public function get_town_dropdown() {
            $this->db->select("town_id, town_name, province_name");
            $this->db->from("towns");
            $this->db->join('provinces', 'provinces.province_id = towns.province_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['town_id']] = $row['town_name'] . " (".$row['province_name'].")";
                }
                return $data;
            }
            return false;
        }
        
        
}