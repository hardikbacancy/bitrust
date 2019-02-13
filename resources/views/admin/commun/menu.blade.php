<?php $r = \Route::current()->getAction() ?>
<?php $route = (isset($r['as'])) ? $r['as'] : ''; ?>

<ul class="sidebar-menu">
    <li class="header">MENU</li>

    <li class="<?php echo (starts_with($route, ADMIN . '.dash')) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.dash') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->hasRole('Superadmin|Admin'))
        <li class="<?php echo (starts_with($route, ADMIN . '.users')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.users.index') }}">
                <i class="fa fa-users"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="<?php echo (starts_with($route, ADMIN . '.pending_users')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.pending_users.index') }}">
                <i class="fa fa-users"></i>
                <span>Unapprove Users</span>
            </a>
        </li>
    @endif

    @if (auth()->user()->hasRole('Superadmin|Admin'))
        <li class="<?php  echo (starts_with($route, ADMIN . '.membership')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.membership') }}"><i class="fa fa-money"></i><span>Membership</span></a>
        </li>
    @else
        <li class="<?php  echo (starts_with($route, ADMIN . '.membership')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.membership.membership_details',\Auth::user()->id) }}"><i class="fa fa-money"></i><span>Membership</span></a>
        </li>
    @endif


    <li class="<?php echo (starts_with($route, ADMIN . '.loan_request')) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.loan_request.index') }}">
            <i class="fa fa-list"></i>
            <span>Loan Request</span>
        </a>
    </li>


    @if (auth()->user()->hasRole('Superadmin|Admin'))
        <li class="<?php echo (starts_with($route, ADMIN . '.expense')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.expense') }}"><i class="fa fa-money"></i><span>Expense</span></a>
        </li>


        <li class="<?php echo (starts_with($route, ADMIN . '.adminsettings')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.adminsettings.index') }}"><i class="fa fa-cog"></i><span>Settings</span></a>
        </li>

        <li class="<?php  echo (starts_with($route, ADMIN . '.report')) ? "active" : '' ?>">
            <a href="{{ route(ADMIN.'.report.report') }}"><i class="fa fa-flag-o"></i><span>Report</span></a>
        </li>


        {{--<li class="<?php  echo (starts_with($route, ADMIN . '.import')) ? "active" : '' ?>">--}}
            {{--<a href="{{ route(ADMIN.'.import') }}"><i class="fa fa-upload"></i><span>Import</span></a>--}}
        {{--</li>--}}

    @endif
</ul>
