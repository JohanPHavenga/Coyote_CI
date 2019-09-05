<?php

class Entrytype_model extends MY_model {

    public $table = "entrytypes";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all($this->table);
    }
    
    public function get_entrytype_field_array() {
        $fields = $this->db->list_fields($this->table);
        foreach ($fields as $field) {
            $data[$field] = "";
        }
        return $data;
    }

    public function get_entrytype_list($limit = 100, $start = 0) {
        $this->db->limit($limit, $start);

        $this->db->select("entrytypes.*");
        $this->db->from($this->table);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['entrytype_id']] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_entrytype_dropdown() {
        $this->db->select("entrytype_id, entrytype_name");
        $this->db->from($this->table);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data[] = "Please Select";
            foreach ($query->result_array() as $row) {
                $data[$row['entrytype_id']] = $row['entrytype_name'];
            }
            return $data;
        }
        return false;
    }

    public function get_entrytype_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $query = $this->db->get_where($this->table, array('entrytype_id' => $id));

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function set_entrytype($action, $id) {
        $data = array(
            'entrytype_name' => $this->input->post('entrytype_name'),
            'entrytype_status' => $this->input->post('entrytype_status'),
        );

        switch ($action) {
            case "add":
                return $this->db->insert($this->table, $data);
            case "edit":
                $data['updated_date'] = date("Y-m-d H:i:s");
                return $this->db->update($this->table, $data, array('entrytype_id' => $id));

            default:
                show_404();
                break;
        }
    }

    public function remove_entrytype($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->delete($this->table, array('entrytype_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

}
