<?php

class Usersubscriptions_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all("usersubscriptions");
    }
    
    public function exists($user_id, $linked_to, $linked_id) {
        $this->db->select("*");
        $this->db->from("usersubscriptions");  
        $this->db->where('user_id', $user_id);               
        $this->db->where('linked_to', $linked_to);
        $this->db->where('linked_id', $linked_id);    
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function get_usersubscription_list($linked_to=NULL, $linked_id=0,$by_usersubscriptiontype=false) {

        $this->db->select("usersubscriptions.*, usersubscriptiontype_name");
        $this->db->join("usersubscriptiontypes", "usersubscriptiontype_id");
        $this->db->from("usersubscriptions");
        
        if ($linked_id>0) {
            $this->db->where('usersubscription_linked_to', $linked_to);
            $this->db->where('linked_id', $linked_id);
        }
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                if ($by_usersubscriptiontype) {
                    $usersubscription_list[$row['usersubscriptiontype_id']][]=$row;
                } else {                    
                    $usersubscription_list[]=$row;
                }
                
//                $data[$row['usersubscription_id']] = $row;
            }
            return $usersubscription_list;
//            return $data;
        }
        return false;
    }

    public function get_usersubscription_dropdown() {
        $this->db->select("usersubscription_id, usersubscription_name");
        $this->db->from("usersubscriptions");
        $this->db->order_by('usersubscription_name');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data[] = "Please Select";
            foreach ($query->result_array() as $row) {
                $data[$row['usersubscription_id']] = $row['usersubscription_name'];
            }
//                return array_slice($data, 0, 500, true);
            return $data;
        }
        return false;
    }

    public function get_usersubscription_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("usersubscriptions.*");
            $this->db->from("usersubscriptions");
            $this->db->where('usersubscription_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function set_usersubscription($action, $usersubscription_id, $usersubscription_data=[], $debug=false) {
        
        // POSTED DATA
        if (empty($usersubscription_data))
        {
            $id_type = $this->input->post("usersubscription_linked_to") . "_id";
            $id = $this->input->post($id_type);

            $usersubscription_data = array(
                'usersubscription_name' => $this->input->post('usersubscription_name'),
                'usersubscriptiontype_id' => $this->input->post('usersubscriptiontype_id'),
                'usersubscription_linked_to' => $this->input->post('usersubscription_linked_to'),
                'linked_id' => $id,
            );
        } 

        if ($debug) {
            echo "<p><b>URL SET Transaction</b></p>";
            echo "ACTION: ".$action."<br>";
            echo "URL ID: ".$usersubscription_id."<br>";
            wts($usersubscription_data);
            die();
        } else {
            switch ($action) {
                case "add":
                    $this->db->trans_start();
                    $this->db->insert('usersubscriptions', $usersubscription_data);
                    $sql = $this->db->set($usersubscription_data)->get_compiled_insert('usersubscriptions');
    //                wts($sql);
    //                die();

                    $usersubscription_id = $this->db->insert_id();
                    $this->db->trans_complete();
                    break;
                case "edit":
                    // add updated date to both data arrays
                    $usersubscription_data['updated_date'] = date("Y-m-d H:i:s");

                    // start SQL transaction
                    $this->db->trans_start();
                    $this->db->update('usersubscriptions', $usersubscription_data, array('usersubscription_id' => $usersubscription_id));
                    $this->db->trans_complete();
                    break;
                default:
                    show_404();
                    break;
            }
            // return ID if transaction successfull
            if ($this->db->trans_status()) {
                return $usersubscription_id;
            } else {
                return false;
            }
        }
    }

    public function remove_usersubscription($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->delete('usersubscriptions', array('usersubscription_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }
    
    public function check_usersubscriptiontype_exists($linked_to, $id, $usersubscriptiontype_id) {
        $this->db->select("usersubscription_id");
        $this->db->from("usersubscriptions");
        $this->db->where('usersubscription_linked_to', $linked_to);
        $this->db->where('linked_id', $id);
        $this->db->where('usersubscriptiontype_id', $usersubscriptiontype_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
