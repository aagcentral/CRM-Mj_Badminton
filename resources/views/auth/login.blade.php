<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/images/faviconc.png') }}" rel="icon">
  <link href="{{ asset('assets/images/fav-apple.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{  url('/') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="{{  url('/') }}/assets/css/style.css" rel="stylesheet">

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <!-- <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="{{  url('/') }}/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Mj Badminton</span>
                </a>
              </div>End Logo -->

              <div class="card mb-3 shadow">

                <div class="card-body">
                  <div class="text-center mt-3 mb-4">
                    <img class="img-fluid" src="{{ asset('assets/images/logo.jpg') }}" alt="Logo" style="height:80px; width:200px;">

                    <p class="card-title text-center p-0 m-0 small">Login to Your Account</p>
                    <p class="text-center small p-0 m-0">Enter your username & password to login</p>
                  </div>

                  @include('auth.message')
                  <form class="row g-2 needs-validation" action="{{ route('auth.login.post') }}" method="post">
                    @csrf

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>


                    <div class="col-12 mb-5 mt-4">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div> -->
                  </form>

                </div>
              </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{  url('/') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="{{  url('/') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{  url('/') }}/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="{{  url('/') }}/assets/vendor/echarts/echarts.min.js"></script>
  <script src="{{  url('/') }}/assets/vendor/quill/quill.js"></script>
  <script src="{{  url('/') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="{{  url('/') }}/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="{{  url('/') }}/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="{{  url('/') }}/assets/js/main.js"></script>

</body>

</html>