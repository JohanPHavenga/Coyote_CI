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
          <a class="navbar-brand" href="/admin/">Coyote</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="/admin/province">Provinces</a></li>
            <li><a href="/admin/town">Towns</a></li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/event">View</a></li>
                    <li><a href="/admin/event/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Editions <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/edition">View</a></li>
                    <li><a href="/admin/edition/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Races <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/race">View</a></li>
                    <li><a href="/admin/race/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Users <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/user">View</a></li>
                    <li><a href="/admin/user/create/add">Add</a></li>
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Roles <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/role">View</a></li>
                    <li><a href="/admin/role/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Entries <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/entry">View</a></li>
                    <li><a href="/admin/entry/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clubs <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/club">View</a></li>
                    <li><a href="/admin/club/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sponsors <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/sponsor">View</a></li>
                    <li><a href="/admin/sponsor/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ASA Numbers <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/asanumber">View</a></li>
                    <li><a href="/admin/asanumber/create/add">Add</a></li>
                </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$this->session->admin_user['user_name'];?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="">Profile</a></li>
                    <li><a href="/login/logout">Logout</a></li>
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
