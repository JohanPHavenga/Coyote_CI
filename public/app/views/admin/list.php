<?php 
    //log_message('error',print_r($province_list,TRUE));   
    
    if ( ! (empty($list))) 
    {
        // pagination links
        echo fpagination(@$pagination);
        
        // create table
        $this->table->set_template(ftable());
        $this->table->set_heading($heading);
        foreach ($list as $id=>$data) {
            if (@$create_link)
            {
                // add edit buttondata
                $data[]=fbuttonLink($create_link."/edit/".$id, "Edit", 'default', 'xs');
                // add delete button. Encrypt the data
                $crypt=base64_encode($this->encryption->encrypt($delete_arr['controller']."|".$delete_arr['id_field']."|".$id));
                $data[]=fbuttonLink("/admin/delete/".$crypt , "Delete", 'danger', 'xs');
            }
            $this->table->add_row($data);
        }
        echo $this->table->generate();
        
        // pagination links
        echo fpagination(@$pagination);
        
    }
    else
    {
        echo "<p>No data to show</p>";
    }
        
    // add button
    if (@$create_link)
    {
    echo fbuttonLink($create_link."/add","Add Entry");
    }

