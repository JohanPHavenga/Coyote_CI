<div class="top-menu hidden-xs">
    <ul class="nav navbar-nav pull-right">

        <!-- BEGIN USER LOGIN DROPDOWN -->
        <li class="dropdown dropdown-user dropdown-dark">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="username username-hide-mobile"><?= $this->session->admin_user['user_name']; ?> <span class="caret"></span></span> 
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="<?=$this->profile_url;?>">
                        <i class="icon-user"></i> My Profile </a>
                </li>
                <li>
                    <a href="<?=$this->logout_url;?>">
                        <i class="icon-key"></i> Log Out </a>
                </li>
            </ul>
        </li>
    </ul>
</div>