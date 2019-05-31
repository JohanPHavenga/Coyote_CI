<?php
echo form_open_multipart($form_url);
?>
<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= ucfirst($action); ?> Edition</span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                //  EDITION NAME
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-7'>";
                echo form_label('Edition Name <span class="compulsary">*</span>', 'edition_name');
                echo form_input([
                    'name' => 'edition_name',
                    'id' => 'edition_name',
//                    'value' => utf8_encode(@$edition_detail['edition_name']),
                    'value' => set_value('edition_name', @$edition_detail['edition_name'], false),
                    'class' => 'form-control input-xlarge',
                    'required' => '',
                ]);
                echo form_input([
                    'name' => 'edition_name_past',
                    'id' => 'edition_name_past',
                    'value' => set_value('edition_name_past', @$edition_detail['edition_name']),
                    'type' => 'hidden',
                ]);

                echo "<p class='help-block' style='font-style: italic;'> Remember to always add the year at the end of the edition name </p>";
                echo "</div>";

                //  
                echo "<div class='col-md-5'>";

                echo "</div>";
                echo "</div>";
                echo "</div>";

                //  EVENT LINK
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-7'>";
                echo form_label('Part of Event <span class="compulsary">*</span>', 'event_id');
                echo form_dropdown('event_id', $event_dropdown, set_value('event_id', @$edition_detail['event_id']), ["id" => "event_id", "class" => "form-control input-xlarge"]);
                echo "</div>";

                //  EDITION STATUS
                echo "<div class='col-md-5'>";
                echo form_label('Edition Status <span class="compulsary">*</span>', 'edition_status');
                echo form_dropdown('edition_status', $status_dropdown, set_value('edition_status', @$edition_detail['edition_status']), ["id" => "edition_status", "class" => "form-control input-small"]);
                echo "</div>";
                echo "</div>";
                echo "</div>";

                //  DATE
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-4'>";
                echo form_label('Date Start <span class="compulsary">*</span>', 'edition_date');
                echo '<div class="input-group input-medium date date-picker">';
                echo form_input([
                    'name' => 'edition_date',
                    'id' => 'edition_date',
                    'value' => set_value('edition_date', @fdateShort($edition_detail['edition_date'])),
                    'class' => 'form-control',
                        //                        'readonly'      => '',
                ]);
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>";

                //  DATE END
                echo "<div class='col-md-4'>";
                echo form_label('Date End', 'edition_date_end');
                echo '<div class="input-group input-medium date date-picker">';
                echo form_input([
                    'name' => 'edition_date_end',
                    'id' => 'edition_date_end',
                    'value' => set_value('edition_date_end', @fdateShort($edition_detail['edition_date_end'])),
                    'class' => 'form-control',
                        //                        'readonly'      => '',
                ]);
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>"; // col
                echo "</div>"; // row
                echo "</div>"; // form-group
                //  ADDRESS
                echo "<div class='form-group'>";
                echo form_label('Street Address <span class="compulsary">*</span>', 'edition_address');
                echo form_input([
                    'name' => 'edition_address',
                    'id' => 'edition_address',
                    'value' => set_value('edition_address', @$edition_detail['edition_address'], false),
                    'class' => 'form-control',
                ]);

                echo "</div>";

                //  ADDRESS
