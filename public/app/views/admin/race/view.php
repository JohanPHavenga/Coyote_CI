
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-list font-dark"></i>
                    <span class="caption-subject bold uppercase"> List of all races</span>
                </div>
            </div>
            <div class="portlet-body">

<?php
                if ( ! (empty($race_data)))
                {
                    // create table
                    $this->table->set_template(ftable('races_table'));
                    $this->table->set_heading($heading);
                    foreach ($race_data as $id=>$data_entry) {
                        
                        $action_array=[
                                [
                                "url"=>"/admin/race/create/edit/".$data_entry['race_id'],
                                "text"=>"Edit",
                                "icon"=>"icon-pencil",
                                ],
                                [
                                "url"=>"/admin/race/delete/".$data_entry['race_id'],
                                "text"=>"Delete",
                                "icon"=>"icon-dislike",
                                "confirmation_text"=>"<b>Are you sure?</b>",
                                ],
                            ];
                        
        
                        $row['id']=$data_entry['race_id'];                  
                        $row['edition']=$data_entry['edition_name'];
                        $row['distance']=fraceDistance($data_entry['race_distance']);
                        $row['time']=ftimeSort($data_entry['race_time']);
                        $row['status']=flableStatus($data_entry['race_status']);
                        $row['actions']= fbuttonActionGroup($action_array);
                        
                        $this->table->add_row($row['id'], $row['edition'], array('data' => $row['distance'], 'align' => 'right'), $row['time'],$row['status'],$row['actions']);
//                        $this->table->add_row($row);
                        unset($row);
                    }
                    echo $this->table->generate();

                }
                else
                {
                    echo "<p>No data to show</p>";
                }

                // add button
                if (@$create_link)
                {
                echo fbuttonLink($create_link."/add","Add Races","primary");
                }
                ?>
            
            </div>
        </div>
    </div>
</div>

