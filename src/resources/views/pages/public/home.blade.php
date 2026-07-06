@extends('theme/full-page')
@section('title')
   {{ __('Welcome') }}!
@endsection
@section('content')
<div class="landing container">

    {{-- Navbar --}}
    <nav class="landing-nav">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-mark"><i class="fas fa-wallet"></i></span>
            {{ config('app.name', 'Expenses') }}
        </a>
        <div class="nav-actions">
            @guest
                <a href="{{ route('login') }}" class="btn btn-ghost">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-primary">{{ __('Get started') }}</a>
            @else
                <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Go to dashboard') }}</a>
            @endguest
        </div>
    </nav>

    {{-- Hero --}}
    <header class="landing-hero">
        <div class="row align-items-center g-5">
            <div class="col-12 col-lg-6 text-center text-lg-start">
                <span class="eyebrow">
                    <i class="fas fa-circle-check"></i> {{ __('Free & open source') }}
                </span>

                <h1>
                    {{ __('Take control of your') }}
                    <span class="gradient-text">{{ __('money') }}</span>.
                </h1>

                <p class="lead mx-auto mx-lg-0">
                    {{ __('Track expenses, incomes, wallets and recurrent payments across multiple currencies — and turn them into insights that help you spend smarter.') }}
                </p>

                <div class="hero-cta justify-content-center justify-content-lg-start">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg lift">
                            {{ __('Create your free account') }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-lg lift">
                            {{ __('Sign in') }}
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg lift">
                            {{ __('Welcome back') }}, {{ Auth::user()->name }} — {{ __('go to dashboard') }}
                        </a>
                    @endguest
                </div>

                <div class="hero-trust justify-content-center justify-content-lg-start">
                    <span><i class="fas fa-check"></i> {{ __('No credit card') }}</span>
                    <span><i class="fas fa-check"></i> {{ __('Multi-currency') }}</span>
                    <span><i class="fas fa-check"></i> {{ __('Private by design') }}</span>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="hero-art">
                    <img src="/images/hero.svg" class="img-fluid" alt="{{ __('Expenses dashboard illustration') }}"/>
                </div>
            </div>
        </div>
    </header>

    {{-- Features --}}
    <section class="landing-features">
        <div class="section-heading">
            <h2>{{ __('Everything you need, nothing you don\'t') }}</h2>
            <p>{{ __('A simple, focused way to understand where your money goes.') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="feature-card">
                    <span class="feature-icon"><i class="fas fa-lightbulb"></i></span>
                    <h3>{{ __('What is it?') }}</h3>
                    <p>{{ __("A web app to track your expenses and incomes so you always know exactly where your money stands.") }}</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="feature-card accent-green">
                    <span class="feature-icon"><i class="fas fa-chart-line"></i></span>
                    <h3>{{ __('How it works') }}</h3>
                    <p>{{ __('Log each transaction as you spend or earn. The app stores everything and turns it into clear reports and trends.') }}</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="feature-card accent-amber">
                    <span class="feature-icon"><i class="fas fa-heart"></i></span>
                    <h3>{{ __("It's free") }}</h3>
                    <p>{{ __('Completely free and open source. Own your data and grab the code whenever you like.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    @guest
    <section class="landing-cta">
        <h2>{{ __('Ready to master your finances?') }}</h2>
        <p>{{ __('Join now and start tracking in minutes — it only takes a few clicks.') }}</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg lift">
            {{ __('Create an account') }} <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </section>
    @endguest

    {{-- Footer --}}
    <footer class="landing-footer">
        {{ __('Made with') }} <i class="fas fa-heart"></i> {{ __('in') }}
        <a href="https://www.42mate.com" target="_blank" rel="noopener">42mate</a>
    </footer>

</div>
@endsection
