@extends('theme/full-page')
@section('content')
<div class="mkt">
    <div class="row align-items-center btn-spacer">
        <div class="col-12 col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <!-- Heading -->
            <h1 class="display-3 text-center text-md-left">
                Welcome to <span class="text-primary">Expenses</span>
            </h1>

            <!-- Text -->
            <p class="lead text-center text-md-left text-muted mb-6 mb-lg-8 ">
                The most simple web application to keep track of your expenses in order to get insights to
                optimize your money.
            </p>

            <!-- Buttons -->
            <div class="text-center text-md-left mb-5">
                @guest
                <a href="/register" class="btn btn-primary shadow lift mr-1">
                    Create an account!
                </a>
                <a href="/login" class="btn btn-primary-soft lift">
                    Sign in
                </a>
                @endguest
                @auth
                <a href="/dashboard" class="btn btn-primary shadow lift mr-1">
                    Welcome back {{ Auth::user()->name}}, Go to the dashboard.
                </a>
                @endauth

            </div>
        </div>
        <div class="col-12 col-sm-12 col-xs-12 col-md-6 col-lg-6">
            <img src="https://landkit.goodthemes.co/assets/img/illustrations/illustration-2.png"  class="img-fluid" />
        </div>
    </div>
    <div class="row align-items-top">
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up">
            <!-- Heading -->
            <h3>
                <i class="fas fa-lightbulb"></i> What is it?
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
                It's a web application to track expenses in order to have control of your money.
            </p>

        </div>
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="50">

            <!-- Heading -->
            <h3>
                <i class="fas fa-cog"></i> How it works?
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
                This tool will help you to keep you on budget, know your history of expenses, and get detailed insights to optimize your money.
            </p>

        </div>
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="100">

            <!-- Heading -->
            <h3>
                <i class="fas fa-vial"></i> Simple as it should be
            </h3>

            <!-- Text -->
            <p class="text-muted mb-0">
                There isn't any extra feature, just expense tracking and reporting. We want to make it simple, not fancy.
            </p>

        </div>
        <div class="col-12 btn-spacer"></div>
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up">
            <!-- Heading -->
            <h3>
                <i class="fas fa-comment-dollar"></i> Organize your expenses
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
                You can create your own categories to classify your expenses.
            </p>

        </div>
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="50">
            <!-- Heading -->
            <h3>
                <i class="fas fa-tags"></i> Tag your expenses
            </h3>

            <!-- Text -->
            <p class="text-muted mb-6 mb-md-0">
                You can create tags to flag some expenses, for example when you are traveling in order to easly indentify
                the cost of your trip.
            </p>
        </div>
        <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="100">
            <!-- Heading -->
            <h3>
                <i class="fas fa-comment-dollar"></i> It's free!!!
            </h3>

            <!-- Text -->
            <p class="text-muted mb-0">
                Yes, the app is totally free.
            </p>
        </div>
        <div class="col-12 btn-spacer"></div>
    </div>
</div>
@endsection
