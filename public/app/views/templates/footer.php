    <!-- BEGIN: LAYOUT/FOOTERS/FOOTER -->
    <a name="footer"></a>
    <footer class="c-layout-footer c-layout-footer-7">
        <div class="container">
            <div class="c-prefooter">
                <div class="c-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">Menu</h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <ul class="c-links c-theme-ul">
                                <li>
                                    <a href="/">Home</a>
                                </li>
                                <li>
                                    <a href="/event/calendar">List All Events</a>
                                </li>
                                <li>
                                    <a href="/#contact">Contact Us</a>
                                </li>
                            </ul>
                            <ul class="c-links c-theme-ul">

                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">Races by area</h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <ul class="c-links c-theme-ul">
                                <?php
                                    foreach ($area_list as $area_id=>$area) {
                                        echo "<li><a href='".base_url().str_replace(" ","",$area['name'])."'>".$area['name']."</a></li>";
                                    }
                                 ?>
                            </ul>

                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">About
                                    <span class="c-theme-font">RoadRunning.co.za</span>
                                </h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <p class="c-text c-font-16 c-font-regular">
                                We are amateur runners in it for the love of the road, the simplicity and beauty of it.
                                This website intends to be a comprehensive listing site for road running events in and around the Cape Town area.
                            </p>
                        </div>
                        <!-- <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">Contact Us</h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <p class="c-address c-font-16"> 25, Lorem Lis Street, Orange
                                <br/> California, US
                                <br/> Phone: 800 123 3456
                                <br/> Fax: 800 123 3456
                                <br/> Email:
                                <a href="mailto:info@jango.com">
                                    <span class="c-theme-color">info@jango.com</span>
                                </a>
                                <br/> Skype:
                                <a href="#">
                                    <span class="c-theme-color">jango</span>
                                </a>
                            </p>
                        </div> -->
                    </div>
                </div>
                <!-- <div class="c-line"></div>
                <div class="c-foot">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">About
                                    <span class="c-theme-font">RoadRunning.co.za</span>
                                </h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <p class="c-text c-font-16 c-font-regular">
                                We are amateur runners in it for the love of the road, the simplicity and beauty of it.
                                This website intends to be a comprehensive listing site for road running events in and around the Cape Town area.
                            </p>
                        </div>
                        <div class="col-md-5">
                            <div class="c-content-title-1 c-title-md">
                                <h3 class="c-title c-font-uppercase c-font-bold">Subscribe to Newsletter</h3>
                                <div class="c-line-left hide"></div>
                            </div>
                            <div class="c-line-left hide"></div>
                            <form action="#">
                                <div class="input-group input-group-lg c-square">
                                    <input type="text" class="c-input form-control c-square c-theme" placeholder="Your Email Here" />
                                    <span class="input-group-btn">
                                        <button class="btn c-theme-btn c-theme-border c-btn-square c-btn-uppercase c-font-16" type="button">Subscribe</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="c-postfooter c-bg-dark-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 c-col">
                        <p class="c-copyright c-font-grey"><?= date('Y');?> &copy; RoadRunning.co.za
                            <span class="c-font-grey-3">All Rights Reserved.</span>
                            <a href="<?=$admin_login;?>">Admin&nbsp;Login</a>
                        </p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                    <ul class="c-socials">
                        <li><a href="https://twitter.com/roadrunningcoza" target="_blank" title="Follow us on Twitter"><i class="icon-social-twitter"></i></a></li>
                        <li><a href="https://www.facebook.com/roadrunningcoza" target="_blank" title="Like us on Facebook"><i class="icon-social-facebook"></i></a></li>
                      <!--<li><a href="#"><i class="icon-social-youtube"></i></a></li>-->
                      <!--<li><a href="#"><i class="icon-social-dribbble"></i></a></li>-->
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </footer>


    <!-- BEGIN: LAYOUT/FOOTERS/GO2TOP -->
    <div class="c-layout-go2top">
        <i class="icon-arrow-up"></i>
    </div>
    <!-- END: LAYOUT/FOOTERS/GO2TOP -->
    <!-- BEGIN: LAYOUT/BASE/BOTTOM -->
    <!-- BEGIN: CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="<?= base_url('plugins/excanvas.min.js'); ?>"></script>
    <![endif]-->
    <script src="<?= base_url('plugins/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/jquery-migrate.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/jquery.easing.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/reveal-animate/wow.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('scripts/reveal-animate/reveal-animate.js'); ?>" type="text/javascript"></script>
    <!-- END: CORE PLUGINS -->
    <?php
    // load extra JS files from controller
        if (isset($js_to_load)) :
            foreach ($js_to_load as $row):
                $js_link=base_url($row);
                echo "<script src='$js_link' type='text/javascript'></script>";
            endforeach;
        endif;
    ?>
    <!-- BEGIN: LAYOUT PLUGINS -->
    <script src="<?= base_url('plugins/cubeportfolio/js/jquery.cubeportfolio.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/counterup/jquery.waypoints.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/counterup/jquery.counterup.min.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/fancybox/jquery.fancybox.pack.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('plugins/smooth-scroll/jquery.smooth-scroll.js'); ?>" type="text/javascript"></script>
    <!-- END: LAYOUT PLUGINS -->
    <!-- BEGIN: THEME SCRIPTS -->
    <script src="<?= base_url('js/components.js'); ?>" type="text/javascript"></script>
    <script src="<?= base_url('js/app.js'); ?>" type="text/javascript"></script>
    <script>
        $(document).ready(function()
        {
            App.init(); // init core
        });
    </script>
    <!-- END: THEME SCRIPTS -->
    <!-- BEGIN: PAGE SCRIPTS -->
    <?php
    // load script files from controller
        if (isset($scripts_to_load)) :
            foreach ($scripts_to_load as $row):
                if (substr($row, 0,4)=="http") {
                    $js_link=$row;
                } else {
                    $js_link=base_url($row);
                }
                echo "<script src='$js_link' type='text/javascript'></script>";
            endforeach;
        endif;
        
        if (isset($scripts_to_display)) {
            echo "<script>";
                foreach ($scripts_to_display as $script) {
                    echo $script;
                }
            echo "</script>";
        }
    ?>
    <!-- END: PAGE SCRIPTS -->
    <!-- END: LAYOUT/BASE/BOTTOM -->
    </body>

</html>
