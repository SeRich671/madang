<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-body-secondary">
    <div id="app">
        @include('parts.fixed-nav')
        @include('parts.second-nav')

        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="border-bottom border-primary bg-white p-3">
                            <h3 class="text-primary">Panel administracyjny</h3>
                        </div>
                        <div class="list-group">
                            <a href="{{ route('admin.order.index') }}" class="list-group-item list-group-item-light list-group-item-action text-primary">Zamówienia</a>
                        </div>
                    </div>
                    @if($menuName)
                        <div class="col-lg-9">
                            <div class="border-bottom border-primary bg-white p-3">
                                <h3 class="text-primary">{{ $menuName }}</h3>
                            </div>
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <div class="bg-white p-1">
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            @if(session('success'))
                                <div class="bg-white p-3">
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif
                            <div class="bg-white p-3">
                                @yield('content')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
        @include('parts.footer')
    </div>
    @stack('scripts')
</body>
</html>
