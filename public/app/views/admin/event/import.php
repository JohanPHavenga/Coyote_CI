<div class="row">
    <div class="col-md-12">
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

                if (isset($sum_data)) {
                    @wts($sum_data);
                }
                ?>
        </div>
        <div class="m-heading-1 border-green m-bordered">
            <h3>File format guideline</h3>
            <p> Placeholder to explain how the file to upload should be formatted with a demo file. </p>
            <p> Download the
                <a class="btn red btn-outline" href="/admin/user/export" >sample file</a>
            </p>
        </div>
    </div>
</div>
