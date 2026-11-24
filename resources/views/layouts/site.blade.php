<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@hasSection('title')@yield('title') | @endif{{ config('app.name') }}</title>

    <meta name="description" content="Welcome to Miracle of Salvation Church, Kampala, Uganda. Join us for worship, prayer, fellowship and spiritual growth.">

    <link rel="icon" href="{{ asset('site/images/logo.jpeg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('site/css/app.css') }}">

    @livewireStyles
</head>

<body>

<header class="site-header">

    <div class="header-container">

        <a href="{{ route('home') }}" class="brand">
            <img
                src="{{ asset('site/images/logo.jpeg') }}"
                alt="Miracle of Salvation Church Logo"
                class="site-logo"
            >

            <div class="brand-name">
                <span>MIRACLE OF</span>
                <span>SALVATION</span>
                <span>CHURCH</span>
            </div>
        </a>

        <button class="menu-toggle"
                id="menuToggle"
                type="button"
                aria-label="Open navigation menu"
                aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-navigation" id="mainNavigation">

            <ul class="nav-links">

                <li>
                    <a href="{{ route('home') }}">HOME</a>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('about.church-profile') }}">ABOUT US</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('about.vision-bearer') }}">vision bearer</a></li>
                        <li><a href="{{ route('about.church-profile') }}">church profile</a></li>
                        <li><a href="{{ route('about.leadership') }}">leadership</a></li>
                        <li><a href="{{ route('branches') }}">our branches</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('events') }}">EVENTS</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('events.church-programs') }}">church programs</a></li>
                        <li><a href="{{ route('events') }}">upcoming events</a></li>
                        <li><a href="{{ route('events.community-outreach') }}">community outreach</a></li>
                        <li><a href="{{ route('events.missions') }}">missions</a></li>
                        <li><a href="{{ route('announcements') }}">announcements</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ $navMinistries->isNotEmpty() ? route('ministries.show', $navMinistries->first()->slug) : route('ministries.gallery') }}">MINISTRIES</a>
                    <ul class="dropdown">
                        @foreach ($navMinistries as $navMinistry)
                            <li><a href="{{ route('ministries.show', $navMinistry->slug) }}">{{ str($navMinistry->name)->lower() }}</a></li>
                        @endforeach
                        <li><a href="{{ route('ministries.gallery') }}">church gallery</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('live') }}">LIVESTREAM</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('live') }}">watch live</a></li>
                        <li><a href="{{ route('livestream.sermons') }}">sermons archive</a></li>
                        <li><a href="{{ route('livestream.videos') }}">videos</a></li>
                    </ul>
                </li>

                <li class="has-dropdown">
                    <a href="{{ route('contact') }}">CONTACT</a>
                    <ul class="dropdown">
                        <li><a href="{{ route('contact') }}">contact us</a></li>
                        <li><a href="{{ route('prayer-requests') }}">prayer requests</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('give') }}" class="give-link">GIVE</a>
                </li>

            </ul>

        </nav>

    </div>

</header>

@yield('content')

<footer class="site-footer">

    <div class="footer-contact">
        <h3>CONTACT US</h3>

        <p><strong>Church:</strong> {{ $settings['church_name'] }}</p>

        @if ($settings['address'])
            <p><strong>Address:</strong> {{ $settings['address'] }}</p>
        @endif
        @if ($settings['phone'])
            <p><strong>Phone:</strong> <a href="tel:{{ $settings['phone'] }}">{{ $settings['phone'] }}</a></p>
        @endif
        @if ($settings['email'])
            <p><strong>Email:</strong> <a href="mailto:{{ $settings['email'] }}">{{ $settings['email'] }}</a></p>
        @endif
        @if ($settings['service_times'])
            <p><strong>Services:</strong> {{ $settings['service_times'] }}</p>
        @endif

        <p>Join us for worship, prayer and fellowship.</p>

        @include('site.partials.social-links')
    </div>

    <div class="footer-bottom">
        <p>
            &copy; {{ date('Y') }} {{ $settings['church_name'] }}.
            All Rights Reserved.
        </p>
    </div>

</footer>

<script src="{{ asset('site/js/script.js') }}"></script>

@livewireScripts

</body>
</html>
