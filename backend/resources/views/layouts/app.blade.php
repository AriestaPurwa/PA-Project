<!DOCTYPE html>
<html>
<head>
    <title>RBS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
 
    {{-- CHANGED: Navbar menggunakan class app-navbar tambahan dan h3 diperbarui dengan ikon SVG --}}
    <div class="navbar app-navbar">
        {{-- CHANGED: H3 judul sekarang lebih ringkas agar tidak memakan tempat --}}
        <h3>Risk Breakdown Structure System</h3>
 
        @guest
 
            {{-- CHANGED: Tombol Login pakai btn-secondary (warna muted di navbar) --}}
            <a href="/login" class="btn-secondary">
                Login
            </a>
 
            {{-- CHANGED: Tombol Register pakai btn/app-btn (warna biru solid) --}}
            <a href="/register" class="btn app-btn">
                Register
            </a>
 
        @endguest
 
        @auth
 
            {{-- CHANGED: Span sapaan user tetap ada, styling dihandle di CSS --}}
            <span>
                Hi, {{ auth()->user()->name }}
            </span>
 
            {{-- CHANGED: Tombol Dashboard pakai btn-secondary agar konsisten dengan navbar gelap --}}
            <a href="{{ url('/dashboard') }}" class="btn-secondary">
                Dashboard
            </a>
 
            {{-- CHANGED: Form logout inline, tombol pakai btn app-btn --}}
            <form action="/logout" method="POST" class="inline-form">
                @csrf
 
                <button type="submit" class="btn app-btn">
                    Logout
                </button>
            </form>
 
        @endauth
    </div>
 
    <div class="container app-layout">
        
        {{-- CHANGED: Sidebar dengan class app-sidebar tambahan --}}
        <div class="sidebar app-sidebar">

            <div class="sidebar-section">
                <h4>Menu</h4>

                <a
                    href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}"
                >
                    Dashboard
                </a>

                <a
                    href="{{ route('projects.index') }}"
                    class="sidebar-link {{ request()->routeIs('projects.index') ? 'active' : '' }}"
                >
                    Projects
                </a>

                <a
                    href="{{ route('risk-overview') }}"
                    class="sidebar-link {{ request()->is('risk-overview*') ? 'active' : '' }}"
                >
                    Risk Overview
                </a>

                <a
                    href="{{ route('activity-log') }}"
                    class="sidebar-link {{ request()->is('activity-log*') ? 'active' : '' }}"
                >
                    Activity Log
                </a>

                <a
                    href="{{ route('reports.index') }}"
                    class="sidebar-link {{ request()->is('reports*') ? 'active' : '' }}"
                >
                    Reports
                </a>
                    Reports
                </a>
            </div>

            <div class="sidebar-section">
                <h4>System</h4>

                <a
                    href="{{ url('/user-guide') }}"
                    class="sidebar-link {{ request()->is('user-guide*') ? 'active' : '' }}"
                >
                    User Guide
                </a>

                <a
                    href="{{ url('/settings') }}"
                    class="sidebar-link {{ request()->is('settings*') ? 'active' : '' }}"
                >
                    Settings
                </a>

                <a
                    href="{{ url('/about-system') }}"
                    class="sidebar-link {{ request()->is('about-system*') ? 'active' : '' }}"
                >
                    About System
                </a>
            </div>

        </div>
 
        {{-- CHANGED: Area konten utama dengan class app-content --}}
        <div class="content app-content">
            @yield('content')
        </div>
 
    </div>
    
    @stack('scripts')
    
</body>
</html>