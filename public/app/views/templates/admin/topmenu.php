<ul class="nav navbar-nav">
    <li class="menu-dropdown classic-menu-dropdown ">
        <a href="javascript:;"> Dashboard 
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class="">
                <a href="/admin" class="nav-link"> Home </a>
            </li>
        </ul>
    </li>
    <li class="menu-dropdown classic-menu-dropdown ">
        <a href="javascript:;"> Manage Events 
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class=""><a href="/admin/event" class="nav-link">Events</a></li>
            <li class=""><a href="/admin/edition" class="nav-link">Editions</a></li>
            <li class=""><a href="/admin/race" class="nav-link">Races</a></li>
        </ul>
    </li>
    <li class="menu-dropdown classic-menu-dropdown ">
        <a href="javascript:;"> Manage Users 
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class=""><a href="/admin/user" class="nav-link">Users</a></li>
            <li class=""><a href="/admin/entry" class="nav-link">Entries</a></li>
            <li class=""><a href="/admin/asanumber" class="nav-link">ASA Numbers</a></li>
        </ul>
    </li>
    <li class="menu-dropdown classic-menu-dropdown ">
        <a href="javascript:;"> Manage Clubs 
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class=""><a href="/admin/club" class="nav-link">Clubs</a></li>
        </ul>
    </li>
    <li class="menu-dropdown classic-menu-dropdown ">
        <a href="javascript:;"> Static Info 
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class=""><a href="/admin/sponsor" class="nav-link">Sponsors</a></li>
            <li class=""><a href="/admin/role" class="nav-link">Roles</a></li>
            <li class=""><a href="/admin/province" class="nav-link">Provinces</a></li>
            <li class=""><a href="/admin/town" class="nav-link">Towns</a></li>
        </ul>
    </li>
    <!-- profile menu for small devices -->
    <li class="menu-dropdown classic-menu-dropdown visible-xs-block">
        <a href="javascript:;"> Profile
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu pull-left">
            <li class=" ">
                <a href="<?=$this->profile_url;?>" class="nav-link  "> My Profile </a>
            </li>
            <li class=" ">
                <a href="<?=$this->logout_url;?>" class="nav-link  "> Log Out </a>
            </li>
        </ul>
    </li>
</ul>