There is no place like ADMIN 127.0.0.1

<?php
    if ($this->session->has_userdata('admin_logged_in')) {
        wts($this->session->admin_user);
    }