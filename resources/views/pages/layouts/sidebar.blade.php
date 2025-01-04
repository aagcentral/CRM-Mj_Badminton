<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    @php
    $ViewPermissionDashboard = App\Models\PermissionRole::getPermissionRole('panel.dashboard', Auth::user()->role_id);
    $ViewPermissionUser = App\Models\PermissionRole::getPermissionRole('user.list', Auth::user()->role_id);
    $ViewPermissionSettingsMenu = App\Models\PermissionRole::getPermissionRole('settings.permission.group', Auth::user()->role_id);
    $ViewPermissionSettingsPermission = App\Models\PermissionRole::getPermissionRole('settings.permission', Auth::user()->role_id);
    $ViewPermissionSettingsRole = App\Models\PermissionRole::getPermissionRole('settings.role.list', Auth::user()->role_id);
    $ViewPermissionSettingsLocation = App\Models\PermissionRole::getPermissionRole('location.list', Auth::user()->role_id);
    @endphp

    @if(!empty($ViewPermissionDashboard))
    <li class="nav-item">
      <a class="nav-link @if(Request::segment(2) != 'dashboard') collapsed  @endif"
        href="{{ route('panel.dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @endif

    @if(!empty($ViewPermissionUser))
    <li class="nav-item">
      <a class="nav-link @if(Request::segment(2) != 'user') collapsed  @endif" href="{{ route('user.list') }}">
        <i class="fa-regular fa-user"></i>
        <span>User</span>
      </a>
    </li>
    @endif

    @if(!empty($ViewPermissionSettingsMenu) || !empty($ViewPermissionSettingsPermission) || !empty($ViewPermissionSettingsRole) || !empty($ViewPermissionSettingsLocation))
    <li class="nav-item">
      <a class="nav-link @if (!in_array(Route::currentRouteName(), ['settings.permission','location.list', 'settings.permission.group','settings.role.list'])) collapsed @endif"
        data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="ri-settings-3-line"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav"
        class="nav-content @if (!in_array(Route::currentRouteName(), ['settings.permission','location.list', 'settings.permission.group','settings.role.list'])) collapse @endif"
        data-bs-parent="#sidebar-nav">

        @if(!empty($ViewPermissionSettingsLocation))
        <li>
          <a href="{{ route('location.list') }}"
            class="@if (Route::currentRouteName() == 'location.list') active @endif">
            <i class="bi bi-circle"></i><span>Location</span>
          </a>
        </li>
        @endif
        <!--***** Don't delete this is for developers and only enable when you want to create permission of new menu *******-->
        <!-- @if(!empty($ViewPermissionSettingsMenu))
        <li>
          <a href="{{ route('settings.permission.group') }}"
            class="@if (Route::currentRouteName() == 'settings.permission.group') active @endif">
            <i class="bi bi-circle"></i><span>Permission Group</span>
          </a>
        </li>
        @endif
        @if(!empty($ViewPermissionSettingsPermission))
        <li>
          <a href="{{ route('settings.permission') }}"
            class="@if (Route::currentRouteName() == 'settings.permission') active @endif">
            <i class="bi bi-circle"></i><span>Permission</span>
          </a>
        </li>
        @endif -->
        <!--*****./End Don't delete it, this is for developers and only enable when you want to create permission of new menu *******-->
        @if(!empty($ViewPermissionSettingsRole))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'settings.role.list') collapsed  @endif" href="{{ route('settings.role.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Role</span>
          </a>
        </li><!-- End  Nav -->
        @endif
      </ul>
    </li><!-- End Forms Nav -->
    @endif


















    <!-- {{-- Permission is not assigned for these routes Miscellaneous--}} -->
    @if(havePermission('enquiry.list'))
    <li class="nav-item">
      <a class="nav-link @if(Route::currentRouteName() != 'enquiry.list') collapsed  @endif" href="{{ route('enquiry.list') }}">
        <i class="fa-solid fa-headset"></i>
        <span>Lead & Enquiry</span>
      </a>
    </li>
    @endif
    @if(havePermission('registration.list') || havePermission('registration.form'))
    <li class="nav-item">
      <a class="nav-link @if (!in_array(Route::currentRouteName(), ['registration.list','registration.form'])) collapsed @endif"
        data-bs-target="#forms-navregistration" data-bs-toggle="collapse" href="#">
        <i class="fa-regular fa-address-card"></i><span>Registration</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-navregistration"
        class="nav-content @if (!in_array(Route::currentRouteName(), ['registration.list','registration.form'])) collapse @endif"
        data-bs-parent="#sidebar-nav">

        <!-- {{-- Check and Show Registration Form Link --}} -->
        @if(havePermission('registration.form'))
        <li>
          <a href="{{ route('registration.form') }}"
            class="@if (Route::currentRouteName() == 'registration.form') active @endif">
            <i class="bi bi-circle"></i><span>Registration</span>
          </a>
        </li>
        @endif

        <!-- {{-- Check and Show Registration Record Link --}} -->
        @if(havePermission('registration.list'))
        <li>
          <a href="{{ route('registration.list') }}"
            class="@if (Route::currentRouteName() == 'registration.list') active @endif">
            <i class="bi bi-circle"></i><span>Registration Record</span>
          </a>
        </li>
        @endif

      </ul>
    </li>
    @endif



    <!-- stock -->
    @if(havePermission('unit.list') || havePermission('category.list') || havePermission('product.list') || havePermission('stock.list') || havePermission('distributed.list'))
    <li class="nav-item">
      <a class="nav-link @if (!in_array(Route::currentRouteName(), ['unit.list','category.list','product.list','stock.list','distributed.list'])) collapsed @endif"
        data-bs-target="#forms-nav1" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-layer-group"></i><span>Stock Management</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav1"
        class="nav-content @if (!in_array(Route::currentRouteName(), ['unit.list','category.list','product.list','stock.list','distributed.list'])) collapse @endif"
        data-bs-parent="#sidebar-nav">

        @if(havePermission('unit.list'))
        <li>
          <a href="{{ route('unit.list') }}"
            class="@if (Route::currentRouteName() == 'unit.list') active @endif">
            <i class="bi bi-circle"></i><span>Unit</span>
          </a>
        </li>
        @endif

        @if(havePermission('category.list'))
        <li>
          <a href="{{ route('category.list') }}"
            class="@if (Route::currentRouteName() == 'category.list') active @endif">
            <i class="bi bi-circle"></i><span>Category</span>
          </a>
        </li>
        @endif

        @if(havePermission('product.list'))
        <li>
          <a href="{{ route('product.list') }}"
            class="@if (Route::currentRouteName() == 'product.list') active @endif">
            <i class="bi bi-circle"></i><span>Product</span>
          </a>
        </li>
        @endif

        @if(havePermission('stock.list'))
        <li>
          <a href="{{ route('stock.list') }}"
            class="@if (Route::currentRouteName() == 'stock.list') active @endif">
            <i class="bi bi-circle"></i><span>Add Stock</span>
          </a>
        </li>
        @endif

        @if(havePermission('distributed.list'))
        <li>
          <a href="{{ route('distributed.list') }}"
            class="@if (Route::currentRouteName() == 'distributed.list') active @endif">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Distributed Stock</span>
          </a>
        </li>
        @endif

      </ul>
    </li>
    @endif

    <!-- notification -->
    @if(havePermission('notifications.list'))
    <li class="nav-item">
      <a class="nav-link @if(Route::currentRouteName() != 'notifications.list') collapsed  @endif" href="{{ route('notifications.list') }}">
        <i class="fa-solid fa-bell"></i>
        <span>Notification</span>
      </a>
    </li>
    @endif

    <!-- report -->
    @if(havePermission('report.feecollection'))
    <li class="nav-item">
      <a class="nav-link @if (!in_array(Route::currentRouteName(), ['report.feecollection'])) collapsed @endif"
        data-bs-target="#forms-navreport" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-calendar-days"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-navreport"
        class="nav-content @if (!in_array(Route::currentRouteName(), ['report.feecollection'])) collapse @endif"
        data-bs-parent="#sidebar-nav">
        <!-- {{-- Check and Show Registration Form Link --}} -->
        @if(havePermission('report.feecollection'))
        <li>
          <a href="{{ route('report.feecollection') }}"
            class="@if (Route::currentRouteName() == 'report.feecollection') active @endif">
            <i class="bi bi-circle"></i><span>Fee Report</span>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif

    <!-- Miscellaneous -->

    @if(havePermission('paymentmodule.list') || havePermission('package.list') || havePermission('training.list') || havePermission('session.list') || havePermission('timings.list') || havePermission('room.list') || havePermission('meal.list') || havePermission('leadsource.list') || havePermission('package.edit'))
    <li class="nav-item">
      <a class="nav-link @if (!in_array(Route::currentRouteName(), ['paymentmodule.list', 'package.list', 'training.list', 'session.list', 'timings.list', 'room.list', 'meal.list', 'leadsource.list', 'package.edit'])) collapsed @endif"
        data-bs-target="#forms-navMiscellaneous" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-list-check"></i><span>Miscellaneous</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-navMiscellaneous"
        class="nav-content @if (!in_array(Route::currentRouteName(), ['paymentmodule.list', 'package.list', 'training.list', 'session.list', 'timings.list', 'room.list', 'meal.list', 'leadsource.list', 'package.edit'])) collapse @endif"
        data-bs-parent="#sidebar-nav">

        @if(havePermission('paymentmodule.list'))
        <li>
          <a href="{{ route('paymentmodule.list') }}"
            class="@if (Route::currentRouteName() == 'paymentmodule.list') active @endif">
            <i class="bi bi-circle"></i><span>Payment Module</span>
          </a>
        </li>
        @endif

        @if(havePermission('package.list'))
        <li>
          <a href="{{ route('package.list') }}"
            class="@if (Route::currentRouteName() == 'package.list') active @endif">
            <i class="bi bi-circle"></i><span>Package</span>
          </a>
        </li>
        @endif

        @if(havePermission('training.list'))
        <li>
          <a href="{{ route('training.list') }}"
            class="@if (Route::currentRouteName() == 'training.list') active @endif">
            <i class="bi bi-circle"></i><span>Training Type</span>
          </a>
        </li>
        @endif

        @if(havePermission('session.list'))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'session.list') collapsed @endif" href="{{ route('session.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Session</span>
          </a>
        </li>
        @endif

        @if(havePermission('timings.list'))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'timings.list') collapsed @endif" href="{{ route('timings.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Time Slot</span>
          </a>
        </li>
        @endif

        @if(havePermission('room.list'))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'room.list') collapsed @endif" href="{{ route('room.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Hostel</span>
          </a>
        </li>
        @endif

        @if(havePermission('meal.list'))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'meal.list') collapsed @endif" href="{{ route('meal.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Meal</span>
          </a>
        </li>
        @endif

        @if(havePermission('leadsource.list'))
        <li class="nav-item">
          <a class="nav-link @if(Route::currentRouteName() != 'leadsource.list') collapsed @endif" href="{{ route('leadsource.list') }}">
            <i class="bi bi-emoji-laughing-fill"></i>
            <span>Lead Source</span>
          </a>
        </li>
        @endif

      </ul>
    </li>
    @endif


  </ul>

</aside><!-- End Sidebar-->