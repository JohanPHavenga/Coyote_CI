<?php
class Edition_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function record_count()
        {
            return $this->db->count_all("editions");
        }


        public function get_edition_id_from_name($edition_nmae)
        {
            $this->db->select("edition_id");
            $this->db->from("editions");
            $this->db->where('edition_name', $edition_nmae);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result=$query->result_array();
                return $result[0]['edition_id'];
            }
            return false;
        }


        public function get_edition_list($limit, $start)
        {
            $this->db->limit($limit, $start);

            $this->db->select("editions.edition_id, edition_name, edition_date, edition_status, edition_address, event_name, sponsor_name");
            $this->db->from("editions");
            $this->db->join('events', 'events.event_id=editions.event_id', 'left');
            $this->db->join('edition_sponsor', 'editions.edition_id=edition_sponsor.edition_id', 'left');
            $this->db->join('sponsors', 'sponsors.sponsor_id=edition_sponsor.sponsor_id', 'left');

            $this->db->order_by('editions.edition_id', 'ASC');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[$row['edition_id']] = $row;
                }
                return $data;
            }
            return false;
        }


        public function get_edition_dropdown()
        {
            $this->db->select("edition_id, edition_name");
            $this->db->from("editions");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['edition_id']] = $row['edition_name'];
                }
                return $data;
            }
            return false;
        }


        public function get_edition_detail($id)
        {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                $this->db->select("editions.*, sponsor_id");
                $this->db->from("editions");
                $this->db->join('edition_sponsor', 'edition_id', 'left');
                $this->db->where('edition_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }
        }

        public function get_edition_detail_full($id)
        {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                $this->db->select("events.*,editions.*, sponsors.*");
                $this->db->from("editions");
                $this->db->join('events', 'events.event_id=editions.event_id', 'left');
                $this->db->join('edition_sponsor', 'editions.edition_id=edition_sponsor.edition_id', 'left');
                $this->db->join('sponsors', 'sponsors.sponsor_id=edition_sponsor.sponsor_id', 'left');
                $this->db->where('editions.edition_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }
        }


        public function set_edition($action, $edition_id, $edition_data=[], $debug=false)
        {
            // POSTED DATA
            if (empty($edition_data))
            {
                $edition_data = array(
                            'edition_name' => $this->input->post('edition_name'),
                            'edition_status' => $this->input->post('edition_status'),
                            'edition_date' => $this->input->post('edition_date'),
                            'event_id' => $this->input->post('event_id'),
                        );
                $edition_sponsor_data = ["edition_id"=>$edition_id,"sponsor_id"=>$this->input->post('sponsor_id')];
            } else {
                $edition_sponsor_data = ["edition_id"=>$edition_id,"sponsor_id"=>4];
                if (!isset($edition_data['edition_status'])) { $edition_data['edition_status'] = 1; }
            }

            if ($debug) {
                echo "<b>Edition Transaction</b>";
                wts($action);
                // wts($edition_id);
                wts($edition_data);
                die();
            } else {

                switch ($action) {
                    case "add":
                        $this->db->trans_start();
                        $this->db->insert('editions', $edition_data);
                        // get edition ID from Insert
                        $edition_id=$this->db->insert_id();
                        // update data array
                        $edition_sponsor_data["edition_id"]=$edition_id;
                        $this->db->insert('edition_sponsor', $edition_sponsor_data);
                        $this->db->trans_complete();
                        break;
                    case "edit":
                        // add updated date to both data arrays
                        $edition_data['updated_date']=date("Y-m-d H:i:s");

                        // start SQL transaction
                        $this->db->trans_start();
                        // chcek if record already exists
                        $item_exists = $this->db->get_where('edition_sponsor', array('edition_id' => $edition_id, 'sponsor_id' => $this->input->post('sponsor_id')));
                        if ($item_exists->num_rows() == 0)
                        {
                            $edition_sponsor_data['updated_date']=date("Y-m-d H:i:s");
                            $this->db->delete('edition_sponsor', array('edition_id' => $edition_id));
                            $this->db->insert('edition_sponsor', $edition_sponsor_data);
                        }
                        $this->db->update('editions', $edition_data, array('edition_id' => $edition_id));
                        $this->db->trans_complete();
                        break;
                    default:
                        show_404();
                        break;
                }
                // return ID if transaction successfull
                if ($this->db->trans_status())
                {
                    return $edition_id;
                } else {
                    return false;
                }

            }

        }


        public function remove_edition($id)
        {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                // only edition needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('editions', array('edition_id' => $id));
                $this->db->trans_complete();
                return $this->db->trans_status();
            }
        }


        public function get_timeperiod()
        {
            $this->db->select("edition_date");
            $this->db->from("editions");
            $this->db->group_by("MONTH(edition_date)");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row)
                {
                    $data[date("Y-m",strtotime($row->edition_date))]=date("F Y",strtotime($row->edition_date));
                }

                return $data;
            }
            return [];
        }


}
