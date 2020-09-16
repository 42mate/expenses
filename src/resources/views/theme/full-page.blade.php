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

    <meta property="twitter:creator" content="@42mate" />
    <meta property="twitter:site" content="@42mate" />
    <meta property="twitter:domain" content="expenses.casivaagustin.com.ar" />
    <meta property="twitter:image:src" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="twitter:title" content="Expenses" />
    <meta property="og:description" content="Tracking Expanses made easy." />
    <meta property="twitter:image" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="twitter:card" content="Tracking expanses made easy" />
    <meta property="og:image" content="http://expenses.casivaagustin.com.ar/images/login-image.jpg" />
    <meta property="og:title" content="Expenses" />
    <meta property="og:url" content="http://expenses.casivaagustin.com.ar" />
    <meta property="og:site_name" content="Expenses" />
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

<body class="">

<div class="container pt-5">
    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center">
                        @yield('content')
    </div>
</div>

</body>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
