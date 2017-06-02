<?php
class Event_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function record_count() {
            return $this->db->count_all("events");
        }

        public function get_event_list($limit=NULL, $start=NULL)
        {
            if (isset($limit)&&isset($start)) {
                $this->db->limit($limit, $start);
            }

            $this->db->select("events.*, town_name, club_name, area_name");
            $this->db->from("events");
            $this->db->join('towns', 'events.town_id=towns.town_id', 'left');
            $this->db->join('organising_club', 'events.event_id=organising_club.event_id', 'left');
            $this->db->join('clubs', 'clubs.club_id=organising_club.club_id', 'left');
            $this->db->join('town_area', 'towns.town_id=town_area.town_id', 'left');
            $this->db->join('areas', 'areas.area_id=town_area.area_id', 'left');
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
            $this->db->order_by("event_name");
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


        public function get_area_list() {
            $area_list=[];
            // set query
            $this->db->select("areas.area_id, area_name");
            $this->db->from("events");
            $this->db->join('editions', 'editions.event_id = events.event_id');
            $this->db->join('towns', 'towns.town_id = events.town_id');
            $this->db->join('town_area', 'towns.town_id = town_area.town_id');
            $this->db->join('areas', 'areas.area_id = town_area.area_id');
            $this->db->where("area_name !=", '');
            $this->db->where("edition_date >=", date("Y-m-d"));
            $this->db->order_by("area_name", "asc");
            $query=$this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $area_list[$row['area_id']]['id']=$row['area_id'];
                    $area_list[$row['area_id']]['name']=$row['area_name'];
                }
            }
            return $area_list;
        }


        public function get_event_list_data($params) {
            //'events.event_id, event_name, edition_id, edition_name, edition_date'
            
//            wts($params);
//            exit();
            
            // field_arr is compulsary
            $field_arr=$params['field_arr'];
            
            // set default sort
            if (!isset($params['sort'])) { $params['sort']="ASC"; }
            $sort=$params['sort'];            

            $this->db->select($field_arr);
            $this->db->from("events");
            $this->db->join('editions', 'editions.event_id = events.event_id');
            $this->db->join('races', 'races.edition_id = editions.edition_id');
            $this->db->join('towns', 'towns.town_id = events.town_id');

            if (isset($params['area'])) {
                $this->db->join('town_area', 'towns.town_id = town_area.town_id');
                $this->db->join('areas', 'areas.area_id = town_area.area_id');
                $this->db->where("area_name", $params['area']);
            }

            if (isset($params['date_from'])) {
                if (!isset($params['date_to'])) {
                    $this->db->where("edition_date >=", $params['date_from']);
                } else {
                    $this->db->where("(edition_date BETWEEN '".$params['date_from']."' AND '".$params['date_to']."')");
                }
            } else {
                $this->db->where("events.event_id", $params['event_id']);
            }
            
            $this->db->where("events.event_status", 1);
            $this->db->where("editions.edition_status", 1);
            $this->db->where("races.race_status", 1);

            $this->db->order_by("edition_date", $sort);
            $this->db->order_by("race_distance", "DESC");

            return $this->db->get();
        }



//        public function get_event_list_summary($date_form, $date_to=NULL, $area=NULL, $sort="ASC")
        public function get_event_list_summary($from,$params)
        {
//            wts($from);
//            wts($params);
//            exit();
            $field_arr=["event_name","editions.edition_id","edition_name","edition_date","town_name","race_distance","race_time_start"];
            // setup fields needed for summary call
            if ($from=="date_range") {
                if (!isset($params['date_to'])) { $params['date_to']=NULL; }
                if (!isset($params['area'])) { $params['area']=NULL; }
                if (!isset($params['sort'])) { $params['sort']="ASC"; }
                $query=$this->get_event_list_data(
                        [
                        "field_arr"=>$field_arr,
                        "date_from"=>$params['date_from'], 
                        "date_to"=>$params['date_to'], 
                        "area"=>$params['area'], 
                        "sort"=>$params['sort'],
                        ]
                        );
            } 
            elseif ($from=="search")
            {
                $query=$this->search_events($params['ss']);
            } 
            elseif ($from=="id") 
            {
                $query=$this->get_event_list_data(
                        [
                        "field_arr"=>$field_arr,                            
                        "event_id"=>$params['event_id'],
                        ]
                        );
                
            }
            
            

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    foreach ($field_arr as $field) {
                        // vir as daar 'n veld is met 'n table naam vooraan
                        if (strpos($field, ".") !== false) {
                            $pieces = explode(".", $field);
                            $field=$pieces[1];
                        }

                        switch ($field) {
                            case "race_distance":
                                $value=floatval($row[$field])."km";
                                if (isset($data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field])) {
                                    $value=$data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field].", ".$value;
                                }
                            break;
                            case "race_time_start":
                                if (date("H",strtotime($row[$field])) >  0) { $value = "Morning";  }
                                if (date("H",strtotime($row[$field])) >  12) { $value = "Afternoon";  }
                                if (date("H",strtotime($row[$field])) >  17) { $value = "Evening";  }
                                if (date("H",strtotime($row[$field])) >  21) { $value = "Night";  }
                            break;
                            case "edition_date":
                                $value=date("D d M Y",strtotime($row[$field]));
                            break;
                            case "edition_name":
                                $value=$row[$field];
                                // sit veld by vir edition_url
                                // sanatize name
//                                $edition_url_name=urlencode(str_replace("'","",str_replace("/"," ",$row[$field])));
                                $edition_url_name=urlencode(str_replace(" ","-",(str_replace("'","",str_replace("/"," ",$row[$field])))));
                                
                                // remove the month and id from array
//                                if ($from=="id") {
//                                    $data["edition_url"]="/event/".$edition_url_name;
//                                } else {
                                    $data[date("F",strtotime($row['edition_date']))][$row['edition_id']]["edition_url"]="/event/".$edition_url_name;
//                                }
                            break;
                            default:
                                $value=$row[$field];
                            break;
                        }

                        $data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field]=$value;

                    }
                }
                if ($from=="id") {
                    return $data[date("F",strtotime($row['edition_date']))][$row['edition_id']];
                } else {
                    return $data;
                }
            }
            return false;

        }
        
        
        public function search_events($ss) {
            
            // NOTE I removed areas because that breaks the search for towns that does not belong to an area
            
            $search_result=[];
            
            $field_arr=["events.event_id","event_name","editions.edition_id","edition_name","edition_date","town_name","race_distance","race_time_start"];
            
            $this->db->select($field_arr);
            
            $this->db->from("events");
            
            $this->db->join('editions', 'editions.event_id = events.event_id');
            $this->db->join('races', 'races.edition_id = editions.edition_id');
            $this->db->join('towns', 'towns.town_id = events.town_id');
//            $this->db->join('town_area', 'towns.town_id = town_area.town_id');
//            $this->db->join('areas', 'areas.area_id = town_area.area_id');
            
//            $this->db->where("edition_date >=", date("Y-m-d"));
            
            $this->db->group_start();
//            $this->db->like("area_name", $ss);
            $this->db->or_like("event_name", $ss);
            $this->db->or_like("edition_name", $ss);
            $this->db->or_like("town_name", $ss);
            $this->db->group_end();
            
            $this->db->where("events.event_status", 1);
            $this->db->where("editions.edition_status", 1);
            $this->db->where("races.race_status", 1);
            
            $this->db->order_by("edition_date", "ASC");   
            $this->db->order_by("race_distance", "DESC");         
            
//            echo $this->db->get_compiled_select();
            
            return $this->db->get();
            
        }


}
