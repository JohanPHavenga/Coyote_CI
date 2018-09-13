<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

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
        echo "<div class='alert alert-$status' role='alert'><i class='fa fa-exclamation-circle'></i> ".$alert_msg."</div>";
        echo "</div></div></div>";
    }

    $heading_date=date("Y");
    if (date('m')>5) { $heading_date.="-".date("Y")-1; }
    ?>

    <!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">

            <div class="c-content-box c-size-md c-no-bottom-padding c-overflow-hide mobile-hide" style="padding: 0;">
                <div class="c-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="c-content-title-1">
                                <h3 class="c-font-34 c-font-center c-font-bold c-font-uppercase c-margin-b-30"> Road Running Race Event Calendar</h3>
                                <div class="c-line-center c-theme-bg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="c-content-tab-4 c-opt-5" role="tabpanel">
                <ul class="nav nav-justified" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#upcoming" role="tab" data-toggle="tab">Upcoming Races</a>
                    </li>
                    <li role="presentation">
                        <a href="#past" role="tab" data-toggle="tab">Past Races</a>
                    </li>
                </ul>
                <div class="c-content-box c-size-md c-no-bottom-padding c-overflow-hide" style="padding: 8px 0;">
                    <div class="c-container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="c-content-title-1">
                                <!-- Calendar Page Display Ad Only -->
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
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="upcoming">
                        <ul class="c-tab-items">
                            <li class="row">
                                <div class="col-md-12">
                                    <?=$upcoming_race_list_html;?>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="past">
                        <ul class="c-tab-items">
                            <li class="row">
                                <div class="col-md-12">
                                    <?=$past_race_list_html;?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            
            <div class="c-content-box c-size-md c-no-bottom-padding c-overflow-hide" style="padding: 8px 0;">
                <div class="c-container">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="c-content-title-1">
                            
                            <!-- Calendar Page Display Ad Only -->
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
            
            <div class="c-content-box c-size-md c-no-bottom-padding c-overflow-hide" >
                <div class="c-container">
                    <div class="row">
                        <div class="col-md-12">
                            <p><a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round" href="/">
                            <i class="icon-home"></i> Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
