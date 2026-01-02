<!doctype html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | KantahKabBanjar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">
    <link rel="icon" type="image/png" href="{{ asset('img') }}/Logo_BPN-KemenATR.png" />

    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/charts-c3/plugin.css" />

    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

    <!-- MAIN Project CSS file -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/main.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    @if (!Session::has('name'))
        <script>
            window.location.href = "/logout";
        </script>
    @endif

</head>

<body data-theme="light" class="font-nunito right_icon_toggle">
    <div id="wrapper" class="theme-cyan">

        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img src="{{ asset('img') }}/Logo_BPN-KemenATR.png" width="48" height="48"
                        alt="Iconic">
                </div>
                <p>Please wait...</p>
            </div>
        </div>

        <!-- Top navbar div start -->
        @include('template._navbar')


        <!-- main left menu -->
        @include('template._sidebar')


        <!-- rightbar icon div -->
        <div class="right_icon_bar">
            {{-- <ul>
                <li><a href="app-inbox.html"><i class="fa fa-envelope"></i></a></li>
                <li><a href="app-chat.html"><i class="fa fa-comments"></i></a></li>
                <li><a href="app-calendar.html"><i class="fa fa-calendar"></i></a></li>
                <li><a href="file-dashboard.html"><i class="fa fa-folder"></i></a></li>
                <li><a href="app-contact.html"><i class="fa fa-id-card"></i></a></li>
                <li><a href="blog-list.html"><i class="fa fa-globe"></i></a></li>
                <li><a href="javascript:void(0);"><i class="fa fa-plus"></i></a></li>
                <li><a href="javascript:void(0);" class="right_icon_btn"><i class="fa fa-angle-right"></i></a></li>
            </ul> --}}
        </div>

        <!-- mani page content body part -->
        @yield('content')


    </div>
    <!-- Javascript -->
    <script src="{{ asset('assets') }}/bundles/libscripts.bundle.js"></script>
    <script src="{{ asset('assets') }}/bundles/vendorscripts.bundle.js"></script>

    <script src="{{ asset('assets') }}/bundles/datatablescripts.bundle.js"></script>

    <!-- page vendor js file -->
    <script src="{{ asset('assets') }}/vendor/toastr/toastr.js"></script>
    <script src="{{ asset('assets') }}/bundles/c3.bundle.js"></script>

    <!-- page js file -->
    <script src="{{ asset('assets') }}/bundles/mainscripts.bundle.js"></script>
    <script src="{{ asset('assets') }}/html-versiokn/js/index.js"></script>

    <script src="{{ asset('assets') }}/html-versiokn/js/pages/tables/jquery-datatable.js"></script>

    {{-- select2 --}}
    <script src="{{ asset('assets') }}/select2/js/select2.full.min.js"></script>

    @yield('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.select').select2();

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
        });
    </script>

</body>

</html>
