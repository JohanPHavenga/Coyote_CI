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
                echo '<span class="twitter-typeahead" style="position: relative; display: inline-block;">';
                echo form_input([
                        'id'            => 'town_name',
                        'name'          => 'town_name',
                        'value'         => set_value('club_name', @$event_detail['town_name']),
                        'class'         => 'form-control',
                    ]);
                echo form_input([
                        'name'          => 'town_id',
                        'id'            => 'town_id',
                        'type'          => 'hidden',
                        'value'         => set_value('club_name', @$event_detail['town_id']),
                    ]);
                echo "</span></div></div>";

                ?>
<!--                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-search"></i>
                    </span>
                    <span class="twitter-typeahead" style="position: relative; display: inline-block;">
                        <input type="text" class="form-control tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
                        <input type="text" id="typeahead_example_2" name="typeahead_example_2" class="form-control tt-input" autocomplete="off" spellcheck="false" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;">
                        <pre aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;"></pre>
                        <div class="tt-menu tt-empty" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;">
                            <div class="tt-dataset tt-dataset-typeahead_example_2"></div>
                            
                        </div>
                    </span> -->
                    </div>
                <?php
                
                
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
