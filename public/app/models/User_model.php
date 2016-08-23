<?php
class User_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("users");
        }
        
        public function get_user_list($limit, $start)
        {
            $this->db->limit($limit, $start);    
            
            $this->db->select("users.*, club_name");
            $this->db->from("users");
            $this->db->join('clubs', 'club_id');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;

        }
        
        public function get_user_dropdown() {
            $this->db->select("user_id, user_name, user_surname");
            $this->db->from("users");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['user_id']] = $row['user_name']." ".$row['user_surname'];
                }
                return $data;
            }
            return false;
        }
        
        public function get_user_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $this->db->select("users.*, club_id");
                $this->db->from("users");
                $this->db->join('clubs', 'club_id', 'left');
                $this->db->where('user_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_user($action, $id)
        {            
            $user_data = array(
                        'user_name' => $this->input->post('user_name'),
                        'user_surname' => $this->input->post('user_surname'),
                        'club_id' => $this->input->post('club_id'),
                    );
            
            switch ($action) {                    
                case "add":                     
                    $this->db->trans_start();
                    $this->db->insert('users', $user_data);  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();               
                case "edit":
                    // add updated date to both data arrays
                    $user_data['updated_date']=date("Y-m-d H:i:s");
                    
                    // start SQL transaction
                    $this->db->trans_start();
                    $this->db->update('users', $user_data, array('user_id' => $id));                  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
        public function remove_user($id) {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                // only edition needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('users', array('user_id' => $id));               
                $this->db->trans_complete();  
                return $this->db->trans_status();    
            }
        }
        
        
}