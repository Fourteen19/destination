<aside class="main-sidebar sidebar-dark-primary elevation-4 mydir-sidebar">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <span class="brand-text font-weight-light">MyDirections</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          @role('System Administrator')
          <li class="nav-item">
              @can('role-list', 'admin')
              <a href="{{ route('admin.roles.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>Manage Roles</p>
            </a>
            @endcan
          </li>
          @endrole

          {{--
          @canany(['profile-edit'], 'admin')
          <li class="nav-item">

              <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>Edit my profile</p>
            </a>

          </li>
          @endcanany
          --}}

          @canany(['admin-list', 'admin-create', 'admin-logs-view'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-cog"></i>
              <p>System Admins <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              @can('admin-list', 'admin')
              <li class="nav-item">
                <a href="{{ route('admin.admins.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage admin users</p>
                </a>
              </li>
              @endcan
              @can('admin-create', 'admin')
              <li class="nav-item">
                <a href="{{ route('admin.admins.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add admin user</p>
                </a>
              </li>
              @endcan
              @can('admin-logs-view', 'admin')
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>View admin logs</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['client-list', 'client-create'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>Clients <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              @can('client-list')
              <li class="nav-item">
                <a href="{{ route('admin.clients.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage clients</p>
                </a>
              </li>
              @endcan
              @can('client-create')
              <li class="nav-item">
                <a href="{{ route('admin.clients.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Create a client</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['tag-list'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>Global data tags <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{ route('admin.tags.sectors.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Sectors</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.tags.routes.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Routes</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.tags.subjects.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Subjects</p>
                </a>
              </li>

            </ul>
          </li>
          @endcanany


          @canany(['global-content-list', 'global-content-create', 'static-content-edit'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>Global Content <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              @can('global-content-list')
              <li class="nav-item">
                <a href="{{ route('admin.global.contents.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage global content</p>
                </a>
              </li>
              @endcan
              @can('global-content-create')
              <li class="nav-item">
                <a href="{{ route('admin.global.contents.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add global content</p>
                </a>
              </li>
              @endcan
              @can('static-content-edit')
              <li class="nav-item">
                <a href="{{ route('admin.static-global-content.edit') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Global static content</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany



          @canany(['global-config-edit'], 'admin')
          <li class="nav-item">
              <a href="{{ route('admin.global-settings') }}" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>Config / settings</p>
            </a>
          </li>
          @endcanany

          @canany(['user-list', 'user-create', 'user-import', 'user-export',], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Users <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            @can('user-list')
              <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage users</p>
                </a>
              </li>
              @endcan
              @can('user-create')
              <li class="nav-item">
                <a href="{{ route('admin.users.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add user</p>
                </a>
              </li>
              @endcan
              @can('user-import')
              <li class="nav-item">
                <a href="{{ route('admin.users.import') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Import users</p>
                </a>
              </li>
              @endcan
              @can('user-export')
              <li class="nav-item">
                <a href="{{ route('admin.users.export') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Export users</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['report-list'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-line"></i>
              <p>Reports <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">


          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fas fa-caret-right nav-icon"></i>
              <p>Preset Reports</p>
            </a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link">
              <i class="fas fa-caret-right nav-icon"></i>
              <p>Bespoke Reports</p>
            </a>
          </li>
          </ul>
          </li>
          @endcanany

          @canany(['client-content-list', 'client-content-create', 'client-tag-list', 'page-list', 'page-edit', 'page-create', 'client-settings-edit'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>Client content <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            @can('client-content-list')
              <li class="nav-item">
                <a href="{{ route('admin.contents.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage client content</p>
                </a>
              </li>
              @endcan
              @can('client-content-create')
              <li class="nav-item">
                <a href="{{ route('admin.contents.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add client content</p>
                </a>
              </li>
              @endcan
              @can('page-list')
              <li class="nav-item"><a href="{{ route('admin.pages.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage public site</p></a>
              </li>
              @endcan
              @can('page-edit')
              <li class="nav-item"><a href="{{ route('admin.public-homepage.edit') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Public home page</p></a>
              </li>
              @endcan
              @can('page-create')
              <li class="nav-item"><a href="{{ route('admin.pages.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add public content</p></a></li>
              @endcan
              @can('client-settings-edit')
              <li class="nav-item"><a href="{{ route('admin.static-client-content.edit') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Static client content</p></a></li>
              @endcan
              @can('client-tag-list')
              <li class="nav-item">
                <a href="{{ route('admin.client-reporting-tags.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Client reporting tags</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['vacancy-list', 'vacancy-create'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Vacancies <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            @can('vacancy-list')
              <li class="nav-item">
                <a href="{{ route('admin.vacancies.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage vacancies</p>
                </a>
              </li>
              @endcan
              @can('vacancy-create')
              <li class="nav-item">
                <a href="{{ route('admin.vacancies.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add vacancy</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['event-list', 'event-create'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Events <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
            @can('event-list')
              <li class="nav-item">
                <a href="{{ route('admin.events.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Manage events</p>
                </a>
              </li>
              @endcan
              @can('event-create')
              <li class="nav-item">
                <a href="{{ route('admin.events.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add event</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany

          @canany(['resource-list', 'resource-create'], 'admin')
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Resources <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              @can('resource-list')
              <li class="nav-item">
                <a href="{{ route('admin.resources.index') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Teaching resources</p>
                </a>
              </li>
              @endcan
              @can('resource-create')
              <li class="nav-item">
                <a href="{{ route('admin.resources.create') }}" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>Add resource</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcanany



        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
