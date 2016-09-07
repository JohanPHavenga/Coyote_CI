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
                echo form_label('Entry Number', 'entry_number');
                echo form_input([
                        'name'          => 'entry_number',
                        'id'            => 'entry_number',
                        'value'         => set_value('entry_number', @$entry_detail['entry_number']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";

                if ( ! @$entry_detail['entry_time'])
                {
                    $time=0;
                } else {
                    $time=@$entry_detail['entry_time'];
                }
                echo "<div class='form-group'>";
                echo form_label('Race Result', 'entry_time');
                echo "<div class='input-group date' id='entry_time'>";
                echo form_input([
                        'name'          => 'entry_time',
                        'value'         => set_value('entry_time', $time, false),
                        'class'         => 'form-control entry_time',
                    ]);    
                echo '<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div>';
                echo "</div>";


                echo "<div class='form-group'>";
                echo form_label('Race', 'race_id');
                echo form_dropdown('race_id', $race_dropdown, @$entry_detail['race_id'], ["id"=>"race_id","class"=>"form-control"]);        
                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('User', 'user_id');
                echo form_dropdown('user_id', $user_dropdown, @$entry_detail['user_id'], ["id"=>"user_id","class"=>"form-control"]);        
                echo "</div>";


                echo "<div class='form-group'>";
                echo form_label('Club', 'club_id');
                echo form_dropdown('club_id', $club_dropdown, @$entry_detail['club_id'], ["id"=>"club_id","class"=>"form-control"]);        
                echo "</div>";
                
                echo "<div class='btn-group'>";
                echo fbutton();
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";

                echo form_close();

            //    wts($town_dropdown);

                //<input type="submit" name="submit" value="Edit Event">
            ?>
            </div>
        </div>
    </div>
</div>