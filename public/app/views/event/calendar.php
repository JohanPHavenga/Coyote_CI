<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>
    <!-- BEGIN: PAGE CONTENT -->

    <?php
    // alert message on top of the page
    // set flashdata [alert|status]
    if($this->session->flashdata('alert'))
    {
        $alert_msg=$this->session->flashdata('alert');
        if ( ! ($this->session->flashdata('status')))
        {
            $status='warning';
        }
        else
        {
            $status=$this->session->flashdata('status');
        }
        echo "<div class='c-content-box c-size-sm' style='padding-bottom: 0;'>";
        echo "<div class='container'><div class='row'>";
        echo "<div class='alert alert-$status' role='alert'>$alert_msg</div>";
        echo "</div></div></div>";
    }
    ?>

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
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Place</th>
                                        <th>Race Distances</th>
                                        <th>Time of Day</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach ($edition_list as $edition_id=>$edition) {
                                            echo "<tr>";
                                                echo "<th scope='row'><a href='".$edition['edition_url']."'>".$edition['edition_date']."</a></th>";
                                                echo "<td>".$edition['edition_name']."</td>";
                                                echo "<td>".$edition['town_name']."</td>";
                                                echo "<td>".$edition['race_distance']."</td>";
                                                echo "<td>".$edition['race_time']."</td>";
                                                echo "<td style='padding: 2px; text-align: center;'><a href='".$edition['edition_url']."' class='btn c-theme-btn c-btn-border-2x c-btn-square'>DETAIL</a></td>";
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
