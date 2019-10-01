<div class="portlet light" id="dates_entry_flat">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-edit font-dark"></i>
            <span class="caption-subject font-dark bold uppercase">ENTRY DETAILS</span>
        </div>
        <div class='btn-group pull-right'>
            <?php
            echo fbutton("Apply", "submit", "primary", null, "save_only", "dates_entry_flat");
//            echo fbuttonLink("/admin/date/create/add/" . $edition_detail['edition_id'] . "/edition", "Add Date", "info");
            ?>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        // =====================================================================
        // EDITION DATES
        // =====================================================================
        $dateype_id = 1;
        if (isset($date_list_by_type[$dateype_id])) {
            $date_detail = $date_list_by_type[$dateype_id][0];
            $date_id = $date_detail['date_id'];
            ?>
            <div class="form-group">
                <div class="row">
                    <div class='col-sm-3'>
                        <?php
                        $field = "date_start";
                        $display = "Start";
                        $field_id = $field . "_" . $date_id;
                        $field_name = 'dates[' . $date_id . '][' . $field . ']';
                        echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                        $form_input_array = [
                            'name' => 'dates[' . $date_id . '][' . $field . ']',
                            'id' => $field_id,
                            'class' => 'form-control',
                            'value' => set_value($field_name, fdateShort($date_detail[$field])),
                        ];
                        echo '<div class="input-group date date-picker">';
                        echo form_input($form_input_array);
                        echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        ?>
                    </div>
                    <div class='col-sm-3'>
                        <?php
                        $field = "date_end";
                        $display = "End";
                        $error_value = strtotime($date_detail['date_start']);
                        $field_id = $field . "_" . $date_id;
                        $field_name = 'dates[' . $date_id . '][' . $field . ']';
                        echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                        $form_input_array = [
                            'name' => 'dates[' . $date_id . '][' . $field . ']',
                            'id' => $field_id,
                            'class' => 'form-control',
                            'value' => set_value($field_name, fdateShort($date_detail[$field])),
                        ];
                        if (strtotime($date_detail[$field]) < $error_value) {
                            $form_input_array['class'] = $form_input_array['class'] . " danger";
                        }
                        echo '<div class="input-group date date-picker">';
                        echo form_input($form_input_array);
                        echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                        ?>
                    </div>
                    <?php
                    // =====================================================================
                    // ON THE DAY ENTRY
                    // =====================================================================
                    if (in_array(1, $entrytype_list)) {
                        $dateype_id = 6;
                        if (isset($date_list_by_type[$dateype_id])) {
                            $date_detail = $date_list_by_type[$dateype_id][0];
                            $date_id = $date_detail['date_id'];
                            ?>
                            <div class='col-sm-1'></div>
                            <div class='col-sm-2'>
                                <?php
                                $field = "date_start";
                                $display = "Open";
                                $error_value = $edition_detail['edition_date'];
                                $field_id = $field . "_" . $date_id;
                                $field_name = 'dates[' . $date_id . '][' . $field . ']';
                                echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                                $form_input_array = [
                                    'name' => 'dates[' . $date_id . '][' . $field . ']',
                                    'id' => $field_id,
                                    'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                    'value' => set_value($field_name, ftimeSort($date_detail[$field])),
                                ];
                                if ($date_detail[$field] == $error_value) {
                                    $form_input_array['class'] = $form_input_array['class'] . " danger";
                                }
                                echo '<div class="input-group input-xsmall">';
                                echo form_input($form_input_array);
                                echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                                ?>
                            </div>
                            <div class='col-sm-2'>
                                <?php
                                $field = "date_end";
                                $display = "Close";
                                $error_value = strtotime($date_detail['date_start']);
                                $field_id = $field . "_" . $date_id;
                                $field_name = 'dates[' . $date_id . '][' . $field . ']';
                                echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                                $form_input_array = [
                                    'name' => 'dates[' . $date_id . '][' . $field . ']',
                                    'id' => $field_id,
                                    'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                    'value' => set_value($field_name, ftimeSort($date_detail[$field])),
                                ];
                                if (strtotime($date_detail[$field]) <= $error_value) {
                                    $form_input_array['class'] = $form_input_array['class'] . " danger";
                                }
                                echo '<div class="input-group input-xsmall">';
                                echo form_input($form_input_array);
                                echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <?php
        } else {
            echo "<div class='note note-danger' role='alert'><b>EDITION DATES</b> NOT LOADED</div>";
        }
        // =====================================================================
        // ONLINE ENTRY
        // =====================================================================
        if (in_array(4, $entrytype_list)) {
            $dateype_id = 3;
            if (isset($date_list_by_type[$dateype_id])) {
                $date_detail = $date_list_by_type[$dateype_id][0];
                $date_id = $date_detail['date_id'];
                ?>
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-4'>
                            <?php
                            $field = "date_start";
                            $display = "Open";
                            $error_value = $edition_detail['edition_date'];
                            $field_id = $field . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $field . ']';
                            echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $field . ']',
                                'id' => $field_id,
                                'class' => 'form-control form_datetime',
                                'value' => set_value($field_name, fdateLong($date_detail[$field], false)),
                            ];
                            if ($date_detail[$field] == $error_value) {
                                $form_input_array['class'] = $form_input_array['class'] . " danger";
                            }
                            echo '<div class="input-group">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                            ?>
                        </div>
                        <div class='col-sm-4'>
                            <?php
                            $field = "date_end";
                            $display = "Close";
                            $error_value = strtotime($date_detail['date_start']);
                            $field_id = $field . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $field . ']';
                            echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $field . ']',
                                'id' => $field_id,
                                'class' => 'form-control form_datetime',
                                'value' => set_value($field_name, fdateLong($date_detail[$field], false)),
                            ];
                            if (strtotime($date_detail[$field]) <= $error_value) {
                                $form_input_array['class'] = $form_input_array['class'] . " danger";
                            }
                            echo '<div class="input-group">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<div class='note note-danger' role='alert'><b>ONLINE ENTRY DATES</b> NOT LOADED</div>";
            }
        }
        // =====================================================================
        // MANUAL ENTRY
        // =====================================================================
        if (in_array(2, $entrytype_list)) {
            $dateype_id = 5;
            if (isset($date_list_by_type[$dateype_id])) {
                $date_detail = $date_list_by_type[$dateype_id][0];
                $date_id = $date_detail['date_id'];
                ?>
                <div class="form-group">
                    <div class="row">
                        <!--<div class='col-sm-4'>-->
                            <?php
//                            $field = "date_start";
//                            $display = "Open";
//                            $error_value = $edition_detail['edition_date'];
//                            $field_id = $field . "_" . $date_id;
//                            $field_name = 'dates[' . $date_id . '][' . $field . ']';
//                            echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
//                            $form_input_array = [
//                                'name' => 'dates[' . $date_id . '][' . $field . ']',
//                                'id' => $field_id,
//                                'class' => 'form-control form_datetime',
//                                'value' => set_value($field_name, fdateLong($date_detail[$field], false)),
//                            ];
//                            if ($date_detail[$field] == $error_value) {
//                                $form_input_array['class'] = $form_input_array['class'] . " danger";
//                            }
//                            echo '<div class="input-group">';
//                            echo form_input($form_input_array);
//                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                            ?>
                        <!--</div>-->
                        <div class='col-sm-4'>
                            <?php
                            $field = "date_end";
                            $display = "Close";
                            $error_value = $edition_detail['edition_date'];
                            $field_id = $field . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $field . ']';
                            echo form_label($date_detail['datetype_display'] . " " . $display, $field_id);
                            $form_input_array = [
                                'name' => 'dates[' . $date_id . '][' . $field . ']',
                                'id' => $field_id,
                                'class' => 'form-control form_datetime',
                                'value' => set_value($field_name, fdateLong($date_detail[$field], false)),
                            ];
                            if (strtotime($date_detail[$field]) <= $error_value) {
                                $form_input_array['class'] = $form_input_array['class'] . " danger";
                            }
                            echo '<div class="input-group">';
                            echo form_input($form_input_array);
                            echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                            ?>
                        </div>
                        <div class='col-sm-5'>
                            <?php
                            // venue_id on open date
                            $field = "venue_id";
                            $field_id = $field . "_" . $date_id;
                            $field_name = 'dates[' . $date_id . '][' . $field . ']';
                            echo form_label("Venue", $field_id);
                            echo form_dropdown(
                                    'dates[' . $date_id . '][' . $field . ']',
                                    $venue_dropdown,
                                    set_value($field_name, $date_detail['venue_id']),
                                    ["id" => $field_id, "class" => "form-control"]
                            );
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                echo "<div class='note note-danger' role='alert'><b>MANUAL ENTRY DATES</b> NOT LOADED</div>";
            }
        }

        // =====================================================================
        // PRE ENTRIES
        // =====================================================================
        if (in_array(3, $entrytype_list)) {
            $dateype_id = 4;
            if (isset($date_list_by_type[$dateype_id])) {
                ?>
                <div class="form-group">
                    <div class="row">
                        <div class='col-sm-4'>
                            <?= form_label("Pre-Entries"); ?>
                        </div>
                    </div>
                    <?php
                    foreach ($date_list_by_type[$dateype_id] as $date_detail) {
                        $date_id = $date_detail['date_id'];
                        ?>

                        <div class="row">
                            <div class='col-sm-4'>
                                <?php
                                $field = "date_start";
                                $display = "Open";
                                $error_value = $edition_detail['edition_date'];
                                $field_id = $field . "_" . $date_id;
                                $field_name = 'dates[' . $date_id . '][' . $field . ']';
                                echo form_label($display, $field_id);
                                $form_input_array = [
                                    'name' => 'dates[' . $date_id . '][' . $field . ']',
                                    'id' => $field_id,
                                    'class' => 'form-control form_datetime',
                                    'value' => set_value($field_name, fdateLong($date_detail[$field], false)),
                                ];
                                if ($date_detail[$field] == $error_value) {
                                    $form_input_array['class'] = $form_input_array['class'] . " danger";
                                }
                                echo '<div class="input-group">';
                                echo form_input($form_input_array);
                                echo '<span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span></div>';
                                ?>
                            </div>
                            <div class='col-sm-2'>
                                <?php
                                $field = "date_end";
                                $display = "Close";
                                $error_value = strtotime($date_detail["date_start"]);
                                $field_id = $field . "_" . $date_id;
                                $field_name = 'dates[' . $date_id . '][' . $field . ']';
                                echo form_label($display, $field_id);
                                $form_input_array = [
                                    'name' => 'dates[' . $date_id . '][' . $field . ']',
                                    'id' => $field_id,
                                    'class' => 'form-control timepicker timepicker-24 input-xsmall',
                                    'value' => set_value($field_name, ftimeSort($date_detail[$field])),
                                ];
                                if (strtotime($date_detail[$field]) <= $error_value) {
                                    $form_input_array['class'] = $form_input_array['class'] . " danger";
                                }
                                echo '<div class="input-group input-xsmall">';
                                echo form_input($form_input_array);
                                echo '<span class="input-group-btn"><button class="btn default date-set" type="button"><i class="fa fa-clock-o"></i></button></div>';
                                ?>
                            </div>
                            <div class='col-sm-5'>
                                <?php
                                // venue_id on open date
                                $field = "venue_id";
                                $field_id = $field . "_" . $date_id;
                                $field_name = 'dates[' . $date_id . '][' . $field . ']';
                                echo form_label("Venue", $field_id);
                                echo form_dropdown(
                                        'dates[' . $date_id . '][' . $field . ']',
                                        $venue_dropdown,
                                        set_value($field_name, $date_detail['venue_id']),
                                        ["id" => $field_id, "class" => "form-control"]
                                );
                                ?>
                            </div>
                            <div class='btn-group pull-right' style="position: relative; top:28px;">
                                <?php
                                echo fbutton("<i class='fa fa-copy white'></i>", "submit", "primary", "sm", "copy_date", "/admin/date/copy/" . $date_id . "/dates_entry_flat");
//                                echo fbuttonLink("/admin/date/copy/" . $date_id . "/dates_entry_flat", "<i class='fa fa-copy white'></i>", "info", "sm");
                                $confirm = "data-toggle='confirmation' data-original-title='Are you sure ?' data-placement='top'";
                                echo fbuttonLink("/admin/date/delete/" . $date_id . "/dates_entry_flat", "<i class='fa fa-times-circle white'></i>", "danger", "sm", $confirm);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            } else {
                echo "<div class='note note-danger' role='alert'><b>PRE ENTRY DATES</b> NOT LOADED</div>";
            }
        }
        ?>
        <div class="form-group">
            <div class="row">
                <div class='col-sm-12'>
                    <?php
                    echo form_label('Entry Details', 'edition_entry_detail');
                    echo form_textarea([
                        'name' => 'edition_entry_detail',
                        'id' => 'edition_entry_detail',
                        'value' => set_value('edition_entry_detail', @$edition_detail['edition_entry_detail'], false),
                    ]);
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>