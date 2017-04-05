<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>
    <!-- BEGIN: PAGE CONTENT -->

    <div class="c-content-box c-size-md ">
        <div class="container">
            <?php
                $n=0;
                foreach ($search_results as $month_list) {
                    foreach ($month_list as $id=>$event) {
                        $n++;
                        if ($n==1) { echo '<div class="row">'; }
                        $rand= rand(1, 8);
                        ?>
                        <div class="col-md-6">
                            <div class="row c-margin-b-40">
                                <div class="c-content-product-2 c-bg-white">
                                    <div class="col-md-4">
                                        <div class="c-content-overlay">
                                            <!--<div class="c-label c-label-right c-theme-bg c-font-uppercase c-font-white c-font-13 c-font-bold">New</div>-->
                                            <div class="c-overlay-wrapper">
                                                <div class="c-overlay-content">
                                                    <a href="<?=base_url($event['edition_url']);?>" class="btn btn-md c-btn-grey-1 c-btn-uppercase c-btn-bold c-btn-border-1x c-btn-square">Detail</a>
                                                </div>
                                            </div>
                                            <div class="c-bg-img-center c-overlay-object" data-height="height" style="height: 230px; background-image: url(img/events/generic/<?=$rand;?>.jpg);"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="c-info-list">
                                            <h3 class="c-title c-font-bold c-font-22 c-font-dark">
                                                <a class="c-theme-link" href="<?=base_url($event['edition_url']);?>"><?= substr($event['edition_name'],0,-5);?></a>
                                            </h3>
                                            <p class="c-desc c-font-16 c-font-thin">
                                                <?=$event['town_name'];?><br>
                                                <?=$event['race_distance'];?><br>
                                                <?=$event['race_time_start'];?> Race
                                            </p>
                                            <p class="c-price c-font-26 c-font-thin"><?=$event['edition_date'];?></p>
                                        </div>
                                        <div>
                                            <a href="<?=base_url($event['edition_url']);?>" class="btn c-theme-btn c-btn-border-2x c-btn-square"> Detail </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php                        
                        if ($n==2) { echo '</div>'; $n=0; }                        
                    }
                }
            ?>
        </div>
    </div>


    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
