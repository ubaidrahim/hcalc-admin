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
            <li class="menu-item">
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
                <div class="badge text-bg-danger rounded-pill ms-auto">5</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                   <a class="menu-link {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                    href="{{ route('categories.index') }}">
                       Category
                   </a>
                 </li>
                  <li class="menu-item">
                   <a class="menu-link {{ request()->routeIs('subcategories.index') ? 'active' : '' }}"
                    href="{{ route('subcategories.index') }}">
                       Sub Category
                   </a>
                 </li>
                  <li class="menu-item">
                   <a class="menu-link {{ request()->routeIs('calculators.index') ? 'active' : '' }}"
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
                <li class="menu-item">
                   <a class="menu-link {{ request()->routeIs('content.home.index') ? 'active' : '' }}"
                    href="{{ route('content.home.index') }}">
                       Homepage
                   </a>
                 </li>
              </ul>
            </li>
          </ul>
        </aside>