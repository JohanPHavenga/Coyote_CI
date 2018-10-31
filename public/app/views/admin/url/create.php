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
                //  NAME
                echo "<div class='form-group'>";
                echo form_label('URL', 'url_name');
                echo form_input([
                        'name'          => 'url_name',
                        'id'            => 'url_name',
                        'value'         => set_value('url_name', @$url_detail['url_name']),
                        'class'         => 'form-control',
                        'type'          => 'url'
                    ]);

                echo "</div>";
                
                 //  File type
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo form_label('URL Type <span class="compulsary">*</span>', 'event_id');
                        echo form_dropdown('urltype_id', $urltype_dropdown, @$url_detail['urltype_id'], ["id"=>"edition_id","class"=>"form-control input-xlarge"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                              
                echo "<hr>";
               
                // Edition
                echo "<div class='form-group'>"; 
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo form_label('Edition', 'edition_id');
                        echo form_dropdown('edition_id', $edition_dropdown, @$url_detail['edition_id'], ["id"=>"edition_id","class"=>"form-control"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo form_label('Race', 'race_id');
                        echo form_dropdown('race_id', $race_dropdown, @$url_detail['race_id'], ["id"=>"race_id","class"=>"form-control"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo form_label('Sponsor', 'sponsor_id');
                        echo form_dropdown('sponsor_id', $sponsor_dropdown, @$url_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo form_label('Club', 'club_id');
                        echo form_dropdown('club_id', $club_dropdown, @$url_detail['club_id'], ["id"=>"club_id","class"=>"form-control"]);        
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                
                
                echo "<div class='form-group'>";
                    echo "<div class='row'>";
                        echo "<div class='col-md-12'>";
                        echo "</div>";
                    echo "</div>";
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
                        'value'         => set_value('created_date', @$url_detail['created_date']),
                        'class'         => 'form-control input-medium',
                        'disabled'      => ''
                    ]);

                echo "</div>";
                echo "<div class='form-group'>";
                echo form_label('Date Updated', 'updated_date');
                echo form_input([
                        'value'         => set_value('updated_date', @$url_detail['updated_date']),
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
<?php
//wts(@$url_detail);
?>