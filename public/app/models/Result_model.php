<?php

class Result_model extends MY_model {

    public $table = "results";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all($this->table);
    }

    public function get_result_field_array() {
        $fields = $this->db->list_fields($this->table);
        foreach ($fields as $field) {
            $data[$field] = "";
        }
        return $data;
    }

    public function get_result_list() {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->join('races', 'race_id');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['result_id']] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_result_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $query = $this->db->get_where('results', array('result_id' => $id));

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function set_result($action, $id, $data) {
        switch ($action) {
            case "add":
                return $this->db->insert('results', $data);
            case "edit":
                $data['updated_date'] = date("Y-m-d H:i:s");
                return $this->db->update('results', $data, array('result_id' => $id));
            default:
                show_404();
                break;
        }
    }

    public function remove_result($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->delete('results', array('result_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

    public function search_result($ss) {

        $search_result = [];

        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->join('races', 'race_id');
        $this->db->group_start();
        $this->db->or_like("race_name", $ss);
        $this->db->or_like("result_surname", $ss);
        $this->db->or_like("result_name", $ss);
        $this->db->or_like("result_asanum", $ss);
        $this->db->or_like("result_racenum", $ss);
        $this->db->group_end();

        $this->db->order_by("result_surname", "DESC");

//            echo $this->db->get_compiled_select();
//            die();

        return $this->db->get();
    }

}
