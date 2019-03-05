<?php
class Emailque_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all("emailques");
    }

    public function get_emailque_list($top=0,$ready_to_send=false) {

        $this->db->select("emailques.*");
        $this->db->from("emailques");
        if ($top>0) { $this->db->limit($top); }
        if ($ready_to_send) { $this->db->where("emailque_isreadytosend",1); }
        $this->db->where("emailque_issent",0); 
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['emailque_id']] = $row;
            }
            return $data;
        }
        return false;
    }

    public function set_emailque($action, $id) {
        $data = array(
            'area_name' => $this->input->post('area_name'),
            'area_status' => $this->input->post('area_status'),
        );

        switch ($action) {
            case "add":
                return $this->db->insert('areas', $data);
            case "edit":
                $data['updated_date'] = date("Y-m-d H:i:s");
                return $this->db->update('areas', $data, array('area_id' => $id));

            default:
                show_404();
                break;
        }
    }

    public function remove_emailque($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->delete('areas', array('area_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }


}
