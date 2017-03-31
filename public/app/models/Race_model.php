<?php
class Race_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function record_count() {
            return $this->db->count_all("races");
        }

        public function get_race_list($limit=NULL, $start=NULL, $edition_id=0)
        {
            if (isset($limit)&&isset($start)) {
                $this->db->limit($limit, $start);
            }

            $this->db->select("races.*, edition_name, racetype_name");
            $this->db->from("races");
            $this->db->join('editions', 'editions.edition_id=races.edition_id', 'left');
            $this->db->join('racetypes', 'racetypes.racetype_id=races.racetype_id', 'left');
            if ($edition_id>0) {
                $this->db->where('races.edition_id', $edition_id);
            }
            $this->db->where('races.race_status', 1);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[$row['race_id']] = $row;
                }
                return $data;
            }
            return false;

        }

         public function get_race_dropdown() {
            $this->db->select("race_id, race_name");
            $this->db->from("races");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['race_id']] = $row['race_name'];
                }
                return $data;
            }
            return false;
        }

        public function get_race_detail($id)
        {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                $this->db->select("races.*, edition_name");
                $this->db->from("races");
                $this->db->join('editions', 'editions.edition_id=races.edition_id', 'left');
                $this->db->where('race_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }

        public function set_race($action, $race_id, $race_data=[], $debug=false)
        {

            // POSTED DATA
            if (empty($race_data))
            {
                $race_data = array(
                            'race_name' => $this->input->post('race_name'),
                            'race_distance' => $this->input->post('race_distance'),
                            'race_time' => $this->input->post('race_time'),
                            'race_status' => $this->input->post('race_status'),
                            'edition_id' => $this->input->post('edition_id'),
                            'racetype_id' => $this->input->post('racetype_id'),
                            'race_fee_licenced' => $this->input->post('race_fee_licenced'),
                            'race_fee_unlicenced' => $this->input->post('race_fee_unlicenced'),
                        );
            } else {
                if (!isset($race_data['race_status'])) { $race_data['race_status'] = 1; }
            }

            if ($debug) {
                echo "<b>Race Transaction</b>";
                wts($action);
                // wts($race_id);
                wts($race_data);
            } else {
                switch ($action) {
                    case "add":
                        $this->db->trans_start();
                        $this->db->insert('races', $race_data);
                        // get edition ID from Insert
                        $race_id=$this->db->insert_id();
                        $this->db->trans_complete();
                        break;
                    case "edit":
                        // add updated date to both data arrays
                        $race_data['updated_date']=date("Y-m-d H:i:s");

                        // start SQL transaction
                        $this->db->trans_start();
                        $this->db->update('races', $race_data, array('race_id' => $race_id));
                        $this->db->trans_complete();
                        break;
                    default:
                        show_404();
                        break;
                }

                // return ID if transaction successfull
                if ($this->db->trans_status())
                {
                    return $race_id;
                } else {
                    return false;
                }
            }
        }


        public function remove_race($id) {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                // only race needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('races', array('race_id' => $id));
                $this->db->trans_complete();
                return $this->db->trans_status();
            }
        }


}
