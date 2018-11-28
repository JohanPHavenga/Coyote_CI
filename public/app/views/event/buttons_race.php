<?php
// RACES BUTTONS
if (isset($event_detail['calc_race_urls'])) {
    $button_class = "btn btn-md c-btn-border-2x c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
    echo '<div class="btn-group">';
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
