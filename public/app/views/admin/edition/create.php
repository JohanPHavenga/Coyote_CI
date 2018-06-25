<?php
echo form_open_multipart($form_url); 
?>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= ucfirst($action);?> Edition</span>
                </div>
            </div>
            <div class="portlet-body">
            <?php  
                //  EDITION NAME
                echo "<div class='form-group'>";                
                    echo "<div class='row'>";
                        echo "<div class='col-md-7'>";
                        echo form_label('Edition Name <span class="compulsary">*</span>', 'edition_name');
                        echo form_input([
                                'name'          => 'edition_name',
                                'id'            => 'edition_name',
                                'value'         => utf8_encode(@$edition_detail['edition_name']),
                                'class'         => 'form-control input-xlarge',
                                'required'      => '',
                            ]);
                        echo form_input([
                                'name'          => 'edition_name_past',
                                'id'            => 'edition_name_past',
                                'value'         => utf8_encode(@$edition_detail['edition_name']),
                                'type'         => 'hidden',
                            ]);

                        echo "<p class='help-block' style='font-style: italic;'> Remember to always add the year at the end of the edition name </p>";
                        echo "</div>";
                        
                //  
                        echo "<div class='col-md-5'>";
                        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                //  EVENT LINK
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-7'>";
                        echo form_label('Part of Event <span class="compulsary">*</span>', 'event_id');
                        echo form_dropdown('event_id', $event_dropdown, @$edition_detail['event_id'], ["id"=>"event_id","class"=>"form-control input-xlarge"]);        
                        echo "</div>";

                //  EDITION STATUS
                        echo "<div class='col-md-5'>";
                        echo form_label('Edition Status <span class="compulsary">*</span>', 'edition_status');
                        echo form_dropdown('edition_status', $status_dropdown, @$edition_detail['edition_status'], ["id"=>"edition_status","class"=>"form-control input-small"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

                //  DATE
                echo "<div class='form-group'>";
                echo form_label('Date <span class="compulsary">*</span>', 'edition_date');
                echo '<div class="input-group input-medium date date-picker">';
                echo form_input([
                        'name'          => 'edition_date',
                        'id'            => 'edition_date',
                        'value'         => set_value('edition_date', @fdateShort($edition_detail['edition_date'])),
                        'class'         => 'form-control',
//                        'readonly'      => '',
                    ]);    
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>";
                
                //  DATE END
//                echo "<div class='form-group'>";
//                echo form_label('Edition Date End', 'edition_date_end');
//                echo '<div class="input-group input-medium date date-picker">';
//                echo form_input([
//                        'name'          => 'edition_date_end',
//                        'id'            => 'edition_date_end',
//                        'value'         => set_value('edition_date_end', @fdateShort($edition_detail['edition_date_end'])),
//                        'class'         => 'form-control',
////                        'readonly'      => '',
//                    ]);    
//                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
//                
//                echo "<p class='help-block' style='font-style: italic;'> Only if applicable </p>";
//                echo "</div>";     
                
                //  ADDRESS
                echo "<div class='form-group'>";
                echo form_label('Street Address', 'edition_address');
                echo form_input([
                        'name'          => 'edition_address',
                        'id'            => 'edition_address',
                        'value'         => utf8_encode(@$edition_detail['edition_address']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                //  ADDRESS
//                echo "<div class='form-group'>";
//                echo form_label('Street Address (Race End)', 'edition_address_end');
//                echo form_input([
//                        'name'          => 'edition_address_end',
//                        'id'            => 'edition_address_end',
//                        'value'         => utf8_encode(@$edition_detail['edition_address_end']),
//                        'class'         => 'form-control',
//                    ]);
//                echo "<p class='help-block' style='font-style: italic;'> Only if it difers from the start address </p>";
//
//                echo "</div>";
                
                 //  GPS
                echo "<div class='form-group'>";
                    echo form_label('Latitude and Longitude', 'latitude_num');
                    echo "<div class='row'>";
                        echo "<div class='col-md-3 col-sm-6'>";
                        echo form_input([
                                'name'          => 'latitude_num',
                                'id'            => 'latitude_num',
                                'value'         => utf8_encode(@$edition_detail['latitude_num']),
                                'class'         => 'form-control',
                            ]);
                        echo "<p class='help-block' style='font-style: italic;'> Ex: -33.844204 </p>";
                        echo "</div>";

                        echo "<div class='col-md-3 col-sm-6'>";
                        echo form_input([
                                'name'          => 'longitude_num',
                                'id'            => 'longitude_num',
                                'value'         => utf8_encode(@$edition_detail['longitude_num']),
                                'class'         => 'form-control',
                            ]);
                        echo "<p class='help-block' style='font-style: italic;'> Ex: 19.015049 </p>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                //  More info URL
                echo "<div class='form-group'>";
                echo form_label('Link to event website (More Info)', 'edition_url');
                echo form_input([
                        'name'          => 'edition_url',
                        'id'            => 'edition_url',
                        'value'         => set_value('edition_url', @$edition_detail['edition_url']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
                //  Entry URL
                echo "<div class='form-group'>";
                echo form_label('Link to race entry (Enter Now)', 'edition_url_entry');
                echo form_input([
                        'name'          => 'edition_url_entry',
                        'id'            => 'edition_url_entry',
                        'value'         => set_value('edition_url_entry', @$edition_detail['edition_url_entry']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
                //  Flyer URL
                echo "<div class='form-group'>";
                echo form_label('Link to race flyer (Race Flyer)', 'edition_url_entry');
                echo form_input([
                        'name'          => 'edition_url_flyer',
                        'id'            => 'edition_url_flyer',
                        'value'         => set_value('edition_url_flyer', @$edition_detail['edition_url_flyer']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
                //  Results URL
                echo "<div class='form-group'>";
                echo form_label('Link to results (Event Results)', 'edition_url_results');
                echo form_input([
                        'name'          => 'edition_url_results',
                        'id'            => 'edition_url_results',
                        'value'         => set_value('edition_url_results', @$edition_detail['edition_url_results']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
                
                //  Contact
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-6'>";
                        echo form_label('Contact Person <span class="compulsary">*</span>', 'user_id');
                        echo form_dropdown('user_id', $contact_dropdown, @$edition_detail['user_id'], ["id"=>"user_id","class"=>"form-control"]);        
                        echo "</div>";

                //  SPONSOR
                        echo "<div class='col-md-6'>";
                        echo form_label('Sponsor <span class="compulsary">*</span>', 'sponsor_id');
                        echo form_dropdown('sponsor_id', $sponsor_dropdown, @$edition_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                
                //  INFO CONFIRMED
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-6'>";
                         echo form_checkbox([
                                'name'          => 'edition_info_isconfirmed',
                                'id'            => 'edition_info_isconfirmed',
                                'value'         => 1,
                                'checked'       => @$edition_detail['edition_info_isconfirmed'],
                            ]);      
                        echo form_label('Information confirmed', 'edition_info_isconfirmed');
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                //  Logo
                echo "<div class='row'>";
                    echo "<div class='col-md-6'>";
                        echo "<div class='form-group'>";
                            echo form_label('Edition Logo Upload', 'edition_logo_upload');
                            echo form_input([
                                    'name'          => 'edition_logo_upload',
                                    'id'            => 'edition_logo_upload',
                                    'type'          => 'file',
                                    'multiple'      => '',
                                    'accept'        => 'image/*',
                                ]);
                        echo "</div>";                        

                    if (($action=="edit")&&(strlen($edition_detail['edition_logo'])>3)) {                               
                        echo "<div class='form-group'>";
                            echo form_label('Edition Logo Current File', 'edition_logo_upload');
                            echo form_input([
                                'name'          => 'edition_logo',
                                'id'            => 'edition_logo',
                                'value'         => set_value('edition_logo', @$edition_detail['edition_logo']),
                                'class'         => 'form-control',
                            ]);
                        echo "</div>";
                    }

                    echo "</div>";
//                        echo form_input([
//                                'name'          => 'edition_logo',
//                                'id'            => 'edition_logo',
//                                'value'         => @$edition_detail['edition_logo'],
//                                'type'         => 'hidden',
//                            ]);

                    if (($action=="edit")&&(strlen($edition_detail['edition_logo'])>3)) {    
                        $img_url=base_url("uploads/admin/edition/".$edition_detail['edition_id']."/".$edition_detail['edition_logo']);
                        echo "<div class='col-md-6'>";
                        echo "<img src='$img_url' style='width: 300px;'>";
                        echo "</div>";
                    }                        
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">More information</span>
                </div>
            </div>
            <div class="portlet-body">
                
                <?php
                //  Event Intro
                echo "<div class='form-group'>";
                echo form_label('Event Intro', 'edition_intro_detail');
                echo form_textarea([
                        'name'          => 'edition_intro_detail',
                        'id'            => 'edition_intro_detail',
                        'value'         => utf8_encode(@$edition_detail['edition_intro_detail']),
                    ]);

                echo "</div>";
                
                //  Entry Details
                echo "<div class='form-group'>";
                echo form_label('Entry Details', 'edition_entry_detail');
                echo form_textarea([
                        'name'          => 'edition_entry_detail',
                        'id'            => 'edition_entry_detail',
                        'value'         => utf8_encode(@$edition_detail['edition_entry_detail']),
                    ]);

                echo "</div>";
                
                //  Decription
                echo "<div class='form-group'>";
                echo form_label('General Information', 'edition_description');
                echo form_textarea([
                        'name'          => 'edition_description',
                        'id'            => 'edition_description',
                        'value'         => utf8_encode(@$edition_detail['edition_description']),
                    ]);

                echo "</div>";
                ?>
            </div>
        </div>        
    </div>
   
    
</div>

<div class="row">
    <div class="col-md-6">    
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Races</span>
                </div>
            </div>
            <div class="portlet-body">  
                <?php
                // RACES
                if ( ! (empty($race_list)))
                {
                    // create table
                    $this->table->set_template(ftable('races_table'));
                    $this->table->set_heading(["ID","Race Distance","Race Type","Race Time","Status","Actions"]);
                    foreach ($race_list as $id=>$data_entry) {
                        
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
                        $row['distance']=fraceDistance($data_entry['race_distance']);
                        $row['racetype']=$data_entry['racetype_name'];
                        $row['time']=ftimeSort($data_entry['race_time_start']);
                        $row['status']=flableStatus($data_entry['race_status']);
                        $row['actions']= fbuttonActionGroup($action_array);
                        
                        $this->table->add_row(
                                $row['id'], 
                                array('data' => $row['distance'], 'align' => 'right'), 
                                $row['racetype'],
                                $row['time'],
                                $row['status'],
                                $row['actions']
                                );
//                        $this->table->add_row($row);
                        unset($row);
                    }
                    echo $this->table->generate();

                }
                else
                {
                    echo "<p>No races loaded for the edition</p>";
                }

                // add button
                echo fbuttonLink("/admin/race/create/add/".@$edition_detail['event_id'],"Add Race","primary");
                ?>
            </div>
        </div>
        <div class="portlet light">        
            <div class="portlet-body">            
                <?php
                 //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Save",$type="submit",$status="primary",NULL,"save_only");
                echo fbutton($text="Save & Close",$type="submit",$status="success");
                echo fbuttonLink($return_url,"Cancel",$status="danger");
                echo "</div>";
                ?>
            </div>
        </div>
    </div>
     <?php
        if ($action=="edit") {   
    ?>
    <div class="col-md-6">
        <div class="portlet light">
            <?php
            echo "<div class='form-group'>";
                echo "<div class='row'>";
                    echo "<div class='col-md-6'>";
                    echo form_label('Date Created', 'created_date');
                    echo form_input([
                            'value'         => set_value('created_date', @$edition_detail['created_date']),
                            'class'         => 'form-control input-medium',
                            'disabled'      => ''
                        ]);
                    echo "</div>";
                    echo "<div class='col-md-6'>";
                    echo form_label('Date Updated', 'updated_date');
                    echo form_input([
                            'value'         => set_value('updated_date', @$edition_detail['updated_date']),
                            'class'         => 'form-control input-medium',
                            'disabled'      => ''
                        ]);

                    echo "</div>";
                echo "</div>";
             echo "</div>";
            ?>
        </div>
    </div>
    <?php
        }
    ?>
</div>

<?php
echo form_close();

//wts($race_list);
?>