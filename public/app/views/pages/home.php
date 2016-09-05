There is no place like 127.0.0.1

<?php
    if ($this->session->has_userdata('user_logged_in')) {
        wts($this->session->user);
    }
