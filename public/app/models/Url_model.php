<?php
class Url_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function set_url($params) {
        // FIRST SEE IF FILE ALREADY EXISTS
        if ($url_id=$this->get_url_id($params)) {
            $action = "edit";
        } else {
            $action = "add";
        }
        // set array to be written to DB        
        $url_data = array(
            'url_name' => $params['data']['url_name'],
            'url_type' => $params['data']['url_type'],
            'edition_id' => $params['data']['edition_id'],
            'race_id' => $params['data']['race_id'],
            'sponsor_id' => $params['data']['sponsor_id'],
            'club_id' => $params['club_id']
        );        

//        echo $action;        
//        wts($params);
//        wts($url_data);
//        die();

        switch ($action) {
            case "add":
                $this->db->trans_start();
                $this->db->insert('urls', $url_data);
                $url_id = $this->db->insert_id();
                $this->db->trans_complete();
                break;
            case "edit":
                // add updated date to both data arrays
                $url_data['updated_date'] = date("Y-m-d H:i:s");
                $this->db->trans_start();
                $this->db->update('urls', $url_data, array('url_id' => $url_id));
                $this->db->trans_complete();
                break;
            default:
                show_404();
                break;
        }
        // return ID if transaction successfull
        if ($this->db->trans_status()) {
            return $url_id;
        } else {
            return false;
        }
    }

    public function get_url_id($params) {
       
        $this->db->select("url_id");
        $this->db->from("urls");
        $this->db->where("url_name", $params['data']['orig_name']);
        $this->db->where("url_linked_to", $params['url_linked_to']);
        $this->db->where("linked_id", $params['id']);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['url_id'];
        } else {
            return false;
        }
      
    }

    public function get_url_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("*");
            $this->db->from("urls");
            $this->db->join('urltypes', 'urltype_id');
            $this->db->where('url_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function get_url_list($by_urltype=false,$url_linked_to=NULL, $linked_id=0) {
        
        $this->db->select("urls.*,urltypes.*");
        $this->db->from("urls");
        $this->db->join('urltypes', 'urltype_id');
        if ($url_linked_to) {
            $this->db->where("url_linked_to", $url_linked_to);
            $this->db->where("linked_id", $linked_id);
        }
//            $this->db->join('editions', 'edition_id',"left outer");
//            $this->db->join('races', 'race_id',"left outer");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                if ($by_urltype) {
                    $url_list[$row['urltype_id']][]=$row;
                } else {                    
                    $url_list[]=$row;
                }
            }
            return $url_list;
        }
        return false;
        
    }

    public function remove_url($url_id) {
        
        $this->load->helper("url");
        $this->db->trans_start();
        $this->db->delete('urls', array('url_id' => $url_id));
        $this->db->trans_complete();
        return $this->db->trans_status();
        
    }

}
