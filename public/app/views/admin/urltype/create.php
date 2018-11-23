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
                echo form_label('Name', 'urltype_name');
                echo form_input([
                        'name'          => 'urltype_name',
                        'id'            => 'urltype_name',
                        'value'         => set_value('urltype_name', @$urltype_detail['urltype_name']),
                        'class'         => 'form-control input-large',
                    ]);

                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Help Text', 'urltype_helptext');
                echo form_input([
                        'name'          => 'urltype_helptext',
                        'id'            => 'urltype_helptext',
                        'value'         => set_value('urltype_helptext', @$urltype_detail['urltype_helptext']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                echo "<div class='form-group'>";
                echo form_label('Button Text', 'urltype_buttontext');
                echo form_input([
                        'name'          => 'urltype_buttontext',
                        'id'            => 'urltype_buttontext',
                        'value'         => set_value('urltype_buttontext', @$urltype_detail['urltype_buttontext']),
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