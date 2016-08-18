<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'sponsor_name');
    echo form_input([
            'name'          => 'sponsor_name',
            'id'            => 'sponsor_name',
            'value'         => set_value('sponsor_name', @$sponsor_detail['sponsor_name']),
            'class'         => 'form-control',
        ]);
    
    echo "</div>";
        
    echo "<div class='form-group'>";
    echo form_label('Status', 'sponsor_status');
    echo form_dropdown('sponsor_status', $status_dropdown, @$sponsor_detail['sponsor_status'], ["id"=>"sponsor_status","class"=>"form-control"]);        
    echo "</div>";
    
   
    echo fbutton();
     
    echo form_close();

//    wts($town_dropdown);
    
    //<input type="submit" name="submit" value="Edit Event">
