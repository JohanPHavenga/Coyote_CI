<?php

class Edition_model extends MY_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function record_count() {
        return $this->db->count_all("editions");
    }

    public function get_edition_id_from_name($edition_name) {
        // CHECK Editions table vir die naame
        $this->db->select("edition_id, edition_name, edition_status");
        $this->db->from("editions");
        $this->db->where("edition_name", $edition_name);
//            $this->db->where("REPLACE(edition_name, '\'', '')='$edition_name'"); // fix vir as daar 'n ' in die naam is
//            $this->db->or_where("REPLACE(edition_name, '/', ' ')=$edition_name`"); // fix vir as daar 'n / in die naam is
//            echo $this->db->get_compiled_select(); exit();
        $editions_query = $this->db->get();


        // CHECK Editions_Past vir as die naam van die edition verander
        $this->db->select("edition_id");
        $this->db->from("editions_past");
        $this->db->where("edition_name", $edition_name);
//            $this->db->where("REPLACE(edition_name, '\'', '')=`$edition_name`"); // fix vir as daar 'n ' in die naam is
//            $this->db->or_where("REPLACE(edition_name, '/', ' ')='$edition_name'"); // fix vir as daar 'n / in die naam is
//            echo $this->db->get_compiled_select();   exit();

        $editions_past_query = $this->db->get();


        if ($editions_query->num_rows() > 0) {
            $result = $editions_query->result_array();
            return $result[0];
        } elseif ($editions_past_query->num_rows() > 0) {
            $result = $editions_past_query->result_array();
            $result[0]['edition_name'] = $this->get_edition_name_from_id($result[0]['edition_id']);
            return $result[0];
        } else {
            return false;
        }
    }

    public function get_edition_name_from_id($edition_id) {
        // CHECK Editions table vir die naame
        $this->db->select("edition_name");
        $this->db->from("editions");
        $this->db->where("edition_id", $edition_id);
        $editions_query = $this->db->get();
        if ($editions_query->num_rows() > 0) {
            $result = $editions_query->result_array();
            return $result[0]['edition_name'];
        } else {
            return false;
        }
    }

    public function get_edition_url_from_id($edition_id) {
        // CHECK Editions table vir die naame
        $this->db->select("edition_name");
        $this->db->from("editions");
        $this->db->where("edition_id", $edition_id);
        $editions_query = $this->db->get();
        if ($editions_query->num_rows() > 0) {
            $result = $editions_query->result_array();
            $e_name = $result[0]['edition_name'];
            $return = [
                'edition_id' => $edition_id,
                'edition_name' => $e_name,
                'edition_url' => base_url() . "event/" . encode_edition_name($e_name)
            ];
            return $return;
        } else {
            return false;
        }
    }

    public function get_edition_list() {
        $this->db->select("editions.*, event_name, asa_member_abbr");
        $this->db->from("editions");
        $this->db->join('events', 'events.event_id=editions.event_id', 'left');
        $this->db->join('edition_asa_member', 'edition_id', 'left');
        $this->db->join('asa_members', 'asa_member_id', 'left');

        $this->db->order_by('editions.edition_date', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['edition_id']] = $row;
            }
            return $data;
        }
        return false;
    }

    public function get_edition_dropdown($use_names = false) {
        $this->db->select("edition_id, edition_name");
        $this->db->from("editions");
        // limit the list a little
        $this->db->where("edition_date > ", date("Y-m-d", strtotime("4 months ago")));
//            $this->db->where("edition_date < ", date("Y-m-d", strtotime("+9 month")));
        $this->db->order_by("edition_name");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            if ($use_names) {
                $data["General Query"] = "No event selected";
                foreach ($query->result_array() as $row) {
                    $data[$row['edition_name']] = $row['edition_name'];
                }
            } else {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['edition_id']] = $row['edition_name'];
                }
            }
            return $data;
        }
        return false;
    }

    public function get_edition_list_simple() {
        $data[0] = "All Editions";
        $this->db->select("edition_id, edition_name");
        $this->db->from("editions");
        $this->db->order_by("edition_id");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['edition_id']] = $row['edition_name'];
            }
        }
        return $data;
    }

    public function get_edition_detail($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("editions.*, sponsor_id, users.user_id, user_name, user_surname, user_email, asa_member_id AS edition_asa_member");
            $this->db->from("editions");
            $this->db->join('edition_sponsor', 'edition_id', 'left');
            $this->db->join('edition_user', 'edition_id', 'left');
            $this->db->join('users', 'user_id', 'left');
            $this->db->join('edition_asa_member', 'edition_id', 'left');
            $this->db->where('edition_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function get_edition_detail_full($id) {
        if (!($id)) {
            return false;
        } else {
            $this->db->select("events.*,editions.*, sponsors.*, clubs.club_id, club_name, users.user_email, towns.town_name, asa_members.*");
            $this->db->from("editions");
            $this->db->join('events', 'events.event_id=editions.event_id', 'left');
            $this->db->join('organising_club', 'events.event_id=organising_club.event_id', 'left');
            $this->db->join('clubs', 'organising_club.club_id=clubs.club_id', 'left');
            $this->db->join('edition_user', 'editions.edition_id=edition_user.edition_id', 'left');
            $this->db->join('users', 'users.user_id=edition_user.user_id', 'left');
            $this->db->join('edition_sponsor', 'editions.edition_id=edition_sponsor.edition_id', 'left');
            $this->db->join('edition_asa_member', 'editions.edition_id=edition_asa_member.edition_id', 'left');
            $this->db->join('asa_members', 'edition_asa_member.asa_member_id=asa_members.asa_member_id', 'left');
            $this->db->join('sponsors', 'sponsors.sponsor_id=edition_sponsor.sponsor_id', 'left');
            $this->db->join('towns', 'towns.town_id=events.town_id', 'left');
            $this->db->where('editions.edition_id', $id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            return false;
        }
    }

    public function set_edition($action, $edition_id, $edition_data = [], $debug = false) {

        // POSTED DATA
        if (empty($edition_data)) {
//                wts($_POST);
//                exit();
            if (empty($this->input->post('edition_date_end'))) {
                $end_date = $this->input->post('edition_date');
                ;
            } else {
                $end_date = $this->input->post('edition_date_end');
            }
            if (empty($this->input->post('edition_info_isconfirmed'))) {
                $edition_info_isconfirmed = false;
            } else {
                $edition_info_isconfirmed = $this->input->post('edition_info_isconfirmed');
            }
            if (empty($this->input->post('edition_isfeatured'))) {
                $edition_isfeatured = false;
            } else {
                $edition_isfeatured = $this->input->post('edition_isfeatured');
            }

            if (empty($this->input->post('edition_entries_date_open'))) {
                $entries_open = NULL;
            } else {
                $entries_open = $this->input->post('edition_entries_date_open');
            }
            if (empty($this->input->post('edition_entries_date_close'))) {
                $entries_close = NULL;
            } else {
                $entries_close = $this->input->post('edition_entries_date_close');
            }
            $edition_data = array(
                'edition_name' => $this->input->post('edition_name'),
                'edition_status' => $this->input->post('edition_status'),
                'edition_results_status' => $this->input->post('edition_results_status'),
                'edition_date' => $this->input->post('edition_date'),
                'edition_date_end' => $end_date,
                'event_id' => $this->input->post('event_id'),
                'edition_address' => $this->input->post('edition_address'),
                'edition_address_end' => $this->input->post('edition_address_end'),
                'latitude_num' => $this->input->post('latitude_num'),
                'longitude_num' => $this->input->post('longitude_num'),
                'edition_logo' => $this->input->post('edition_logo'),
                'edition_info_isconfirmed' => $edition_info_isconfirmed,
                'edition_isfeatured' => $edition_isfeatured,
                'edition_intro_detail' => $this->input->post('edition_intro_detail'),
                'edition_entry_detail' => $this->input->post('edition_entry_detail'),
                'edition_description' => $this->input->post('edition_description'),
                'edition_entries_date_open' => $entries_open,
                'edition_entries_date_close' => $entries_close,
            );

            $edition_sponsor_data = ["edition_id" => $edition_id, "sponsor_id" => $this->input->post('sponsor_id')];
            $edition_user_data = ["edition_id" => $edition_id, "user_id" => $this->input->post('user_id')];
            if ($this->input->post('edition_asa_member') > 0) {
                $edition_asamember_data = ["edition_id" => $edition_id, "asa_member_id" => $this->input->post('edition_asa_member')];
            }
        } else {

            $edition_sponsor_data = ["edition_id" => $edition_id, "sponsor_id" => 4];
            // check if user_id is sent;
            if (@$edition_data['user_id']) {
                $user_id = $edition_data['user_id'];
                unset($edition_data['user_id']);
            } else {
                $user_id = 19;
            }
            $edition_user_data = ["edition_id" => $edition_id, "user_id" => $user_id];
            // Status check
            if (!isset($edition_data['edition_status'])) {
                $edition_data['edition_status'] = 1;
            }
            // check if asa_memberdata exists
            if (array_key_exists("edition_asa_member", $edition_data)) {
                if ($edition_data['edition_asa_member'] > 0) {
                    $edition_asamember_data = ["edition_id" => $edition_id, "asa_member_id" => $edition_data['edition_asa_member']];
                }
                unset($edition_data['edition_asa_member']);
            }
        }

        if ($debug) {
            echo "<b>Edition Transaction</b>";
            wts($_FILES);
            wts($action);
            wts($edition_id);
            wts($edition_data);
            wts(@$edition_asamember_data);
            die();
        } else {

            switch ($action) {
                case "add":
                    $this->db->trans_start();
                    $this->db->insert('editions', $edition_data);
                    // get edition ID from Insert
                    $edition_id = $this->db->insert_id();
                    // update sponser array
                    $edition_sponsor_data["edition_id"] = $edition_id;
                    $this->db->insert('edition_sponsor', $edition_sponsor_data);
                    // update user array
                    $edition_user_data["edition_id"] = $edition_id;
                    $this->db->insert('edition_user', $edition_user_data);
                    // update asamember array
                    if (@$edition_asamember_data) {
                        $edition_asamember_data["edition_id"] = $edition_id;
                        $this->db->insert('edition_asa_member', $edition_asamember_data);
                    }
                    $this->db->trans_complete();
                    break;
                case "edit":
                    // add updated date to both data arrays
                    $edition_data['updated_date'] = date("Y-m-d H:i:s");

                    // start SQL transaction
                    $this->db->trans_start();
                    // EDITION SPONSOR CHECK
                    // check if record already exists
                    $item_exists = $this->db->get_where('edition_sponsor', array('edition_id' => $edition_id, 'sponsor_id' => $this->input->post('sponsor_id')));
                    if ($item_exists->num_rows() == 0) {
                        $edition_sponsor_data['updated_date'] = date("Y-m-d H:i:s");
                        $this->db->delete('edition_sponsor', array('edition_id' => $edition_id));
                        $this->db->insert('edition_sponsor', $edition_sponsor_data);
                    }
                    // EDITION USER CHECK
                    // check if record already exists
                    $item_exists = $this->db->get_where('edition_user', array('edition_id' => $edition_id, 'user_id' => $this->input->post('user_id')));
                    if ($item_exists->num_rows() == 0) {
                        $edition_user_data['updated_date'] = date("Y-m-d H:i:s");
                        $this->db->delete('edition_user', array('edition_id' => $edition_id));
                        $this->db->insert('edition_user', $edition_user_data);
                    }
                    // EDITION ASA MEMBER CHECK
                    // check if record already exists
                    $item_exists = $this->db->get_where('edition_asa_member', array('edition_id' => $edition_id, 'asa_member_id' => $this->input->post('edition_asa_member')));
                    if ($item_exists->num_rows() == 0) {
                        $edition_user_data['updated_date'] = date("Y-m-d H:i:s");
                        $this->db->delete('edition_asa_member', array('edition_id' => $edition_id));
                        if (@$edition_asamember_data) {
                            $this->db->insert('edition_asa_member', $edition_asamember_data);
                        }
                    }
                    // UPDATE ACTUAL EDITIONS TABLE
                    $this->db->update('editions', $edition_data, array('edition_id' => $edition_id));
                    $this->db->trans_complete();


                    // check of die naam van die edition verander het, indien wel, kryf na editions_past

                    if ($this->input->post('edition_name_past') != $this->input->post('edition_name')) {
                        $this->db->trans_start();
                        $this->db->insert('editions_past', ["edition_id" => $edition_id, "edition_name" => $this->input->post('edition_name_past')]);
                        $this->db->trans_complete();
                    }


                    break;
                default:
                    show_404();
                    break;
            }
            // return ID if transaction successfull
            if ($this->db->trans_status()) {
                return $edition_id;
            } else {
                return false;
            }
        }
    }

    public function update_field($e_id, $field, $value) {
        if (!($e_id)) {
            return false;
        } else {
            $this->db->trans_start();
            $this->db->update('editions', [$field => $value], array('edition_id' => $e_id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

    public function remove_edition($id) {
        if (!($id)) {
            return false;
        } else {
            // only edition needed, SQL key constraints used to remove records from organizing_club
            $this->db->trans_start();
            $this->db->delete('editions', array('edition_id' => $id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
    }

    public function get_timeperiod() {
        $this->db->select("edition_date");
        $this->db->from("editions");
        $this->db->group_by("YEAR(edition_date)");
        $this->db->group_by("MONTH(edition_date)");
        $this->db->order_by("edition_date", "DESC");
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[date("Y-m", strtotime($row->edition_date))] = date("F Y", strtotime($row->edition_date));
            }

            return $data;
        }
        return [];
    }

}
