  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="#!" class="logo d-flex align-items-center">
        <!-- <img src="{{ url('') }}/assets/img/logo.png" alt=""> -->
        <img class="img-fluid" src="{{ asset('assets/images/logo1.jpg') }}" alt="Logo" style="height:100px; width:200px;">
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>

    </div>


    @if(Auth()->user()->id==4)
    @php
    $location = App\Models\Location::getRecord();
    @endphp
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="{{ route('update.user.location') }}" onchange="return submit()">
        @csrf
        <select name="user_location" class="form-select" id="">
          @foreach ($location as $row)
          <option value="{{ $row->location_id }}" @if($row->location_id==Auth()->user()->locationID) selected @endif>{{ $row->location }}</option>
          @endforeach
        </select>
      </form>
    </div><!-- End Search Bar -->
    @endif
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/images/nouser.jpg') }}" alt="Profile" class="rounded-circle border border-light">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <p>{{ Auth::user()->Userlocations ? Auth::user()->Userlocations->location : 'N/A' }}</p>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('sign.out') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->