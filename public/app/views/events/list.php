<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <!-- BEGIN: LAYOUT/BREADCRUMBS/BREADCRUMBS-1 -->
    <div class="c-layout-breadcrumbs-1 c-fonts-uppercase c-fonts-bold">
        <div class="container">
            <div class="c-page-title c-pull-left">
                <h3 class="c-font-uppercase c-font-sbold">List all Events</h3>
            </div>
            <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
                <li>
                    <a href="/events">Events</a>
                </li>
                <li>/</li>
                <li>
                    <a href="/">Home</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-1 -->

    <!-- BEGIN: PAGE CONTENT -->

    <!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">

            <div class="row">
                <?php
                if ($race_summary) {
                    foreach ($race_summary as $month=>$edition_list) {
                        ?>
                        <div class="c-content-title-1">
                            <h3 class="c-center c-font-dark c-font-uppercase">Races in <?=$month;?></h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Place</th>
                                        <th>Race Distances</th>
                                        <th>Time of Day</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($edition_list as $edition_id=>$edition) {
                                            echo "<tr>";
                                                echo "<th scope='row'>".$edition['edition_date']."</th>";
                                                echo "<td>".$edition['edition_name']."</td>";
                                                echo "<td>".$edition['town_name']."</td>";
                                                echo "<td>".$edition['race_distance']."</td>";
                                                echo "<td>".$edition['race_time']."</td>";
                                            echo "</tr>";
                                        }
                                     ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="c-content-title-1">
                        <h3 class="c-center c-font-dark c-font-uppercase">Event Information</h3>
                        <div class="c-line-center c-theme-bg"></div>
                    </div>
                    <p>There is currently no event data to display. Please chack back again shortly.</p>
                    <?php
                }
                ?>
                <p><a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round" href="/">
                    <i class="icon-home"></i> Home</a></p>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
