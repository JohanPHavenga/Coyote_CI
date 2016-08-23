    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$title;?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url('css/bootstrap.min.css');?>" rel="stylesheet">    
    <link href="<?=base_url('css/bootstrap-theme.min.css');?>" rel="stylesheet">
    <link href="<?=base_url('css/custom.css');?>" rel="stylesheet">
    
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