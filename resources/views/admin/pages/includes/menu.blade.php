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
                <li><a href="{{ route('admin.roles.index') }}">Manage roles</a></li>
            @endcan
            </ul>
      </div>
    </div>

</div>
@endrole

{{--
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
--}}

@canany(['admin-list', 'admin-create', 'admin-logs-view'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-user-cog mr-3"></i> Manage System Administrators</h5></div>
      <div class="card-body">


            <ul class="card-text list-unstyled">
            @can('admin-list', 'admin')
                <li><a href="{{ route('admin.admins.index') }}">Manage admin users</a></li>
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
                        <li><a href="{{ route('admin.clients.institutions.index', ['client' => getClientUuid()] ) }}">Manage institutions</a></li>
                        @endcan
                        @can('institution-create', 'admin')
                        <li><a href="{{ route('admin.clients.institutions.create', ['client' => getClientUuid()]) }}">Add institution</a></li>
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
                <li><a href="{{ route('admin.clients.index') }}">Manage clients</a></li>
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
            <li><a href="{{ route('admin.tags.sectors.index') }}">Sectors</a></li>
            <li><a href="{{ route('admin.tags.routes.index') }}">Routes</a></li>
            <li><a href="{{ route('admin.tags.subjects.index') }}">Subjects</a></li>
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['global-content-list', 'global-content-create', 'static-content-edit'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-globe mr-3"></i> Global Content</h5></div>
        <div class="card-body">

            <ul class="card-text list-unstyled">
            @can('global-content-list')
                <li><a href="{{ route('admin.global.contents.index') }}">Manage global content</a></li>
            @endcan
            @can('global-content-create')
                <li><a href="{{ route('admin.global.contents.create') }}">Add global content</a></li>
            @endcan
            @can('global-content-create')
                <li><a href="{{ route('admin.static-global-content.edit') }}">Edit static global content</a></li>
            @endcan
            @can('client-keyword-list')
                <li><a href="{{ route('admin.keywords.index') }}">Article keywords tags</a></li>
            @endcan
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
            <li><a href="{{ route('admin.global-settings') }}">Edit settings</a></li>
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
                <li><a href="{{ route('admin.users.import') }}">Import user</a></li>
            @endcan
            @can('user-export')
                <li><a href="{{ route('admin.users.export') }}">Export user</a></li>
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
            @can('report-list', 'admin')
                <li><a href="{{ route('admin.reports') }}">Preset Reports</a></li>
                <li><a href="{{ route('admin.reports', 'advanced') }}">Bespoke Reports</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['client-content-list', 'client-content-create', 'client-tag-list', 'client-keyword-list', 'page-list', 'page-edit', 'page-create', 'client-settings-edit', 'homepage-settings-edit'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-newspaper mr-3"></i> Client content</h5></div>
        <div class="card-body">

            <ul class="card-text list-unstyled">
            @can('client-content-list')
                <li><a href="{{ route('admin.contents.index') }}">Manage client content</a></li>
            @endcan
            @can('client-content-create')
                <li><a href="{{ route('admin.contents.create') }}">Add client content</a></li>
            @endcan
            @can('page-list')
                <li><a href="{{ route('admin.pages.index') }}">Manage public site</a></li>
            @endcan
            @can('page-edit')
                <li><a href="{{ route('admin.public-homepage.edit') }}">Public home page</a></li>
            @endcan
            @can('page-create')
                <li><a href="{{ route('admin.pages.standard.create') }}">Add public content</a></li>
            @endcan
            @can('client-settings-edit')
                <li><a href="{{ route('admin.static-client-content.edit') }}">Static client content</a></li>
            @endcan
            @can('client-tag-list')
                <li><a href="{{ route('admin.client-reporting-tags.index') }}">Client reporting tags</a></li>
            @endcan
            @can('homepage-settings-edit')
                <li><a href="{{ route('admin.homepage-settings.edit') }}">Homepage Settings</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany


@canany(['employer-list', 'vacancy-list', 'vacancy-create', 'vacancy-role-list', 'vacancy-region-list'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-briefcase mr-3"></i> Vacancies</h5></div>
        <div class="card-body">

            <ul class="card-text list-unstyled">
            @can('employer-list')
                <li><a href="{{ route('admin.employers.index') }}">Manage employers</a></li>
            @endcan
            @can('vacancy-list')
                <li><a href="{{ route('admin.vacancies.index') }}">Manage current vacancies</a></li>
                <li><a href="{{ route('admin.passed-vacancies.index') }}">Manage passed vacancies</a></li>
            @endcan
            @can('vacancy-create')
                <li><a href="{{ route('admin.vacancies.create') }}">Add vacancy</a></li>
            @endcan
            @can('vacancy-role-list')
                <li><a href="{{ route('admin.vacancies.roles.index') }}">Manage vacancies roles</a></li>
            @endcan
            @can('vacancy-region-list')
                <li><a href="{{ route('admin.vacancies.regions.index') }}">Manage vacancies regions</a></li>
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
                <li><a href="{{ route('admin.events.index') }}">Manage upcoming events</a></li>
                <li><a href="{{ route('admin.passed-events.index') }}">Manage passed events</a></li>
            @endcan
            @can('event-create')
                <li><a href="{{ route('admin.events.create') }}">Add event</a></li>
            @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

@canany(['resource-list', 'resource-create'], 'admin')
<div class="col mb-4">
    <div class="card h-100">
    <div class="card-head"><h5 class="card-title mydir"><i class="fas fa-chalkboard-teacher mr-3"></i> Resources</h5></div>
        <div class="card-body">

            <ul class="card-text list-unstyled">
                @can('resource-list')
                    <li><a href="{{ route('admin.resources.index') }}">Teaching resources</a></li>
                @endcan
                @can('resource-create')
                    <li><a href="{{ route('admin.resources.create') }}">Add resource</a></li>
                @endcan
            </ul>
        </div>
    </div>
</div>
@endcanany

</div>
