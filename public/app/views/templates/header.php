<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <?php
            if ($title) {
                $page_title=$title;
            } else {
                $page_title="Running Event Listing Site";
            }
        ?>
        <title>RoadRunning.co.za | <?=$page_title;?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8">
        <meta content="Listing all road running events in and around Cape Town in a modern, easy to compare fashsion" name="description" />
        <meta content="Johan Havenga" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!-- <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'> -->
        <link href="<?= base_url('plugins/bootstrap-social/bootstrap-social.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/animate/animate.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN: BASE PLUGINS  -->
        <link href="<?= base_url('plugins/revo-slider/css/settings.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/revo-slider/css/layers.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/revo-slider/css/navigation.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/cubeportfolio/css/cubeportfolio.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END: PAGE STYLES -->
        <!-- BEGIN THEME STYLES -->
        <link href="<?= base_url('css/plugins.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('css/components.css'); ?>" id="style_components" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('css/theme.css'); ?>" rel="stylesheet" id="style_theme" type="text/css" />
        <link href="<?= base_url('css/custom.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME STYLES -->
        <link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>" /> </head>

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
                            <a href="/" class="c-logo">
                                <img src="<?= base_url('img/logo.png'); ?>" alt="RoadRunning.co.za" class="c-desktop-logo">
                                <img src="<?= base_url('img/logo.png'); ?>" alt="RoadRunning.co.za" class="c-desktop-logo-inverse">
                                <img src="<?= base_url('img/logo.png'); ?>" alt="RoadRunning.co.za" class="c-mobile-logo"> </a>
                            <!-- <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                                <span class="c-line"></span>
                                <span class="c-line"></span>
                                <span class="c-line"></span>
                            </button> -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END: HEADER -->
        <!-- END: LAYOUT/HEADERS/HEADER-1 -->
