@extends('theme/full-page')
@section('content')
    <div class="row align-items-center">
        <div class="col-6">
            <!-- Heading -->
            <h1 class="display-3 text-center text-md-left">
                Welcome to <span class="text-primary">Expenses</span>
            </h1>

            <!-- Text -->
            <p class="lead text-center text-md-left text-muted mb-6 mb-lg-8">
                The most simple web application to track and classify your expenses.
            </p>

            <!-- Buttons -->
            <div class="text-center text-md-left">
                <a href="/register" class="btn btn-primary shadow lift mr-1">
                    Start now!
                </a>
                <a href="/login" class="btn btn-primary-soft lift">
                    Sign in
                </a>
            </div>
        </div>
        <div class="col-6">
            <img src="https://landkit.goodthemes.co/assets/img/illustrations/illustration-2.png"  class="img-fluid" />
        </div>

        <div class="row mt-5">
            <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up">
alexis g imbaez
                <!-- Icon -->
                <div class="icon text-primary mb-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path d="M7 3h10a4 4 0 110 8H7a4 4 0 110-8zm0 6a2 2 0 100-4 2 2 0 000 4z" fill="#335EEA"></path><path d="M7 13h10a4 4 0 110 8H7a4 4 0 110-8zm10 6a2 2 0 100-4 2 2 0 000 4z" fill="#335EEA" opacity=".3"></path></g></svg>
                </div>

                <!-- Heading -->
                <h3>
                    What is it?
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    It's a web application to track expenses in order to have control of your money. This tool will help you to keep you on budget, know your history of expenses, and get detailed insights to optimize your money.
                </p>

            </div>
            <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">

                <!-- Icon -->
                <div class="icon text-primary mb-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path d="M5.5 4h4A1.5 1.5 0 0111 5.5v1A1.5 1.5 0 019.5 8h-4A1.5 1.5 0 014 6.5v-1A1.5 1.5 0 015.5 4zm9 12h4a1.5 1.5 0 011.5 1.5v1a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-1a1.5 1.5 0 011.5-1.5z" fill="#335EEA"></path><path d="M5.5 10h4a1.5 1.5 0 011.5 1.5v7A1.5 1.5 0 019.5 20h-4A1.5 1.5 0 014 18.5v-7A1.5 1.5 0 015.5 10zm9-6h4A1.5 1.5 0 0120 5.5v7a1.5 1.5 0 01-1.5 1.5h-4a1.5 1.5 0 01-1.5-1.5v-7A1.5 1.5 0 0114.5 4z" fill="#335EEA" opacity=".3"></path></g></svg>
                </div>

                <!-- Heading -->
                <h3>
                    How it works?
                </h3>

                <!-- Text -->
                <p class="text-muted mb-6 mb-md-0">
                    Every time you spend some money you need to register the expense and that's it. After that you'll have insights and information of your expenses.
                </p>

            </div>
            <div class="col-12 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

                <!-- Icon -->
                <div class="icon text-primary mb-3">
                    <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><path d="M0 0h24v24H0z"></path><path d="M17.272 8.685a1 1 0 111.456-1.37l4 4.25a1 1 0 010 1.37l-4 4.25a1 1 0 01-1.456-1.37l3.355-3.565-3.355-3.565zm-10.544 0L3.373 12.25l3.355 3.565a1 1 0 01-1.456 1.37l-4-4.25a1 1 0 010-1.37l4-4.25a1 1 0 011.456 1.37z" fill="#335EEA"></path><rect fill="#335EEA" opacity=".3" transform="rotate(15 12 12)" x="11" y="4" width="2" height="16" rx="1"></rect></g></svg>
                </div>

                <!-- Heading -->
                <h3>
                    Simple as it should be
                </h3>

                <!-- Text -->
                <p class="text-muted mb-0">
                    There isn't any extra feature, just expense tracking and reporting. We want to make it simple, not fancy. You don't need to know about accounting to use it, just create an account and start tracking your expenses.
                </p>

            </div>
        </div>
    </div>
@endsection
