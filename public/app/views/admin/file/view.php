
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-list font-dark"></i>
                    <span class="caption-subject bold uppercase"> List of all files</span>
                </div>
            </div>
            <div class="portlet-body">

<?php
                if ( ! (empty($file_data)))
                {
                    // create table
                    $this->table->set_template(ftable('files_table'));
                    $this->table->set_heading($heading);
                    foreach ($file_data as $id=>$data_entry) {
                        
                        $action_array=[
//                                [
//                                "url"=>"/admin/file/create/edit/".$data_entry['file_id'],
//                                "text"=>"Edit",
//                                "icon"=>"icon-pencil",
//                                ],
                                [
                                "url"=>"/admin/file/delete/".$data_entry['file_id'],
                                "text"=>"Delete",
                                "icon"=>"icon-dislike",
                                "confirmation_text"=>"<b>Are you sure?</b>",
                                ],
                            ];
                        
        
                        $row['id']=$data_entry['file_id'];                  
                        $row['file']=$data_entry['file_name'];  
                        $row['filetype']=$data_entry['filetype_name'];       
                        $row['file_linked_to']=$data_entry['file_linked_to'];
                        $row['linked_id']=$data_entry['linked_id'];
                        $row['actions']= fbuttonActionGroup($action_array);
                      
                        $this->table->add_row($row);
                        unset($row);
                    }
                    echo $this->table->generate();

                }
                else
                {
                    echo "<p>No data to show</p>";
                }

                // add button
                if (@$create_link)
                {
                echo fbuttonLink($create_link."/add","Add File","primary");
                }
                ?>
            
            </div>
        </div>
    </div>
</div>

<?php
//wts($file_data);
?>

