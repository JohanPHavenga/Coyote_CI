        </div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
        <script src="<?=base_url('js/jquery-2.1.0.js');?>"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url('js/bootstrap.min.js');?>"></script>
        
        
        <?php
        // load extra JS files from controller
            if (isset($js_to_load)) : 
                foreach ($js_to_load as $row):
                    $js_link=base_url('js/'.$row);        
                    echo "<script src='$js_link'></script>";
                endforeach;
            endif;
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                <?php
                if (isset($js_script_to_load)) :
                    echo $js_script_to_load;
                endif;
                ?>
            });
        </script>
    </body>
</html>