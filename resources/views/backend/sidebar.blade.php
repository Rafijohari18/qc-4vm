@php
    $segment1 = Request::segment(1);
    $segment2 = Request::segment(2);
    $segment3 = Request::segment(3);
    $segment4 = Request::segment(4);
@endphp

<ul class="sidenav-inner py-1">

<!-- Dashboards -->
<li class="sidenav-item ">
  <a href="{{ route('dashboard') }}" class="sidenav-link"><i class="sidenav-icon ion ion-md-speedometer"></i>
    <div>Dashboard</div>
  </a>
</li>



<li class="sidenav-divider mb-1"></li>
<li class="sidenav-header small font-weight-semibold">ELEMENTS</li>

@can('data_master')
<li class="sidenav-item {{ ($segment1 == 'project' || $segment1 == 'jenis') ? 'open active' : '' }}">
    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-apps"></i>
        <div>Data Master</div>
    </a>

    <ul class="sidenav-menu">
        @can('jenis_project')
        <li class="sidenav-item {{ $segment1 == 'jenis' ? 'active' : '' }}">
            <a href="{{ route('jenis.project.index') }}" class="sidenav-link">
                <div>Jenis Project</div>
            </a>
        </li>
        @endcan
        @can('project')
        <li class="sidenav-item {{ $segment1 == 'project' ? 'active' : '' }}">
            <a href="{{ route('project.index') }}" class="sidenav-link">
                <div>Project</div>
            </a>
        </li>
        @endcan

    </ul>
</li>

@endcan



@can('list_project')

<li class="sidenav-item {{ $segment2 == 'project' ? 'active' : '' }}">
  <a href="{{ route('list.project.pic') }}" class="sidenav-link"><i class="sidenav-icon ion ion-ios-albums"></i>
    <div>List Project</div>
  </a>
</li>
@endcan

@can('report')

<li class="sidenav-item {{ ($segment1 == 'all' || $segment1 == 'my') ? 'open active' : '' }}">
    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-ios-paper"></i>
        <div>Report</div>
    </a>

    @can('all_report')
    <ul class="sidenav-menu">
        <li class="sidenav-item {{ $segment1 == 'all' ? 'active' : '' }}">
            <a href="{{ route('all.report') }}" class="sidenav-link">
                <div>All Report</div>
            </a>
        </li>
    @endcan

    @can('my_report') 
        <li class="sidenav-item {{ $segment1 == 'my' ? 'active' : '' }}">
            <a href="{{ route('my.report') }}" class="sidenav-link">
                <div>My Report</div>
            </a>
        </li>
    @endcan

    
    </ul>
</li>

@endcan

@can('user')
<li class="sidenav-item {{ ($segment1 == 'user' || $segment1 == 'roles' || $segment1 == 'permission' || $segment1 == 'role-has-permission') ? 'open active' : '' }}">
    <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-people"></i>
        <div>User Manager</div>
    </a>

    <ul class="sidenav-menu">
        <li class="sidenav-item {{ $segment1 == 'user' ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="sidenav-link">
                <div>Users</div>
            </a>
        </li>
        @can('roles')
        <li class="sidenav-item {{ $segment1 == 'roles' ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="sidenav-link">
                <div>Roles</div>
            </a>
        </li>
        @endcan

        @can('permission')

        <li class="sidenav-item {{ $segment1 == 'permission' ? 'active' : '' }}">
            <a href="{{ route('permission.index') }}" class="sidenav-link">
                <div>Permission</div>
            </a>
        </li>
        @endcan

        @can('role_has_permission')
        <li class="sidenav-item {{ $segment2 == 'role-has-permission' ? 'active' : '' }}">
            <a href="{{ route('role-has-permission.index') }}" class="sidenav-link">
                <div>Role Has Permission</div>
            </a>
        </li>
        @endcan

    </ul>
</li>
@endcan


</ul>