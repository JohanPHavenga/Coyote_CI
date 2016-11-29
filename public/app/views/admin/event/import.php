<div class="row">
    <div class="col-md-12">

    <?php
    if (!isset($import_event_data)) {
        ?>
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Import Event Data</span>
                </div>
            </div>
            <?php
                if (@$error) {
                    echo "<div class='note note-danger' role='alert'>$error</div>";
                }
                echo form_open_multipart($form_url);

                echo "<div class='form-group'>";
                echo form_label('File to upload', 'eventfile');
                echo form_upload([
                        'name'          => 'eventfile',
                        'id'            => 'eventfile',
                        'class'         => 'form-control',
                        'required'      => '',
                    ]);

                echo "</div>";

                echo "<div class='btn-group'>";
                echo fbutton($text="Upload",$type="submit",$status="primary");
                echo "</div>";

                echo form_close();
                ?>
        </div>
        <div class="m-heading-1 border-green m-bordered">
            <h3>Import file format guideline</h3>
            <p> Below click to either download the generic sample file or choose to pull data from a spesific month to manupulate.</p>
            <p> Download the
                <a class="btn red btn-outline" href="/admin/event/run_export" >generic sample file</a> or
                <a class="btn green btn-outline" href="/admin/event/export" >choose timeperiod</a>
            </p>
        </div>

        <?php
        // if import data was successfull
            } else {

                foreach ($import_event_data as $event_action=>$event_list) {
                    $k=0;
                    ?>
                    <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><?=$event_action;?></span>
                        </div>
                    </div>
                    <?php
                    $this->table->set_template(ftable());
                    foreach ($event_list as $event_id=>$event) {
                        $data[$k]="<b>".$event['event_name']."</b>";
                        if (empty($event['town_id'])) { $data[$k].= " - <span style='color: red; font-weight: bold;'>Town not found!</span>"; }

                        foreach ($event['edition_data'] as $edition_action=>$edition_list) {
                            $data[$k].="<br>&nbsp;Edition: [<b>".$edition_action."</b>]";
                            foreach ($edition_list as $edition_id=>$edition) {
                                $data[$k].="<br>&nbsp;&nbsp;".$edition['edition_name']." - ".$edition['edition_date']."";

                                foreach ($edition['race_data'] as $race_action=>$race_list) {
                                    $data[$k].="<br>&nbsp;&nbsp;&nbsp;Race: [<b>".$race_action."</b>]";
                                    foreach ($race_list as $race_id=>$race) {
                                        $data[$k].="<br>&nbsp;&nbsp;&nbsp;&nbsp;".$race['race_name']." - ".$race['race_distance']."";
                                    }
                                }
                            }
                        }

                        $this->table->add_row($data);
                        unset($data);
                        $k++;
                    }
                    echo $this->table->generate();
                    ?>
                    <div class='btn-group'>
                        <a href="./" class="btn btn-danger" role="button">Cancel</a>
                        <a href="../run_import" class="btn btn-success" role="button">Confirm</a>
                    </div>

                    </div>
                    <?php
                }
                // @wts($import_event_data);
            }
        ?>

    </div>
</div>
