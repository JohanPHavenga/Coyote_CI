<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'role_name');
    echo form_input([
            'name'          => 'role_name',
            'id'            => 'role_name',
            'value'         => set_value('role_name', @$role_detail['role_name']),
            'class'         => 'form-control',
        ]);
    
    echo "</div>";
        
    echo "<div class='form-group'>";
    echo form_label('Status', 'role_status');
    echo form_dropdown('role_status', $status_dropdown, @$role_detail['role_status'], ["id"=>"role_status","class"=>"form-control"]);        
    echo "</div>";
    
   
    echo fbutton();
     
    echo form_close();

//    wts($town_dropdown);
    
    //<input type="submit" name="submit" value="Edit Event">
