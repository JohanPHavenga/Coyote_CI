<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?= $title; ?></title>
        <link rel="shortcut icon" type="image/x-icon" href="fe_icon.ico" />

        <!-- Bootstrap -->
        <link href="<?= base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">    
        <link href="<?= base_url('css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
        <link href="<?= base_url('css/custom.css'); ?>" rel="stylesheet">

        <?php include_once('shared_head.php'); ?>
    </head>
    <body>
            
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Coyote</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/about">About</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <?php
                            if ($this->session->has_userdata('user_logged_in')) {
                            ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$this->session->user['user_name'];?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Profile</a></li>
                                    <li><a href="/login/logout">Logout</a></li>
                                </ul>
                            <?php
                            } else {
                            ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/login">User Login</a></li>
                                    <li><a href="/login/admin">Admin Login</a></li>
                                </ul>
                            <?php
                            }
                        ?>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    
    <div class="container theme-showcase" role="main">
        
        <h1><?php echo $title; ?></h1>
        
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
            echo "<div class='alert alert-$status' role='alert'>$alert_msg</div>";
        }