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
                echo form_label('Name', 'filetype_name');
                echo form_input([
                        'name'          => 'filetype_name',
                        'id'            => 'filetype_name',
                        'value'         => set_value('filetype_name', @$filetype_detail['filetype_name']),
                        'class'         => 'form-control input-large',
                    ]);

                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Help Text', 'filetype_helptext');
                echo form_input([
                        'name'          => 'filetype_helptext',
                        'id'            => 'filetype_helptext',
                        'value'         => set_value('filetype_helptext', @$filetype_detail['filetype_helptext']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Button Text', 'filetype_buttontext');
                echo form_input([
                        'name'          => 'filetype_buttontext',
                        'id'            => 'filetype_buttontext',
                        'value'         => set_value('filetype_buttontext', @$filetype_detail['filetype_buttontext']),
                        'class'         => 'form-control input-large',
                    ]);

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