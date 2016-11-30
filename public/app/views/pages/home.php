<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <!-- BEGIN: PAGE CONTENT -->
    <!-- BEGIN: LAYOUT/SLIDERS/REVO-SLIDER-4 -->
    <section class="c-layout-revo-slider c-layout-revo-slider-4" dir="ltr">
        <div class="tp-banner-container c-theme">
            <div class="tp-banner rev_slider" data-version="5.0">
                <ul>
                    <!--BEGIN: SLIDE #1 -->
                    <li data-transition="fade" data-slotamount="1" data-masterspeed="1000">
                        <img alt="" src="<?= base_url('img/bg-43.jpg');?>" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                        <div class="tp-caption customin customout" data-x="center" data-y="center" data-hoffset="" data-voffset="-50" data-speed="500" data-start="1000" data-transform_idle="o:1;" data-transform_in="rX:0.5;scaleX:0.75;scaleY:0.75;o:0;s:500;e:Back.easeInOut;"
                        data-transform_out="rX:0.5;scaleX:0.75;scaleY:0.75;o:0;s:500;e:Back.easeInOut;" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="600">
                            <h3 class="c-main-title-circle c-font-48 c-font-bold c-font-center c-font-uppercase c-font-white c-block"> ROADRUNNING.CO.ZA
                                <br> COMING SOON</span> </h3>
                        </div>
                        <div class="tp-caption lft" data-x="center" data-y="center" data-voffset="110" data-speed="900" data-start="2000" data-transform_idle="o:1;" data-transform_in="x:100;y:100;rX:120;scaleX:0.75;scaleY:0.75;o:0;s:500;e:Back.easeInOut;"
                        data-transform_out="x:100;y:100;rX:120;scaleX:0.75;scaleY:0.75;o:0;s:500;e:Back.easeInOut;">
                            <!-- <a href="#" class="c-action-btn btn btn-lg c-btn-square c-theme-btn c-btn-bold c-btn-uppercase">Learn More</a> -->
                        </div>
                    </li>
                    <!--END -->
                    <!--BEGIN: SLIDE #2 -->
                    <li data-transition="fade" data-slotamount="1" data-masterspeed="1000">
                        <img alt="" src="<?= base_url('img/bg-20.jpg'); ?>" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                        <div class="tp-caption customin customout" data-x="center" data-y="center" data-hoffset="" data-voffset="-50" data-speed="500" data-start="1000" data-transform_idle="o:1;" data-transform_in="rX:0.5;scaleX:0.75;scaleY:0.75;o:0;s:500;e:Back.easeInOut;"
                        data-transform_out="rX:0.5;scaleX:0.75;scaleY:0.75;o:0;s:600;e:Back.easeInOut;" data-splitin="none" data-splitout="none" data-elementdelay="0.1" data-endelementdelay="0.1" data-endspeed="600">
                            <h3 class="c-main-title-circle c-font-48 c-font-bold c-font-center c-font-uppercase c-font-white c-block"> LISTING ALL RUNNING
                                <br>EVENTS IN CAPE TOWN AND SURROUNDS </h3>
                        </div>
                        <div class="tp-caption lft" data-x="center" data-y="center" data-voffset="110" data-speed="900" data-start="2000" data-transform_idle="o:1;" data-transform_in="x:100;y:100;rX:120;scaleX:0.75;scaleY:0.75;o:0;s:900;e:Back.easeInOut;"
                        data-transform_out="x:100;y:100;rX:120;scaleX:0.75;scaleY:0.75;o:0;s:900;e:Back.easeInOut;">
                            <!-- <a href="#" class="c-action-btn btn btn-lg c-btn-square c-theme-btn c-btn-bold c-btn-uppercase">Learn More</a> -->
                        </div>
                    </li>
                    <!--END -->
                </ul>
            </div>
        </div>
    </section>
    <!-- END: LAYOUT/SLIDERS/REVO-SLIDER-4 -->



    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <div class="row">
                <?php
                if ($race_summary) {
                    foreach ($race_summary as $month=>$edition_list) {
                        ?>
                        <div class="c-content-title-1">
                            <h3 class="c-center c-font-dark c-font-uppercase">Races in <?=$month;?></h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Place</th>
                                        <th>Race Distances</th>
                                        <th>Time of Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($edition_list as $edition_id=>$edition) {
                                            echo "<tr>";
                                                echo "<th scope='row' style='width: 10%'>".$edition['edition_date']."</th>";
                                                echo "<td style='width: 40%'>".$edition['edition_name']."</td>";
                                                echo "<td style='width: 25%'>".$edition['town_name']."</td>";
                                                echo "<td style='width: 15%'>".$edition['race_distance']."</td>";
                                                echo "<td style='width: 10%'>".$edition['race_time']."</td>";
                                            echo "</tr>";
                                        }
                                     ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="c-content-title-1">
                        <h3 class="c-center c-font-dark c-font-uppercase">Event Information</h3>
                        <div class="c-line-center c-theme-bg"></div>
                    </div>
                    <p>There is currently no event data to display. Please chack back again shortly.</p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>


    <!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
    <div class="c-content-box c-size-md c-bg-grey-1">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="c-content-feature-1 wow animate fadeInUp">
                        <div class="c-content-line-icon c-theme c-icon-29"></div>
                        <h3 class="c-font-uppercase c-font-bold">Listing Events</h3>
                        <p class="c-font-thin">We will be listing all road running events in and around Cape Town in a modern, easy to compare fashsion.</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="c-content-feature-1 wow animate fadeInUp" data-wow-delay="0.2s">
                        <div class="c-content-line-icon c-theme c-icon-screen-chart"></div>
                        <h3 class="c-font-uppercase c-font-bold">Consolidating Results</h3>
                        <p class="c-font-thin">The site will enable you to create a profile and pull in results from running events you enter to keep track and show your progres.</p>
                    </div>
                </div>
                <div class="col-sm-4 c-card">
                    <div class="c-content-feature-1 wow animate fadeInUp" data-wow-delay="0.4s">
                        <div class="c-content-line-icon c-theme c-icon-bulb"></div>
                        <h3 class="c-font-uppercase c-font-bold">Promoting Clubs</h3>
                        <p class="c-font-thin">We want to promote road running clubs through this site by giving them a platform to list and promote their clubs and races.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- BEGIN: CONTENT/CONTACT/FEEDBACK-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">
            <div class="c-content-feedback-1 c-option-1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="c-container c-bg-green c-bg-img-bottom-right" style="background-image:url(img/feedback_box_1.png)">
                            <div class="c-content-title-1 c-inverse">
                                <h3 class="c-font-uppercase c-font-bold">About us</h3>
                                <div class="c-line-left"></div>
                                <p class="c-font-lowercase">We are amateur runners in it for the love of the road, the simplicity and beauty of it.<br>
                                    This project started out due to a lack of a comprehensive, modern listing site for running events in the Cape Town area.
                                    Our goal is to fill that void and hope to make this a national project one day. The mission is to become the number one road running events listing site in the country.</p>
                            </div>
                        </div>
                        <div class="c-container c-bg-grey-1 c-bg-img-bottom-right" style="background-image:url(img/feedback_box_2.png)">
                            <div class="c-content-title-1">
                                <h3 class="c-font-uppercase c-font-bold">When will the site go live?</h3>
                                <div class="c-line-left"></div>
                                <p>The goal is to have the site ready for an early 2017 launch. Watch this space!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" id="contact">
                        <div class="c-contact">
                            <div class="c-content-title-1">
                                <h3 class="c-font-uppercase c-font-bold">Keep in touch</h3>
                                <div class="c-line-left"></div>
                                <p class="c-font-lowercase">Our proverbial door is always open to comments and ideas. Please send us a message using the form below.</p>
                            </div>
                            <?php
                            if ($_POST) {
                                if(!@$email_send) {
                                    echo '<div class="alert alert-danger" role="alert">';
                                    echo validation_errors();
                                    echo '</div>';
                                } else {
                                    echo '<div class="alert alert-success" role="alert">';
                                    echo "Thank you for contacting us. Your message has successfully been send.";
                                    echo '</div>';
                                }
                            }
                            ?>
                            <?php echo form_open('pages/mailer#contact'); ?>
                                <div class="form-group">
                                    <?php echo form_input(array('id'=>'dname', 'name'=>'dname', 'value'=>@$form_data['dname'], 'placeholder'=>'Your Name', 'class'=>'form-control c-square c-theme input-lg')); ?></div>
                                <div class="form-group">
                                    <?php echo form_input(array('id'=>'demail', 'name'=>'demail', 'value'=>@$form_data['demail'], 'placeholder'=>'Your Email', 'class'=>'form-control c-square c-theme input-lg')); ?></div>
                                <div class="form-group">
                                    <?php echo form_input(array('id'=>'dphone', 'name'=>'dphone', 'value'=>@$form_data['dphone'], 'placeholder'=>'Contact Phone', 'class'=>'form-control c-square c-theme input-lg')); ?></div>
                                <div class="form-group">
                                    <?php echo form_textarea(array('id'=>'dmsg', 'name'=>'dmsg', 'value'=>@$form_data['dmsg'], 'placeholder'=>'Write comment here ...', 'rows'=>'8', 'class'=>'form-control c-square c-theme input-lg')); ?></div>
                                    <?php echo form_button(array('type'=>'submit', 'class'=>'btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-square','content'=>'Submit')); ?>
                            <?php echo form_close(); ?>

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
