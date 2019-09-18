<div class="portlet light" id="dates_flat">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-edit font-dark"></i>
            <span class="caption-subject font-dark bold uppercase">DATES</span>
        </div>
        <div class='btn-group pull-right'>
            <?php
            echo fbutton("Apply", "submit", "primary", null, "save_only", "dates_flat");
            echo fbuttonLink("/admin/date/create/add/" . $edition_detail['edition_id'] . "/edition", "Add Date", "info");
            ?>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        if (isset($date_list_by_group["Edition Dates"])) {
            $date_group_name = "Edition Dates";
            ?>
            <div class="form-group">
                <div class="row">
                    <div class='col-sm-3'>
                        <?php
                        $dateype_id = 1;
                        if (isset($date_list_by_group[$date_group_name][$dateype_id])) {
                            $date_detail = $date_list_by_group[$date_group_name][$dateype_id];
                            $date_id = $date_detail['date_id'];
                            $datetype_name = $date_detail['datetype_name'];
                            $field_id = $datetype_name . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $datetype_name . ']';
                            echo form_label($date_detail['datetype_display'], $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $datetype_name . ']',
                                'id' => $field_id,
                                'class' => 'form-control',
                                'value' => set_value($field_name, fdateShort($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group date date-picker">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                    <div class='col-sm-3'>
                        <?php
                        $dateype_id = 2;
                        if (isset($date_list_by_group[$date_group_name][$dateype_id])) {
                            $date_detail = $date_list_by_group[$date_group_name][$dateype_id];
                            $date_id = $date_detail['date_id'];
                            $datetype_name = $date_detail['datetype_name'];
                            $field_id = $datetype_name . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $datetype_name . ']';
                            echo form_label($date_detail['datetype_display'], $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $datetype_name . ']',
                                'id' => $field_id,
                                'class' => 'form-control',
                                'value' => set_value($field_name, fdateShort($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group date date-picker">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
        
        if (isset($date_list_by_group["Entry Online"])) {
            $date_group_name = "Entry Online";
            ?>
            <div class="form-group">
                <div class="row">
                    <div class='col-sm-4'>
                        <?php
                        $dateype_id = 3;
                        if (isset($date_list_by_group[$date_group_name][$dateype_id])) {
                            $date_detail = $date_list_by_group[$date_group_name][$dateype_id];
                            $date_id = $date_detail['date_id'];
                            $datetype_name = $date_detail['datetype_name'];
                            $field_id = $datetype_name . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $datetype_name . ']';
                            echo form_label($date_detail['datetype_display'], $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $datetype_name . ']',
                                'id' => $field_id,
                                'class' => 'form-control form_datetime',
                                'value' => set_value($field_name, fdateLong($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                    <div class='col-sm-4'>
                        <?php
                        $dateype_id = 4;
                        if (isset($date_list_by_group[$date_group_name][$dateype_id])) {
                            $date_detail = $date_list_by_group[$date_group_name][$dateype_id];
                            $date_id = $date_detail['date_id'];
                            $datetype_name = $date_detail['datetype_name'];
                            $field_id = $datetype_name . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $datetype_name . ']';
                            echo form_label($date_detail['datetype_display'], $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $datetype_name . ']',
                                'id' => $field_id,
                                'class' => 'form-control form_datetime',
                                'value' => set_value($field_name, fdateLong($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }

        
        // NEED TO REMOVE TIME FROM BELOW
        
        

        if ($date_list_by_group) {
            $groups_to_display = [
//                'Entry Online' => [3, 4],
                'Entry OTD' => [13, 14],
            ];
            foreach ($groups_to_display as $date_group_name => $date_group) {
                if (isset($date_list_by_group[$date_group_name])) {
                    ?>
                    <div class="form-group">
                        <div class="row">

                            <?php
                            foreach ($date_group as $dateype_id) {
                                echo "<div class='col-sm-4'>";
                                if (isset($date_list_by_group[$date_group_name][$dateype_id])) {
                                    $date_detail = $date_list_by_group[$date_group_name][$dateype_id];
                                    $date_id = $date_detail['date_id'];
                                    $datetype_name = $date_detail['datetype_name'];
                                    $field_id = $datetype_name . "_" . $date_id;
                                    $field_name = 'dates[' . $date_id . '][' . $datetype_name . ']';
                                    echo form_label($date_detail['datetype_display'], $field_id);
                                    $form_input_array = [
                                        'name' => 'dates[' . $date_id . '][' . $datetype_name . ']',
                                        'id' => $field_id,
                                        'class' => 'form-control',
                                    ];
                                    // switch for datetime pciker vs date picker
                                    $input_group = "";
                                    switch ($date_group_name) {
                                        case "Entry Online":
                                            $form_input_array['class'] = "form-control form_datetime";
                                            $form_input_array['value'] = set_value($field_name, fdateLong($date_detail['date_date']));
                                            break;
                                        case "Entry OTD":
                                            $form_input_array['class'] = "form-control timepicker timepicker-24";
                                            $date_value = ftimeSort($date_detail['date_date']);
                                            break;
                                        default:
                                            $input_group = "date date-picker";
                                            $form_input_array['class'] = "form-control";
                                            $form_input_array['value'] = set_value($field_name, fdateShort($date_detail['date_date']));
                                            break;
                                    }
                                    echo '<div class="input-group ' . $input_group . '">';
                                    echo form_input($form_input_array);
                                    echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                                } else {
                                    echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                                }
                                echo "</div>";
                            }
                            // enter IF statements here if there is exceptions for the group
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
        } else {
            echo "<p>No dates linked to this edition</p>";
        }
        ?>
    </div>
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

