<div class="c-content-box c-size-sm <?= $box_color; ?>">
    <div class="container">
        <div class="row">
            <?php            
                if (strlen($event_detail['edition_description'])>10) {
            ?>
            <div class="col-md-6">
                <div class="c-content-title-1 ">
                    <h3 class="c-font-uppercase c-font-bold">
                        General Information
                    </h3>
                </div>
                <?php
                echo $event_detail['edition_description'];
                ?>
            </div>
            <?php
                }
            ?>
            <!--
            <div class="col-md-6" id="contact">
                <div class="c-contact">
                    <div class="c-content-title-1">
                        <h3 class="c-font-uppercase c-font-bold">Contact Event Organiser</h3>
                    </div>
                    <?php
                    if ($_POST) {
                        if (!@$email_send) {
                            echo '<div class="alert alert-danger" role="alert">';
                            echo validation_errors();
                            echo '</div>';
                        } else {
                            echo '<div class="alert alert-success" role="alert">';
                            echo "Thank you for contacting us. Your message has successfully been send.<br>We will get back to you as soon as we can.";
                            echo '</div>';
                        }
                    }
                    echo form_open('contact'); 
                    ?>
                    <div class="form-group">
                        <label for="dname">Your name *</label>
                        <?php 
                        echo form_input(
                                [
                                    'id' => 'dname', 
                                    'name' => 'dname', 
                                    'value' => @$form_data['dname'], 
                                    'placeholder' => 'John Smith', 
                                    'class' => 'form-control c-square c-theme input-lg'
                                ]
                        ); 
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="demail">Your email address *</label>
                        <?php 
                        echo form_input(
                                [
                                    'id' => 'demail', 
                                    'name' => 'demail', 
                                    'type' => 'email', 
                                    'value' => @$form_data['demail'], 
                                    'placeholder' => 'name.surname@example.com', 
                                    'class' => 'form-control c-square c-theme input-lg'
                                ]
                        ); 
                        ?>
                    </div>
                    <div class="form-group">                                    
                        <label for="dmsg">Comment *</label>
                        <?php 
                        echo form_textarea(
                                [
                                    'id' => 'dmsg', 
                                    'name' => 'dmsg', 
                                    'value' => @$form_data['dmsg'], 
                                    'placeholder' => 'Write comment here ...', 
                                    'rows' => '5', 
                                    'class' => 'form-control c-square c-theme input-lg',
                                ]
                        ); ?>
                    </div>
                        <?php 
                        echo form_button(
                                [
                                    'type' => 'submit', 
                                    'class' => 'btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round', 
                                    'content' => 'Submit'
                                ]
                        ); 
                        echo form_hidden('devent',$event_detail['edition_name']); 
                        echo form_hidden('dto',$event_detail['user_email']); 
                        echo form_hidden('dreturn_url',$event_detail['summary']['edition_url']); 
                        echo form_close(); 
                        ?>
                </div>
            </div>
            -->
        </div>
    </div>
</div>