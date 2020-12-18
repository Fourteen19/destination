{{--
@canany(['dashboard-stats-view'], 'admin')
    <p>Show dashboard stats!</p>
@endcanany
--}}


<div class="row row-cols-1 row-cols-md-3 mydir-dashboard">
  
@role('System Administrator')
<div class="col mb-4">
    <div class="card h-100">
        <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-tag mr-3"></i> Roles</h5></div>
      <div class="card-body">
            <ul class="card-text list-unstyled">
            @can('role-list', 'admin')
                <li><a href="{{ route('admin.roles.index') }}">Manage Roles</a></li>
            @endcan
            </ul>   
      </div>
    </div>

</div>
@endrole

@canany(['profile-edit'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-edit mr-3"></i> Your profile</h5></div>
    <div class="card-body">
       <ul class="card-text list-unstyled">
        <li><a href="">Edit my profile</a></li>
        </ul>
      </div>
    </div>
</div>
@endcanany

@canany(['admin-list', 'admin-create', 'admin-logs-view'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-cog mr-3"></i> Manage System Administrators</h5></div>
      <div class="card-body">
        
        
            <ul class="card-text list-unstyled">
            @can('admin-list', 'admin')
                <li><a href="{{ route('admin.admins.index') }}">Manage Admin Users</a></li>
            @endcan
            @can('admin-create', 'admin')
                <li><a href="{{ route('admin.admins.create') }}">Add admin user</a></li>
            @endcan
            @can('admin-logs-view', 'admin')
                <li><a href="">View admin logs</a></li>
            @endcan
            </ul>
      
      </div>
    </div>

</div>
@endcanany

@role('Client Admin')
    @canany(['institution-list', 'institution-create'], 'admin')
    <div class="col mb-4">
        <div class="card h-100">
        <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-cog mr-3"></i> Manage Institutions</h5></div>
            <div class="card-body">
                
                
                    <ul class="card-text list-unstyled">
                        @can('admin-list', 'admin')
                        <li><a href="{{ route('admin.admins.index') }}">Manage institutions</a></li>
                        @endcan
                        @can('institution-create', 'admin')
                        <li><a href="{{ route('admin.admins.create') }}">Add institution</a></li>
                        @endcan
                    </ul>
            
            </div>
        </div>
    </div>
    @endcanany
@endrole


@canany(['client-list', 'client-create'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-tie mr-3"></i> Clients</h5></div>
        <div class="card-body">
            
            <ul class="card-text list-unstyled">
            @can('client-list')
                <li><a href="{{ route('admin.clients.index') }}">Manage Clients</a></li>
            @endcan
            @can('client-create')
                <li><a href="{{ route('admin.clients.create') }}">Create a client</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['tag-list'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-tags mr-3"></i> Global data tags</h5></div>
        <div class="card-body">
            
            <ul class="card-text list-unstyled">
            {{--<li><a href="{{ route('admin.contents.index') }}">Manage (global) data tags</a></li>--}}
            <li><a href="{{ route('admin.clients.index') }}">Sectors</a></li>
            <li><a href="{{ route('admin.clients.index') }}">Routes</a></li>
            {{--<li><a href="{{ route('admin.clients.index') }}">Terms</a></li>--}}
            <li><a href="{{ route('admin.tags.subjects.index') }}">Subjects</a></li>
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['global-content-list', 'global-content-create'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-globe mr-3"></i> Global Content</h5></div>
        <div class="card-body">
           
            <ul class="card-text list-unstyled">
            @can('global-content-list')
                <li><a href="{{ route('admin.contents.index') }}">Manage global content</a></li>
            @endcan
            @can('global-content-create')
                <li><a href="{{ route('admin.contents.create') }}">Add global content</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany
 
@canany(['static-content-edit'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-th-large mr-3"></i> Static Content</h5></div>
        <div class="card-body">
            <ul class="card-text list-unstyled">
            <li><a href="">Edit static content elements</a></li>
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['global-config-edit'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-wrench mr-3"></i> Global configuration / settings</h5></div>
        <div class="card-body">
            <ul class="card-text list-unstyled">
            <li><a href="">Edit settings</a></li>
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['user-list', 'user-create', 'user-import', 'user-export',], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-users mr-3"></i> Users</h5></div>
        <div class="card-body">
            
            <ul class="card-text list-unstyled">
            @can('user-list')
                <li><a href="{{ route('admin.users.index') }}">Manage users</a></li>
            @endcan
            @can('user-create')
                <li><a href="{{ route('admin.users.create') }}">Add user</a></li>
            @endcan
            @can('user-import')
                <li><a href="">Import user</a></li>
            @endcan
            @can('user-export')
                <li><a href="">Export user</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['report-list'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-chart-line mr-3"></i> Reports</h5></div>
        <div class="card-body">
            
            <ul class="card-text list-unstyled">
            <li><a href="">User Reports</a></li>
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['client-content-list', 'client-content-create', 'client-tag-list'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-newspaper mr-3"></i> Client content</h5></div>
        <div class="card-body">
           
            <ul class="card-text list-unstyled">
            @can('client-content-list')
                <li><a href="">Manage client content</a></li>
            @endcan
            @can('client-content-create')
                <li><a href="">Add client content</a></li>
            @endcan
            @can('client-tag-list')
                <li><a href="">Client data tag</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany


@canany(['vacancy-list', 'vacancy-create'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-briefcase mr-3"></i> Vacancies</h5></div>
        <div class="card-body">
           
            <ul class="card-text list-unstyled">
            @can('vacancy-list')
                <li><a href="">Manage Vacancies</a></li>
            @endcan
            @can('vacancy-create')
                <li><a href="">Add Vacancy</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['event-list', 'event-create'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-calendar-alt mr-3"></i> Events</h5></div>
        <div class="card-body">
            
            <ul class="card-text list-unstyled">
            @can('event-list')
                <li><a href="">Manage Events</a></li>
            @endcan
            @can('event-create')
                <li><a href="">Add Event</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

</div>


{{-- 
@role('System Administrator')
<ul>
    <li>Manage Roles</li>
    @can('role-list', 'admin')
        <li><a href="{{ route('admin.roles.index') }}">Manage Roles</a></li>
    @endcan
</ul>
@endrole


@canany(['profile-edit'], 'admin')
<ul>
    <li><a href="">Edit my profile</a></li>
</ul>
@endcanany


@canany(['admin-list', 'admin-create', 'admin-logs-view'], 'admin')
<ul>
    <li>Manage Admin Users</li>
    @can('admin-list', 'admin')
        <li><a href="{{ route('admin.admins.index') }}">Manage Admin Users</a></li>
    @endcan
    @can('admin-create', 'admin')
        <li><a href="{{ route('admin.admins.create') }}">Add admin user</a></li>
    @endcan
    @can('admin-logs-view', 'admin')
        <li><a href="">View admin logs</a></li>
    @endcan
</ul>
@endcanany

@role('Client Admin')
    @canany(['institution-list', 'institution-create'], 'admin')
    <ul>
        <li>Manage institutions</li>
        @can('admin-list', 'admin')
            <li><a href="{{ route('admin.admins.index') }}">Manage institutions</a></li>
        @endcan
        @can('institution-create', 'admin')
            <li><a href="{{ route('admin.admins.create') }}">Add institution</a></li>
        @endcan
    </ul>
    @endcanany
@endrole

@canany(['client-list', 'client-create'], 'admin')
<ul>
    <li>Manage clients</li>
    @can('client-list')
        <li><a href="{{ route('admin.clients.index') }}">Manage Clients</a></li>
    @endcan
    @can('client-create')
        <li><a href="{{ route('admin.clients.create') }}">Create a client</a></li>
    @endcan
</ul>
@endcanany



@canany(['tag-list'], 'admin')
<ul>
    <li>Manage (global) data tags</li>
    <li><a href="{{ route('admin.contents.index') }}">Manage (global) data tags</a></li>
    <li><a href="{{ route('admin.clients.index') }}">Sectors</a></li>
    <li><a href="{{ route('admin.clients.index') }}">Routes</a></li>
    <li><a href="{{ route('admin.clients.index') }}">Types (of role)</a></li>
    <li><a href="{{ route('admin.clients.index') }}">Terms</a></li>
    <li><a href="{{ route('admin.tags.subjects.index') }}">Subjects</a></li>
</ul>
@endcanany


@canany(['global-content-list', 'global-content-create'], 'admin')
<ul>
    <li>Manage global content</li>
    @can('global-content-list')
        <li><a href="{{ route('admin.contents.index') }}">Manage global content</a></li>
    @endcan
    @can('global-content-create')
        <li><a href="{{ route('admin.contents.create') }}">Add global content</a></li>
    @endcan
</ul>
@endcanany



@canany(['static-content-edit'], 'admin')
<ul>
    <li>Manage static content</li>
    <li><a href="">Edit static content element</a></li>
</ul>
@endcanany



@canany(['global-config-edit'], 'admin')
<ul>
    <li>Global configuration / settings</li>
    <li><a href="">Global configuration / settings</a></li>
</ul>
@endcanany



@canany(['user-list', 'user-create', 'user-import', 'user-export',], 'admin')
<ul>
    <li>Manage users</li>
    @can('user-list')
        <li><a href="{{ route('admin.users.index') }}">Manage users</a></li>
    @endcan
    @can('user-create')
        <li><a href="{{ route('admin.users.create') }}">Add user</a></li>
    @endcan
    @can('user-import')
        <li><a href="">Import user</a></li>
    @endcan
    @can('user-export')
        <li><a href="">Export user</a></li>
    @endcan
</ul>
@endcanany



@canany(['report-list'], 'admin')
<ul>
    <li>View reports</li>
    <li><a href="">User Reports (for my institution)</a></li>
</ul>
@endcanany



@canany(['client-content-list', 'client-content-create', 'client-tag-list'], 'admin')
<ul>
    <li>Manage (client) content</li>
    @can('client-content-list')
        <li><a href="">Manage (client) content</a></li>
    @endcan
    @can('client-content-create')
        <li><a href="">Add / edit (client content)</a></li>
    @endcan
    @can('client-tag-list')
        <li><a href="">Client data tag</a></li>
    @endcan
</ul>
@endcanany



@canany(['vacancy-list', 'vacancy-create'], 'admin')
<ul>
    <li>Vacancies</li>
    @can('vacancy-list')
        <li><a href="">Manage Opportunities</a></li>
    @endcan
    @can('vacancy-create')
        <li><a href="">Add / edit Opportunities</a></li>
    @endcan
</ul>
@endcanany



@canany(['event-list', 'event-create'], 'admin')
<ul>
    <li>Manage Events</li>
    @can('event-list')
        <li><a href="">Manage Events</a></li>
    @endcan
    @can('event-create')
        <li><a href="">Add / edit Events</a></li>
    @endcan
</ul>
@endcanany
--}}