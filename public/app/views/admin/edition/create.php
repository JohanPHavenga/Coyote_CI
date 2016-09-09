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
                echo form_label('Name', 'edition_name');
                echo form_input([
                        'name'          => 'edition_name',
                        'id'            => 'edition_name',
                        'value'         => set_value('edition_name', @$edition_detail['edition_name']),
                        'class'         => 'form-control',
                        'required'      => '',
                    ]);

                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Status', 'edition_status');
                echo form_dropdown('edition_status', $status_dropdown, @$edition_detail['edition_status'], ["id"=>"edition_status","class"=>"form-control input-small"]);        
                echo "</div>";

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


                echo "<div class='form-group'>";
                echo form_label('Event', 'event_id');
                echo form_dropdown('event_id', $event_dropdown, @$edition_detail['event_id'], ["id"=>"event_id","class"=>"form-control"]);        
                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Sponsor', 'sponsor_id');
                echo form_dropdown('sponsor_id', $sponsor_dropdown, @$edition_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control"]);        
                echo "</div>";
                
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