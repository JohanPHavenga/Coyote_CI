<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>
    <!-- END: LAYOUT/BREADCRUMBS/BREADCRUMBS-1 -->

    <!-- BEGIN: PAGE CONTENT -->

    <!-- BEGIN: CONTENT/FEATURES/FEATURES-1 -->
    <div class="c-content-box c-size-md c-bg-white">
        <div class="container">

            <div class="row">
                <div class="c-content-title-1">
                    <h3 class="c-center c-font-dark c-font-uppercase">Sorry!</h3>
                    <div class="c-line-center c-theme-bg"></div>
                </div>
                <div class="c-center">
                    <?php
                    if ($this->session->flashdata('alert')) {
                        $alert_msg = $this->session->flashdata('alert');
                        $status = $this->session->flashdata('status');
                        
                        echo "<div class='alert alert-$status alert-dismissible' role='alert'>"
                                . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'
                                . "$alert_msg"
                                . "</div>";
                        
                    }
                    ?>
                    <p>The page you are looking for could not be found.<br>Please try again.</p>
                    <p>&nbsp;</p>
                    <p><a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round" href="/">
                        <i class="icon-home"></i> Home</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
