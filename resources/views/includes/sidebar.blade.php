<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <span class=" brand-link brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-door-open fa-fw"></i>
                        <p>
                            Rooms
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.movies.index') }}" class="nav-link {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-video fa-fw"></i>
                        <p>
                            Movies
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.schedules.index') }}" class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list fa-fw"></i>
                        <p>
                            Schedule
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-check-square"></i>
                        <p>
                            Booking
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
