<?php    
    //log_message('error',print_r($province_list,TRUE));    
//    wts($province_list);
    $data_arr=$town_list;

    if ( ! (empty($data_arr))) 
    {
        $this->table->set_heading($heading);
        
        echo $links;
        $template = array(
                'table_open' => '<table class="table table-striped table-bordered table-condensed ">'
        );
        $this->table->set_template($template);
        echo $this->table->generate($data_arr);
        echo $links;
        
        //pagenation
//        <nav aria-label="Page navigation">
//  <ul class="pagination">
//    <li>
//      <a href="#" aria-label="Previous">
//        <span aria-hidden="true">&laquo;</span>
//      </a>
//    </li>
//    <li><a href="#">1</a></li>
//    <li><a href="#">2</a></li>
//    <li><a href="#">3</a></li>
//    <li><a href="#">4</a></li>
//    <li><a href="#">5</a></li>
//    <li>
//      <a href="#" aria-label="Next">
//        <span aria-hidden="true">&raquo;</span>
//      </a>
//    </li>
//  </ul>
//</nav>
    }
    else
    {
        echo "No data to show";
    }


