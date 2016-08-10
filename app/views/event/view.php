<?php 
  if($this->session->flashdata('message'))
  {
      echo "<blockquote style='background:#EEE8AA';>";
      echo $this->session->flashdata('message');
      echo "</blockquote>";
  }
  
    //log_message('error',print_r($province_list,TRUE));    
//    wts($province_list);
    $data_arr=$event_list_formatted;

    if ($data_arr) 
    {
        $this->table->set_heading($heading);
        
        $template = array(
                'table_open' => '<table class="table table-striped table-bordered table-condensed ">'
        );
        $this->table->set_template($template);
        echo $links;
        echo $this->table->generate($data_arr);
        echo $links;
        echo "<p><a href='".$create_link."/add'>Add Entry</a></p>";
    }
    else
    {
        echo "No data to show";
    }


