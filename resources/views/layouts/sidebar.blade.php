<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo me-1">
                <span class="text-primary">
                  <img src="{{ asset('assets/img/logo.png') }}" alt="HCalculator"  height="30">
                </span>
              </span>
              {{-- <span class="app-brand-text demo menu-text fw-semibold ms-2">HCalculator</span> --}}
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a
                href="{{ route('dashboard') }}"
                class="menu-link">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>
            <!-- Dashboards -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Calculators">Calculators</div>
                <div class="badge text-bg-danger rounded-pill ms-auto">{{\App\Models\Calculator::where('status',1)->count()}}</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('categories.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('categories.index') }}">
                       Category
                   </a>
                 </li>
                  <li class="menu-item {{ request()->routeIs('subcategories.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('subcategories.index') }}">
                       Sub Category
                   </a>
                 </li>
                  <li class="menu-item {{ request()->routeIs('calculators.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('calculators.index') }}">
                       Calculators
                   </a>
                 </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Calculators">Content</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('content.home.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('content.home.index') }}">
                       Homepage
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('content.footer.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('content.footer.index') }}">
                       Footer
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('team.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('team.index') }}">
                       Team Members
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('content.policy.index',['type' => 'privacy_policy']) ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('content.policy.index',['type' => 'privacy_policy']) }}">
                       Privacy Policy
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('content.policy.index',['type' => 'terms']) ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('content.policy.index',['type' => 'terms']) }}">
                       Terms of Use
                   </a>
                 </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Calculators">Visitors & Activities</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('visitors.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('visitors.index') }}">
                       List Visitors
                   </a>
                 </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Calculators">Website Settings</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                   <a class="menu-link"
                    href="#">
                       General Settings
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('settings.menu.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('settings.menu.index') }}">
                       Menu Settings
                   </a>
                 </li>
                <li class="menu-item {{ request()->routeIs('sitescripts.index') ? 'active' : '' }}">
                   <a class="menu-link"
                    href="{{ route('sitescripts.index') }}">
                       Site Scripts
                   </a>
                 </li>
              </ul>
            </li>
          </ul>
        </aside>