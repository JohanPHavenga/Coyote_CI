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
                    $data[$row['event_id']] = $row['event_name']." [#".$row['event_id']."]";
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
            
            // field_arr is compulsary
            foreach ($params['field_arr'] as $field) {
                if ($field=="results_file") { $field="file_name as results_file"; }
                $field_arr[]=$field;
            }
//            wts($field_arr);
//            die();
            
            // set default sort
            if (!isset($params['sort'])) { $params['sort']="ASC"; }
            $sort=$params['sort'];            

//            $this->db->select($field_arr);
            $this->db->from("events");
            $this->db->join('editions', 'editions.event_id = events.event_id');
            $this->db->join('races', 'races.edition_id = editions.edition_id');
            $this->db->join('racetypes', 'races.racetype_id = racetypes.racetype_id', 'left outer');
            $this->db->join('towns', 'towns.town_id = events.town_id');
            $this->db->join('edition_user', 'editions.edition_id = edition_user.edition_id','left outer');
            $this->db->join('users', 'users.user_id = edition_user.user_id','left outer');
            $this->db->join('files', '(editions.edition_id = files.edition_id) and (files.filetype_id=4)', 'left outer');  // results

//            echo $this->db->get_compiled_select();
//            exit();
            
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
            
            if (isset($params['confirmed'])) {
                $this->db->where("edition_info_isconfirmed", $params['confirmed']);                
            }
            
            $this->db->where("events.event_status", 1);
            $this->db->where("editions.edition_status", 1);
            $this->db->where("races.race_status", 1);

            $this->db->order_by("edition_date", $sort);
            $this->db->order_by("race_distance", "DESC");
            
            $this->db->select($field_arr);
            
