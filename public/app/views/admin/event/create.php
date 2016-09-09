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
                echo form_label('Name', 'event_name');
                echo form_input([
                        'name'          => 'event_name',
                        'id'            => 'event_name',
                        'value'         => set_value('event_name', @$event_detail['event_name']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Status', 'event_status');
                echo form_dropdown('event_status', $status_dropdown, @$event_detail['event_status'], ["id"=>"event_status","class"=>"form-control"]);        
                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Town', 'town_name');
                echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span>';
                echo form_input([
                        'id'            => 'town_name',
                        'name'          => 'town_name',
                        'value'         => set_value('club_name', @$event_detail['town_name']),
                        'class'         => 'form-control',
                    ]);
                echo "</div></div>";
                echo form_input([
                        'name'          => 'town_id',
                        'id'            => 'town_id',
                        'type'          => 'hidden',
                        'value'         => set_value('club_name', @$event_detail['town_id']),
                    ]);


                echo "<div class='form-group'>";
                echo form_label('Organising Club', 'club_id');
                echo form_dropdown('club_id', $club_dropdown, @$event_detail['club_id'], ["id"=>"club_id","class"=>"form-control"]);        
                echo "</div>";
                
                echo "<div class='btn-group'>";
                echo fbutton();
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";

                echo form_close();

//                wts($town_dropdown);

                //<input type="submit" name="submit" value="Edit Event">
            ?>
            </div>
        </div>
    </div>
</div>
