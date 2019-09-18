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
        // =====================================================================
        // EDITION DATES
        // =====================================================================
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
        // =====================================================================
        // ONLINE ENTRY
        // =====================================================================
        if (in_array(4, $entrytype_list)) {
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
        // =====================================================================
        // ON THE DAY ENTRY
        // =====================================================================
        if (in_array(1, $entrytype_list)) {
            $date_group_name = "Entry OTD";
            ?>
            <div class="form-group">
                <div class="row">
                    <div class='col-sm-3'>
                        <?php
                        $dateype_id = 13;
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
                                'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                'value' => set_value($field_name, ftimeSort($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group input-xsmall">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                    <div class='col-sm-3'>
                        <?php
                        $dateype_id = 14;
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
                                'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                'value' => set_value($field_name, ftimeSort($date_detail['date_date'])),
                            ];
                            echo '<div class="input-group input-xsmall">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                        } else {
                            echo "<div class='note note-danger' role='alert'><b>DATE</b> NOT LOADED</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
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

