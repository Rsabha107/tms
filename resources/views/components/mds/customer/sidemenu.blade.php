<nav class="navbar navbar-vertical navbar-expand-lg" data-navbar-appearance="darker">
    <script>
        var navbarStyle = window.config.config.phoenixNavbarStyle;
        if (navbarStyle && navbarStyle !== 'transparent') {
            document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
        }
    </script>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->

        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">

                <li class="nav-item">
                    <!-- label-->
                    <!-- <p class="navbar-vertical-label">Apps
                    </p> -->
                    <hr class="navbar-vertical-line" />
                    <!-- parent pages-->


                    <div class="nav-item-wrapper"><a class="nav-link {{ Request::is('mds/admin/booking') ? 'active' : '' }} label-1" href="{{route('mds.admin.booking')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-book"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">List of Bookings</span></span>
                            </div>
                        </a>
                    </div>

                    <div class="nav-item-wrapper"><a class="nav-link {{ Request::is('mds/admin/booking/create') ? 'active' : '' }} label-1" href="{{route('mds.admin.booking.create')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-book"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Make a Booking</span></span>
                            </div>
                        </a>
                    </div>

                    <!-- ******************************** Setting menu ******************************** -->
                    @if (Auth::user()->can('setup.menu'))
                    <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator {{ Request::is('mds/setting/*')||Request::is('mds/setting/*') ? '' : 'collapsed' }} label-1" href="#nv-settings" role="button" data-bs-toggle="collapse" aria-expanded="{{ Request::is('tracki/sec/permissions/*')||Request::is('tracki/sec/roles/*') ? 'true' : 'false' }}" aria-controls="nv-settings">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div>
                                <span class="nav-link-icon"><span data-feather="settings"></span></span><span class="nav-link-text">Settings</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Request::is('mds/setting/*') ? 'show' : '' }}" data-bs-parent="#navbarVerticalCollapse" id="nv-settings">
                                <li class="collapsed-nav-item-title d-none">Setting
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/event') ? 'active' : '' }}" href="{{route('mds.setting.event')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Event</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/rsp') ? 'active' : '' }}" href="{{route('mds.setting.rsp')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Remote Search Park</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/vehicle_type') ? 'active' : '' }}" href="{{route('mds.setting.vehicle_type')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Vehicle Type</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/driver') ? 'active' : '' }}" href="{{ route('mds.setting.driver') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Drivers</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/vehicle') ? 'active' : '' }}" href="{{ route('mds.setting.vehicle') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Vehicles</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/delivery_type') ? 'active' : '' }}" href="{{ route('mds.setting.delivery_type') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Dispatch Type</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/cargo') ? 'active' : '' }}" href="{{ route('mds.setting.cargo') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Cargo</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/schedule') ? 'active' : '' }}" href="{{ route('mds.setting.schedule') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Delivery Schedule </span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>

                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/funcareas') ? 'active' : '' }}" href="{{ route('mds.setting.funcareas') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Functional Area</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/venue') ? 'active' : '' }}" href="{{ route('mds.setting.venue') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Venue</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/zone') ? 'active' : '' }}" href="{{ route('mds.setting.zone') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Loading Zone</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('mds/setting/status/booking') ? 'active' : '' }}" href="{{ route('mds.setting.status.booking') }}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Booking Status</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if (Auth::user()->can('roles.permissions.menu'))
                    <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator {{ Request::is('sec/permissions/*')||Request::is('sec/roles/*') ? '' : 'collapsed' }} label-1" href="#nv-roleperm" role="button" data-bs-toggle="collapse" aria-expanded="{{ Request::is('sec/permissions/*')||Request::is('sec/roles/*') ? 'true' : 'false' }}" aria-controls="nv-roleperm">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div>
                                <span class="nav-link-icon"><span data-feather="trello"></span></span><span class="nav-link-text">Role & Permission</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Request::is('sec/permissions/*') ? 'show' : '' }}" data-bs-parent="#navbarVerticalCollapse" id="nv-roleperm">
                                <li class="collapsed-nav-item-title d-none">All Permissions
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('sec/permissions/list') ? 'active' : '' }}" href="{{route('sec.perm.list')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">All Permissions</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('sec/roles/roles/list') ? 'active' : '' }}" href="{{route('sec.roles.list')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">All Roles</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link {{ Request::is('sec/rolesetup/list') ? 'active' : '' }}"" href=" {{route('sec.rolesetup.list')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">List Roles in Permission</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{route('sec.rolesetup.add')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Role in Permission</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{route('sec.groups.list')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Groups</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <!-- parent pages-->

                    <!-- ******************************** Manage Admin User ******************************** -->
                    @if (Auth::user()->can('manage.admin.users.menu'))
                    <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-adminuser" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-adminuser">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div>
                                <span class="nav-link-icon"><span data-feather="trello"></span></span><span class="nav-link-text">Manage Users</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent  {{ Request::is('sec/adminuser/*') ? 'show' : '' }}" data-bs-parent="#navbarVerticalCollapse" id="nv-adminuser">
                                <li class="collapsed-nav-item-title d-none">Manage Users
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{route('sec.adminuser.list')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">All Users</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{route('sec.adminuser.add')}}" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Add User</span>
                                        </div>
                                    </a>
                                    <!-- more inner pages-->
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    @if (Auth::user()->can('user.addx'))
                    <!-- parent pages-->
                    <!-- ******************************** Kanbad and Calendar  ******************************** -->
                    <!-- <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-kanban" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-kanban">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon"><span class="fas fa-caret-right"></span></div>
                                <span class="nav-link-icon"><span data-feather="trello"></span></span><span class="nav-link-text">Kanban</span><span class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-kanban">
                                <li class="collapsed-nav-item-title d-none">Kanban
                                </li>
                                <li class="nav-item"><a class="nav-link" href="apps/kanban/kanban.html" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Kanban</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="apps/kanban/boards.html" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Boards</span><span class="badge ms-2 badge badge-phoenix badge-phoenix-info ">New</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="apps/kanban/create-kanban-board.html" data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">Create
                                                board</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>  -->
                    <div class="nav-item-wrapper"><a class="nav-link label-1" href="{{route('auth.signup')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="user-plus"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Add Users</span></span>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if (Auth::user()->can('calendar.menux'))
                    <div class="nav-item-wrapper"><a class="nav-link label-1" href="{{route('project.show.calendar')}}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="calendar"></span></span><span class="nav-link-text-wrapper"><span class="nav-link-text">Calendar</span></span>
                            </div>
                        </a>
                    </div>
                    @endif
                </li>

            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button class="btn navbar-vertical-toggle border-0 fw-semi-bold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-0"></span><span class="uil uil-arrow-from-right fs-0"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button>
    </div>
</nav>