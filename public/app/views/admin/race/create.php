<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= ucfirst($action);?> entry</span>
                </div>
            </div>
            <div class="portlet-body">
            <?php  
                echo form_open($form_url); 
                
                echo "<div class='row'>";                 
                    echo "<div class='col-md-5'>";
                        echo "<div class='form-group'>";   
                            echo form_label('Race Distance (km)', 'race_distance');
                            echo form_input([
                                    'name'          => 'race_distance',
                                    'id'            => 'race_distance',
                                    'value'         => @$race_detail['race_distance']+0,
                                    'class'         => 'form-control input-small',
                                    'required'      => '',
                                ]);    
                        echo "</div>";
                    
                        echo "<div class='form-group'>";       
                            echo form_label('Status', 'race_status');
                            echo form_dropdown('race_status', $status_dropdown, @$race_detail['race_status'], ["id"=>"race_status","class"=>"form-control input-small"]);
                        echo "</div>";
                        
                        echo "<div class='form-group'>";   
                            echo form_label('Race Type', 'racetype_id');
                            echo form_dropdown('racetype_id', $racetype_dropdown, @$race_detail['racetype_id'], ["id"=>"racetype_id","class"=>"form-control input-small"]);   
                        echo "</div>"; 
                        
                    echo "</div>"; // end col
                    
                    echo "<div class='col-md-7'>";                        
                        echo "<div class='form-group'>";   
                            echo form_label('Start Time', 'race_time_start');
                            echo '<div class="input-group input-small">';
                            echo form_input([
                                    'name'          => 'race_time_start',
                                    'id'            => 'race_time_start',
                                    'value'         => set_value('race_time_start', ftimeSort(@$race_detail['race_time_start'],false)),
                                    'class'         => 'form-control timepicker timepicker-24',
                                    'required'      => '',
                                ]);    
                            echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                        echo "</div>";
                        
                        echo "<div class='form-group'>";   
                            echo form_label('Cut-off Time', 'race_time_end');
                            echo '<div class="input-group input-small">';
                            echo form_input([
                                    'name'          => 'race_time_end',
                                    'id'            => 'race_time_end',
                                    'value'         => set_value('race_time_end', ftimeSort(@$race_detail['race_time_end'],false)),
                                    'class'         => 'form-control timepicker timepicker-24',
                                ]);    
                            echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                        echo "</div>";
                        
                        echo "<div class='form-group'>";
                            echo form_label('Race Date', 'race_date');
                            echo '<div class="input-group input-medium date date-picker">';
                            echo form_input([
                                    'name'          => 'race_date',
                                    'id'            => 'race_date',
                                    'value'         => set_value('race_date', @fdateShort($race_detail['race_date'])),
                                    'class'         => 'form-control',
                                ]);    
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';                            
                            echo "<p class='help-block' style='font-style: italic;'>Only applicable if different than edition date [".fdateShort($edition_detail['edition_date'])."]</p>";
                         echo "</div>";
                
                    echo "</div>"; // end col
                echo "</div>"; // end Row
                
                // Editions
                echo "<div class='form-group'>";
                    echo "<div class='row'>";                 
                    echo "<div class='col-md-12'>";
                        echo "<div class='form-group'>";
                        echo form_label('Edition', 'edition_id');
                        echo form_dropdown('edition_id', $edition_dropdown, @$race_detail['edition_id'], ["id"=>"edition_id","class"=>"form-control"]);        
                        echo "</div>"; 
                    echo "</div>"; // end col
                    echo "</div>"; // end Row
                
                
                // Race Name
                    echo "<div class='row'>";      
                    echo "<div class='col-md-6'>";
                            echo form_label('Race Name', 'race_name');
                            echo form_input([
                                    'name'          => 'race_name',
                                    'id'            => 'race_name',
                                    'value'         => set_value('race_name', $race_detail['race_name']),
                                    'class'         => 'form-control input-medium',
                                ]);

                            echo "<p class='help-block' style='font-style: italic;'>(optional)</p>";
                    echo "</div>"; // end col
                    echo "</div>"; // end Row
                echo "</div>";
                
                // RACE FEES
                echo "<div class='row'>";                 
                    echo "<div class='col-md-6'>";
                        echo "<div class='form-group'>";
                        echo form_label('Flat Race Fee', 'race_fee_flat');
                        echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                        echo form_input([
                                'name'          => 'race_fee_flat',
                                'id'            => 'race_fee_flat',
                                'value'         => @$race_detail['race_fee_flat'],
                                'class'         => 'form-control input-xsmall',

                            ]);
                        echo "</div>";
                        echo "<p class='help-block' style='font-style: italic;'>Note if set this is the old fee that will display</p></div>";
                    echo "</div>"; // end col
                echo "</div>"; // end Row
                
                echo "<div class='row'>";                 
                    echo "<div class='col-md-6'>";
                        echo "<div class='form-group'>";
                        echo form_label('Senior Race Fee Licenced', 'race_fee_senior_licenced');
                        echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                        echo form_input([
                                'name'          => 'race_fee_senior_licenced',
                                'id'            => 'race_fee_senior_licenced',
                                'value'         => @$race_detail['race_fee_senior_licenced'],
                                'class'         => 'form-control input-xsmall',

                            ]);
                        echo "</div></div>";
                
                        echo "<div class='form-group'>";
                        echo form_label('Senior Race Fee Unlicenced', 'race_fee_senior_unlicenced');
                        echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                        echo form_input([
                                'name'          => 'race_fee_senior_unlicenced',
                                'id'            => 'race_fee_senior_unlicenced',
                                'value'         => @$race_detail['race_fee_senior_unlicenced'],
                                'class'         => 'form-control input-xsmall',
                            ]);
                        echo "</div></div>";
                        
                    echo "</div>"; // end col  
                    echo "<div class='col-md-6'>";
                
                        echo "<div class='form-group'>";
                        echo form_label('Junior Race Fee Licenced', 'race_fee_junior_licenced');
                        echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                        echo form_input([
                                'name'          => 'race_fee_junior_licenced',
                                'id'            => 'race_fee_junior_licenced',
                                'value'         => @$race_detail['race_fee_junior_licenced'],
                                'class'         => 'form-control input-xsmall',

                            ]);
                        echo "</div></div>";

                        echo "<div class='form-group'>";
                        echo form_label('Junior Race Fee Unlicenced', 'race_fee_junior_unlicenced');
                        echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                        echo form_input([
                                'name'          => 'race_fee_junior_unlicenced',
                                'id'            => 'race_fee_junior_unlicenced',
                                'value'         => @$race_detail['race_fee_junior_unlicenced'],
                                'class'         => 'form-control input-xsmall',
                            ]);
                        echo "</div></div>";
                    echo "</div>"; // end col
                echo "</div>"; // end Row
                
                echo "<div class='form-group'>";
                    echo "<div class='row'>";                       
                        echo "<div class='col-md-6'>";
                            echo form_label('Minimum age', 'race_minimum_age');
                            echo form_input([
                                    'name'          => 'race_minimum_age',
                                    'id'            => 'race_minimum_age',
                                    'value'         => set_value('race_minimum_age', $race_detail['race_minimum_age']),
                                    'class'         => 'form-control input-xsmall',
                                ]);

                        echo "</div>"; // end col
                    echo "</div>"; // end Row
                echo "</div>"; // end form-group
                
                // flags
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                        echo" <div class='mt-checkbox-inline'>";
                            if ($race_detail['race_isover70free']) { $c = "checked=''"; } else { $c = ''; }
                            echo '<label class="mt-checkbox">
                                        <input type="checkbox" id="race_isover70free" name="race_isover70free" value="1" ' . $c . '> Over 70 free?
                                        <span></span>
                                    </label>';
                    echo "</div>"; // end col
                    echo "</div>"; // end Row
                echo "</div>"; // end form-group
                
                
                //  Race Notes
                echo "<div class='form-group'>";
                echo form_label('Race Notes', 'race_notes');
                echo form_textarea([
                        'name'          => 'race_notes',
                        'id'            => 'race_notes',
                        'value'         => utf8_encode(@$race_detail['race_notes']),
                    ]);

                echo "</div>";
                
                //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Save",$type="submit",$status="primary",NULL,"save_only");
                echo fbutton($text="Save & Close",$type="submit",$status="success");
                echo fbuttonLink($return_url,"Cancel",$status="danger");
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
                        'value'         => set_value('created_date', @$race_detail['created_date']),
                        'class'         => 'form-control input-medium',
                        'disabled'      => ''
                    ]);

                echo "</div>";
                echo "<div class='form-group'>";
                echo form_label('Date Updated', 'updated_date');
                echo form_input([
                        'value'         => set_value('updated_date', @$race_detail['updated_date']),
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