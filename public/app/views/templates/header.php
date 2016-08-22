<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$title;?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url('css/bootstrap.min.css');?>" rel="stylesheet">    
    <link href="<?=base_url('css/bootstrap-theme.min.css');?>" rel="stylesheet">
    
    <?php
        // load extra CSS files from controller
        if (isset($css_to_load)) : 
        foreach ($css_to_load as $row):
            $css_link=base_url('css/'.$row);        
            echo "<link href='$css_link' rel='stylesheet'>";
        endforeach;
        endif;
    ?>
    
   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" type="image/x-icon" href="ci-icon.ico" />
    
    <style>
        body {
            padding-top: 70px;
            padding-bottom: 30px;
          }

          .theme-dropdown .dropdown-menu {
            position: static;
            display: block;
            margin-bottom: 20px;
          }

          .theme-showcase > p > .btn {
            margin: 5px 0;
          }

          .theme-showcase .navbar .container {
            width: auto;
          }
    </style>
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
            <li><a href="/province/view">Provinces</a></li>
            <li><a href="/town/view">Towns</a></li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Events <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/event/view">View</a></li>
                    <li><a href="/event/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Editions <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/edition/view">View</a></li>
                    <li><a href="/edition/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Races <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/race/view">View</a></li>
                    <li><a href="/race/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clubs <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/club/view">View</a></li>
                    <li><a href="/club/create/add">Add</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sponsors <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/sponsor/view">View</a></li>
                    <li><a href="/sponsor/create/add">Add</a></li>
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
