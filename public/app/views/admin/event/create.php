<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'event_name');
    echo form_input([
            'name'          => 'event_name',
            'id'            => 'event_name',
            'value'         => set_value('event_name', @$event_detail['event_name']),
            'class'         => 'form-control',
        ]);
    
    echo "</div>";
        
    echo "<div class='form-group'>";
    echo form_label('Status', 'event_status');
    echo form_dropdown('event_status', $status_dropdown, @$event_detail['event_status'], ["id"=>"event_status","class"=>"form-control"]);        
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Town', 'town_id');
    echo form_dropdown('town_id', $town_dropdown, @$event_detail['town_id'], ["id"=>"town_id","class"=>"form-control autocomplete"]);        
    echo "</div>";
    
    
    echo "<div class='form-group'>";
    echo form_label('Organising Club', 'club_id');
    echo form_dropdown('club_id', $club_dropdown, @$event_detail['club_id'], ["id"=>"club_id","class"=>"form-control"]);        
    echo "</div>";
   
    echo fbutton();
     
    echo form_close();

//    wts($town_dropdown);
    
    //<input type="submit" name="submit" value="Edit Event">