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
                                <a href="/calendar">Upcoming Events</a>
                            </li>
                            <li>
                                <a href="/calendar/results"> Results</a>
                            </li>
                            <li>
                                <a href="/parkrun/calendar"> Parkrun</a>
                            </li>
                            <li>
                                <a href="/faq"> FAQ</a>
                            </li>
                            <li>
                                <a href="/contact">Contact Us</a>
                            </li>
                            <li>
                                <a href="/search">Search</a>
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
                            foreach ($area_list as $area_id => $area) {
                                echo "<li><a href='" . base_url() . str_replace(" ", "", strtolower($area['area_name'])) . "'>" . $area['area_name'] . "</a></li>";
                            }
                            ?>
                        </ul>

                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="c-content-title-1 c-title-md">
                            <h3 class="c-title c-font-uppercase c-font-bold">Races by date</h3>
                            <div class="c-line-left hide"></div>
                        </div>
                        <ul class="c-links c-theme-ul">
                            <?php                            
                            foreach ($date_list as $year => $month_list) {
                                foreach ($month_list as $month_number => $month_name) {
                                    echo "<li><a href='" . base_url() . "calendar/".$year."/".$month_number."'>" . $month_name . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
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
                    <p class="c-copyright c-font-grey"><?= date('Y'); ?> &copy; RoadRunning.co.za
                        <span class="c-font-grey-3">All Rights Reserved.</span>
                        <a href="<?= $admin_login; ?>">Admin&nbsp;Login</a>
                    </p>
                </div>
                <div class="col-md-6 col-sm-6">
                    <ul class="c-socials">
                        <li><a href="https://www.patreon.com/roadrunningza" target="_blank" title="Support us on Patreon">
                                <img src="/img/become_a_patron.png" alt="Support us on Patreon" style="height: 36px; margin-top: 1px;"></a>
                        </li>
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

<link href="<?= base_url('css/roboto-condensed.min.css'); ?>" rel="stylesheet" type="text/css" media="screen" />
<!--<link href="<?= base_url('css/roboto.css'); ?>" rel="stylesheet" type="text/css" />-->
<link href="<?= base_url('plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('css/components.min.css'); ?>" id="style_components" rel="stylesheet" type="text/css" />
<link href="<?= base_url('css/theme.css'); ?>" rel="stylesheet" id="style_theme" type="text/css" />
<link href="<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" /
<noscript>
    <!--<link href="<?= base_url('plugins/bootstrap-social/bootstrap-social.css'); ?>" rel="stylesheet" type="text/css" />-->
    <link href="<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('plugins/animate/animate.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('css/custom.css'); ?>" rel="stylesheet" type="text/css" />
</noscript>

<!-- END GLOBAL MANDATORY STYLES -->
        
        <!-- BEGIN THEME STYLES -->
        <!--<link href="<?= base_url('css/custom.css'); ?>" rel="stylesheet" type="text/css" />-->
        <!-- END THEME STYLES -->
        
<!-- DEFER LOADING OF CSS FILES -->
<script type="text/javascript">
    /* Font Awesome */
    var font_awesome = document.createElement('link');
    font_awesome.rel = 'stylesheet';
    font_awesome.href = '<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>';
    font_awesome.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(font_awesome, godefer);
    
    /* Simple Line Icons */
    var simple_line_icons = document.createElement('link');
    simple_line_icons.rel = 'stylesheet';
    simple_line_icons.href = '<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>';
    simple_line_icons.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(simple_line_icons, godefer);
    
    /* Animate */
    var animate = document.createElement('link');
    animate.rel = 'stylesheet';
    animate.href = '<?= base_url('plugins/animate/animate.min.css'); ?>';
    animate.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(animate, godefer);
    
    /* Plugins */
    var plugins = document.createElement('link');
    plugins.rel = 'stylesheet';
    plugins.href = '<?= base_url('css/plugins.min.css'); ?>';
    plugins.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(plugins, godefer);
        
    /* Custom */
    var custom = document.createElement('link');
    custom.rel = 'stylesheet';
    custom.href = '<?= base_url('css/custom.css'); ?>';
    custom.type = 'text/css';
    var godefer = document.getElementsByTagName('link')[0];
    godefer.parentNode.insertBefore(custom, godefer);
</script>
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
        if (substr($row, 0, 4) == "http") {
            $js_link = $row;
        } else {
            $js_link = base_url($row);
        }
        echo "<script src='$js_link'></script>";
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
<!--<script src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
<script>
    $(document).ready(function ()
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
        if (substr($row, 0, 4) == "http") {
            $js_link = $row;
        } else {
            $js_link = base_url($row);
        }
        echo "<script src='$js_link' type='text/javascript' defer></script>";
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

<?php
//    wts($date_list);
?>