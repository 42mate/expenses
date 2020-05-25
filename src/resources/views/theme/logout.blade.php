<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>@yield('title')</title>
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link type="text/css" rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="bg-gradient-primary">

<body class="bg-gradient-primary">

<div class="container pt-5">
    <div class="title-brand text-center">
        <a href="{{ route('home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
    </div>

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</body>
<script src="/js/app.js"></script>
</html>
