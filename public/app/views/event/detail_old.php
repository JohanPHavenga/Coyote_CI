<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>
    <!-- BEGIN: PAGE CONTENT -->

    <!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">

            <?= $notice; ?>

            <div class="c-shop-product-details-2">
                <div class="row">
                    <div class="col-md-6">
                        <div id="map" style="width: 100%; height: 500px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="c-product-meta">
                            <div class="c-content-title-1">
                                <h3 class="c-font-uppercase c-font-bold"><?= $event_detail['edition_name'];?></h3>
                                <div class="c-line-left"></div>
                            </div>
                            <!-- <div class="c-product-review">
                                <?= date("Y-m-d",strtotime($event_detail['edition_date']))." in ".$event_detail['town_name'];?>
                            </div>
                            <div class="c-product-price">$99.00</div>
                            <div class="c-product-short-desc"> Lorem ipsum dolor ut sit ame dolore adipiscing elit, sed nonumy nibh sed euismod laoreet dolore magna aliquarm erat volutpat Nostrud duis molestie at dolore. </div> -->
                            <div class="row c-product-variant">
                                <div class="col-sm-12 col-xs-12">
                                    <p class="c-product-margin-1 c-font-uppercase c-font-bold">Where:</p>
                                    <p><?=$event_detail['edition_address']."<br>".$event_detail['town_name'];?></p>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <p class="c-product-margin-1 c-font-uppercase c-font-bold">When:</p>
                                    <p><?= date("Y-m-d",strtotime($event_detail['edition_date']));?></p>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <p class="c-product-margin-1 c-font-uppercase c-font-bold">Races:</p>
                                    <?php
                                    foreach ($event_detail['race_list'] as $race) {
                                        echo "<p>";
                                        echo $race['race_name']." - ";
                                        echo $race['race_distance']+0;
                                        echo "km - start time: ";
                                        echo date("H:i",strtotime($race['race_time_start']));
                                        echo "</p>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="c-product-add-cart">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12 c-margin-t-20">
                                        <p>
                                            <?php
                                            if ($event_detail['edition_url']) {
                                            ?>
                                                <a class="btn c-theme-btn c-btn-border-2x c-btn-uppercase btn-sm c-btn-bold c-btn-round" target="_blank" href="<?=$event_detail['edition_url']?>">
                                                <i class="icon-share-alt"></i> View Event Website</a>
                                                <?php
                                                }
                                             ?>
                                         </p>
                                         <p>
                                            <a class="btn c-theme-btn c-btn-border-2x c-btn-uppercase btn-sm c-btn-bold c-btn-round" href="/event/ics/<?=$event_detail['edition_id'];?>">
                                            <i class="icon-cloud-download"></i> Download Calendar Reminder</a>
                                        </p>
                                         <p>
                                            <a class="btn c-theme-btn c-btn-border-2x c-btn-uppercase btn-sm c-btn-bold c-btn-round" href="/event">
                                            <i class="icon-calendar"></i> Back to Events Calendar</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        // wts($event_detail);
    ?>


    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->

<script>
  function initMap() {
    var myLatLng = {lat: <?= $event_detail['latitude_num'];?>, lng: <?= $event_detail['longitude_num'];?>};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 14,
      center: myLatLng
    });

    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      title: '<?= $event_detail['event_name'];?>'
    });
  }
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6v1yh3HTOju-2iQ1xyfoYcDqIoOw-078&callback=initMap">
</script>
