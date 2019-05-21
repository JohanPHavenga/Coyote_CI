<div class="c-content-box c-size-sm c-bg-dark">
    <div class="container">
        <div class="c-content-subscribe-form-1">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="c-title c-font-30 c-font-uppercase c-font-bold">Subscribe to this event</h3>
                    <div class="c-body c-font-16 c-font-uppercase c-font-sbold">Get an email in your inbox when information is updated for this event, entry opens, results are published and more</div>
                </div>
                <div class="col-sm-6">
                    <form action="<?=base_url("event/subscribe");?>" method="post">
                        <div class="input-group input-group-lg">
                            <input type="email" class="form-control input-lg" name="sub_email" placeholder="Your Email Here" value="<?=$rr_cookie['sub_email'];?>">
                            <input type="hidden" name="edition_id" value="<?=$event_detail['edition_id'];?>">
                            <span class="input-group-btn">
                                <button type="submit" class="btn c-theme-btn c-btn-uppercase btn-lg c-btn-bold c-btn-square">SUBSCRIBE</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
