<!DOCTYPE html>
<html lang="en">
  <head>
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
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Login <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/login">User Login</a></li>
                            <li><a href="/login/admin">Admin Login</a></li>
                        </ul>
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