<?php
echo form_open_multipart($form_url);
?>
<div class="row">
    <div class="col-md-6">
        <?php $this->load->view('/admin/edition/general'); ?>
    </div>
    <div class="col-md-6" id="races">
        <?php
        if ($action == "edit") {
            $this->load->view('/admin/edition/races');
            $this->load->view('/admin/edition/dates');
        } else {
            $this->load->view('/admin/edition/more_information');
        }
        ?>
    </div> 
</div>

<?php
if ($action == "edit") {
    ?>
    <div class="row">
        <div class="col-md-6">
            <?php $this->load->view('/admin/edition/more_information'); ?>
        </div>
        <div class="col-md-6">    
            <?php $this->load->view('/admin/edition/urls'); ?>
            <?php $this->load->view('/admin/edition/files'); ?>
            <?php $this->load->view('/admin/edition/created_updated'); ?>
        </div> 
    </div> 
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
    </div> 
</div> 

<?php
echo form_close();
//wts($entrytype_list);
//wts($date_list_by_group);
//wts($status_list);