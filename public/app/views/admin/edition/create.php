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
                echo validation_errors(); 

                //  NAME
                echo "<div class='form-group'>";
                echo form_label('Name <span class="compulsary">*</span>', 'edition_name');
                echo form_input([
                        'name'          => 'edition_name',
                        'id'            => 'edition_name',
                        'value'         => utf8_encode(@$edition_detail['edition_name']),
                        'class'         => 'form-control input-xlarge',
                        'required'      => '',
                    ]);

                echo "<p class='help-block' style='font-style: italic;'> Remember to always add the year at the end of the edition name </p>";
                echo "</div>";

                //  EVENT LINK
                echo "<div class='form-group'>";
                echo form_label('Event <span class="compulsary">*</span>', 'event_id');
                echo form_dropdown('event_id', $event_dropdown, @$edition_detail['event_id'], ["id"=>"event_id","class"=>"form-control input-xlarge"]);        
                echo "</div>";

                //  STATUS
                echo "<div class='form-group'>";
                echo form_label('Status <span class="compulsary">*</span>', 'edition_status');
                echo form_dropdown('edition_status', $status_dropdown, @$edition_detail['edition_status'], ["id"=>"edition_status","class"=>"form-control input-small"]);        
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
                        'readonly'      => '',
                    ]);    
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>";
                
                //  DATE END
                echo "<div class='form-group'>";
                echo form_label('Edition Date End', 'edition_date_end');
                echo '<div class="input-group input-medium date date-picker">';
                echo form_input([
                        'name'          => 'edition_date_end',
                        'id'            => 'edition_date_end',
                        'value'         => set_value('edition_date_end', @fdateShort($edition_detail['edition_date_end'])),
                        'class'         => 'form-control',
//                        'readonly'      => '',
                    ]);    
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                
                echo "<p class='help-block' style='font-style: italic;'> Only if applicable </p>";
                echo "</div>";
                
                
                //  More info URL
                echo "<div class='form-group'>";
                echo form_label('More Info URL', 'edition_url');
                echo form_input([
                        'name'          => 'edition_url',
                        'id'            => 'edition_url',
                        'value'         => set_value('edition_url', @$edition_detail['edition_url']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
                 //  Entry URL
                echo "<div class='form-group'>";
                echo form_label('Entry URL', 'edition_url_entry');
                echo form_input([
                        'name'          => 'edition_url_entry',
                        'id'            => 'edition_url_entry',
                        'value'         => set_value('edition_url_entry', @$edition_detail['edition_url_entry']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";  
                
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
                echo "<div class='form-group'>";
                echo form_label('Street Address (Race End)', 'edition_address_end');
                echo form_input([
                        'name'          => 'edition_address_end',
                        'id'            => 'edition_address_end',
                        'value'         => utf8_encode(@$edition_detail['edition_address_end']),
                        'class'         => 'form-control',
                    ]);
                echo "<p class='help-block' style='font-style: italic;'> Only if it difers from the start address </p>";

                echo "</div>";
                
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
                
                
                //  Logo
                echo "<div class='form-group'>";
                echo form_label('Edition Logo', 'edition_logo');
                echo form_input([
                        'name'          => 'edition_logo',
                        'id'            => 'edition_logo',
                        'value'         => @$edition_detail['edition_logo'],
                        'type'          => 'file',
                        'multiple'      => '',
                        'accept'        => 'image/*',
                    ]);
                echo "</div>";
                
                
                
                //  Contact
                echo "<div class='form-group'>";
                echo form_label('Contact Person <span class="compulsary">*</span>', 'user_id');
                echo form_dropdown('user_id', $contact_dropdown, @$edition_detail['user_id'], ["id"=>"user_id","class"=>"form-control input-xlarge"]);        
                echo "</div>";

                //  SPONSOR
                echo "<div class='form-group'>";
                echo form_label('Sponsor <span class="compulsary">*</span>', 'sponsor_id');
                echo form_dropdown('sponsor_id', $sponsor_dropdown, @$edition_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control input-xlarge"]);        
                echo "</div>";
                
                //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Submit",$type="submit",$status="primary");
                echo fbuttonLink($return_url,"Cancel");
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
                //  Decription
                echo "<div class='form-group'>";
                echo form_label('General Information', 'edition_description');
                echo form_textarea([
                        'name'          => 'edition_description',
                        'id'            => 'edition_description',
                        'value'         => utf8_encode(@$edition_detail['edition_description']),
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
                
           
                if ($action=="edit") {   
                    //  DATES Created + Updated
                   echo "<div class='form-group'>";
                   echo form_label('Date Created', 'created_date');
                   echo form_input([
                           'value'         => set_value('created_date', @$edition_detail['created_date']),
                           'class'         => 'form-control input-medium',
                           'disabled'      => ''
                       ]);

                   echo "</div>";
                   echo "<div class='form-group'>";
                   echo form_label('Date Updated', 'updated_date');
                   echo form_input([
                           'value'         => set_value('updated_date', @$edition_detail['updated_date']),
                           'class'         => 'form-control input-medium',
                           'disabled'      => ''
                       ]);

                   echo "</div>";
                }
                
                
                //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Submit",$type="submit",$status="primary");
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";
                ?>
            </div>
        </div>        
    </div>
</div>

<?php
echo form_close();
?>