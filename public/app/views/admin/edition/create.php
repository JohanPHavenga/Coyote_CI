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

                echo form_open($form_url); 

                //  NAME
                echo "<div class='form-group'>";
                echo form_label('Name', 'edition_name');
                echo form_input([
                        'name'          => 'edition_name',
                        'id'            => 'edition_name',
                        'value'         => set_value('edition_name', @$edition_detail['edition_name']),
                        'class'         => 'form-control input-xlarge',
                        'required'      => '',
                    ]);

                echo "<p class='help-block' style='font-style: italic;'> Remember to always add the year at the end of the edition name </p>";
                echo "</div>";

                //  EVENT LINK
                echo "<div class='form-group'>";
                echo form_label('Event', 'event_id');
                echo form_dropdown('event_id', $event_dropdown, @$edition_detail['event_id'], ["id"=>"event_id","class"=>"form-control input-xlarge"]);        
                echo "</div>";

                //  STATUS
                echo "<div class='form-group'>";
                echo form_label('Status', 'edition_status');
                echo form_dropdown('edition_status', $status_dropdown, @$edition_detail['edition_status'], ["id"=>"edition_status","class"=>"form-control input-small"]);        
                echo "</div>";

                //  DATE
                echo "<div class='form-group'>";
                echo form_label('Date', 'edition_date');
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
                
                //  URL
                echo "<div class='form-group'>";
                echo form_label('URL', 'edition_url');
                echo form_input([
                        'name'          => 'edition_url',
                        'id'            => 'edition_url',
                        'value'         => set_value('edition_url', @$edition_detail['edition_url']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";                
                
                //  ADDRESS
                echo "<div class='form-group'>";
                echo form_label('Street Address', 'edition_address');
                echo form_input([
                        'name'          => 'edition_address',
                        'id'            => 'edition_address',
                        'value'         => set_value('edition_url', @$edition_detail['edition_address']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                 //  GPS
                echo "<div class='form-group'>";
                echo form_label('Latitude and Longitude', 'latitude_num');
                echo "<div class='row'>";
                echo "<div class='col-md-3 col-sm-6'>";
                echo form_input([
                        'name'          => 'latitude_num',
                        'id'            => 'latitude_num',
                        'value'         => set_value('latitude_num', @$edition_detail['latitude_num']),
                        'class'         => 'form-control',
                    ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: -33.844204 </p>";
                echo "</div>";
                echo "<div class='col-md-3 col-sm-6'>";
                echo form_input([
                        'name'          => 'longitude_num',
                        'id'            => 'longitude_num',
                        'value'         => set_value('longitude_num', @$edition_detail['longitude_num']),
                        'class'         => 'form-control',
                    ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: 19.015049 </p>";
                echo "</div>";
                echo "</div>";

                echo "</div>";

                //  SPONSOR
                echo "<div class='form-group'>";
                echo form_label('Sponsor', 'sponsor_id');
                echo form_dropdown('sponsor_id', $sponsor_dropdown, @$edition_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control input-xlarge"]);        
                echo "</div>";
                
                //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Submit",$type="submit",$status="primary");
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";

                echo form_close();
            ?>
            </div>
        </div>
    </div>
    
    <?php
    if ($action=="edit") {
    ?>
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
                ?>
            </div>
        </div>        
    </div>
    <?php
    }
    ?>
</div>