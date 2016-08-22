<?php
class Race_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("races");
        }
        
        public function get_race_list($limit, $start)
        {
            $this->db->limit($limit, $start);    
            
            $this->db->select("races.*, edition_name");
            $this->db->from("races");
            $this->db->join('editions', 'editions.edition_id=races.edition_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;

        }
        
        public function get_race_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $this->db->select("races.*, edition_name");
                $this->db->from("races");
                $this->db->join('editions', 'editions.edition_id=races.edition_id', 'left');
                $this->db->where('race_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_race($action, $id)
        {            
            $race_data = array(
                        'race_name' => $this->input->post('race_name'),
                        'race_distance' => $this->input->post('race_distance'),
                        'race_date' => $this->input->post('race_date'),
                        'race_status' => $this->input->post('race_status'),
                        'edition_id' => $this->input->post('edition_id'),
                    );       
            
            switch ($action) {                    
                case "add":                     
                    $this->db->trans_start();
                    $this->db->insert('races', $race_data);  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();               
                case "edit":
                    // add updated date to both data arrays
                    $race_data['updated_date']=date("Y-m-d H:i:s");
                    
                    // start SQL transaction
                    $this->db->trans_start();
                    $this->db->update('races', $race_data, array('race_id' => $id));                  
                    $this->db->trans_complete();  
                    return $this->db->trans_status();    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
        public function remove_race($id) {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                // only race needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('races', array('race_id' => $id));               
                $this->db->trans_complete();  
                return $this->db->trans_status();    
            }
        }
        
        
}