<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest RBS Editor</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="navbar guest-navbar">

        <h3>
            RBS Guest Mode
        </h3>

        <span>
            Temporary project
        </span>

        <a href="/login" class="btn-secondary">
            Login to Save
        </a>

    </div>

    <div class="guest-container">

        <main class="guest-content">

            @if(session('success'))
                <div class="app-card guest-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="app-card guest-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

    @stack('scripts')

</body>
</html>