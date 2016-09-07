<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-edit font-dark"></i>
                    <span class="caption-subject font-dark bold uppercase">Dump</span>
                </div>
            </div>
            <div class="portlet-body">
                <p>There is no place like ADMIN 127.0.0.1</p>
                <?php
                    if ($this->session->has_userdata('admin_logged_in')) {
                        wts($this->session->admin_user);
                    }
                ?>
            </div>
        </div>
    </div>
</div>