<?php
if ($calc_edition_urls) {                        
    $button_class = "btn btn-md c-btn-border-2x c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
    echo '<div class="btn-group">';
    // ENTRY
    if (isset($calc_edition_urls[5])) {
        echo '<a href="' . $calc_edition_urls[5] . '" target="_blank" class="' . $button_class . '">Enter Now</a>';
    }
    // MORE INFO
    if (isset($calc_edition_urls[1])) {
        echo '<a href="' . $calc_edition_urls[1] . '" target="_blank" class="' . $button_class . '">More Info</a>';
    }
    // FLYER
    if (isset($calc_edition_urls[2])) {
        echo '<a href="' . $calc_edition_urls[2] . '" target="_blank" class="' . $button_class . '">Event Flyer</a>';
    }
    // ENTRY FORM
    if (isset($calc_edition_urls[3])) {
        echo '<a href="' . $calc_edition_urls[3] . '" target="_blank" class="' . $button_class . '">Manual Entry Form</a>';
    }
    // RESULTS
    if (isset($calc_edition_urls[4])) {
        echo '<a href="' . $calc_edition_urls[4] . '" target="_blank" class="' . $button_class . '">Race Results</a>';
    }
    // ROUTE MAP
    if (isset($calc_edition_urls[7])) {
        echo '<a href="' . $calc_edition_urls[7] . '" target="_blank" class="' . $button_class . '">Route Map</a>';
    }
    // FACEBOOK
    if (isset($calc_edition_urls[6])) {
        echo '<a href="' . $calc_edition_urls[6] . '" target="_blank" class="' . $button_class . '"><i class="fa fa-facebook"></i> Facebook</a>';
    }
    echo "</div>";
}

