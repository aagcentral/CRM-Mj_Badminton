<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title> @yield('title')|MJBADMINTON</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ url('') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ url('') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Template Main CSS File -->
    <link href="{{ url('') }}/assets/css/style.css" rel="stylesheet">
    <link href="{{ url('') }}/assets/costom.css" rel="stylesheet">
    @yield('css')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>


    @include('pages.layouts.header');

    @include('pages.layouts.sidebar');


    <main id="main" class="main" style="height: 82vh">

        @include('auth.message')

        @yield('content')

    </main><!-- End #main -->

    @include('pages.layouts.footer');

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- DataTables -->

    <link rel="stylesheet" href="{{ url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ url('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Vendor JS Files -->
    <script src="{{ url('') }}/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ url('') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('') }}/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="{{ url('') }}/assets/vendor/echarts/echarts.min.js"></script>
    <script src="{{ url('') }}/assets/vendor/quill/quill.js"></script>
    <script src="{{ url('') }}/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="{{ url('') }}/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="{{ url('') }}/assets/vendor/php-email-form/validate.js"></script>

    {{-- <script src="{{ 'plugins/select2/js/select2.full.min.js' }}"></script> --}}


    <!-- Template Main JS File -->
    <script src="{{ url('') }}/assets/js/main.js"></script>

    <script src="{{ url('') }}/assets/js/custom.js"></script>

    <!-- DataTables  & Plugins -->
    <script src=" {{ url('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    @yield('js')
</body>

</html>