//            echo $this->db->get_compiled_select();
//            exit();

            
            return $this->db->get();
        }


        // ======================================================================================
        // MAIN QUERY TO GET EVENT DATA 
        // for backend and frontend
        // ======================================================================================
        public function get_event_list_summary($from,$params)
        {
            // set fields to be fetched
            $field_arr=["event_name","editions.edition_id","edition_name","edition_status","edition_date","edition_info_isconfirmed","edition_url_entry","edition_url_results","edition_logo","edition_info_email_sent",
                "racetype_abbr","town_name","race_distance","race_time_start",
                "user_name", "user_surname", "user_email", "results_file"];
            
            // setup fields needed for summary call
            // go get the data
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
                        "confirmed"=>@$params['confirmed'],
                        "results"=>@$params['results'],
                        ]
                        );
            } 
            elseif ($from=="search")
            {
                $field_arr[]="file_name";
                $query=$this->search_events($field_arr, $params['ss'], $params['inc_all'],@$params['inc_non_active']);
            } 
            elseif ($from=="id") 
            {
                $query=$this->get_event_list_data(
                        [
                        "field_arr"=>$field_arr,                            
                        "event_id"=>$params['event_id'],
                        ]
                        );
            
            } else {
                die("'get_event_summary_list: no from provided");
            }

            // as daar nie enige resultate was nie, stuur terun
            if (!$query->num_rows()) { return false; }
            
            // formulate the return            
            foreach ($query->result_array() as $row) {
                $year=date("Y",strtotime($row['edition_date']));
                $month=date("F",strtotime($row['edition_date']));
                $day=date("d",strtotime($row['edition_date']));
                $id=$row['edition_id'];

                foreach ($field_arr as $field) {

                    // vir as daar 'n veld is met 'n table naam vooraan
                    if (strpos($field, ".") !== false) { $pieces = explode(".", $field); $field=$pieces[1]; }

                    switch ($field) {

                        case "race_distance":                                
                            $value=floatval($row[$field])."km";
                            $value_arr=intval($row[$field]);
                            if ($row['racetype_abbr']=="W") { $value.=" W"; $value_arr.="W"; }

                            // also add an array of race distances
                            $data[$year][$month][$day][$id]['distance_arr'][$value_arr]=$value_arr;

                            // make string
                            if (isset($data[$year][$month][$day][$id][$field])) {
                                $value=$data[$year][$month][$day][$id][$field].", ".$value;
                            };                                
                        break;
                        case "race_time_start":
                            if (date("H",strtotime($row[$field])) >  0) { $value = "Morning";  }
                            if (date("H",strtotime($row[$field])) >  12) { $value = "Afternoon";  }
                            if (date("H",strtotime($row[$field])) >  17) { $value = "Evening";  }
                            if (date("H",strtotime($row[$field])) >  21) { $value = "Night";  }

                            if (!isset($data[$year][$month][$day][$id]["start_time"])) {
                                $data[$year][$month][$day][$id]["start_time"]=date("H:i",strtotime($row[$field]));                                    
                            } else {
                                $data[$year][$month][$day][$id]["start_time"].=", ".date("H:i",strtotime($row[$field]));
                            } 
                        break;
                        case "edition_date":
                            $value=date("D d M Y",strtotime($row[$field]));
                        break;
                        case "edition_name":
                            $value=$row[$field];
                            $edition_url_name=encode_edition_name($row[$field]);
                            $data[$year][$month][$day][$id]["edition_url"]="/event/".$edition_url_name;
                        break;
                        default:
                            $value=$row[$field];
                        break;
                    }

                    // haal racetype_abbr uit die lys
                    if ($field!="racetype_abbr") {
                        $data[$year][$month][$day][$id][$field]=$value;
                    }

                }
            }
            if ($from=="id") {
                return $data[$year][$month][$day][$id];
            } else {
                return $data;
            }
                

        }
                        
        public function get_event_list_summary_old($from,$params)
        {
//            wts($from);
//            wts($params);
//            exit();
            $field_arr=["event_name","editions.edition_id","edition_name","edition_date","edition_info_isconfirmed","edition_url_entry","edition_url_results","edition_logo","edition_info_email_sent",
                "racetype_abbr","town_name","race_distance","race_time_start",
                "user_name", "user_surname", "user_email"];
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
                        "confirmed"=>@$params['confirmed'],
                        "results"=>@$params['results'],
                        ]
                        );
            } 
            elseif ($from=="search")
            {
                $query=$this->search_events($field_arr, $params['ss'], $params['inc_all']);
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
//                    wts($row);
//                    die();
                    
                    foreach ($field_arr as $field) {
                        
                        // vir as daar 'n veld is met 'n table naam vooraan
                        if (strpos($field, ".") !== false) {
                            $pieces = explode(".", $field);
                            $field=$pieces[1];
                        }

                        switch ($field) {
                            
                            case "race_distance":                                
                                $value=floatval($row[$field])."km";
                                $value_arr=intval($row[$field]);
                                if ($row['racetype_abbr']=="W") { $value.=" W"; $value_arr.="W"; }
                                
                                // also add an array of race distances
                                $data[date("F",strtotime($row['edition_date']))][$row['edition_id']]['distance_arr'][$value_arr]=$value_arr;
                                
                                // make string
                                if (isset($data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field])) {
                                    $value=$data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field].", ".$value;
                                };
                                
                            break;
                            case "race_time_start":
                                if (date("H",strtotime($row[$field])) >  0) { $value = "Morning";  }
                                if (date("H",strtotime($row[$field])) >  12) { $value = "Afternoon";  }
                                if (date("H",strtotime($row[$field])) >  17) { $value = "Evening";  }
                                if (date("H",strtotime($row[$field])) >  21) { $value = "Night";  }
                                
                                if (!isset($data[date("F",strtotime($row['edition_date']))][$row['edition_id']]["start_time"])) {
                                    $data[date("F",strtotime($row['edition_date']))][$row['edition_id']]["start_time"]=date("H:i",strtotime($row[$field]));                                    
                                } else {
                                    $data[date("F",strtotime($row['edition_date']))][$row['edition_id']]["start_time"].=", ".date("H:i",strtotime($row[$field]));
                                } 
                            break;
                            case "edition_date":
                                $value=date("D d M Y",strtotime($row[$field]));
                            break;
                            case "edition_name":
                                $value=$row[$field];
                                // sit veld by vir edition_url
                                // sanatize name
//                                $edition_url_name=urlencode(str_replace("'","",str_replace("/"," ",$row[$field])));
                                $edition_url_name=encode_edition_name($row[$field]);
                                
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

                        // haal racetype_abbr uit die lys
                        if ($field!="racetype_abbr") {
                            $data[date("F",strtotime($row['edition_date']))][$row['edition_id']][$field]=$value;
                        }

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
        
        
        public function get_event_list_sitemap($params) {
                        
            $field_arr=['edition_name'];
            $this->db->select($field_arr);
            $this->db->from("editions");
            
            //c onfirmed races
            if (isset($params['confirmed'])) {
                $this->db->where("edition_info_isconfirmed", $params['confirmed']);        
                $this->db->where("edition_date >=", date("Y-m-d"));        
            }
            
            // next 3 months races
            if (isset($params['upcoming_3months'])) {
                $this->db->where("edition_info_isconfirmed !=", 1);       
                $date_to=date("Y-m-d", strtotime("+3 months"));
                $this->db->where("(edition_date BETWEEN '".date("Y-m-d")."' AND '".$date_to."')"); 
            }            
            
            // rest of upcoming races
            if (isset($params['upcoming_older'])) {
                $this->db->where("edition_info_isconfirmed !=", 1);        
                $this->db->where("edition_date > ", date("Y-m-d", strtotime("+3 months")));        
            }
            
            // rest of upcoming races
            if (isset($params['results'])) {  
                $this->db->group_start();    
                $this->db->where("edition_url_results !=", "");
                $this->db->where("edition_date < ", date("Y-m-d"));    
                $this->db->group_end();         
                $date_from=date("Y-m-d", strtotime("-3 months"));
                $this->db->or_where("(edition_date BETWEEN '".$date_from."' AND '".date("Y-m-d")."')"); 
            }

            // rest of upcoming races
            if (isset($params['old'])) {    
                $this->db->group_start();
                $this->db->where("edition_url_results");      
                $this->db->or_where("edition_url_results", "");   
                $this->db->group_end();   
                
                $this->db->where("edition_date < ", date("Y-m-d", strtotime("-3 months")));        
            }
            
            $this->db->order_by("edition_date", "ASC");
            
//            echo $this->db->get_compiled_select();
//            exit();
            
            $query=$this->db->get();
            
            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row)
                {
                    $edition_url_name=urlencode(str_replace(" ","-",(str_replace("'","",str_replace("/"," ",$row["edition_name"])))));
                    $url_list[]="event/".$edition_url_name;
                }
                return $url_list;
            }
            return false;
            
        }




        public function search_events($field_arr, $ss, $show_all=false, $incl_non_active=false) {
            
            // NOTE I removed areas because that breaks the search for towns that does not belong to an area
            
            $search_result=[];
            
//            $field_arr=["events.event_id","event_name","editions.edition_id","edition_name","edition_date","town_name","race_distance","race_time_start"];
            
            $this->db->select($field_arr);
            
            $this->db->from("events");
            
            $this->db->join('editions', 'editions.event_id = events.event_id');
            $this->db->join('races', 'races.edition_id = editions.edition_id');
            $this->db->join('towns', 'towns.town_id = events.town_id');
            $this->db->join('racetypes', 'races.racetype_id = racetypes.racetype_id', 'left outer');
            $this->db->join('edition_user', 'editions.edition_id = edition_user.edition_id', 'left outer');
            $this->db->join('users', 'users.user_id = edition_user.user_id', 'left outer');
            $this->db->join('files', '(editions.edition_id = files.edition_id) and (files.filetype_id=1)', 'left outer');            
            
//            $this->db->join('town_area', 'towns.town_id = town_area.town_id');
//            $this->db->join('areas', 'areas.area_id = town_area.area_id');            
//            $this->db->where("edition_date >=", date("Y-m-d"));
            
            $this->db->group_start();
//            $this->db->like("area_name", $ss);
            $this->db->or_like("event_name", $ss);
            $this->db->or_like("edition_name", $ss);
            $this->db->or_like("town_name", $ss);
            $this->db->group_end();
            
            if (!$incl_non_active) {
                $this->db->where("events.event_status", 1);
                $this->db->where("editions.edition_status", 1);
                $this->db->where("races.race_status", 1);
            }
            if (!$show_all) {
                $this->db->where("edition_date > ", date("Y-m-d", strtotime("3 months ago")));     
                $this->db->where("edition_date < ", date("Y-m-d", strtotime("+9 month")));             
            }
            
            $this->db->order_by("edition_date", "DESC");   
            $this->db->order_by("race_distance", "DESC");         
            
//            echo $this->db->get_compiled_select();
//            die();
            
            return $this->db->get();
            
        }


}
