@php
    $user = auth()->user();

    // Since you only use admin role, privileges control everything
    $allAccess = false; 

    $privileges = [];

    if ($user && $user->privileges()->exists()) {
        $privileges = $user->privileges
            ->pluck('actions', 'module')
            ->map(fn($a) => json_decode($a, true))
            ->toArray();
    }

    function canAccess($privileges, $module, $action = 'view') {
        return isset($privileges[$module]) && in_array($action, $privileges[$module]);
    }
@endphp

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Dashboard -->
                @if(canAccess($privileges, 'dashboard'))
                <li class="{{ request()->routeIs(['admin.dashboard']) ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span>ড্যাশবোর্ড</span>
                    </a>
                </li>
                @endif

                <!-- Categories -->
                @if(canAccess($privileges, 'categories'))
                <li class="{{ request()->routeIs('admin.categories.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-folder"></i>
                        <span>ক্যাটাগরি</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'categories', 'create'))
                        <li>
                            <a href="{{ route('admin.categories.create') }}" class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                                নতুন ক্যাটাগরি
                            </a>
                        </li>
                        @endif

                        @if(canAccess($privileges, 'categories', 'view'))
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">
                                সকল ক্যাটাগরি
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
                @endif

                <!-- Helpers -->
                @if(canAccess($privileges, 'helpers'))
                <li class="{{ request()->routeIs('admin.helpers.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span>সহায়তাকারী</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'helpers', 'create'))
                        <li>
                            <a href="{{ route('admin.helpers.create') }}" class="{{ request()->routeIs('admin.helpers.create') ? 'active' : '' }}">
                                নতুন সহায়তাকারী
                            </a>
                        </li>
                        @endif

                        @if(canAccess($privileges, 'helpers', 'view'))
                        <li>
                            <a href="{{ route('admin.helpers.index') }}" class="{{ request()->routeIs('admin.helpers.index') ? 'active' : '' }}">
                                সকল সহায়তাকারী
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
                @endif

                <!-- Receivers -->
                @if(canAccess($privileges, 'receivers'))
                <li class="{{ request()->routeIs('admin.receivers.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-tie"></i>
                        <span>গ্রাহক</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'receivers', 'create'))
                        <li>
                            <a href="{{ route('admin.receivers.create') }}" class="{{ request()->routeIs('admin.receivers.create') ? 'active' : '' }}">
                                নতুন গ্রাহক
                            </a>
                        </li>
                        @endif

                        @if(canAccess($privileges, 'receivers', 'view'))
                        <li>
                            <a href="{{ route('admin.receivers.index') }}" class="{{ request()->routeIs('admin.receivers.index') ? 'active' : '' }}">
                                সকল গ্রাহক
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>
                @endif

                <!-- Costs -->
                @if(canAccess($privileges, 'costs'))
                    <li class="{{ request()->routeIs(['admin.cost_sources.*','admin.costs.*']) ? 'mm-active sidebarParentActive' : '' }}">
                        <a href="javascript:void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>খরচ</span>
                        </a>
                        <ul class="sub-menu">

                            <!-- Cost Sources -->
                            @if(canAccess($privileges, 'cost_sources', 'view'))
                            <li>
                                <a href="{{ route('admin.cost_sources.index') }}" class="{{ request()->routeIs('admin.cost_sources.index') ? 'active' : '' }}">
                                    খরচের উৎস
                                </a>
                            </li>
                            @endif

                            <!-- Create Cost -->
                            @if(canAccess($privileges, 'costs', 'create'))
                            <li>
                                <a href="{{ route('admin.costs.create') }}" class="{{ request()->routeIs('admin.costs.create') ? 'active' : '' }}">
                                    নতুন খরচ
                                </a>
                            </li>
                            @endif

                            <!-- All Costs -->
                            @if(canAccess($privileges, 'costs', 'view'))
                            <li>
                                <a href="{{ route('admin.costs.index') }}" class="{{ request()->routeIs('admin.costs.index') ? 'active' : '' }}">
                                    সকল খরচ
                                </a>
                            </li>
                            @endif

                        </ul>
                    </li>
                @endif



                <!-- Reports -->
                @if(canAccess($privileges, 'reports'))
                <li class="{{ request()->routeIs('admin.reports.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-chart-line"></i>
                        <span>রিপোর্ট</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'reports', 'view'))
                        <li><a href="{{ route('admin.reports.revenue') }}">আয়ের রিপোর্ট</a></li>
                        <li><a href="{{ route('admin.reports.cost') }}">খরচের রিপোর্ট</a></li>
                        <li><a href="{{ route('admin.reports.cash_book') }}">ক্যাশ বুক</a></li>
                        @endif

                    </ul>
                </li>
                @endif

                <!-- Admins -->
                @if(canAccess($privileges, 'admins'))
                <li class="{{ request()->routeIs('admin.admins.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-shield"></i>
                        <span>অ্যাডমিন</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'admins', 'create'))
                        <li><a href="{{ route('admin.admins.create') }}">নতুন অ্যাডমিন</a></li>
                        @endif

                        @if(canAccess($privileges, 'admins', 'view'))
                        <li><a href="{{ route('admin.admins.index') }}">সকল অ্যাডমিন</a></li>
                        @endif

                    </ul>
                </li>
                @endif

                <!-- Privilege Management -->
                @if(canAccess($privileges, 'admins', 'edit'))
                <li class="{{ request()->routeIs('admin.privileges.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.privileges.index') }}" class="waves-effect">
                        <i class="fas fa-user-lock"></i>
                        <span>ব্যবহারকারীর প্রিভিলেজ</span>
                    </a>
                </li>
                @endif

                <!-- Settings -->
                @if(canAccess($privileges, 'settings'))
                <li class="{{ request()->routeIs(['profile.setting', 'system.index']) ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>সেটিংস</span>
                    </a>
                    <ul class="sub-menu">

                        @if(canAccess($privileges, 'settings', 'view'))
                        <li><a href="{{ route('profile.setting') }}">প্রোফাইল সেটিংস</a></li>
                        <li><a href="{{ route('system.index') }}">সিস্টেম সেটিংস</a></li>
                        @endif

                    </ul>
                </li>
                @endif

            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
