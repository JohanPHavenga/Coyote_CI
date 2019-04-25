<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>

    <!-- BEGIN: CONTENT/CONTACT/FEEDBACK-1 -->
    <div class="c-content-box c-size-sm c-bg-white">
        <div class="container">
            <div class="c-content-feedback-1 c-option-1">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        // flash data here
                        // 
                        if ($_POST) {
                            if (validation_errors()) {
                                echo '<div class="alert alert-danger" role="alert">';
                                echo validation_errors();
                                echo '</div>';
                                $show_text=false;
                            } else {
                                echo '<div class="alert alert-success" role="alert">';
                                echo "Thank you for contacting us. <b>Your message has been sent successfully.</b><br>We will get back to you as soon as we can.";
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row"> 

                    <div class="col-md-7" id="contact">
                        <div class="c-content-media-1 c-bordered">

                            <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">Subscribe Now</div>
                            <a href="#" class="c-title c-font-uppercase c-theme-on-hover c-font-bold">Newsletter Subscription</a>
                            <p class="c-font-lowercase">Please complete the form below to subscribe to our monthly newsletter</p>

                            <!--                            <div class="c-content-title-3 c-theme-border c-font-bold c-font-uppercase">
                                                            <h1>Newsletter Subscription</h1>
                                                            <p class="c-font-lowercase">Please complete the form below to subscribe to our monthly newsletter</p>
                                                        </div>-->

                            <!--                            <div class="c-content-title-1">
                                                            <h3 class="c-font-uppercase c-font-bold">Keep in touch</h3>
                                                            <div class="c-line-left"></div>
                                                            <p class="c-font-lowercase">Please send us a message using the form below.</p>
                                                        </div>-->
                            <?php
//                            if ($_POST) {
//                                if (!@$email_send) {
//                                    echo '<div class="alert alert-danger" role="alert">';
//                                    echo validation_errors();
//                                    echo '</div>';
//                                } else {
//                                    echo '<div class="alert alert-success" role="alert">';
//                                    echo "Thank you for contacting us. Your message has successfully been send.<br>We will get back to you as soon as we can.";
//                                    echo '</div>';
//                                }
//                            }
                            

                            echo form_open('newsletter');
                            ?>
                            <div class="form-group">
                                <label for="dname">Name *</label>
                                <?php
                                echo form_input(
                                        [
                                            'id' => 'dname',
                                            'name' => 'dname',
                                            'value' => @$form_data['dname'],
                                            'placeholder' => 'John',
                                            'class' => 'form-control c-square c-theme input-lg'
                                        ]
                                );
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="dname">Last name *</label>
                                <?php
                                echo form_input(
                                        [
                                            'id' => 'dsurname',
                                            'name' => 'dsurname',
                                            'value' => @$form_data['dsurname'],
                                            'placeholder' => 'Smith',
                                            'class' => 'form-control c-square c-theme input-lg'
                                        ]
                                );
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="demail">Email address *</label>
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
                            <div class="form-group g-recaptcha" data-sitekey="6LcxdoYUAAAAAADszn1zvLq3C9UFfwnafqzMWYoV"></div>
                            <?php
                            echo form_button(
                                    [
                                        'type' => 'submit',
                                        'class' => 'btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round',
                                        'content' => 'Subscribe'
                                    ]
                            );
                            echo form_hidden('dto', @$form_data['dto']);
                            echo form_hidden('dreturn_url', @$form_data['dreturn_url']);
                            echo form_close();
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="c-content-media-1 c-bordered">
                            <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">Why Subscribe</div>
                            <a href="#" class="c-title c-font-uppercase c-theme-on-hover c-font-bold">What will I get?</a>
                            <p>If you subscribe to our newsletter you will receive a <b>monthly</b> update of results loaded for the events that was, 
                                plus a list of upcoming events over the next two months.</p>
                            <p>It will remain a <b>work in progress</b> so please, if there is any suggestions out there to make it better, 
                                hit the reply button and give me a piece of your mind.                            
                            </p>
                            <div class="btn-group">
                                <a class="btn c-theme-btn c-btn-uppercase btn-sm c-btn-bold c-margin-t-20" href="/contact">
                                    <i class="icon-bubble"></i>
                                    Given a piece of your mind</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/CONTACT/FEEDBACK-1 -->


    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->

<?php
//wts($form_data); 
?>
