
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
    