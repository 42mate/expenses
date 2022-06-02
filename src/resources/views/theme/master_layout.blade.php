<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">

    <meta property="twitter:creator" content="@42mate"/>
    <meta property="twitter:site" content="@42mate"/>
    <meta property="twitter:domain" content="expenses.42mate.com"/>
    <meta property="twitter:image:src" content="http://expenses.42mate.com/images/login-image.jpg"/>
    <meta property="twitter:title" content="Expenses"/>
    <meta property="og:description" content="Tracking Expanses made easy."/>
    <meta property="twitter:image" content="http://expenses.42mate.com/images/login-image.jpg"/>
    <meta property="twitter:card" content="Tracking expanses made easy"/>
    <meta property="og:image" content="http://expenses.42mate.com/images/login-image.jpg"/>
    <meta property="og:title" content="Expenses"/>
    <meta property="og:url" content="http://expenses.42mate.com"/>
    <meta property="og:site_name" content="Expenses"/>
    <meta property="og:type" content="article"/>
    <meta name="description" content="Tracking expenses made easy"/>
    <meta name="abstract" content="A website to track your expenses, that's it"/>
    <meta name="keywords" content="Expenses Tracking Personal Finances Simple"/>
    <meta name="robots" content="follow, index"/>
    <meta name="generator" content="42mate"/>
    <link rel="image_src" href=""/>
    <link rel="canonical" href="http://expenses.42mate.com"/>
    <link rel="shortlink" href="http://expenses.42mate.com"/>
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="cleartype" content="on">
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico">
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark d-sm-block" id="accordionSidebar">
        @section('sidebar')
            @include('includes.sidebar')
        @show
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

        @section('toolbar')
            @include('includes.toolbar')
        @show

        <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('page_titĺe')

                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                @if (Session::has('warning'))
                    <div class="alert alert-warning">{{ Session::get('warning') }}</div>
                @endif

                @if (!$errors->isEmpty())
                    <div class="alert alert-danger">There are some errors, please verify</div>
                @endif

                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; 42mate - 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @yield('modal')
        </div>
    </div>
</div>

</body>
<script src="{{ mix('/js/app.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>


</html>
