<?php
class Sponsor_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("sponsors");
        }
        
        public function get_sponsor_list($limit, $start)
        {
            $this->db->limit($limit, $start);    
            
            $this->db->select("sponsors.*");
            $this->db->from("sponsors");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[$row['sponsor_id']] = $row;
                }
                return $data;
            }
            return false;

        }
        
        public function get_sponsor_dropdown() {
            $this->db->select("sponsor_id, sponsor_name");
            $this->db->from("sponsors");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['sponsor_id']] = $row['sponsor_name'];
                }
//                return array_slice($data, 0, 500, true);
                return $data;
            }
            return false;
        }
        
        public function get_sponsor_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $query = $this->db->get_where('sponsors', array('sponsor_id' => $id));

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_sponsor($action, $id)
        {            
            $data = array(
                        'sponsor_name' => $this->input->post('sponsor_name'),
                        'sponsor_status' => $this->input->post('sponsor_status'),
                    );            
            
            switch ($action) {                    
                case "add": 
                    return $this->db->insert('sponsors', $data);                    
                case "edit":
                    $data['updated_date']=date("Y-m-d H:i:s");
                    return $this->db->update('sponsors', $data, array('sponsor_id' => $id));
                    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
        public function remove_sponsor($id) {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $this->db->trans_start();
                $this->db->delete('sponsors', array('sponsor_id' => $id));             
                $this->db->trans_complete();  
                return $this->db->trans_status();    
            }
        }
        
}