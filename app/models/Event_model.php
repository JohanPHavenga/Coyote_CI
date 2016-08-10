<?php
class Event_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }
        
        public function record_count() {
            return $this->db->count_all("events");
        }
        
        public function get_event_list($limit, $start)
        {
            $this->db->limit($limit, $start);    
            
            $this->db->select("events.*, town_name");
            $this->db->from("events");
            $this->db->join('towns', 'towns.town_id = events.town_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[] = $row;
                }
                return $data;
            }
            return false;

        }
        
        public function get_event_detail($id)
        {
            if( ! ($id)) 
            {
                return false;  
            } 
            else 
            {
                $query = $this->db->get_where('events', array('event_id' => $id));

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }
        
        public function set_event($action, $id)
        {
            $data = array(
                        'event_name' => $this->input->post('event_name'),
                        'town_id' => $this->input->post('town_id'),
                    );            
            
            switch ($action) {                    
                case "add": 
                    return $this->db->insert('events', $data);                    
                case "edit":
                    $data['updated_date']=date("Y-m-d H:i:s");
                    return $this->db->update('events', $data, array('event_id' => $id));
                    
                default:
                    show_404();
                    break;
            }
            
        }
        
        
}