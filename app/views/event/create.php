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
    echo form_label('Town', 'town_id');
    echo form_dropdown('town_id', $town_dropdown, @$event_detail['town_id'], ["id"=>"e1","class"=>"form-control autocomplete"]);        
    echo "</div>";
   
    echo fbutton();
     
    echo form_close();

//    wts($town_dropdown);
    
    //<input type="submit" name="submit" value="Edit Event">
