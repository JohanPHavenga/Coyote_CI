<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'club_name');
    echo form_input([
            'name'          => 'club_name',
            'id'            => 'club_name',
            'value'         => set_value('club_name', @$club_detail['club_name']),
            'class'         => 'form-control',
        ]);
    
    echo "</div>";
        
    echo "<div class='form-group'>";
    echo form_label('Status', 'club_status');
    echo form_dropdown('club_status', $status_dropdown, @$club_detail['club_status'], ["id"=>"club_status","class"=>"form-control"]);        
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Town', 'town_id');
    echo form_dropdown('town_id', $town_dropdown, @$club_detail['town_id'], ["id"=>"town_id","class"=>"form-control autocomplete"]);        
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Sponsor', 'sponsor_id');
    echo form_dropdown('sponsor_id', $sponsor_dropdown, @$club_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control"]);        
    echo "</div>";
   
    echo fbutton();
     
    echo form_close();

//    wts($town_dropdown);
    
    //<input type="submit" name="submit" value="Edit Event">
