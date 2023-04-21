<li class="mt-3 mb-1 nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-wpforms"></i> Data Collection</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url("xlsform-subject") }}"><i class="la la-tags nav-icon"></i> Form Subjects</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url("xlsform-template") }}"><i class="la la-wpforms nav-icon"></i> Form Templates</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('team') }}"><i class="nav-icon las la-users"></i> Teams</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url("xlsform") }}"><i class="la la-wpforms nav-icon"></i> Team Forms</a></li>
        <li class='nav-item'><a class="nav-link" href='{{ backpack_url('submission') }}'><i class='nav-icon la la-clipboard-check'></i> Submissions</a></li>
    </ul>
</li>


<li class="mt-3 mb-1 nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user-cog"></i> User<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Management</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('invite') }}'><i class='nav-icon las la-user-plus'></i> Invites</a></li>
    </ul>
</li>