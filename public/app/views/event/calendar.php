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
                echo $race_list_html;
                ?>
                <p><a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round" href="/">
                <i class="icon-home"></i> Home</a></p>
        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
