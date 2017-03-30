<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">

    <div class="c-content-box c-size-md c-bg-img-top c-no-padding c-pos-relative">
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
                                    <?= $event_detail['summary']['race_time']; ?> Race<br>
                                </p>
                            </div>
                            <div class="c-section">
                                <div class="c-content-label c-font-uppercase c-font-bold c-theme-bg">Entries</div>
                                <p>                                    
                                    <?php
                                        if ($event_detail['edition_url']) {
                                            $url_segments=parse_url($event_detail['edition_url']);
                                    ?>
                                    <a href="<?=$event_detail['edition_url'];?>" target="_blank"><?=$url_segments['host'];?></a><br>
                                    <?php
                                        }
                                        if (isset($event_detail['user_email'])) {
                                            $contact_email=$event_detail['user_email'];
                                        } else {
                                            $contact_email="info@roadrunning.co.za";
                                        }
                                    ?>
                                    <a href="mailto:<?=$contact_email;?>?subject=Race info enquiry from roadrunning.co.za"><?=$contact_email;?></a>
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
<!--                                    <li>
                                        <a href="#" title=""View event facebook page">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" title=""View race information">
                                            <i class="fa fa-info"></i>
                                        </a>
                                    </li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="gmapbg" class="c-content-contact-1-gmap" style="height: 630px;"></div>
    </div>
    
    <div class="c-content-box c-size-md c-bg-grey-1" style="clear: all;">
        <div class="container">
            
            <?= $notice; ?>
            
            <div class="c-content-bar-2 c-opt-1">
                <div class="row" data-auto-height="true">
                    <div class="col-md-12">
                        <!-- Begin: Title 1 component -->
                        <div class="c-content-title-1" data-height="height" style="height: 167px;">
                            <h3 class="c-font-uppercase c-font-bold"><?=$event_detail['edition_name'];?></h3>
                            <p class="c-font-uppercase c-font-sbold"> Annual <?=$event_detail['event_name'];?> <br><?=$event_detail['summary']['race_distance'];?> </p>
                            <?php
                                if ($event_detail['edition_url']) {
                                ?>
                                <a href="<?=$event_detail['edition_url'];?>" class="btn btn-md c-btn-border-2x c-btn-square c-theme-btn c-btn-uppercase c-btn-bold">Enter Now</a>
                                <?php
                                }
                            ?>
                        </div>
                        <!-- End-->
                    </div>
<!--                    <div class="col-md-6">
                        <div class="c-content-v-center"">
                            <img src="../img/events/tyger_walk_run.jpg" style="max-width: 500px"/>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    
    
    <?php
        $box_color='';
        foreach ($event_detail['race_list'] as $race) {
            ?>
            <div class="c-content-box c-size-md <?=$box_color;?>">
                <div class="container">
                    <div class="c-content-bar-2 c-opt-1">
                        <div class="row" data-auto-height="true">
                            <div class="col-md-6">
                                <!-- Begin: Title 1 component -->
                                <div class="c-content-title-1" data-height="height" style="height: 167px;">
                                    <h3 class="c-font-uppercase c-font-sbold"><?=$race['race_distance']+0;?>km Race</h3>
                                    <p class="c-font"> Start time: <?=ftimeSort($race['race_time']);?></p>
                                </div>
                                <!-- End-->
                            </div>
                            <div class="col-md-6">
                                <div class="c-content-v-center"">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($box_color=="c-bg-grey-1") { $box_color=''; } else { $box_color="c-bg-grey-1"; }
        }
    ?>
    
    <div class="c-content-box c-size-md <?=$box_color;?>">
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
        wts($event_detail);
    ?>
    
</div>
<!-- END: PAGE CONTAINER -->