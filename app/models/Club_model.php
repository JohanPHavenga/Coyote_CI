<?php
class Club_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("clubs");
        }
        
        public function get_club_list($limit, $start)
        {
            $this->db->limit($limit, $start);    
            
            $this->db->select("clubs.*, town_name, province_name");
            $this->db->from("clubs");
            $this->db->join('towns', 'town_id', 'left');
            $this->db->join('provinces', 'province_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;

        }
        
        public function get_club_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $query = $this->db->get_where('clubs', array('club_id' => $id));

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_club($action, $id)
        {            
            $data = array(
                        'club_name' => $this->input->post('club_name'),
                        'club_status' => $this->input->post('club_status'),
                        'town_id' => $this->input->post('town_id'),
                    );            
            
            switch ($action) {                    
                case "add": 
                    return $this->db->insert('clubs', $data);                    
                case "edit":
                    $data['updated_date']=date("Y-m-d H:i:s");
                    return $this->db->update('clubs', $data, array('club_id' => $id));
                    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
        public function remove_club($id) {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                return $this->db->delete('clubs', array('club_id' => $id));
            }
        }
        
}