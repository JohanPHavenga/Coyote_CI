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
                echo validation_errors(); 

                echo form_open($form_url); 

                
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
                echo form_label('Time', 'race_time');
                echo '<div class="input-group input-small">';
                echo form_input([
                        'name'          => 'race_time',
                        'id'            => 'race_time',
                        'value'         => set_value('race_time', ftimeSort(@$race_detail['race_time'],false)),
                        'class'         => 'form-control timepicker timepicker-24',
                        'required'      => '',
                    ]);    
                echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                echo "</div>";
                
                

                echo "<div class='form-group'>";
                echo form_label('Status', 'race_status');
                echo form_dropdown('race_status', $status_dropdown, @$race_detail['race_status'], ["id"=>"race_status","class"=>"form-control input-small"]);        
                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Race Type', 'racetype_id');
                echo form_dropdown('racetype_id', $racetype_dropdown, @$race_detail['racetype_id'], ["id"=>"racetype_id","class"=>"form-control input-small"]);        
                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Edition', 'edition_id');
                echo form_dropdown('edition_id', $edition_dropdown, @$race_detail['edition_id'], ["id"=>"edition_id","class"=>"form-control"]);        
                echo "</div>";
                
                
                echo "<div class='form-group'>";
                echo form_label('Race Fee Licenced', 'race_fee_licenced');
                echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                echo form_input([
                        'name'          => 'race_fee_licenced',
                        'id'            => 'race_fee_licenced',
                        'value'         => @$race_detail['race_fee_licenced'],
                        'class'         => 'form-control input-xsmall',
                    
                    ]);

                echo "</div></div>";
                
                echo "<div class='form-group'>";
                echo form_label('Race Fee Unlicenced', 'race_fee_unlicenced');
                echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                echo form_input([
                        'name'          => 'race_fee_unlicenced',
                        'id'            => 'race_fee_unlicenced',
                        'value'         => @$race_detail['race_fee_unlicenced'],
                        'class'         => 'form-control input-xsmall',
                    ]);

                echo "</div></div>";
                
                echo "<div class='form-group'>";
                echo form_label('Race Name', 'race_name');
                echo form_input([
                        'name'          => 'race_name',
                        'id'            => 'race_name',
                        'value'         => set_value('race_name', @$race_detail['race_name']),
                        'class'         => 'form-control input-medium',
                    ]);

                echo "<p class='help-block' style='font-style: italic;'>(optional)</p></div>";
                
                echo "<div class='btn-group'>";
                echo fbutton();
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";

                echo form_close();
            ?>
            </div>
        </div>
    </div>
</div>