<?php 
    //log_message('error',print_r($province_list,TRUE));    
//    wts($province_list);
    $data_arr=$event_list_formatted;

    if ( ! (empty($data_arr))) 
    {
        // pagination links
        echo fpagination($pagination);
        
        // create table
        $this->table->set_template(ftable());
        $this->table->set_heading($heading);
        echo $this->table->generate($data_arr);
        
        // pagination links
        echo fpagination($pagination);
        
        // add button
        echo fbuttonLink($create_link."/add","Add Entry");
        
    }
    else
    {
        echo "No data to show";
    }


