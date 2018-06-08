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

                echo "<div class='form-group'>";
                echo form_label('Name', 'racetype_name');
                echo form_input([
                        'name'          => 'racetype_name',
                        'id'            => 'racetype_name',
                        'value'         => set_value('racetype_name', @$racetype_detail['racetype_name']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Abbreviation', 'racetype_abbr');
                echo form_input([
                        'name'          => 'racetype_abbr',
                        'id'            => 'racetype_abbr',
                        'value'         => set_value('racetype_abbr', @$racetype_detail['racetype_abbr']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";

                echo "<div class='form-group'>";
                echo form_label('Status', 'racetype_status');
                echo form_dropdown('racetype_status', $status_dropdown, @$racetype_detail['racetype_status'], ["id"=>"racetype_status","class"=>"form-control"]);        
                echo "</div>";    

                //  BUTTONS
                echo "<div class='btn-group'>";
                echo fbutton($text="Save",$type="submit",$status="primary",NULL,"save_only");
                echo fbutton($text="Save & Close",$type="submit",$status="success");
                echo fbuttonLink($return_url,"Cancel",$status="danger");
                echo "</div>";
                
//                echo "<div class='btn-group'>";
//                echo fbutton();
//                echo fbuttonLink($return_url,"Cancel");
//                echo "</div>";

                echo form_close();

            //    wts($town_dropdown);

                //<input type="submit" name="submit" value="Edit Event">
            ?>
            </div>
        </div>
    </div>
</div>