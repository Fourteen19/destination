<nav class="main-header navbar navbar-expand navbar-dark mydir-nav">
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
      </li>

      @if (isGlobalAdmin())
        @if (
                (Route::is('admin.dashboard')) ||
                (Route::is('admin.admins.index')) ||
                (Route::is('admin.vacancies.index')) ||
                (Route::is('admin.events.index')) ||
                (Route::is('admin.users.index')) ||
                (Route::is('admin.contents.index')) ||
                (Route::is('admin.pages.index')) ||
                (Route::is('admin.employers.index'))
            )
            <li class="nav-item d-none d-sm-inline-block">
                @livewire('admin.client-selector')
            </li>
        @endif
      @endif

    </ul>

    <ul class="navbar-nav ml-auto">
        @canany(['file-manager'], 'admin')<li><a class="nav-link" href=" {{ route('admin.file-manager') }}"><i class="fas fa-images mr-2"></i>File Manager</a></li>@endcanany
        @canany(['profile-edit'], 'admin')<li><a class="nav-link" href=" {{ route('admin.edit-my-profile.edit') }}"><i class="fas fa-user-edit mr-2"></i>Edit my profile</a></li>@endcanany
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
  </nav>
