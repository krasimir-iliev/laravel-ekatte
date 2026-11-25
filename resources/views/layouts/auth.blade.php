<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Styles / Scripts -->
    @vite([
        'resources/sass/app.scss',
        'resources/js/app.js'
    ])
</head>
<body>
    <div id="auth">
        <main>
            <div class="container-fluid">
                <div class="vh-100 d-flex flex-wrap justify-content-center align-items-center">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex align-items-center bg-transparent border-transparent">
                            <div class="card-title mb-0">@yield('title')</div>

                            <div class="btn-group btn-group-sm flex-shrink-0 ml-auto" role="group">
                                <div class="dropdown">
                                    @php
                                        $currentLocale = LaravelLocalization::getCurrentLocale();
                                    @endphp
                                    <button type="button" class="btn btn-link d-block border-0 text-decoration-none dropdown-toggle pl-2 pr-0 py-0" data-toggle="dropdown">
                                        <span class="text-uppercase">{{ $currentLocale }}</span>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" @class(['dropdown-item', 'disabled' => $currentLocale == $localeCode])>
                                                {{ $properties['native'] }} (<span class="text-uppercase">{{ $localeCode }}</span>)
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

            @yield('scripts')
        </main>
    </div>
</body>
</html>
