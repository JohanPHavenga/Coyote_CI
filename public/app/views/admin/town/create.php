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
                echo form_label('Name', 'town_name');
                echo form_input([
                        'name'          => 'town_name',
                        'id'            => 'town_name',
                        'value'         => set_value('town_name', @$town_detail['town_name']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";
                
                //  GPS
                echo "<div class='form-group'>";
                echo form_label('Latitude and Longitude', 'latitude_num');
                echo "<div class='row'>";
                echo "<div class='col-md-6 col-sm-6'>";
                echo form_input([
                    'name' => 'latitude_num',
                    'id' => 'latitude_num',
                    'value' => utf8_encode(@$town_detail['latitude_num']),
                    'class' => 'form-control',
                ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: -33.844204 </p>";
                echo "</div>";

                echo "<div class='col-md-6 col-sm-6'>";
                echo form_input([
                    'name' => 'longitude_num',
                    'id' => 'longitude_num',
                    'value' => utf8_encode(@$town_detail['longitude_num']),
                    'class' => 'form-control',
                ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: 19.015049 </p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                
                //  PROVINCE
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-6'>";
                echo form_label('Province <span class="compulsary">*</span>', 'province_id');
                echo form_dropdown('province_id', $province_dropdown, @$town_detail['province_id'], ["id" => "province_id", "class" => "form-control"]);
                echo "</div>";

                //  AREA
                echo "<div class='col-md-6'>";
                echo form_label('Area <span class="compulsary">*</span>', 'area_id');
                echo form_dropdown('area_id', $area_dropdown, @$town_detail['area_id'], ["id" => "area_id", "class" => "form-control"]);
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

//                wts($town_detail);

                //<input type="submit" name="submit" value="Edit Event">
            ?>
            </div>
        </div>
    </div>
</div>