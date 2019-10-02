
<div class="portlet light" id="more_info">
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-edit font-dark"></i>
            <span class="caption-subject font-dark bold uppercase">More Information</span>
        </div>
        <div class='btn-group pull-right'>
            <?= fbutton("Apply", "submit", "primary", NULL, "save_only", "more_info"); ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="form-group">
            <div class="row">
                <div class='col-sm-3'>
                    <?php
                    echo form_label('T-shirt Cost', 'edition_tshirt_amount');
                    echo '<div class="input-group"><span class="input-group-addon"><i class="fa fa-money"></i></span>';
                    echo form_input([
                        'name' => 'edition_tshirt_amount',
                        'id' => 'edition_tshirt_amount',
                        'value' => set_value('edition_tshirt_amount', $edition_detail['edition_tshirt_amount']),
                        'class' => 'form-control input-xsmall',
                        'type' => 'number',
                        'step' => ".01",
                        'min' => '0',
                    ]);
                    echo "</div>";
                    ?>
                </div>
                <div class='col-sm-9'>
                    <?php
                    echo form_label('T-shirt text', 'edition_tshirt_text');
                    echo form_input([
                        'name' => 'edition_tshirt_text',
                        'id' => 'edition_tshirt_text',
                        'value' => set_value('edition_tshirt_text', $edition_detail['edition_tshirt_text'], false),
                        'class' => 'form-control',
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12'>
                <?php
                echo form_label('General Information', 'edition_general_detail');
                echo form_textarea([
                    'name' => 'edition_general_detail',
                    'id' => 'edition_description',
                    'value' => set_value('edition_general_detail', $edition_detail['edition_general_detail'], false),
                ]);
                ?>
            </div>
        </div>
    </div>
</div> 