<?php

class MY_model extends CI_Model {
    
     function __construct() {
        parent::__construct();
        // Load any front-end only dependencies
    }    
    
    public function get_status_dropdown()
    {
        $this->db->select("*");
        $this->db->from("status");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data[] = "Please Select";
            foreach ($query->result_array() as $row) {
                $data[$row['status_id']] = $row['status_name'];
            }
            return $data;
        }
        return false;
    }
    
    public function get_linked_to_dropdown()
    {
        $this->db->select("*");
        $this->db->from("linked_to");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data[] = "Please Select";
            foreach ($query->result_array() as $row) {
                $data[$row['linked_to_name']] = $row['linked_to_name'];
            }
            return $data;
        }
        return false;
    }
    
    
}
