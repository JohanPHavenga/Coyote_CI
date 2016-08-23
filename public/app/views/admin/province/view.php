<?php    
    //log_message('error',print_r($province_list,TRUE));    
//    wts($province_list);
    $data_arr=$province_list;

    if ( ! (empty($data_arr))) 
    {
        // set heading      
        $this->table->set_heading($heading);
        $template = array(
                'table_open' => '<table class="table table-striped table-bordered table-condensed ">'
        );
        $this->table->set_template($template);
        echo $this->table->generate($data_arr);
    }
    else
    {
        echo "No data to show";
    }


