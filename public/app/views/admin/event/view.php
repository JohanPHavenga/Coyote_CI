
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-list font-dark"></i>
                    <span class="caption-subject bold uppercase"> List of all events</span>
                </div>
            </div>
            <div class="portlet-body">

<?php
                if ( ! (empty($event_data)))
                {
                    // pagination links
                    echo fpagination(@$pagination);

                    // create table
                    $this->table->set_template(ftable('events_table'));
                    $this->table->set_heading($heading);
                    foreach ($event_data as $id=>$data_entry) {
                        
                        $action_array=[
                                [
                                "url"=>"/admin/event/create/edit/".$data_entry['event_id'],
                                "text"=>"Edit",
                                "icon"=>"icon-pencil",
                                ],
                                [
                                "url"=>"/admin/event/delete/".$data_entry['event_id'],
                                "text"=>"Delete",
                                "icon"=>"icon-dislike",
                                "confirmation_text"=>"<b>Are you sure?</b> <br>Note, this will also delete all editions and reaces linked to this event",
                                ],
                            ];
                        
                        $row['id']=$data_entry['event_id'];
                        $row['name']=$data_entry['event_name'];
                        $row['status']=flableStatus($data_entry['event_status']);
                        $row['created']=$data_entry['created_date'];
                        $row['town']=$data_entry['town_name'];
                        $row['area']=$data_entry['area_name'];
                        $row['actions']= fbuttonActionGroup($action_array);
                        $this->table->add_row($row);
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
                echo fbuttonLink($create_link."/add","Add Event","primary");
                }
                ?>
            
            </div>
        </div>
    </div>
</div>

