<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    
    <?= $title_bar; ?>
    
    <div class="c-content-box c-size-sm c-bg-img-top c-no-padding c-pos-relative">
        <div class="container">
            <div class="c-content-contact-1 c-opt-1">
                <div class="row" data-auto-height=".c-height" style="min-height: 628px;">
                    <div class="col-sm-7 c-desktop"></div>
                    <div class="col-sm-5" style="padding: 0;">
                        <div class="c-body" style="padding: 45px 45px 35px 40px;">
                            <div class="c-section">
                                <h3><?= $event_detail['edition_name'];?></h3>
                            </div>
                            <div class="c-section">
                                <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">General</div>
                                <p>
                                    <b><?= date("d F Y",strtotime($event_detail['edition_date']));?></b><br>
                                    <?= $event_detail['edition_address']; ?><br>
                                    <?= $event_detail['town_name']; ?><br>
                                    <?= $event_detail['summary']['race_time_start']; ?> Race<br>
                                </p>
                            </div>
                            <div class="c-section">
                                <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">Entries</div>
                                <p>                                    
                                    <?php
                                        // show link in summary info
                                        if ($event_detail['main_url']) {
                                            $url_segments=parse_url($event_detail['main_url']);   
                                            echo "<a href='".$event_detail['main_url']."' target='_blank'>".$url_segments['host']."</a><br>";                                           
                                        }                                       
                                        
                                        // show email
                                        if (isset($event_detail['user_email'])) {
                                            $contact_email=$event_detail['user_email'];
                                        } else {
                                            $contact_email="info@roadrunning.co.za";
                                        }
                                    ?>
                                    <a href="mailto:<?=$contact_email;?>?subject=Enquiry regarding <?=$event_detail['event_name'];?> from roadrunning.co.za"><?=$contact_email;?></a>
                                </p>
                            </div>
                            <div class="c-section">
                                <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">More</div>
                                <br/>
                                <ul class="c-content-iconlist-1 c-theme">
                                    <li>
                                        <a href="/event/ics/<?=$event_detail['edition_id'];?>" title="Outlook Calender Reminder Download">
                                            <i class="fa fa-calendar-plus-o"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?=$event_detail['google_cal_url']?>" target="_blank" title="Google Calender Reminder">
                                            <i class="fa fa-google"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="gmapbg" class="c-content-contact-1-gmap" style="height: 630px;"></div>
    </div>
    
    <?= $notice; ?>
    
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
 
                        
                            // BUTTONS
                            $button_class="btn btn-md c-btn-border-2x c-btn-square c-theme-btn c-btn-uppercase c-btn-bold c-margin-t-20";
                            // ENTRY
                            if ($event_detail['edition_url_entry']) {
                                echo '<a href="'.$event_detail['edition_url_entry'].'" target="_blank" class="'.$button_class.'">Enter Now</a>';                                                 
                            }
                            // MORE INFO
                            if ($event_detail['edition_url']) {
                                echo '<a href="'.$event_detail['edition_url'].'" target="_blank" class="'.$button_class.'">More Info</a>';  
                            }
                            // FLYER
                            if ($event_detail['edition_url_flyer']) {
                                echo '<a href="'.$event_detail['edition_url_flyer'].'" target="_blank" class="'.$button_class.'">Event Flyer</a>';                            
                            }
                            // RESULTS
                            if ($event_detail['edition_url_results']) {
                                echo '<a href="'.$event_detail['edition_url_results'].'" target="_blank" class="'.$button_class.'">Race Results</a>';                             
                            }
                         ?>
                        <!-- End-->
                    </div>
                    <div class="col-md-5 edition-logo">
                        <?php
                            if (strlen($event_detail['edition_logo'])>3) {
                                $img_url=base_url("uploads/admin/edition/".$event_detail['edition_id']."/".$event_detail['edition_logo']);
                                echo "<img src='$img_url' style='max-height: 250px; max-width: 400px;'>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details Page Right Float -->
    <div class="c-content-box c-size-sm">
        <div class="container">
            <div class="c-content-bar-2 c-opt-1">
                <div class="row" data-auto-height="true">
                    <div class="col-md-12">
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-client="ca-pub-8912238222537097"
                            data-ad-slot="2234707964"
                            data-ad-format="auto"></ins>
                       <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                       </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php
    if (strlen($event_detail['edition_entry_detail'])>10) {
    ?>
    <div class="c-content-box c-size-sm c-bg-grey-1">
        <div class="container">
            <div class="row">            
                <div class="col-md-12">
                    
                    <div class="c-content-title-1 ">
                        <h3 class="c-font-uppercase c-font-bold">
                            Entries Information
                        </h3>
                    </div>
                    <?php
                        echo $event_detail['edition_entry_detail'];
                    ?>
                </div>
<!--                <div class="col-md-6">
                 Details Entries 
                    <ins class="adsbygoogle"
                         style="display:block"
                         data-ad-client="ca-pub-8912238222537097"
                         data-ad-slot="3291345169"
                         data-ad-format="auto"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>-->
            </div>
        </div>
    </div>
    <?php
        $box_color='';
    } else {
        $box_color='c-bg-grey-1';
    }
    
    
    // START RACES
        foreach ($event_detail['race_list'] as $race_id=>$race) {
            
            if ($race['race_date']>0) {
                $race_date=fdateHuman($race['race_date']);
            } else {
                $race_date=fdateHuman($race['edition_date']);
            }
            
            ?>
            <div class="c-content-box c-size-sm <?=$box_color;?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="c-content-title-1 c-title-pricing-1">
                                <h3 class="c-font-uppercase c-font-bold">
                                    <?php
                                        if (!empty($race['race_name'])) {
                                            echo $race['race_name'];
                                        } else {
                                            echo fraceDistance($race['race_distance']);
                                            echo " ".$race['racetype_name']."</h3>";                                            
                                        }
                                    ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="c-content-pricing-1 c-opt-1">
                            <div class="col-md-3 c-sm-hidden">
                                <div class="c-content c-column-odd c-padding-adjustment">
                                    <div class="c-row c-title c-font-19">Date</div>
                                    <div class="c-row c-title c-font-19">Start Time</div>
                                    <?php
                                        if ($race['race_time_end']>0) {
                                    ?>
                                    <div class="c-row c-title c-font-19">Cut-off Time</div>
                                    <?php
                                        }
                                    ?>
                                    <div class="c-row c-title c-font-19">Distance</div>
                                    <div class="c-row c-title c-font-19">Race Type</div>
                                     <?php
                                        if ($race['race_fee_flat']>0) {
                                            echo '<div class="c-row c-title c-font-19">Race fee</div>';
                                        }
                                        else 
                                        {
                                            if ($race['race_fee_senior_licenced']>0) {
                                                echo '<div class="c-row c-title c-font-19">Licenced Athlete</div>';
                                            }
                                            if ($race['race_fee_senior_unlicenced']>0) {
                                                echo '<div class="c-row c-title c-font-19">Unlicenced Athlete</div>';
                                            }
                                            if ($race['race_fee_junior_licenced']>0) {
                                                echo '<div class="c-row c-title c-font-19">Licenced Junior</div>';
                                            }
                                            if ($race['race_fee_junior_unlicenced']>0) {
                                                echo '<div class="c-row c-title c-font-19">Unicenced Junior</div>';
                                        
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="c-content c-column-even c-padding-adjustment">
                                    <div class="c-row c-font-19">
                                        <span class="c-sub-title">Date: </span> 
                                        <span class="c-font-19 c-font-bold"><?=$race_date?></span>
                                    </div>
                                    <div class="c-row c-font-19">
                                        <span class="c-sub-title">Start Time: </span> 
                                        <span class="c-font-19 c-font-bold"><?=ftimeSort($race['race_time_start']);?></span>
                                    </div>
                                    <?php
                                        if ($race['race_time_end']>0) {
                                    ?>
                                    <div class="c-row c-font-19">
                                        <span class="c-sub-title">Cut-off Time: </span> 
                                        <span class="c-font-19 c-font-bold"><?=ftimeSort($race['race_time_end']);?></span>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="c-row c-font-19">
                                        <span class="c-sub-title">Distance: </span>
                                        <span class="c-font-19 c-font-bold"><?=fraceDistance($race['race_distance']);?></span>
                                </div>
                                    <div class="c-row c-font-19">
                                        <span class="c-sub-title">Race Type: </span> 
                                        <span class="c-font-19 c-font-bold"><?=$race['racetype_name'];?></span>
                                    </div>
                                    <?php                                    
                                        if ($race['race_fee_flat']>0) {
                                            echo '<div class="c-row c-price">';
                                            echo '<span class="c-sub-title">Race fee: </span>';
                                            echo '<span class="c-dollar c-font-19">R</span>';
                                            echo '<span class="c-font-19 c-font-bold">';
                                            echo $race['race_fee_flat']+0;
                                            echo '</span></div>';
                                        }
                                        else 
                                        {
                                        if ($race['race_fee_senior_licenced']>0) {
                                    ?>
                                    <div class="c-row c-price">
                                        <span class="c-sub-title">Licenced Athlete: </span> 
                                        <span class="c-dollar c-font-19">R</span>
                                        <span class="c-font-19 c-font-bold"><?=$race['race_fee_senior_licenced']+0;?></span>
                                    </div>
                                    <?php
                                        }
                                        if ($race['race_fee_senior_unlicenced']>0) {
                                    ?>
                                    <div class="c-row c-price">
                                        <span class="c-sub-title">Unlicenced Athlete: </span> 
                                        <span class="c-dollar c-font-19">R</span>
                                        <span class="c-font-19 c-font-bold"><?=$race['race_fee_senior_unlicenced']+0;?></span>
                                    </div>
                                    <?php
                                        }
                                        if ($race['race_fee_junior_licenced']>0) {
                                    ?>
                                    <div class="c-row c-price">
                                        <span class="c-sub-title">Licenced Junior: </span> 
                                        <span class="c-dollar c-font-19">R</span>
                                        <span class="c-font-19 c-font-bold"><?=$race['race_fee_junior_licenced']+0;?></span>
                                    </div>
                                    <?php
                                        }
                                        if ($race['race_fee_junior_unlicenced']>0) {
                                    ?>
                                    <div class="c-row c-price">
                                        <span class="c-sub-title">Unlicenced Junior: </span> 
                                        <span class="c-dollar c-font-19">R</span>
                                        <span class="c-font-19 c-font-bold"><?=$race['race_fee_junior_unlicenced']+0;?></span>
                                    </div>
                                    <?php
                                        }
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="col-md-6 c-sm-hidden">
                                <div class="row">
                                    <div class="col-md-3 c-md-hidden"></div>
                                    <div class="col-md-6">
                                        <div class="c-content-v-center c-bg-<?=$race['race_color'];?>" data-height="height" style="height: 100px;">
                                            <div class="c-wrapper">
                                                <div class="c-body">
                                                    <h1 class="c-font-white c-font-bold c-font-uppercase c-font-center"><?=fraceDistance($race['race_distance']);?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="c-content-v-center c-bg-grey-3" data-height="height" style="height: 100px;">
                                            <div class="c-wrapper">
                                                <div class="c-body">
                                                    <h1 class="c-font-white c-font-bold c-font-uppercase c-font-center" title="<?=$race['racetype_name'];?>"><?=$race['racetype_abbr'];?></h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-9 c-margin-t-20">
                                        <?=$race['race_notes'];?>
                                    </div>
                                </div>
                            </div>
                            
                           

                        </div>
                    </div>
                    
                     
                    <div class="row">
                        <div class="c-content-pricing-1 c-opt-1">
                            <div class="col-md-12 c-lg-hidden">
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 10px;">
                                        <?=$race['race_notes'];?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    // NEXT AND PREVIOUS BUTTONS
                    
                        $button_class="btn btn-md c-btn-border-2x c-btn-square btn-theme c-btn-uppercase c-btn-bold c-margin-t-20";
                    ?>
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?php
                            if ($prev_race_list[$race_id]) {
                                echo '<a href="'.$prev_race_list[$race_id]['url'].'" title="'.$prev_race_list[$race_id]['edition_name'].'" class="'.$button_class.' btn-default previous-btn"><i class="fa fa-angle-left"></i> Previous '.intval($prev_race_list[$race_id]['race_distance']).'k</a>';  
                            }
                            ?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="c-pull-right">
                            <?php
                            if ($next_race_list[$race_id]) {
                                echo '<a href="'.$next_race_list[$race_id]['url'].'" title="'.$next_race_list[$race_id]['edition_name'].'" class="'.$button_class.' btn-default next-btn">Next '.intval($prev_race_list[$race_id]['race_distance']).'k <i class="fa fa-angle-right"></i></a>';   
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>  
            <?php
            if ($box_color=="c-bg-grey-1") { $box_color=''; } else { $box_color="c-bg-grey-1"; }
        }
        
        
        
    if (strlen($event_detail['edition_description'])>10) {
    ?>
    <div class="c-content-box c-size-sm <?=$box_color;?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="c-content-title-1 ">
                        <h3 class="c-font-uppercase c-font-bold">
                            General Information
                        </h3>
                    </div>
                    <?php
                        echo $event_detail['edition_description'];
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($box_color=="c-bg-grey-1") { $box_color=''; } else { $box_color="c-bg-grey-1"; }    
    }
    
    
    ?>
    <!-- Details Page Right Float -->
    <div class="c-content-box c-size-sm <?=$box_color;?>">
        <div class="container">
            <div class="c-content-bar-2 c-opt-1">
                <div class="row" data-auto-height="true">
                    <div class="col-md-12">
                        <ins class="adsbygoogle"
                            style="display:block"
                            data-ad-client="ca-pub-8912238222537097"
                            data-ad-slot="2234707964"
                            data-ad-format="auto"></ins>
                       <script>
                       (adsbygoogle = window.adsbygoogle || []).push({});
                       </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
       
    <?php
    if ($box_color=="c-bg-grey-1") { $box_color=''; } else { $box_color="c-bg-grey-1"; }
    
    ?>
    <div class="c-content-box c-size-sm <?=$box_color;?>">
        <div class="container">
            <div class="c-content-bar-2 c-opt-1">
                <div class="row" data-auto-height="true">
                    <div class="col-md-6">
                        <p>
                            <a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold" href="/event">
                            <i class="icon-arrow-left"></i> Back to Events Calendar</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
//        wts($next_race_list);
//        wts($event_detail);
    ?>
    
</div>
<!-- END: PAGE CONTAINER -->

<?php
    echo $structured_data;
?>