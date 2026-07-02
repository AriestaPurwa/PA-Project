<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guest RBS Editor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="guest-modern-shell">

    <header class="guest-modern-topbar">

        <div class="guest-modern-brand">
            <div class="guest-modern-brand-icon">
                R
            </div>

            <div>
                <h3>RBS Guest Mode</h3>
                <span>Temporary Risk Breakdown Structure Editor</span>
            </div>
        </div>

        <div class="guest-modern-actions">
            <span class="guest-modern-badge">
                Guest Access
            </span>

            <a href="/login" class="guest-login-btn">
                Login to Save
            </a>
        </div>

    </header>

    <main class="guest-modern-content">

        @if(session('success'))
            <div class="guest-flash success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="guest-flash error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')

    </main>

</div>

@stack('scripts')

</body>
</html>