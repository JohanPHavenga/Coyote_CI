<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-8912238222537097",
            enable_page_level_ads: true
          });
        </script>
        <meta charset="utf-8" />
        <?php
            if ($title) {
                $page_title=$title;
            } else {
                $page_title="Running Event Listing Site";
            }
        ?>
        <title><?=$page_title;?> | RoadRunning.co.za</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="Listing all road running events in and around Cape Town in a modern, easy to compare fashsion" name="description" />
        <meta content="Johan Havenga" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!--<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>-->
        <link href="<?= base_url('css/roboto-condensed.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/bootstrap-social/bootstrap-social.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/animate/animate.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <?php
            // load extra CSS files from controller
            if (isset($css_to_load)) :
            foreach ($css_to_load as $row):
                $css_link=base_url($row);
                echo "<link href='$css_link' rel='stylesheet'>";
            endforeach;
            endif;
        ?>
        <!-- BEGIN THEME STYLES -->
        <link href="<?= base_url('css/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('css/components.min.css'); ?>" id="style_components" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('css/theme.css'); ?>" rel="stylesheet" id="style_theme" type="text/css" />
        <link href="<?= base_url('css/custom.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME STYLES -->
        <!-- <link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>" />  -->

        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('img/favicon/apple-icon-57x57.png');?>">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('img/favicon/apple-icon-60x60.png');?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('img/favicon/apple-icon-72x72.png');?>">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('img/favicon/apple-icon-76x76.png');?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('img/favicon/apple-icon-114x114.png');?>">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('img/favicon/apple-icon-120x120.png');?>">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('img/favicon/apple-icon-144x144.png');?>">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('img/favicon/apple-icon-152x152.png');?>">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('img/favicon/apple-icon-180x180.png');?>">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url('img/favicon/android-icon-192x192.png');?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('img/favicon/favicon-32x32.png');?>">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('img/favicon/favicon-96x96.png');?>">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('img/favicon/favicon-16x16.png');?>">
        <link rel="manifest" href="<?= base_url('img/favicon/manifest.json');?>">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= base_url('img/favicon/ms-icon-144x144.png');?>">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body class="c-layout-header-fixed c-layout-header-mobile-fixed">
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-85900175-2', 'auto');
          ga('send', 'pageview');

        </script>
        <!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
        <!-- BEGIN: HEADER -->
        <header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
            <div class="c-navbar">
                <div class="container">
                    <div class="c-navbar-wrapper clearfix">
                        <div class="c-brand c-pull-left">
                            <a href="/" class="c-logo ">
                                <?php $img_url="img/logo-vec-37.png";?>
                                <img src="<?= base_url($img_url); ?>" alt="RoadRunning.co.za" class="c-desktop-logo">
                                <img src="<?= base_url($img_url); ?>" alt="RoadRunning.co.za" class="c-desktop-logo-inverse">
                                <img src="<?= base_url('img/logo-vec-27.png'); ?>" alt="RoadRunning.co.za" class="c-mobile-logo">
                            </a>
                            <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                                <span class="c-line"></span>
                                <span class="c-line"></span>
                                <span class="c-line"></span>
                            </button>
                            <button class="c-search-toggler" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        
                        <!-- BEGIN: QUICK SEARCH -->
                        <form class="c-quick-search" action="<?= base_url("search"); ?>">
                            <input type="text" name="query" placeholder="Search for an event" value="" class="form-control" autocomplete="off">
                            <span class="c-theme-link">&times;</span>
                        </form>
                        <!-- END: QUICK SEARCH -->

                        <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                            <ul class="nav navbar-nav c-theme-nav">
                                <?php
                                    foreach ($menu_array as $menu_item) {
                                        if ($section==$menu_item['section']) {
                                            $mc="c-active";
                                        } else {
                                            $mc="";
                                        }
                                        echo "<li class='$mc'>";
                                            if ($menu_item['text']=="Contact Us") {
                                                    echo "<a href='".$menu_item['url']."' class='c-link dropdown-toggle'>".$menu_item['text']."</a>";
                                            }
                                            else
                                            {
                                                echo "<a href='".$menu_item['url']."' class='c-link dropdown-toggle'>".$menu_item['text']."</a>";
                                            }
                                        echo "</li>";
                                    }
                                ?>
                                <li class="c-search-toggler-wrapper">
                                    <a href="#" class="c-btn-icon c-search-toggler">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- END: HEADER -->
        <!-- END: LAYOUT/HEADERS/HEADER-1 -->
