<?php

class File_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function set_file($params) {
        // FIRST SEE IF FILE ALREADY EXISTS
        if ($this->get_file_id($params)) {
            $action = "edit";
        } else {
            $action = "add";
        }
        // set array to be written to DB        
        $file_data = array(
            'file_name' => $params['data']['file_name'],
            'file_type' => $params['data']['file_type'],
            'file_ext' => $params['data']['file_ext'],
            'file_size' => $params['data']['file_size'],
            'file_is_image' => $params['data']['is_image'],
            'filetype_id' => $params['filetype_id'],
            $params['id_type'] => $params['id'],
        );
        if ($params['data']['is_image']) {
            $file_data['file_height'] = $params['data']['image_height'];
            $file_data['file_width'] = $params['data']['image_width'];
        }

//        echo $action;        
//        wts($params);
//        wts($file_data);
//        die();

        switch ($action) {
            case "add":
                $this->db->trans_start();
                $this->db->insert('files', $file_data);
                $file_id = $this->db->insert_id();
                $this->db->trans_complete();
                break;
            case "edit":
                // add updated date to both data arrays
                $file_data['updated_date'] = date("Y-m-d H:i:s");
                $this->db->trans_start();
                $this->db->update('files', $file_data, array('file_id' => $file_id));
                $this->db->trans_complete();
                break;
            default:
                show_404();
                break;
        }
        // return ID if transaction successfull
        if ($this->db->trans_status()) {
            return $file_id;
        } else {
            return false;
        }
    }

    public function get_file_id($params) {
        if (!$params['data']['orig_name']) {
            return false;
        } else {
            $this->db->select("file_id");
            $this->db->from("files");
            $this->db->where("file_name", $params['data']['orig_name']);
            $this->db->where($params['id_type'], $params['id']);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
                return $result[0]['file_id'];
            } else {
                return false;
            }
        }
    }

    public function get_file_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("*");
            $this->db->from("files");
            $this->db->join('filetypes', 'filetype_id');
            $this->db->where('file_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function get_file_list($id_type=NULL, $id=0) {
        if (!$id) {
            return false;
        } else {
            $this->db->select("files.*,filetypes.*,editions.edition_name");
            $this->db->from("files");
            $this->db->join('filetypes', 'filetype_id');
            if ($id_type) {
                $this->db->where($id_type, $id);
            }
            $this->db->join('editions', 'edition_id');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $file_list[$row['filetype_id']][]=$row;
                }
                return $file_list;
            }
            return false;
        }
    }

    public function remove_file($file_id,$path) {
        
        $this->load->helper("file");
        // physical file delete
        unlink($path);
        $this->db->trans_start();
        $this->db->delete('files', array('file_id' => $file_id));
        $this->db->trans_complete();
        return $this->db->trans_status();
        
    }

}
