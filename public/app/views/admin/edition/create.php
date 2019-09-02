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

                <!-- EDITION NAME -->
                <div class='form-group'>
                    <div class='row'>
                        <div class='col-sm-7'>
                            <?php
                            echo form_label('Edition Name <span class="compulsary">*</span>', 'edition_name');
                            echo form_input([
                                'name' => 'edition_name',
                                'id' => 'edition_name',
                                'value' => set_value('edition_name', $edition_detail['edition_name'], false),
                                'class' => 'form-control',
                                'required' => '',
                            ]);
                            echo form_input([
                                'name' => 'edition_name_past',
                                'id' => 'edition_name_past',
                                'value' => set_value('edition_name_past', $edition_detail['edition_name']),
                                'type' => 'hidden',
                            ]);
                            ?>
                            <p class='help-block' style='font-style: italic;'> Remember the <b>year</b> at the end of the edition name </p>

                            <?php
                            // EVENT INPUT ON ADD
                            if ($action == "add") {
                                echo form_label('Part of Event <span class="compulsary">*</span>', 'event_id');
                                echo form_dropdown('event_id', $event_dropdown, set_value('event_id', $edition_detail['event_id']), ["id" => "event_id", "class" => "form-control input-xlarge"]);
                                echo form_input(['name' => 'edition_status', 'value' => set_value('edition_status', 1), 'type' => 'hidden',]);
                            } else {
                                ?>
                                <div class='row'>
                                    <div class='col-sm-6'>
                                        <?php
                                        // EDITION STATUS    
                                        echo form_label('Edition Status <span class="compulsary">*</span>', 'edition_status');
                                        echo form_dropdown('edition_status', $status_dropdown, set_value('edition_status', $edition_detail['edition_status']), ["id" => "edition_status", "class" => "form-control input-small"]);
                                        ?>
                                    </div>
                                    <div class='col-sm-6'>
                                        <?php
                                        echo form_label('Information Status <span class="compulsary">*</span>', 'edition_info_status');
                                        echo form_dropdown('edition_info_status', $info_status_dropdown, set_value('edition_info_status', @$edition_detail['edition_info_status']), ["id" => "edition_info_status", "class" => "form-control input-small"]);
                                        ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class='col-sm-5'>
                            <?php
                            echo form_label('', 'event_id');
                            echo "<p class='help-block'><b>Event:</b>" . $edition_detail['event_name'] . " (<a href='" . $event_edit_url . "'>Edit</a>)</p>";
                            echo form_input([
                                'name' => 'event_id',
                                'id' => 'event_id',
                                'value' => set_value('event_id', $edition_detail['event_id']),
                                'type' => 'hidden',
                            ]);
                            ?>
                            <p class='help-block'><b>Town:</b> <?= $edition_detail['town_name']; ?></p>
                            <p class='help-block'> <b>Club:</b> <?= $edition_detail['club_name']; ?></p>
                            <p class='help-block'><b>Slug:</b> <a href='<?= base_url('/event/' . $edition_detail['edition_slug']); ?>' title='Preview' target='_blank'>
                                    <?= $edition_detail['edition_slug']; ?></a></p>
                        </div>
                    </div>
                </div>

                <!-- FLAGS -->
                <div class="form-group">
                    <div class="row">
                        <div class='col-md-8'>
                            <div class='mt-checkbox-inline'>
                                <?php
                                $is_featured_data = array(
                                    'name' => 'edition_isfeatured',
                                    'id' => 'edition_isfeatured',
                                    'value' => '1',
                                    'checked' => $edition_detail['edition_isfeatured'],
                                );
                                echo '<label class="mt-checkbox">' . form_checkbox($is_featured_data) . "Is Featured<span></span></label>";

                                // TBR once new site is launched
//                                $is_confirmed_data = array(
//                                    'name' => 'edition_info_isconfirmed',
//                                    'id' => 'edition_info_isconfirmed',
//                                    'value' => '1',
//                                    'checked' => $edition_detail['edition_info_isconfirmed'],
//                                );
//                                echo '<label class="mt-checkbox">' . form_checkbox($is_confirmed_data) . "Information confirmed<span></span></label>";

                                // TBR once new site is launched
//                                $results_loaded_data = array(
//                                    'name' => 'edition_results_isloaded',
//                                    'id' => 'edition_results_isloaded',
//                                    'value' => '1',
//                                    'checked' => $edition_detail['edition_results_isloaded'],
//                                    'disabled' => '',
//                                );
//                                echo '<label class="mt-checkbox">' . form_checkbox($results_loaded_data) . "Results Loaded<span></span></label>";
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- DATE & GPS -->
                    <div class="row">
                        <div class='col-sm-4'>
                            <?php
                            echo form_label('Edition Date <span class="compulsary">*</span>', 'edition_date');
                            echo '<div class="input-group date date-picker">';
                            echo form_input([
                                'name' => 'edition_date',
                                'id' => 'edition_date',
                                'value' => set_value('edition_date', fdateShort($edition_detail['edition_date'])),
                                'class' => 'form-control',
                            ]);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                            ?>
                        </div>
                        <div class='col-sm-8'>
                            <?php
                            echo form_label('GPS <span class="compulsary">*</span>', 'edition_gps');
                            echo form_input([
                                'name' => 'edition_gps',
                                'id' => 'edition_gps',
                                'value' => set_value('edition_gps', $edition_detail['edition_gps']),
                                'class' => 'form-control',
                            ]);
                            ?>
                            <!--<p class='help-block' style='font-style: italic;'> Ex: -33.844204,19.015049 </p>-->
                        </div>
                    </div>
                </div>

                <!-- CONTACT / SPONSOR / ASA -->
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-4'>
                            <?php
                            echo form_label('Contact Person <span class="compulsary">*</span>', 'user_id');
                            echo form_dropdown('user_id', $contact_dropdown, set_value('user_id', $edition_detail['user_id']), ["id" => "user_id", "class" => "form-control"]);
                            ?>
                        </div>
                        <div class='col-sm-5'>
                            <?php
                            echo form_label('Sponsor <span class="compulsary">*</span>', 'sponsor_id');
                            echo form_dropdown('sponsor_id', $sponsor_dropdown, set_value('sponsor_id', $edition_detail['sponsor_id']), ["id" => "sponsor_id", "class" => "form-control"]);
                            ?>
                        </div>
                        <div class='col-sm-3'>
                            <?php
                            echo form_label('ASA Affiliation <span class="compulsary">*</span>', 'edition_asa_member');
                            echo form_dropdown('edition_asa_member', $asamember_dropdown, set_value('edition_asa_member', $edition_detail['edition_asa_member']), ["id" => "edition_asa_member", "class" => "form-control"]);
                            ?>
                        </div>
                    </div>
                </div>


                <!-- ADDRESS -->
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-6'>
                            <?php
                            echo form_label('Street Address Start <span class="compulsary">*</span>', 'edition_address');
                            echo form_input([
                                'name' => 'edition_address',
                                'id' => 'edition_address',
                                'value' => set_value('edition_address', $edition_detail['edition_address'], false),
                                'class' => 'form-control',
                            ]);
                            ?>
                        </div>
                        <div class='col-sm-6'>
                            <?php
                            echo form_label('Street Address End', 'edition_address_end');
                            echo form_input([
                                'name' => 'edition_address_end',
                                'id' => 'edition_address_end',
                                'value' => set_value('edition_address_end', $edition_detail['edition_address_end'], false),
                                'class' => 'form-control',
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet-footer">
                <div class='btn-group pull-right'>
                    <?= fbutton($text = "Save", $type = "submit", $status = "primary", NULL, "save_only"); ?>
                </div>
            </div>

        </div> <!-- close portlet -->
    </div> <!-- close col -->

    <!-- RACES + DATES-->
    <?php
    if ($action == "edit") {
        ?>    
        <div class="col-md-6">
            <!-- RACES -->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Races</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
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
            
            <!-- DATES -->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold">DATES</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if (!(empty($date_list))) {
                        // create table
                        $this->table->set_template(ftable('list_table'));
                        $this->table->set_heading(["ID", "Date", "Date Type", "Actions"]);
                        foreach ($date_list as $id => $data_entry) {

                            $action_array = [
                                [
                                    "url" => "/admin/date/create/edit/" . $data_entry['date_id'],
                                    "text" => "Edit",
                                    "icon" => "icon-pencil",
                                ],
                                [
                                    "url" => "/admin/date/delete/" . $data_entry['date_id'],
                                    "text" => "Delete",
                                    "icon" => "icon-dislike",
                                    "confirmation_text" => "<b>Are you sure?</b>",
                                ],
                            ];


                            $row['id'] = $data_entry['date_id'];
                            $row['date_date'] = $data_entry['date_date'];
                            $row['datetype'] = $data_entry['datetype_name'];
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
                    echo fbuttonLink("/admin/date/create/add/" . $edition_detail['edition_id'] . "/edition", "Add Date", "default");
                    echo "</div>";
                    ?>
                </div>
            </div>
        </div> <!-- col -->  
    </div>
    <?php
}
?>

<div class="row">
    <!-- INTRO / ENTRIES / GENERAL INFO -->
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
                    'value' => set_value('edition_intro_detail', @$edition_detail['edition_intro_detail'], false),
                ]);

                echo "</div>";

                //  Entry Details
                echo "<div class='form-group'>";
                echo form_label('Entry Details', 'edition_entry_detail');
                echo form_textarea([
                    'name' => 'edition_entry_detail',
                    'id' => 'edition_entry_detail',
                    'value' => set_value('edition_entry_detail', @$edition_detail['edition_entry_detail'], false),
                ]);

                echo "</div>";

                //  Decription
                echo "<div class='form-group'>";
                echo form_label('General Information', 'edition_general_detail');
                echo form_textarea([
                    'name' => 'edition_general_detail',
                    'id' => 'edition_description',
                    'value' => set_value('edition_general_detail', @$edition_detail['edition_general_detail'], false),
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
    </div>
    <?php
    if ($action == "edit") {
        ?>
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
} // IF EDIT
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