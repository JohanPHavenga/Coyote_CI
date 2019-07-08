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
                    </form><br>
                    <style>.bmc-button img{width: 27px !important;margin-bottom: 1px !important;box-shadow: none !important;border: none !important;vertical-align: middle !important;}.bmc-button{line-height: 36px !important;height:37px !important;text-decoration: none !important;display:inline-flex !important;color:#000000 !important;background-color:#FFFFFF !important;border-radius: 3px !important;border: 1px solid transparent !important;padding: 1px 9px !important;font-size: 22px !important;letter-spacing: 0.6px !important;box-shadow: 0px 1px 2px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;margin: 0 auto !important;font-family:'Cookie', cursive !important;-webkit-box-sizing: border-box !important;box-sizing: border-box !important;-o-transition: 0.3s all linear !important;-webkit-transition: 0.3s all linear !important;-moz-transition: 0.3s all linear !important;-ms-transition: 0.3s all linear !important;transition: 0.3s all linear !important;}.bmc-button:hover, .bmc-button:active, .bmc-button:focus {-webkit-box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;text-decoration: none !important;box-shadow: 0px 1px 2px 2px rgba(190, 190, 190, 0.5) !important;opacity: 0.85 !important;color:#000000 !important;}</style><link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet"><a class="bmc-button" target="_blank" href="https://www.buymeacoffee.com/roadrunning"><img src="https://bmc-cdn.nyc3.digitaloceanspaces.com/BMC-button-images/BMC-btn-logo.svg" alt="Buy me a coffee"><span style="margin-left:5px">Buy me a coffee</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

