<?php $r = \Route::current()->getAction() ?>
<?php $route = (isset($r['as'])) ? $r['as'] : ''; ?>

<ul class="sidebar-menu">
    <li class="header">MENU</li>

    <li class="<?php echo ( starts_with($route, ADMIN.'.dash') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.dash') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->hasRole('Superadmin|Admin'))
    <li class="<?php echo ( starts_with($route, ADMIN.'.users') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.users.index') }}">
            <i class="fa fa-users"></i>
            <span>Users</span>
        </a>
    </li>
    @endif

    <li class="<?php echo ( starts_with($route, ADMIN.'.loan_request') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.loan_request.index') }}">
            <i class="fa fa-list"></i>
            <span>Loan Request</span>
        </a>
    </li>


    @if (auth()->user()->hasRole('Superadmin|Admin'))

    <li class="<?php echo ( starts_with($route, ADMIN.'.adminsettings') ) ? "active" : '' ?>">
        <a href="{{ route(ADMIN.'.adminsettings.index') }}"><i class="fa fa-cog"></i>Settings</a>
    </li>
        <li class="<?php echo ( starts_with($route, ADMIN.'.export') ) ? "active" : '' ?>">
            <a href="/admin/report"><i class="fa fa-cog"></i>Report</a>
        </li>
    @endif


</ul>
