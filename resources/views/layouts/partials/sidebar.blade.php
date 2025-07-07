<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <img src="{{ asset('images/prmi-logo.webp') }}" alt="Logo" class="app-brand-logo demo" style="width: 50px">
            <span class="app-brand-text demo menu-text fw-bold ms-3">PRMI</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Page 1">Dashboard</div>
            </a>
        </li>
        <!-- Front Pages -->
        <li
            class="menu-item {{ Route::is('admin*') || Route::is('organizational-structure*') || Route::is('sponsor*') || Route::is('member*') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-database"></i>
                <div data-i18n="Master">Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('admin*') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}" class="menu-link ">
                        <div data-i18n="Landing">Admin</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('organizational-structure*') ? 'active' : '' }}">
                    <a href="{{ route('organizational-structure.index') }}" class="menu-link ">
                        <div data-i18n="Landing">Organisasi</div>
                    </a>
                </li>
                {{-- sponsor --}}
                <li class="menu-item {{ Route::is('sponsor*') ? 'active' : '' }}">
                    <a href="{{ route('sponsor.index') }}" class="menu-link ">
                        <div data-i18n="Landing">Sponsor</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('member*') ? 'active' : '' }}">
                    <a href="{{ route('member.index') }}" class="menu-link ">
                        <div data-i18n="Landing">Member</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('user*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Page 1">User</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('event*') ? 'active' : '' }}">
            <a href="{{ route('event.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar"></i>
                <div data-i18n="Page 1">Event</div>
            </a>
        </li>
        {{-- blog --}}
        <li class="menu-item {{ Route::is('blog*') ? 'active' : '' }}">
            <a href="{{ route('blog.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-news"></i>
                <div data-i18n="Page 1">Blog</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('about-us*') ? 'active' : '' }}">
            <a href="{{ route('about-us.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-file-info"></i>
                <div data-i18n="Page 1">About Us</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('setting*') ? 'active' : '' }}">
            <a href="{{ route('setting.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>
                <div data-i18n="Page 1">Setting</div>
            </a>
        </li>


    </ul>
</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ti tabler-menu icon-base"></i>
        <i class="ti tabler-chevron-right icon-base"></i>
    </a>
</div>
<!-- / Menu -->
