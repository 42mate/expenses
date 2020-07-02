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

    <meta property="twitter:creator" content="@42mate" />
    <meta property="twitter:site" content="@42mate" />
    <meta property="twitter:domain" content="expenses.casivaagustin.com.ar" />
    <meta property="twitter:image:src" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="twitter:title" content="My Expenses" />
    <meta property="og:description" content="Tracking Expanses made easy." />
    <meta property="twitter:image" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="twitter:card" content="Tracking expanses made easy" />
    <meta property="og:image" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="og:title" content="My Expenses" />
    <meta property="og:url" content="http://expenses.casivaagustin.com.ar" />
    <meta property="og:site_name" content="My Expenses" />
    <meta property="og:type" content="article" />
    <meta name="description" content="Tracking expenses made easy" />
    <meta name="abstract" content="A website to track your expenses, that's it" />
    <meta name="keywords" content="Expenses Tracking Personal Finances Simple" />
    <meta name="robots" content="follow, index" />
    <meta name="generator" content="42mate" />
    <link rel="image_src" href="" />
    <link rel="canonical" href="http://expenses.casivaagustin.com.ar" />
    <link rel="shortlink" href="http://expenses.casivaagustin.com.ar" />
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="cleartype" content="on">
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-none d-sm-block" id="accordionSidebar">
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
                @section('session_messages')
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                @endsection
                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @yield('modal')
        </div>
    </div>
</div>

</body>
<script src="/js/app.js"></script>
</html>
