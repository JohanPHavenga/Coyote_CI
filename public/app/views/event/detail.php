<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <!-- BEGIN: LAYOUT/BREADCRUMBS/BREADCRUMBS-1 -->
    <div class="c-layout-breadcrumbs-1 c-fonts-uppercase c-fonts-bold">
        <div class="container">
            <div class="c-page-title c-pull-left">
                <h3 class="c-font-uppercase c-font-sbold"><?=$event_detail['edition_name'];?></h3>
            </div>
            <ul class="c-page-breadcrumbs c-theme-nav c-pull-right c-fonts-regular">
                <li>
                    <a href="/event/calendar"><?=$event_detail['edition_name'];?></a>
                </li>
                <li>/</li>
                <li>
                    <a href="/event/calendar">Events</a>
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
                    wts($event_detail);
                ?>

                <p>
                    <a class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-round" href="/event">
                    <i class="icon-calendar"></i> Events Calendar</a>
                </p>
            </div>

        </div>
    </div>
    <!-- END: CONTENT/FEATURES/FEATURES-1 -->

    <!-- END: PAGE CONTENT -->
</div>
<!-- END: PAGE CONTAINER -->
