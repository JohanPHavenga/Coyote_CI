<?php
class Event_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function record_count() {
            return $this->db->count_all("events");
        }

        public function get_event_list($limit, $start)
        {
            $this->db->limit($limit, $start);

            $this->db->select("events.*, town_name, club_name");
            $this->db->from("events");
            $this->db->join('towns', 'events.town_id=towns.town_id', 'left');
            $this->db->join('organising_club', 'events.event_id=organising_club.event_id', 'left');
            $this->db->join('clubs', 'clubs.club_id=organising_club.club_id', 'left');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $data[$row['event_id']] = $row;
                }
                return $data;
            }
            return false;

        }

        public function get_event_dropdown() {
            $this->db->select("event_id, event_name");
            $this->db->from("events");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $data[] = "Please Select";
                foreach ($query->result_array() as $row) {
                    $data[$row['event_id']] = $row['event_name'];
                }
                return $data;
            }
            return false;
        }

        public function get_event_detail($id)
        {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                $this->db->select("events.*, club_id, town_name");
                $this->db->from("events");
                $this->db->join('towns', 'events.town_id=towns.town_id', 'left');
                $this->db->join('organising_club', 'event_id', 'left');
                $this->db->where('event_id', $id);
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    return $query->row_array();
                }
                return false;
            }

        }

        public function set_event($action, $event_id, $event_data=[], $debug=false)
        {
            // POSTED DATA
            if (empty($event_data))
            {
                $event_data = array(
                            'event_name' => $this->input->post('event_name'),
                            'event_status' => $this->input->post('event_status'),
                            'town_id' => $this->input->post('town_id'),
                        );
                $organise_club_data = ["club_id"=>$this->input->post('club_id'),"event_id"=>$event_id];
            } else {
                $organise_club_data = ["club_id"=>8,"event_id"=>$event_id];
                if (!isset($event_data['event_status'])) { $event_data['event_status'] = 1; }
                if (!isset($event_data['town_id'])) { $event_data['town_id'] = 1; }
            }

            if ($debug) {
                echo "<b style='color:red;'>Event Transaction</b>";
                wts($action);
                // wts($event_id);
                wts($event_data);
            } else {
                switch ($action) {
                    case "add":
                        $this->db->trans_start();
                        $this->db->insert('events', $event_data);
                        // get event ID from Insert
                        $event_id=$this->db->insert_id();
                        // update data array
                        $organise_club_data["event_id"]=$event_id;
                        $this->db->insert('organising_club', $organise_club_data);
                        $this->db->trans_complete();
                        break;
                    case "edit":
                        // add updated date to both data arrays
                        $event_data['updated_date']=date("Y-m-d H:i:s");

                        // start SQL transaction
                        $this->db->trans_start();
                        // chcek if record already exists
                        $item_exists = $this->db->get_where('organising_club', array('event_id' => $event_id, 'club_id' => $this->input->post('club_id')));
                        if ($item_exists->num_rows() == 0)
                        {
                            $organise_club_data['updated_date']=date("Y-m-d H:i:s");
                            $this->db->delete('organising_club', array('event_id' => $event_id));
                            $this->db->insert('organising_club', $organise_club_data);
                        }
                        $this->db->update('events', $event_data, array('event_id' => $event_id));
                        $this->db->trans_complete();
                        break;
                    default:
                        show_404();
                        break;
                }
                // return ID if transaction successfull
                if ($this->db->trans_status())
                {
                    return $event_id;
                } else {
                    return false;
                }
            }

        }


        public function remove_event($id) {
            if( ! ($id))
            {
                return false;
            }
            else
            {
                // only event needed, SQL key constraints used to remove records from organizing_club
                $this->db->trans_start();
                $this->db->delete('events', array('event_id' => $id));
                $this->db->trans_complete();
                return $this->db->trans_status();
            }
        }


        public function export($date)
        {
            $this->db->select('events.event_id, event_name, edition_id, edition_name, edition_date');
            $this->db->from("events");
            $this->db->join('editions', 'editions.event_id = events.event_id');



            if ($date) {
                $from_date=$date."-01";
                $to_date=$date."-31";
                $this->db->where("(edition_date BETWEEN '$from_date' AND '$to_date')");
            }

            $this->db->order_by("edition_date", "asc");

            return $query = $this->db->get();
        }


}
