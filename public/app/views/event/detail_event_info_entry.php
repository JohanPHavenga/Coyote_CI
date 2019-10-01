<div class="c-content-box c-size-sm c-bg-grey-1">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <div class="c-content-title-1 ">
                    <h3 class="c-font-uppercase c-font-bold">
                        Entries Information
                    </h3>
                </div>
                <ul>
                    <?php
                    // if not NO INFO
                    if (!in_array(5, $event_detail['entrytype_list'])) {
                        // Online entries
                        if (isset($event_detail['entrytype_list'][4])) {
                            echo "<li><a href='" . $calc_edition_urls[5] . "' class='link'>Enter Online</a></li>";
                            echo "<li>Online entries close on <b>" . fdateHumanFull($event_detail['date_list'][3][0]['date_end'], true) . "</b></li>";
                        } else {
                            echo "<li class='red'>No online entries available</li>";
                        }

                        // OTD entries
                        if (isset($event_detail['entrytype_list'][1])) {
                            echo "<li>Entries will be taken <span class='red'><b>on the day</b></span> from <b>" .
                            ftimeMil($event_detail['date_list'][6][0]['date_start']);
                            if (!time_is_midnight($event_detail['date_list'][6][0]['date_end'])) {
                                echo " - " . ftimeMil($event_detail['date_list'][6][0]['date_end']);
                            }
                            echo "</b></li>";
                        } else {
                            echo "<li class='red em'>No entrires avaialble on race day</li>";
                        }

                        // Manual entries
                        if (isset($event_detail['entrytype_list'][2])) {
                            if (!empty($event_detail['date_list'][5][0]['venue_name'])) {
                                echo "<li>Pre-Entries can also be completed at " . $event_detail['date_list'][5][0]['venue_name'] . "</li>";
                            }
                            echo "<li>Closing date for manual pre-entries is <u>" . fdateHumanFull($event_detail['date_list'][5][0]['date_end'], true, true) . "</u></li>";
                        }

                        // PRE entries
                        if (isset($event_detail['entrytype_list'][3])) {
                            echo "<li><b>Entries will be taken on:</b><ul>";
                            foreach ($event_detail['date_list'][4] as $date) {
                                echo "<li>" . fdateHumanFull($date['date_start'], true, true) . "-" . ftimeMil($date['date_end']) . " @ " . $date['venue_name'] . "</li>";
                            }
                            echo "</ul></li>";
                        }
                    }
                    ?>
                </ul>
                <?php
                // always show what is in the box
                if (strlen($event_detail['edition_entry_detail']) > 15) {
                    echo $event_detail['edition_entry_detail'];
                }
                ?>
            </div>
        </div>
        <?php
        if (!in_array(3, $event_detail['regtype_list'])) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="c-content-title-1" style="padding-top: 25px;">
                        <h3 class="c-font-uppercase c-font-bold">
                            Number Collection
                    </div>
                    <ul>
                        <?php
                        // OTD Reg
                        if (isset($event_detail['regtype_list'][1])) {
                            echo "<li>Registration & number collection will take place <b>on the day</b> from <b>" .
                            ftimeMil($event_detail['date_list'][9][0]['date_start']);
                            if (!time_is_midnight($event_detail['date_list'][9][0]['date_end'])) {
                                echo " - " . ftimeMil($event_detail['date_list'][9][0]['date_end']);
                            }
                            echo "</b></li>";
                        } else {
                            echo "<li class='red em'>No number collection on race day</li>";
                        }

                        // PRE Reg
                        if (isset($event_detail['regtype_list'][2])) {
                            echo "<li><b>Registration / Number collection will take place on:</b><ul>";
                            foreach ($event_detail['date_list'][10] as $date) {
                                echo "<li>" . fdateHumanFull($date['date_start'], true, true) . "-" . ftimeMil($date['date_end']) . " @ " . $date['venue_name'] . "</li>";
                            }
                            echo "</ul></li>";
                        }
                        ?>
                    </ul>
                    <?php
                    // always show what is in the box
                    if (strlen($event_detail['edition_reg_detail']) > 15) {
                        echo $event_detail['edition_reg_detail'];
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>