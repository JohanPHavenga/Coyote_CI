<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    
    private function hash_pass($password) 
    {
        return sha1($password."37");
    }
    
    public function record_count() {
        return $this->db->count_all("users");
    }
    

    public function get_user_list($limit, $start)
    {
        $this->db->limit($limit, $start);    

        $this->db->select("users.*, club_name");
        $this->db->from("users");
        $this->db->join('clubs', 'club_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['user_id']] = $row;
            }
            return $data;
        }
        return false;
    }
    

    public function get_user_dropdown() {
        $this->db->select("user_id, user_name, user_surname");
        $this->db->from("users");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data[] = "Please Select";
            foreach ($query->result_array() as $row) {
                $data[$row['user_id']] = $row['user_name']." ".$row['user_surname'];
            }
            return $data;
        }
        return false;
    }
    

    public function get_user_detail($id)
    {
        if( ! ($id)) 
        {
            return false;  
        } 
        else 
        {
            $this->db->select("users.*, club_id");
            $this->db->from("users");
            $this->db->join('clubs', 'club_id', 'left');
            $this->db->where('user_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }

    }
    

    public function set_user($action, $id)
    {            
        $user_data = array(
                    'user_name' => $this->input->post('user_name'),
                    'user_surname' => $this->input->post('user_surname'),
                    'user_username' => $this->input->post('user_username'),
                    'user_password' => $this->hash_pass($this->input->post('user_password')),
                    'club_id' => $this->input->post('club_id'),
                );

        switch ($action) {                    
            case "add":                     
                $this->db->trans_start();
                $this->db->insert('users', $user_data);  
                    // get event ID from Insert
                $user_id=$this->db->insert_id();          
                // update data array
                foreach ($this->input->post('role_id') as $role_id) {
                    $this->db->insert('user_role', ["user_id"=>$user_id,"role_id"=>$role_id]);
                }                
                $this->db->trans_complete();  
                return $this->db->trans_status();               
                
            case "edit":
                // add updated date to both data arrays
                $user_data['updated_date']=date("Y-m-d H:i:s");
                //check of password wat gepost is alreeds gehash is
                if ($this->check_password($this->input->post('user_password')))
                {
                    unset($user_data['user_password']);
                }

                // start SQL transaction
                $this->db->trans_start();
                $this->db->update('users', $user_data, array('user_id' => $id));
                
                // delete uit user_role
                $this->db->where('user_id', $id);
                $this->db->delete('user_role');
                // add nuwe entries
                foreach ($this->input->post('role_id') as $role_id) {
                    $this->db->insert('user_role', ["user_id"=>$id,"role_id"=>$role_id]);
                }                
                
                $this->db->trans_complete();
                return $this->db->trans_status();
            default:
                show_404();
                break;
        }

    }


    public function remove_user($id) {
        if( ! ($id))
        {
            return false;
        }
        else
        {
            // only edition needed, SQL key constraints used to remove records from organizing_club
            $this->db->trans_start();
            $this->db->delete('users', array('user_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }
    
    
    public function check_login($login_type="user")
    {            
        $user_data = array(
                    'user_username' => $this->input->post('user_username'),
                    'user_password' => $this->hash_pass($this->input->post('user_password')),
                );
                
        $this->db->select("users.user_id, user_name, user_surname, role_id");
        $this->db->from("users");
        if ($login_type=="admin") {
            $this->db->join("user_role","users.user_id=user_role.user_id"); 
            $user_data["role_id"]=1;
        }
        $this->db->where($user_data); 
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;

    }
    
    private function check_password($password)
    {            
        $this->db->where('user_password', $password);
        $this->db->from('users');
        return $this->db->count_all_results();
    }
    
}