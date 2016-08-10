        </div>
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url('js/bootstrap.min.js');?>"></script>
        <script src="<?=base_url('js/select2.js');?>"></script>
    <script>
        $(document).ready(function() { $(".autocomplete").select2({
               minimumInputLength: 2 
        }); });
    </script>
    </body>
</html>