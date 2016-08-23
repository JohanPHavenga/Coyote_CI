<?php 
    echo validation_errors(); 
    
    echo form_open($form_url); 
    
    echo "<div class='form-group'>";
    echo form_label('Name', 'user_name');
    echo form_input([
            'name'          => 'user_name',
            'id'            => 'user_name',
            'value'         => set_value('user_name', @$user_detail['user_name']),
            'class'         => 'form-control',
            'required'      => '',
        ]);
    
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Surname', 'user_surname');
    echo form_input([
            'name'          => 'user_surname',
            'id'            => 'user_surname',
            'value'         => set_value('user_surname', @$user_detail['user_surname']),
            'class'         => 'form-control',
            'required'      => '',
        ]);
    
    echo "</div>";
    
    echo "<div class='form-group'>";
    echo form_label('Club', 'club_id');
    echo form_dropdown('club_id', $club_dropdown, @$user_detail['club_id'], ["id"=>"club_id","class"=>"form-control"]);        
    echo "</div>";
   
    echo fbutton();
     
    echo form_close();
