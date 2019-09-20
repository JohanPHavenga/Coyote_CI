<?php

class Date_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all("dates");
    }

    public function exists($linked_to, $linked_id, $datetype_id) {
        $this->db->select("date_id");
        $this->db->from("dates");
        $this->db->where('date_linked_to', $linked_to);
        $this->db->where('linked_id', $linked_id);
        $this->db->where('datetype_id', $datetype_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['date_id'];
        }
        return false;
    }

    public function get_date_list($linked_to = NULL, $linked_id = 0, $by_date_type = false) {
        $this->db->select("*");
        $this->db->join("datetypes", "datetype_id");
        $this->db->from("dates");
        if ($linked_to) {
            $this->db->where('date_linked_to', $linked_to);
        }
        if ($linked_id > 0) {
            $this->db->where('linked_id', $linked_id);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                if ($by_date_type) {
//                    $date_list[$row['datetype_id']][$row["linked_id"]] = $row;
                    $date_list[$row['datetype_id']][] = $row;
                } else {
                    $date_list[$row['date_id']] = $row;
                }
            }
            return $date_list;
        }
        return false;
    }

    public function get_date_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("dates.*");
            $this->db->from("dates");
            $this->db->where('date_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function set_date($action, $date_id, $date_data = [], $debug = false) {

        // POSTED DATA
        if (empty($date_data)) {
            $id_type = $this->input->post("date_linked_to") . "_id";
            $id = $this->input->post($id_type);

            $date_data = array(
                'date_start' => $this->input->post('date_start'),
                'date_end' => $this->input->post('date_end'),
                'datetype_id' => $this->input->post('datetype_id'),
                'date_linked_to' => $this->input->post('date_linked_to'),
                'linked_id' => $id,
            );
        }

        if ($debug) {
            echo "<p><b>URL SET Transaction</b></p>";
            echo "ACTION: " . $action . "<br>";
            echo "URL ID: " . $date_id . "<br>";
            wts($date_data);
            die();
        } else {
            switch ($action) {
                case "add":
                    $this->db->trans_start();
                    $this->db->insert('dates', $date_data);
                    $sql = $this->db->set($date_data)->get_compiled_insert('dates');
                    //                wts($sql);
                    //                die();

                    $date_id = $this->db->insert_id();
                    $this->db->trans_complete();
                    break;
                case "edit":
                    // add updated date to both data arrays
                    $date_data['updated_date'] = date("Y-m-d H:i:s");

                    // start SQL transaction
                    $this->db->trans_start();
                    $this->db->update('dates', $date_data, array('date_id' => $date_id));
                    $this->db->trans_complete();
                    break;
                default:
                    show_404();
                    break;
            }
            // return ID if transaction successfull
            if ($this->db->trans_status()) {
                return $date_id;
            } else {
                return false;
            }
        }
    }

    public function remove_date($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->delete('dates', array('date_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

    public function check_datetype_exists($linked_to, $id, $datetype_id) {
        $this->db->select("date_id");
        $this->db->from("dates");
        $this->db->where('date_linked_to', $linked_to);
        $this->db->where('linked_id', $id);
        $this->db->where('datetype_id', $datetype_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
