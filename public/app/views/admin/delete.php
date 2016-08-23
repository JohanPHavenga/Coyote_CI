<?php
echo "Are you sure you want to delete this record?";

echo validation_errors(); 
    
echo form_open("admin/$controller/delete/confirm"); 
echo form_hidden($id_field, $id);
echo "<br>";
echo fbutton("Confirm","submit","danger");
echo "&nbsp;";
echo fbuttonLink("/admin/".$controller."/view","Cancel");

echo form_close();
