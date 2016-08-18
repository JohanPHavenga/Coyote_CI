<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'edition_name');
    echo form_input([
            'name'          => 'edition_name',
            'id'            => 'edition_name',
            'value'         => set_value('edition_name', @$edition_detail['edition_name']),
            'class'         => 'form-control',
            'required'      => '',
        ]);
    
    echo "</div>";
        
    echo "<div class='form-group'>";
    echo form_label('Status', 'edition_status');
    echo form_dropdown('edition_status', $status_dropdown, @$edition_detail['edition_status'], ["id"=>"edition_status","class"=>"form-control"]);        
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Date', 'edition_date');
    echo form_input([
            'name'          => 'edition_date',
            'id'            => 'edition_date',
            'value'         => set_value('edition_date', @fdateShort($edition_detail['edition_date'])),
            'class'         => 'form-control',
            'type'          => 'date',
        ]);    
    echo "</div>";
    
    
    echo "<div class='form-group'>";
    echo form_label('Event', 'event_id');
    echo form_dropdown('event_id', $event_dropdown, @$edition_detail['event_id'], ["id"=>"event_id","class"=>"form-control"]);        
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Sponsor', 'sponsor_id');
    echo form_dropdown('sponsor_id', $sponsor_dropdown, @$edition_detail['sponsor_id'], ["id"=>"sponsor_id","class"=>"form-control"]);        
    echo "</div>";
   
    echo fbutton();
     
    echo form_close();
