<!DOCTYPE html>
<html lang="en">
<head>
    <title>RBS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="app-shell">

    {{-- SIDEBAR --}}
    <aside class="app-sidebar">

        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                R
            </div>

            <div>
                <h3>RBS System</h3>
                <span>Risk Management Tool</span>
            </div>
        </div>

        <nav class="sidebar-nav">

            <div class="sidebar-section">
                <h4>Main Menu</h4>

                <a
                    href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">▦</span>
                    Dashboard
                </a>

                <a
                    href="{{ route('projects.index') }}"
                    class="sidebar-link {{ request()->routeIs('projects.*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">▤</span>
                    Projects
                </a>

                <a
                    href="{{ route('risk-overview') }}"
                    class="sidebar-link {{ request()->is('risk-overview*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">⚠</span>
                    Risk Overview
                </a>

                <a
                    href="{{ route('activity-log') }}"
                    class="sidebar-link {{ request()->is('activity-log*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">◷</span>
                    Activity Log
                </a>

                <a
                    href="{{ route('reports.index') }}"
                    class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">▣</span>
                    Reports
                </a>
            </div>

            <div class="sidebar-section">
                <h4>System</h4>

                <a
                    href="{{ route('user-guide') }}"
                    class="sidebar-link {{ request()->is('user-guide*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">?</span>
                    User Guide
                </a>

                <a
                    href="{{ route('settings') }}"
                    class="sidebar-link {{ request()->is('settings*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">⚙</span>
                    Settings
                </a>

                <a
                    href="{{ route('about-system') }}"
                    class="sidebar-link {{ request()->is('about-system*') ? 'active' : '' }}"
                >
                    <span class="sidebar-icon">i</span>
                    About System
                </a>
            </div>

        </nav>

    </aside>

    {{-- MAIN AREA --}}
    <main class="app-main">

        {{-- TOPBAR --}}
        <header class="app-topbar">

            <div class="topbar-title">
                <span class="topbar-kicker">Risk Breakdown Structure</span>
                <h1>Project Risk Management</h1>
            </div>

            <div class="topbar-actions">

                @guest
                    <a href="/login" class="topbar-link">
                        Login
                    </a>

                    <a href="/register" class="btn app-btn">
                        Register
                    </a>
                @endguest

                @auth
                    <div class="topbar-user">
                        <div class="topbar-avatar">
                            @if(!empty(auth()->user()->profile_photo))
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile Photo">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>

                        <div class="topbar-user-info">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>Authenticated User</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline-form">
                        @csrf

                        <button type="submit" class="btn logout-btn">
                            Logout
                        </button>
                    </form>
                @endauth

            </div>

        </header>

        {{-- CONTENT --}}
        <section class="app-content">
            @yield('content')
        </section>

    </main>

</div>

@stack('scripts')

</body>
</html>