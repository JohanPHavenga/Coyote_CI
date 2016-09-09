<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Metronic | Clean</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/simple-line-icons/simple-line-icons.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
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
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?= base_url('css/admin/components-rounded.min.css'); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?= base_url('css/admin/plugins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?= base_url('css/admin/layout.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('css/admin/theme.min.css'); ?>" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?= base_url('css/admin/custom.css'); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
                            <div class="container-fluid">
                                <!-- BEGIN LOGO -->
                                <div class="page-logo">
                                    <a href="index.php">
                                        <img src="<?= base_url('img/admin/coyote.png'); ?>" alt="logo" class="logo-default">
                                    </a>
                                </div>
                                <!-- END LOGO -->
                                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <a href="javascript:;" class="menu-toggler"></a>
                                <!-- END RESPONSIVE MENU TOGGLER -->
                                <!-- BEGIN TOP NAVIGATION MENU -->
                                <?php include ('usernav.php'); ?>
                                <!-- END TOP NAVIGATION MENU -->
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
                        <!-- BEGIN HEADER MENU -->
                        <div class="page-header-menu">
                            <div class="container-fluid">
                                <!-- BEGIN MEGA MENU -->
                                <div class="hor-menu  ">
                                    <?php include('topmenu.php'); ?>
                                </div>
                                <!-- END MEGA MENU -->
                            </div>    
                        </div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
            
            <div class="page-wrapper-row full-height">
              <div class="page-wrapper-middle">
                  <!-- BEGIN CONTAINER -->
                  <div class="page-container">
                      <!-- BEGIN CONTENT -->
                      <div class="page-content-wrapper">
                          <!-- BEGIN CONTENT BODY -->
                          <!-- BEGIN PAGE HEAD-->
                          <div class="page-head">
                              <div class="container-fluid">
                                  <!-- BEGIN PAGE TITLE -->
                                  <div class="page-title">
                                      <h1>
                                          <?= (isset($title) ? $title : 'Page Title');?>
                                      </h1>
                                  </div>
                                  <!-- END PAGE TITLE -->
                              </div>
                          </div>
                          <!-- END PAGE HEAD-->
                          <!-- BEGIN PAGE CONTENT BODY -->
                          <div class="page-content">
                              <div class="container-fluid">
                                  <?php
                                    if (isset($crumbs)) {
                                        echo "<ul class='page-breadcrumb breadcrumb'>";
                                            foreach ($crumbs as $text=>$link) 
                                            {
                                                if (empty($link)) 
                                                {
                                                    echo "<li><span>$text</span></li>";
                                                } else {
                                                    echo "<li><a href='$link'>$text</a> <i class='fa fa-circle'></i></li> ";
                                                }
                                            }
                                        echo "</ul>";
                                    }
                                  ?>
                                  <!-- BEGIN PAGE CONTENT INNER -->
                                  <div class="page-content-inner">
                                        <?php
                                        // alert message on top of the page
                                        // set flashdata [alert|status]
                                        if($this->session->flashdata('alert'))
                                        {
                                            $alert_msg=$this->session->flashdata('alert');
                                            if ( ! ($this->session->flashdata('status'))) 
                                            {
                                                $status='warning';
                                            }
                                            else 
                                            {
                                                $status=$this->session->flashdata('status');
                                            }
                                            echo "<div class='note note-$status' role='alert'>$alert_msg</div>";
                                        }