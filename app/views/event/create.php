<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo form_label('Name', 'event_name');
    echo form_input([
            'name'          => 'event_name',
            'id'            => 'event_name',
            'value'         => set_value('event_name', @$event_detail['event_name']),
        ]);
    
    echo "<br>";
    echo form_label('Town', 'town_id');
    echo form_dropdown('town_id', $town_dropdown, @$event_detail['town_id']);    
    
    echo "<br>";
    echo form_submit('submit', ucfirst($action).' Event');
     
    echo form_close();

//    wts($town_dropdown);
