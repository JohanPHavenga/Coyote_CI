<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase"><?= ucfirst($action);?> entry</span>
                </div>
            </div>
            <div class="portlet-body">
            <?php  
                echo form_open($form_url); 

                echo "<div class='form-group'>";
                echo form_label('Quote', 'quote_quote');
                echo form_input([
                        'name'          => 'quote_quote',
                        'id'            => 'quote_quote',
                        'value'         => set_value('quote_quote', @$quote_detail['quote_quote']),
                        'class'         => 'form-control',
                    ]);

                echo "</div>";

                echo "<div class='btn-group'>";
                echo fbutton();
                echo fbuttonLink($return_url,"Cancel");
                echo "</div>";

                echo form_close();
            ?>
            </div>
        </div>
    </div>
</div>