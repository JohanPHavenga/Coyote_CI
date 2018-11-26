<div class="c-content-box c-size-sm c-bg-grey-1">
    <div class="container">
        <div class="c-content-bar-2 c-opt-1">
            <div class="row" data-auto-height="true">
                <div class="col-md-8">
                    <!-- Begin: Title 1 component -->
                    <div class="c-content-title-1" data-height="height">
                        <h3 class="c-font-uppercase c-font-bold"><?= substr($event_detail['edition_name'], 0, -4); ?></h3>
                    </div>
                    <p class="c-font-sbold">                            
                        Annual <?= $event_detail['event_name']; ?> 
                        <?php
                        if ($event_detail['club_id'] != 8) {
                            echo " organized by ";
                            if (isset($event_detail['club_url_list'][0])) {
                                echo "<a href='".$event_detail['club_url_list'][0]['url_name']."' target='_blank' title='Visit athletics club website' class='link'>".$event_detail['club_name']."</a>";
                            } else {
                                echo $event_detail['club_name'];
                            }
                            
                        }
                        echo " on <strong>" . date("d F Y", strtotime($event_detail['edition_date'])) . "</strong>";

                        if ((!empty($event_detail['sponsor_name'])) && ($event_detail['sponsor_name'] != "No sponsor")) {
                            echo "<br>Brought to you by ";
                            if (isset($event_detail['sponsor_url_list'][0])) {
                                echo "<a href='".$event_detail['sponsor_url_list'][0]['url_name']."' target='_blank' title='Visit sponsor website' class='link'>".$event_detail['sponsor_name']."</a>";
                            } else {
                                echo $event_detail['sponsor_name'];
                            }
                        }
                        ?>
                    </p>
                    <?php
                    // INTRO
                    if (strlen(strip_tags($event_detail['edition_intro_detail'])) > 5) {
                        echo $event_detail['edition_intro_detail'];
                    }

                    // ASA MEMBERSHIP
                    if ($event_detail['asa_member_id'] > 0) {
                        echo "<p style='font-size: 0.9em;'>This event is held under the rules and regulations of "
                        . "<u><a href='https://www.athletics.org.za/' target='_blank' title='Athletics South Africa'>ASA</a></u> "
                        . "and <u><a href='" . $event_detail['asa_member_url'] . "' target='_blank' title='" . $event_detail['asa_member_abbr'] . "'>"
                        . "" . $event_detail['asa_member_name'] . "</a></u></p>";
                    }

                    // EDITION BUTTONS
                    if ($event_detail['calc_edition_urls']) {
                        $button_class = "btn btn-md c-btn-border-2x c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
                        echo '<div class="btn-group">';
                        // ENTRY
                        if (isset($event_detail['calc_edition_urls'][5])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][5] . '" target="_blank" class="' . $button_class . '">Enter Now</a>';
                        }
                        // MORE INFO
                        if (isset($event_detail['calc_edition_urls'][1])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][1] . '" target="_blank" class="' . $button_class . '">More Info</a>';
                        }
                        // FLYER
                        if (isset($event_detail['calc_edition_urls'][2])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][2] . '" target="_blank" class="' . $button_class . '">Event Flyer</a>';
                        }
                        // ENTRY FORM
                        if (isset($event_detail['calc_edition_urls'][3])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][3] . '" target="_blank" class="' . $button_class . '">Manual Entry Form</a>';
                        }
                        // RESULTS
                        if (isset($event_detail['calc_edition_urls'][4])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][4] . '" target="_blank" class="' . $button_class . '">Race Results</a>';
                        }
                        // ROUTE MAP
                        if (isset($event_detail['calc_edition_urls'][7])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][7] . '" target="_blank" class="' . $button_class . '">Route Map</a>';
                        }
                        // FACEBOOK
                        if (isset($event_detail['calc_edition_urls'][6])) {
                            echo '<a href="' . $event_detail['calc_edition_urls'][6] . '" target="_blank" class="' . $button_class . '"><i class="fa fa-facebook"></i> Facebook</a>';
                        }
                        echo "</div>";
                    }
                    
                    // RACES BUTTONS
                    if (isset($event_detail['calc_race_urls'])) {
                        $button_class = "btn btn-md c-btn-border-2x c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
                        echo '<br><div class="btn-group">';
                        foreach ($event_detail['calc_race_urls'] as $race_id=>$race_urls)
                        {
                            // Race Results
                            if (isset($race_urls[4])) {
                                $btn_text= round($event_detail['race_list'][$race_id]['race_distance'],0)."K ".$event_detail['race_list'][$race_id]['racetype_name']." Results";
                                echo '<a href="' . $race_urls[4] . '" target="_blank" class="' . $button_class . '">'.$btn_text.'</a>';
                            }
                            
                            // Route Maps
                            if (isset($race_urls[7])) {
                                $btn_text= round($event_detail['race_list'][$race_id]['race_distance'],0)."K ".$event_detail['race_list'][$race_id]['racetype_name']." Route Map";
                                echo '<a href="' . $race_urls[7] . '" target="_blank" class="' . $button_class . '">'.$btn_text.'</a>';
                            }
                        }
                        echo "</div>";
                    }
                    ?>
                    <!-- End-->

                </div>
                <div class="col-md-4 edition-logo">
                    <?php
                    if (@$event_detail['file_list'][1]) {
                        $img_url = base_url("uploads/edition/" . $event_detail['edition_id'] . "/" . $event_detail['file_list'][1][0]['file_name']);
                        echo "<img src='$img_url' style='max-height: 250px; max-width: 400px; float:right;'>";

                        // =================================
                        // #toberemoved                      
                        // =================================
                    } elseif (strlen($event_detail['edition_logo']) > 3) {
                        $img_url = base_url("uploads/admin/edition/" . $event_detail['edition_id'] . "/" . $event_detail['edition_logo']);
                        echo "<img src='$img_url' style='max-height: 250px; max-width: 400px;'>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>