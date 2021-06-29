<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>

    <!-- Sidebar -->
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
			<ul class="vertical-nav-menu">
                <!-- if $menus == ''; $menus = menu_list() -->
                @foreach($menus = menu_list() ?? '' as $menu)
                    @if($menu->link == '' || $user_menu->can($menu->link))
                    <li>
                        <a href="{{ $menu->link !== '' ? route($menu->link) : '#' }}"><i class="metismenu-icon {{ $menu->icon }}"></i>{{ $menu->name }}
                            @if(count($menu->childs))
                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                            @endif
                        </a>
                        @if(count($menu->childs))
                            @include('dash::components.menu-child',['menus' => $menu->childs])
                        @endif
                    </li>
                    @endif
				@endforeach
			</ul>
        </div>
	</div>
	<!-- End Sidebar -->
</div>