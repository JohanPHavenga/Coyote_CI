<?php
class Asanumber_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("asanumbers");
        }
        
        public function get_asanumber_list($limit, $start)
        {
            $this->db->limit($limit, $start);
            
            $this->db->select("asanumbers.*, user_name, user_surname");
            $this->db->from("asanumbers");
            $this->db->join('users', 'user_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[$row['asanumber_id']] = $row;
                }
                return $data;
            }
            return false;

        }        
        
        public function get_asanumber_dropdown() {
            $this->db->select("asanumber_id, asanumber_num, asanumber_year");
            $this->db->from("asanumbers");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['asanumber_id']] = $row['asanumber_year'] . "-".$row['asanumber_num'];
                }
//                return array_slice($data, 0, 500, true);
                return $data;
            }
            return false;
        }
        
        public function get_asanumber_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $this->db->select("asanumbers.*, user_name, user_surname");
                $this->db->from("asanumbers");
                $this->db->join('users', 'user_id', 'left');
                $this->db->where('asanumber_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_asanumber($action, $id)
        {            
            $asanumber_data = array(
                        'asanumber_num' => $this->input->post('asanumber_num'),
                        'asanumber_year' => $this->input->post('asanumber_year'),
                        'user_id' => $this->input->post('user_id'),
                    );       
            
            switch ($action) {                    
                case "add":                     
                    $this->db->trans_start();
                    $this->db->insert('asanumbers', $asanumber_data);  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();               
                case "edit":
                    // add updated date to both data arrays
                    $asanumber_data['updated_date']=date("Y-m-d H:i:s");
                    
                    // start SQL transaction
                    $this->db->trans_start();
                    $this->db->update('asanumbers', $asanumber_data, array('asanumber_id' => $id));                  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
        public function remove_asanumber($id) {
            if( ! ($id))
            {
                return false;  
            } 
            else 
            {
                // only asanumber needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('asanumbers', array('asanumber_id' => $id));               
                $this->db->trans_complete();  
                return $this->db->trans_status();    
            }
        }
        
        
}