//                echo "<div class='form-group'>";
//                echo form_label('Street Address (Race End)', 'edition_address_end');
//                echo form_input([
//                        'name'          => 'edition_address_end',
//                        'id'            => 'edition_address_end',
//                        'value'         => utf8_encode(@$edition_detail['edition_address_end']),
//                        'class'         => 'form-control',
//                    ]);
//                echo "<p class='help-block' style='font-style: italic;'> Only if it difers from the start address </p>";
//
//                echo "</div>";
                //  GPS
                echo "<div class='form-group'>";
                echo form_label('Latitude and Longitude <span class="compulsary">*</span>', 'latitude_num');
                echo "<div class='row'>";
                echo "<div class='col-md-3 col-sm-6'>";
                echo form_input([
                    'name' => 'latitude_num',
                    'id' => 'latitude_num',
                    'value' => set_value('latitude_num', @$edition_detail['latitude_num']),
                    'class' => 'form-control',
                ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: -33.844204 </p>";
                echo "</div>";

                echo "<div class='col-md-3 col-sm-6'>";
                echo form_input([
                    'name' => 'longitude_num',
                    'id' => 'longitude_num',
                    'value' => set_value('longitude_num', @$edition_detail['longitude_num']),
                    'class' => 'form-control',
                ]);
                echo "<p class='help-block' style='font-style: italic;'> Ex: 19.015049 </p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                //  ONLINE ENTRIES OPEN AND CLOSE
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-4'>";
                echo form_label('Online Entries Open', 'edition_entries_date_open');
                echo '<div class="input-group input-medium">';
                echo form_input([
                    'name' => 'edition_entries_date_open',
                    'id' => 'edition_entries_date_open',
                    'value' => set_value('edition_entries_date_open', @fdateLong($edition_detail['edition_entries_date_open'])),
                    'class' => 'form-control form_datetime'
                ]);
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>";

                //  ENTRIES CLOSE
                echo "<div class='col-md-4'>";
                echo form_label('Online Entries Close', 'edition_entries_date_close');
                echo '<div class="input-group input-medium">';
                echo form_input([
                    'name' => 'edition_entries_date_close',
                    'id' => 'edition_entries_date_close',
                    'value' => set_value('edition_entries_date_close', @fdateLong($edition_detail['edition_entries_date_close'])),
                    'class' => 'form-control form_datetime',
                        //                        'readonly'      => '',
                ]);
                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                echo "</div>"; // col
                echo "</div>"; // row
                echo "</div>"; // form-group
                //  ASA Membership
                echo "<div class='form-group'>";
                echo form_label('ASA Affiliation', 'edition_asa_member');
                echo "<div class='row'>";
                echo "<div class='col-md-9'><div class='mt-radio-inline'>";
                foreach ($asamember_list as $asamember) {
                    $id = $asamember['asa_member_id'];
                    $abbr = $asamember['asa_member_abbr'];
                    if (@$edition_detail['edition_asa_member'] == $id) {
                        $c = "checked=''";
                    } else {
                        $c = '';
                    }
                    echo '<label class="mt-radio">
                                <input type="radio" name="edition_asa_member" id="edition_asa_member" value="' . $id . '" ' . $c . '> ' . $abbr . '
                                <span></span>
                            </label>';
                }
                if (!@$edition_detail['edition_asa_member']) {
                    $c = "checked=''";
                } else {
                    $c = '';
                }
                echo '<label class="mt-radio">
                                <input type="radio" name="edition_asa_member" id="edition_asa_member" value="0" ' . $c . '> None
                                <span></span>
                            </label>';
                echo "</div></div>";
                echo "</div>";

                //  CONTACT
                echo "<div class='row'>";
                echo "<div class='col-md-6'>";
                echo form_label('Contact Person <span class="compulsary">*</span>', 'user_id');
                echo form_dropdown('user_id', $contact_dropdown, set_value('user_id', @$edition_detail['user_id']), ["id" => "user_id", "class" => "form-control"]);
                echo "</div>";

                //  SPONSOR
                echo "<div class='col-md-6'>";
                echo form_label('Sponsor <span class="compulsary">*</span>', 'sponsor_id');
                echo form_dropdown('sponsor_id', $sponsor_dropdown, set_value('sponsor_id', @$edition_detail['sponsor_id']), ["id" => "sponsor_id", "class" => "form-control"]);
                echo "</div>";
                echo "</div>";
                echo "</div>";

                //  RESULTS STATUS
                echo "<div class='form-group'>";
                echo "<div class='row'>";
                echo "<div class='col-md-3'>";
                echo form_label('Results Status <span class="compulsary">*</span>', 'edition_results_status');
                echo form_dropdown('edition_results_status', $results_status_dropdown, set_value('edition_results_status', @$edition_detail['edition_results_status']), ["id" => "edition_results_status", "class" => "form-control input-small"]);
                echo "</div>";
                echo "<div class='col-md-8' style='padding-top: 20px;'>";
                echo" <div class='mt-checkbox-inline'>";
                if ($edition_detail['edition_info_isconfirmed']) {
                    $c = "checked=''";
                } else {
                    $c = '';
                }
                echo '<label class="mt-checkbox">
                                    <input type="checkbox" id="edition_info_isconfirmed" name="edition_info_isconfirmed" value="1" ' . $c . '> Information confirmed
                                    <span></span>
                                </label>';

                if ($edition_detail['edition_isfeatured']) {
                    $c = "checked=''";
                } else {
                    $c = '';
                }
                echo '<label class="mt-checkbox">
                                    <input type="checkbox" id="edition_isfeatured" name="edition_isfeatured" value="1" ' . $c . '> Is Featured
                                    <span></span>
                                </label>';
                if (@$edition_detail['edition_results_isloaded']) {
                    $c = "checked=''";
                } else {
                    $c = '';
                }
                echo '<label class="mt-checkbox">
                                    <input type="checkbox" id="edition_results_isloaded" name="edition_results_isloaded" disabled="disabled" value="1" ' . $c . '> Results Loaded
                                    <span></span>
                                </label>';
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                ?>
            </div>
            <div class="portlet-footer">
                <?php
                //  BUTTONS
                echo "<div class='btn-group pull-right'>";
                echo fbutton($text = "Save", $type = "submit", $status = "primary", NULL, "save_only");
                echo "</div>";
                ?>
            </div>

        </div>
    </div>




    <!-- MORE INFO -->
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
                //  Event Intro
                echo "<div class='form-group'>";
                echo form_label('Event Intro', 'edition_intro_detail');
                echo form_textarea([
                    'name' => 'edition_intro_detail',
                    'id' => 'edition_intro_detail',
                    'value' => set_value('edition_intro_detail', @$edition_detail['edition_intro_detail'],false),
                ]);

                echo "</div>";

                //  Entry Details
                echo "<div class='form-group'>";
                echo form_label('Entry Details', 'edition_entry_detail');
                echo form_textarea([
                    'name' => 'edition_entry_detail',
                    'id' => 'edition_entry_detail',
                    'value' => set_value('edition_entry_detail', @$edition_detail['edition_entry_detail'],false),
                ]);

                echo "</div>";

                //  Decription
                echo "<div class='form-group'>";
                echo form_label('General Information', 'edition_description');
                echo form_textarea([
                    'name' => 'edition_description',
                    'id' => 'edition_description',
                    'value' => set_value('edition_description', @$edition_detail['edition_description'],false),
                ]);

                echo "</div>";
                ?>

            </div> <!-- portlet-body -->    
            <div class="portlet-footer">
                <?php
//  BUTTONS
                echo "<div class='btn-group pull-right'>";
                echo fbutton($text = "Save", $type = "submit", $status = "primary", NULL, "save_only");
                echo "</div>";
                ?>
            </div>
        </div> <!-- portlet -->  
    </div> <!-- col -->  
</div>

<?php
if ($action == "edit") {
    ?>
    <div class="row">

        <!-- ADD URLs -->
        <div class="col-md-6">    
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold">URLs</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if (!(empty($url_list))) {
                        // create table
                        $this->table->set_template(ftable('list_table'));
                        $this->table->set_heading(["ID", "URL", "URL Type", "Actions"]);
                        foreach ($url_list as $id => $data_entry) {

                            $action_array = [
                                [
                                    "url" => "/admin/url/create/edit/" . $data_entry['url_id'],
                                    "text" => "Edit",
                                    "icon" => "icon-pencil",
                                ],
                                [
                                    "url" => "/admin/url/delete/" . $data_entry['url_id'],
                                    "text" => "Delete",
                                    "icon" => "icon-dislike",
                                    "confirmation_text" => "<b>Are you sure?</b>",
                                ],
                            ];


                            $row['id'] = $data_entry['url_id'];
                            $row['url_name'] = $data_entry['url_name'];
                            $row['urltype'] = $data_entry['urltype_name'];
                            $row['actions'] = fbuttonActionGroup($action_array);

                            $this->table->add_row($row);
                            unset($row);
                        }
                        echo $this->table->generate();
                    } else {
                        echo "<p>No URLs loaded for the edition</p>";
                    }

                    // add button
                    echo "<div class='btn-group'>";
                    echo fbuttonLink("/admin/url/create/add/" . $edition_detail['edition_id'] . "/edition", "Add URL", "default");
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div> <!-- col -->

        <!-- ADD FILES -->
        <div class="col-md-6">    
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Files</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if (!(empty($file_list))) {
                        // create table
                        $this->table->set_template(ftable('file_table'));
                        $this->table->set_heading(["ID", "File Name", "File Type", "Actions"]);
                        foreach ($file_list as $id => $data_entry) {

                            $action_array = [
                                [
                                    "url" => "/admin/file/delete/" . $data_entry['file_id'],
                                    "text" => "Delete",
                                    "icon" => "icon-dislike",
                                    "confirmation_text" => "<b>Are you sure?</b>",
                                ],
                            ];

                            $file_id = my_encrypt($data_entry['file_id']);
                            $file_url = base_url("file/handler/" . $file_id);

                            $row['id'] = $data_entry['file_id'];
                            $row['file_name'] = "<a href='$file_url' target='_blank'>" . $data_entry['file_name'] . "</a>";
                            $row['filetype'] = $data_entry['filetype_name'];
                            $row['actions'] = fbuttonActionGroup($action_array);

                            $this->table->add_row($row);
                            unset($row);
                        }
                        echo $this->table->generate();
                    } else {
                        echo "<p>No Files loaded for the edition</p>";
                    }

                    // add button
                    echo "<div class='btn-group'>";
                    echo fbuttonLink("/admin/file/create/add/" . $edition_detail['edition_id'] . "/edition", "Add File", "default");
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div> <!-- col -->

    </div> <!-- row --->



    <div class="row">
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Races</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    // RACES
                    if (!(empty($race_list))) {
                        // create table
                        $this->table->set_template(ftable('races_table'));
                        $this->table->set_heading(["ID", "Race Distance", "Race Type", "Race Time", "Status", "Actions"]);
                        foreach ($race_list as $id => $data_entry) {

                            $action_array = [
                                [
                                    "url" => "/admin/race/create/edit/" . $data_entry['race_id'],
                                    "text" => "Edit",
                                    "icon" => "icon-pencil",
                                ],
                                [
                                    "url" => "/admin/race/delete/" . $data_entry['race_id'],
                                    "text" => "Delete",
                                    "icon" => "icon-dislike",
                                    "confirmation_text" => "<b>Are you sure?</b>",
                                ],
                            ];


                            $row['id'] = $data_entry['race_id'];
                            $row['distance'] = fraceDistance($data_entry['race_distance']);
                            $row['racetype'] = $data_entry['racetype_name'];
                            $row['time'] = ftimeSort($data_entry['race_time_start']);
                            $row['status'] = flableStatus($data_entry['race_status']);
                            $row['actions'] = fbuttonActionGroup($action_array);

                            $this->table->add_row(
                                    $row['id'], array('data' => $row['distance'], 'align' => 'right'), $row['racetype'], $row['time'], $row['status'], $row['actions']
                            );
//                        $this->table->add_row($row);
                            unset($row);
                        }
                        echo $this->table->generate();
                    } else {
                        echo "<p>No races loaded for the edition</p>";
                    }

                    // add button
                    echo "<div class='btn-group'>";
                    echo fbuttonLink("/admin/race/create/add/" . $edition_detail['edition_id'], "Add Race", "default");
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div>

        <!-- LOGO -->
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Logo Upload</span>
                    </div>
                </div>
                <div class="portlet-body">  
                    <?php
                    echo "<div class='form-group'>";
                    echo "<div class='row'>";
                    echo "<div class='col-md-12'>";
                    // LOGO
                    if (($action == "edit") && (@$file_list_by_type[1])) {
                        $img_url = base_url("uploads/edition/" . $edition_detail['edition_id'] . "/" . $file_list_by_type[1][0]['file_name']);
                        echo "<div class='col-md-6'>";
                        echo "<p><img src='$img_url' style='width: 300px;'></p>";
                        echo "</div>";
                    } else {
                        echo "<p>No logo to display</p>";
                    }
                    echo "</div>";

                    echo "</div>";
                    echo "</div>";
                    ?>
                </div> <!-- portlet-body -->   
            </div> <!-- portlet -->  
            <div class="portlet light">

                <div class="portlet-body">  
                    <?php
                    if ($action == "edit") {
                        echo "<div class='form-group'>";
                        echo "<div class='row'>";
                        echo "<div class='col-md-6'>";
                        echo form_label('Date Created', 'created_date');
                        echo form_input([
                            'value' => set_value('created_date', @$edition_detail['created_date']),
                            'class' => 'form-control input-medium',
                            'disabled' => ''
                        ]);
                        echo "</div>";
                        echo "<div class='col-md-6'>";
                        echo form_label('Date Updated', 'updated_date');
                        echo form_input([
                            'value' => set_value('updated_date', @$edition_detail['updated_date']),
                            'class' => 'form-control input-medium',
                            'disabled' => ''
                        ]);

                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

        </div> <!-- col -->  
    </div> <!-- row -->  

    <?php
}
?>
<div class="row">
    <div class="col-md-6">  
        <div class="row">
            <div class="col-md-6">   
                <?php
                //  BUTTONS
                echo "<div class='btn-group' style='padding-bottom: 20px;'>";
                echo fbutton($text = "Save", $type = "submit", $status = "primary", NULL, "save_only");
                echo fbutton($text = "Save & Close", $type = "submit", $status = "success");
                echo fbuttonLink($return_url, "Cancel", $status = "danger");
                echo "</div>";
                ?>
            </div>
        </div>
    </div> <!-- col -->
</div> <!-- row -->  

<?php
echo form_close();
?>