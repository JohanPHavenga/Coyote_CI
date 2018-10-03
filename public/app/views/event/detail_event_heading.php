<div class="c-content-box c-size-sm c-bg-grey-1">
    <div class="container">
        <div class="c-content-bar-2 c-opt-1">
            <div class="row" data-auto-height="true">
                <div class="col-md-7">
                    <!-- Begin: Title 1 component -->
                    <div class="c-content-title-1" data-height="height">
                        <h3 class="c-font-uppercase c-font-bold"><?=substr($event_detail['edition_name'],0,-4);?></h3>
                    </div>
                    <p class="c-font-sbold">                            
                        Annual <?=$event_detail['event_name'];?> 
                        <?php
                            if ($event_detail['club_id']!=8) {
                                echo " organized by ".$event_detail['club_name'];
                            }
                            echo " on <strong>". date("d F Y",strtotime($event_detail['edition_date'])) ."</strong>";
                        
                            if ((!empty($event_detail['sponsor_name'])) && ($event_detail['sponsor_name']!="No sponsor")) {
                                echo "<br>Brought to you by ".$event_detail['sponsor_name'];
                            }
                        ?>
                    </p>
                    <?php
                        // INTRO
                        if (strlen($event_detail['edition_intro_detail'])>10) {
                            echo $event_detail['edition_intro_detail'];
                        }
                        
                        // ASA MEMBERSHIP
                        if ($event_detail['asa_member_id']>0) {                        
                            echo "<p> This event is held under the rules and regulations of "
                                    . "<u><a href='https://www.athletics.org.za/' target='_blank' title='Athletics South Africa'>ASA</a></u> "
                                    . "and <u><a href='".$event_detail['asa_member_url']."' target='_blank' title='".$event_detail['asa_member_abbr']."'>"
                                    . "".$event_detail['asa_member_name']."</a></u></p>";
                        }
                    
                        // BUTTONS
                        $button_class="btn btn-md c-btn-border-2x c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
                        echo '<div class="btn-group">';
                        // ENTRY
                        if ($event_detail['edition_url_entry']) {
                            echo '<a href="'.$event_detail['edition_url_entry'].'" target="_blank" class="'.$button_class.'">Enter Now</a>';                                                 
                        }
                        // MORE INFO
                        if ($event_detail['edition_url']) {
                            echo '<a href="'.$event_detail['edition_url'].'" target="_blank" class="'.$button_class.'">More Info</a>';  
                        }
                        // FLYER
                        if (@$event_detail['file_list'][2]) {
                            $file_url=base_url("download/file/edition/".$event_detail['edition_id']."/".$event_detail['file_list'][2][0]['file_name']);
                            echo "<a href='$file_url' class='".$button_class."'>Event Flyer</a>";

                        // =================================
                        // #toberemoved
                        // =================================
                        } elseif ($event_detail['edition_url_flyer']) {
                            echo '<a href="'.$event_detail['edition_url_flyer'].'" target="_blank" class="'.$button_class.'">Event Flyer</a>';                            
                        }
                        // RESULTS
                        if ($event_detail['edition_url_results']) {
                            echo '<a href="'.$event_detail['edition_url_results'].'" target="_blank" class="'.$button_class.'">Race Results</a>';                             
                        }
                        echo "</div>";
                     ?>
                    <!-- End-->
                    
                </div>
                <div class="col-md-5 edition-logo">
                    <?php
                    if (@$event_detail['file_list'][1]) {
                        $img_url=base_url("uploads/edition/".$event_detail['edition_id']."/".$event_detail['file_list'][1][0]['file_name']);
                        echo "<img src='$img_url' style='max-height: 250px; max-width: 400px;'>";
                        
                    // =================================
                    // #toberemoved                      
                    // =================================
                    } elseif (strlen($event_detail['edition_logo'])>3) {
                        $img_url=base_url("uploads/admin/edition/".$event_detail['edition_id']."/".$event_detail['edition_logo']);
                        echo "<img src='$img_url' style='max-height: 250px; max-width: 400px;'>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>