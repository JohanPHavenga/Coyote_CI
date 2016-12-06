    <!-- BEGIN: LAYOUT/FOOTERS/FOOTER-6 -->
    <a name="footer"></a>
    <footer class="c-layout-footer c-layout-footer-6 c-bg-grey-1">
        <div class="c-postfooter c-bg-dark-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-9 col-xs-9 c-col">
                        <p class="c-copyright c-font-grey">2016 &copy; RoadRunning.co.za
                            <span class="c-font-grey-3">All Rights Reserved.</span>
                            <a href="<?=$admin_login;?>">Admin&nbsp;Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END: LAYOUT/FOOTERS/FOOTER-6 -->
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
                $js_link=base_url($row);
                echo "<script src='$js_link' type='text/javascript'></script>";
            endforeach;
        endif;
    ?>
    <!-- END: PAGE SCRIPTS -->
    <!-- END: LAYOUT/BASE/BOTTOM -->
    </body>

</html>
