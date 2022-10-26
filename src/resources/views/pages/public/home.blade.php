@extends('theme/full-page')
@section('title')
   {{ __('Welcome') }}!
@endsection
@section('content')
    <div class="mkt">
        <div class="row align-items-center btn-spacer">
            <div class="col-12 col-sm-12 col-xs-12 col-md-6 col-lg-6">
                <!-- Heading -->
                <h1 class="display-3 text-center text-md-left">
                    <span class="text-primary">{{ __('Expenses') }}</span>
                </h1>

                <!-- Text -->
                <p class="lead text-center text-md-left text-muted mb-6 mb-lg-8 ">
                    {{ __('The most simple web application to keep track of your expenses in order to get insights to optimize your money.') }}
                </p>

                <!-- Buttons -->
                <div class="text-center text-md-left mb-5">
                    @guest
                        <a href="/register" class="btn btn-primary shadow lift mr-1">
                            {{ __('Create an account!') }}
                        </a>
                        <a href="/login" class="btn btn-primary-soft lift">
                            {{ __('Login') }}
                        </a>
                    @endguest
                    @auth
                        <a href="/dashboard" class="btn btn-primary shadow lift mr-1">
                            {{ __('Welcome back') }} {{ Auth::user()->name}}, {{ __('Go to the dashboard') }}.
                        </a>
                    @endauth

                </div>
            </div>
            <div class="col-12 col-sm-12 col-xs-12 col-md-6 col-lg-6">
                <img src="/images/home.svg" class="img-fluid"/>
            </div>
        </div>
        <div class="row align-items-top">
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up">
                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-lightbulb mr-2"></i> {{ __('What is it?') }}
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    {{ __("It's a web application to track expenses in order to have control of your money.") }}
                </p>
            </div>
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="50">

                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-cog mr-2"></i> {{ __('How it works?') }}
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    {{ __('This tool will help you to keep you on budget, know your history of expenses, and get detailed insights to optimize your money.') }}
                </p>

            </div>
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="100">

                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-vial mr-2"></i> {{ __('Simple as it should be') }}
                </h3>

                <!-- Text -->
                <p class="text-muted mb-0">
                    {{ __("There isn't any extra feature, just expense tracking and reporting. We want to make it simple, not fancy.") }}
                </p>

            </div>
            <div class="col-12 btn-spacer"></div>
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up">
                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-comment-dollar mr-2"></i> Organize your expenses
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    You can create your own categories to classify your expenses.
                </p>

            </div>
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="50">
                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-tags mr-2"></i> Tag your expenses
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    You can create tags to flag some expenses, for example when you are traveling in order to easly
                    indentify
                    the cost of your trip.
                </p>
            </div>
            <div class="col-12 col-md-4 aos-init aos-animate mb-5" data-aos="fade-up" data-aos-delay="100">
                <!-- Heading -->
                <h3 class="mb-3">
                    <i class="fas fa-comment-dollar mr-2"></i> It's free!!!
                </h3>

                <!-- Text -->
                <p class="text-muted mb-0">
                    Yes, the app is totally free.
                </p>
            </div>
            <div class="col-12 btn-spacer"></div>
        </div>
    </div>
    <div class="text-align-center mt-2 mb-5">
        Made with <i class="fas fa-heart"></i> in <a href="https://www.42mate.com">42mate</a>
    </div>
@endsection
