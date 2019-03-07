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
        $this->db->limit(3);
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
    
    public function get_linked_to_list()
    {
        $this->db->select("*");
        $this->db->from("linked_to");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['linked_to_id']] = $row['linked_to_name'];
            }
            return $data;
        }
        return false;
    }
    
    public function set_results_flag($linked_to, $linked_id, $flag) {
        $id_field=$linked_to."_id";
        $table=$linked_to."s";
        $field=$linked_to."_results_isloaded";
        
        $this->db->trans_start();
        $this->db->update($table, [$field => $flag], array($id_field => $linked_id));
        $this->db->trans_complete();
              
        // return ID if transaction successfull
        if ($this->db->trans_status()) {
            return true;
        } else {
            return false;
        }
    }
    
    
}
