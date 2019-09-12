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
                <div class='btn-group pull-right'>
                    <?= fbutton("Apply", "submit", "primary", NULL, "save_only"); ?>
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
                                ?>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='form-group'>
                                            <?php
                                            echo form_label('Part of Event <span class="compulsary">*</span>', 'event_id');
                                            echo form_dropdown('event_id', $event_dropdown, set_value('event_id', $edition_detail['event_id']), ["id" => "event_id", "class" => "form-control input-xlarge"]);
                                            echo form_input(['name' => 'edition_status', 'value' => set_value('edition_status', 1), 'type' => 'hidden',]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
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
                                    echo form_dropdown('edition_info_status', $info_status_dropdown, set_value('edition_info_status', $edition_detail['edition_info_status']), ["id" => "edition_info_status", "class" => "form-control input-small"]);
                                    ?>
                                </div>
                            </div>
                            <?php
                            ?>
                        </div>
                        <div class='col-sm-5'>
                            <?php
                            if ($action == "edit") {
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
                                <?php
                            }
                            ?>
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
                                    'checked' => set_value('edition_isfeatured', $edition_detail['edition_isfeatured']),
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

                <!-- CONTACT / ASA -->
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-4'>
                            <?php
                            echo form_label('Contact Person <span class="compulsary">*</span>', 'user_id');
                            echo form_dropdown('user_id', $contact_dropdown, set_value('user_id', $edition_detail['user_id']), ["id" => "user_id", "class" => "form-control"]);
                            ?>
                        </div>
                        <div class='col-sm-3'>
                            <?php
                            echo form_label('ASA Affiliation', 'edition_asa_member');
                            echo form_dropdown('edition_asa_member', $asamember_dropdown, set_value('edition_asa_member', $edition_detail['edition_asa_member']), ["id" => "edition_asa_member", "class" => "form-control"]);
                            ?>
                        </div>
                    </div>
                </div>

                <!-- SPONSORS / ENTRY TYPES -->
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-5'>
                            <?php
                            echo form_label('Sponsor <span class="compulsary">*</span>', 'sponsor_id');
                            echo form_multiselect('sponsor_id[]', $sponsor_dropdown, set_value('sponsor_id', $sponsor_list),
                                    ["id" => "sponsor_id", "class" => "form-control", "size" => 5]);
                            ?>
                        </div>
                        <div class='col-sm-5'>
                            <?php
                            echo form_label('Entry Types', 'entry_types');
                            echo form_multiselect('entrytype_id[]', $entrytype_dropdown, set_value('entrytype_id', $entrytype_list),
                                    ["id" => "entrytype_id", "class" => "form-control", "size" => 5]);
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
                            // TBR
                            echo form_input([
                                'name' => 'edition_address',
                                'id' => 'edition_address',
                                'value' => set_value('edition_address', $edition_detail['edition_address'], false),
                                'class' => 'form-control',
                            ]);
//                            echo form_textarea([
//                                'name' => 'edition_address',
//                                'id' => 'edition_address',
//                                'value' => set_value('edition_address', $edition_detail['edition_address'], false),
//                            ]);
                            ?>
                        </div>
                        <div class='col-sm-6'>
                            <?php
                            echo form_label('Street Address End', 'edition_address_end');
                            // TBR
                            echo form_input([
                                'name' => 'edition_address_end',
                                'id' => 'edition_address_end',
                                'value' => set_value('edition_address_end', $edition_detail['edition_address_end'], false),
                                'class' => 'form-control',
                            ]);
//                            echo form_textarea([
//                                'name' => 'edition_address_end',
//                                'id' => 'edition_address_end',
//                                'value' => set_value('edition_address_end', $edition_detail['edition_address_end'], false),
//                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- close portlet -->
    </div> <!-- close col -->

    <?php
    if ($action == "edit") {
        ?>    
        <div class="col-md-6" id="races">

            <!-- RACES -->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Races</span>
                    </div>
                    <div class='btn-group pull-right'>
                        <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "races"); ?>
                        <?= fbuttonLink("/admin/race/create/add/" . $edition_detail['edition_id'], "Add Race", "info"); ?>
                    </div>
                </div>
                <!-- RACES FLAT EDIT -->
                <?php
                if ($race_list) {
                    foreach ($race_list as $race_id => $race) {
                        // set race icon on wheather there is info loaded or not                        
                        if ((($race['race_fee_flat'] > 0) || ($race['race_fee_senior_licenced'] > 0)) && ($race['race_time_end'] > 0)) {
                            $icon_class = "green";
                        } elseif (($race['race_fee_flat'] > 0) || ($race['race_fee_senior_licenced'] > 0)) {
                            $icon_class = "amber";
                        } else {
                            $icon_class = "red";
                        }
                        // set badge color
                        switch ($race['race_status']) {
                            case "1":
                                $badge_type = "success";
                                break;
                            case "2":
                                $badge_type = "danger";
                                break;
                            default;
                                $badge_type = "warning";
                                break;
                        }
                        ?>
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject uppercase">
                                    <i class="fa fa-check-square <?= $icon_class; ?>"></i>
                                    <strong><?= fraceDistance($race['race_distance']) . "</strong> " . $race['racetype_name']; ?>
                                </span>
                                <span style='margin-top: -2px;' class="badge badge-<?= $badge_type; ?>"> <?= $status_list[$race['race_status']]; ?> </span>
                            </div>
                            <div class='btn-group pull-right' style="margin: 5px 0 0 10px;">
                                <?php
                                echo fbuttonLink("/admin/race/create/edit/" . $race_id, "Edit", "default", "sm");
                                $confirm = "data-toggle='confirmation' data-original-title='Are you sure ?' data-placement='left'";
                                echo fbuttonLink("/admin/race/delete/" . $race_id, "Delete", "danger", "sm", $confirm);
                                ?>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="form-group">

                                <div class="row">
                                    <div class='col-sm-2'>
                                        <?php
                                        echo form_label("Start", 'race_time_start');
                                        ?>
                                        <div class="input-group input-xsmall">
                                            <?php
                                            echo form_input([
                                                'name' => 'races[' . $race_id . '][race_time_start]',
                                                'id' => 'race_time_start',
                                                'value' => set_value('race_time_start', $race['race_time_start'], false),
                                                'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                                'required' => '',
                                            ]);
                                            ?>
                                            <span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button>
                                        </div>
                                    </div>
                                    <div class='col-sm-2'>
                                        <?php
                                        echo form_label("Cut-off", 'race_time_end');
                                        ?>
                                        <div class="input-group input-xsmall">
                                            <?php
                                            echo form_input([
                                                'name' => 'races[' . $race_id . '][race_time_end]',
                                                'id' => 'race_time_end',
                                                'value' => set_value('race_time_end', $race['race_time_end'], false),
                                                'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                                'required' => '',
                                            ]);
                                            ?>
                                            <span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button>
                                        </div>
                                    </div>
                                    <?php
                                    if ($race['race_distance'] >= 10) {
                                        ?>
                                        <div class='col-sm-2'>
                                            <?php
                                            echo form_label('Senior Lic', 'race_fee_senior_licenced');
                                            echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                                            echo form_input([
                                                'name' => 'races[' . $race_id . '][race_fee_senior_licenced]',
                                                'id' => 'race_fee_senior_licenced',
                                                'value' => set_value('race_fee_senior_licenced', $race['race_fee_senior_licenced']),
                                                'class' => 'form-control input-xsmall',
                                                'type' => 'number',
                                                'step' => ".01",
                                                'min' => '0',
                                            ]);
                                            echo "</div>";
                                            ?>
                                        </div>
                                        <?php
                                        if ($race['race_distance'] < 20) {
                                            ?>
                                            <div class='col-sm-2'>
                                                <?php
                                                echo form_label('Junior Lic', 'race_fee_junior_licenced');
                                                echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                                                echo form_input([
                                                    'name' => 'races[' . $race_id . '][race_fee_junior_licenced]',
                                                    'id' => 'race_fee_junior_licenced',
                                                    'value' => set_value('race_fee_junior_licenced', $race['race_fee_junior_licenced']),
                                                    'class' => 'form-control input-xsmall',
                                                    'type' => 'number',
                                                    'step' => ".01",
                                                    'min' => '0',
                                                ]);
                                                echo "</div>";
                                                ?>

                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class='col-sm-2'>
                                            <?php
                                            echo form_label('Flat Fee', 'race_fee_flat');
                                            echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                                            echo form_input([
                                                'name' => 'races[' . $race_id . '][race_fee_flat]',
                                                'id' => 'race_fee_flat',
                                                'value' => set_value('race_fee_flat', $race['race_fee_flat']),
                                                'class' => 'form-control input-xsmall',
                                                'type' => 'number',
                                                'step' => ".01",
                                                'min' => '0',
                                            ]);
                                            echo "</div>";
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class='col-sm-3'>
                                        <?php
                                        echo form_label("Name", 'race_name');
                                        echo form_input([
                                            'name' => 'races[' . $race_id . '][race_name]',
                                            'id' => 'race_name',
                                            'value' => set_value('race_name', $race['race_name'], true),
                                            'class' => 'form-control',
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<p>No races linked to this edition</p>";
                }
                ?>
            </div>


            <!-- DATES -->
            <div class="portlet light" id="dates">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold">DATES</span>
                    </div>
                    <div class='btn-group pull-right'>
                        <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "dates"); ?>
                        <?= fbuttonLink("/admin/date/create/add/" . $edition_detail['edition_id'] . "/edition", "Add Date", "info"); ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php
                    if (!(empty($date_list))) {
                        // create table
                        $this->table->set_template(ftable('edition_dates_table'));
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
                    ?>
                </div>
            </div>
        </div> <!-- col -->  
        <?php
    }
    ?>
</div>

<div class="row">
    <!-- INTRO / ENTRIES / GENERAL INFO -->
    <div class="col-md-6">
        <div class="portlet light" id="more_info">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">More information</span>
                </div>
                <div class='btn-group pull-right'>
                    <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "more_info"); ?>
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
        </div> <!-- portlet -->  
    </div>
    <?php
    if ($action == "edit") {
        ?>
        <!-- ADD URLs -->
        <div class="col-md-6">    
            <div class="portlet light" id="url_list">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold">URLs</span>
                    </div>
                    <div class='btn-group pull-right'>
                        <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "url_list"); ?>
                        <?= fbuttonLink("/admin/url/create/add/" . $edition_detail['edition_id'] . "/edition", "Add URL", "info"); ?>
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
                    ?>
                </div>
            </div>

            <div class="portlet light" id="file_list">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-edit font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Files</span>
                    </div>
                    <div class='btn-group pull-right'>
                        <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "file_list"); ?>
                        <?= fbuttonLink("/admin/file/create/add/" . $edition_detail['edition_id'] . "/edition", "Add File", "info"); ?>
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
                            'value' => set_value('created_date', $edition_detail['created_date']),
                            'class' => 'form-control input-medium',
                            'disabled' => ''
                        ]);
                        echo "</div>";
                        echo "<div class='col-md-6'>";
                        echo form_label('Date Updated', 'updated_date');
                        echo form_input([
                            'value' => set_value('updated_date', $edition_detail['updated_date']),
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
    <div class="col-md-12">
        <div class='btn-group' style='padding-bottom: 20px;'>
            <?php
            echo fbutton($text = "Apply", $type = "submit", $status = "primary", NULL, "save_only");
            echo fbutton($text = "Save", $type = "submit", $status = "success");
            ?>
        </div>
        <div class='btn-group pull-right' style='padding-bottom: 20px;'>
            <?php
            echo fbuttonLink($return_url, "Cancel", $status = "warning");
            if ($edition_detail['edition_status'] == 2) {
                echo fbuttonLink($delete_url, "Delete", $status = "danger");
            }
            ?>
        </div>
    </div> <!-- col -->
</div> <!-- row -->

<?php
echo form_close();
//wts($edition_detail);
//wts($status_list);