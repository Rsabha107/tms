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
                @hasanyrole('SuperAdmin|HRMSADMIN')
                    <li class="nav-item">
                        <!-- parent pages-->
                        <div class="nav-item-wrapper">
                            <a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button"
                                data-bs-toggle="collapse" aria-expanded="true" aria-controls="nv-home">
                                <div class="d-flex align-items-center">
                                    <div class="dropdown-indicator-icon-wrapper">
                                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                    </div>
                                    <span class="nav-link-icon"><span data-feather="pie-chart"></span></span><span
                                        class="nav-link-text">Home</span><span
                                        class="fa-solid fa-circle text-info ms-1 new-page-indicator"
                                        style="font-size: 6px"></span>
                                </div>
                            </a>
                            <div class="parent-wrapper label-1">
                                <ul class="nav collapse parent show" data-bs-parent="#navbarVerticalCollapse"
                                    id="nv-home">
                                    <li class="collapsed-nav-item-title d-none">Home</li>
                                    @if (Auth::user()->can('hrms.menu'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('hr.admin.dashboard') }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text">HRMS</span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                @endhasanyrole
                <li class="nav-item">
                    <!-- label-->
                    <p class="navbar-vertical-label">Apps</p>
                    <hr class="navbar-vertical-line" />
                    <!-- parent pages-->

                    <!-- ************* MDS Management **************** -->
                    {{-- @if (Auth::user()->can('procurement.menu')) --}}
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ Request::is('mds/admin/booking*') ? '' : 'collapsed' }}"
                            href="#nv-leads-managementz" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ Request::is('mds/admin/booking*') ? 'true' : 'false' }}"
                            aria-controls="nv-leads-managementz">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper">
                                    <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                                </div>
                                <span class="nav-link-icon"><i class="fa-solid fa-phone text-warning"></i></span><span
                                    class="nav-link-text">MDS</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ Request::is('mds/admin/booking*') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-leads-managementz">
                                <li class="collapsed-nav-item-title d-none">
                                    MDS
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('mds/admin/booking') ? 'active' : '' }}"
                                        href="{{ route('mds.admin.booking') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">List of Bookings</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('mds/admin/booking/create') ? 'active' : '' }}"
                                        href="{{ route('mds.admin.booking.create') }}">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text">Make a Booking</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    {{-- @endif --}}
                    <!-- ************* MDS Management **************** -->
            </ul>
        </div>
    </div>
    {{-- @endif --}}
    {{-- </li> --}}

    {{-- @if (Auth::user()->can('roles.permissions.menu') || Auth::user()->can('manage.admin.users.menu')) --}}
    <li class="nav-item">
        <!-- label-->
        <p class="navbar-vertical-label">Security/Privacy</p>
        <hr class="navbar-vertical-line" />
        <!-- parent pages-->
        {{-- @if (Auth::user()->can('roles.permissions.menu')) --}}
        <div class="nav-item-wrapper">
            <a class="nav-link dropdown-indicator label-1 {{ Request::is('sec/permissions/*') || Request::is('sec/roles/*') || Request::is('sec/groups/*')
                ? ''
                : 'collapsed' }}"
                href="#nv-security-privacy" role="button" data-bs-toggle="collapse"
                aria-expanded="{{ Request::is('sec/permissions/*') ||
                Request::is('sec/roles/*') ||
                Request::is('sec/groups/*') ||
                Request::is('sec/groups/*')
                    ? 'true'
                    : 'false' }}"
                aria-controls="nv-security-privacy">
                <div class="d-flex align-items-center">
                    <div class="dropdown-indicator-icon-wrapper">
                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                    </div>
                    <span class="nav-link-icon"><i class="fa-solid fa-user-shield text-warning"></i></span><span
                        class="nav-link-text">Roles & Permissioins</span>
                </div>
            </a>
            <div class="parent-wrapper label-1">
                <ul class="nav collapse parent {{ Request::is('sec/permissions/*') || Request::is('sec/roles/*') || Request::is('sec/groups/*') ? 'show' : '' }}"
                    data-bs-parent="#navbarVerticalCollapse" id="nv-security-privacy">
                    <li class="collapsed-nav-item-title d-none">Roles & Permissioins</li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sec/permissions/list') ? 'active' : '' }}"
                            href="{{ route('sec.perm.list') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">All Permissions</span>
                            </div>
                        </a>
                        <!-- more inner pages-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sec/roles/roles/list') ? 'active' : '' }}"
                            href="{{ route('sec.roles.list') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">All Roles</span>
                            </div>
                        </a>
                        <!-- more inner pages-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sec/rolesetup/list') ? 'active' : '' }}"
                            href=" {{ route('sec.rolesetup.list') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">List Roles in Permission</span>
                            </div>
                        </a>
                        <!-- more inner pages-->
                    </li>
                    <!-- <li
                                        class="nav-item"><a class="nav-link"
                                        href="{{ route('sec.rolesetup.add') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">Role in Permission</span>
                                            </div>
                                        </a>
                                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('sec/groups/groups/list') ? 'active' : '' }}"
                            href="{{ route('sec.groups.list') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">Groups</span>
                            </div>
                        </a>
                        <!-- more inner pages-->
                    </li>
                </ul>
            </div>
        </div>
        {{-- @endif --}}
        <!-- parent pages-->
        @if (Auth::user()->can('manage.admin.users.menu'))
            <div class="nav-item-wrapper">
                <a class="nav-link dropdown-indicator label-1 {{ Request::is('sec/adminuser/*') ? '' : 'collapsed' }}"
                    href="#nv-manage-users" role="button" data-bs-toggle="collapse"
                    aria-expanded="{{ Request::is('sec/adminuser/*') ? 'true' : 'false' }}"
                    aria-controls="nv-manage-users">
                    <div class="d-flex align-items-center">
                        <div class="dropdown-indicator-icon-wrapper">
                            <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                        </div>
                        <span class="nav-link-icon"><i class="fa-solid fa-user-shield text-warning"></i></span><span
                            class="nav-link-text">Manage Users</span>
                    </div>
                </a>
                <div class="parent-wrapper label-1">
                    <ul class="nav collapse parent {{ Request::is('sec/adminuser/*') ? 'show' : '' }}"
                        data-bs-parent="#navbarVerticalCollapse" id="nv-manage-users">
                        <li class="collapsed-nav-item-title d-none">Manage Users</li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('sec/adminuser/list') ? 'active' : '' }}"
                                href="{{ route('sec.adminuser.list') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text">All users</span>
                                </div>
                            </a>
                            <!-- more inner pages-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('sec/adminuser/add') ? 'active' : '' }}"
                                href="{{ route('sec.adminuser.add') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text">Add users</span>
                                </div>
                            </a>
                            <!-- more inner pages-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('sec/adminuser/add2') ? 'active' : '' }}"
                                href="{{ route('sec.adminuser.add2') }}">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text">Add users2</span>
                                </div>
                            </a>
                            <!-- more inner pages-->
                        </li>
                    </ul>
                </div>
            </div>
        @endif
    </li>
    {{-- @endif --}}

    {{-- <li class="nav-item">
        <!-- label-->
        <p class="navbar-vertical-label">General</p>
        <hr class="navbar-vertical-line" />
        <!-- parent pages-->
        <div class="nav-item-wrapper">
            <a class="nav-link dropdown-indicator label-1" href="#nv-customization" role="button"
                data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-customization">
                <div class="d-flex align-items-center">
                    <div class="dropdown-indicator-icon-wrapper">
                        <span class="fas fa-caret-right dropdown-indicator-icon"></span>
                    </div>
                    <span class="nav-link-icon"><span data-feather="settings"></span></span><span
                        class="nav-link-text">Settings</span><span
                        class="fa-solid fa-circle text-info ms-1 new-page-indicator" style="font-size: 6px"></span>
                </div>
            </a>
            <div class="parent-wrapper label-1">
                <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-customization">
                    <li class="collapsed-nav-item-title d-none">
                        Customization
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('general.settings.company') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">Company Settings</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('general.settings.address') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">Business Address</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('general.settings.currency') }}">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">Currency</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="documentation/customization/color.html">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-text">Color</span>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <a class="nav-link label-1" href="showcase.html" role="button" data-bs-toggle="" aria-expanded="false">
            <div class="d-flex align-items-center">
                <span class="nav-link-icon"><span data-feather="monitor"></span></span><span
                    class="nav-link-text-wrapper"><span class="nav-link-text">Showcase</span></span>
            </div>
        </a>
        </div> -->
    </li> --}}
    </ul>
    </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-8"></span><span
                class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed
                View</span>
        </button>
    </div>
</nav>
