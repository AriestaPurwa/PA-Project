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
            <a href="/projects" class="btn-secondary">
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
            {{-- CHANGED: H4 label "Menu" tetap ada, styling diperbarui di CSS jadi lebih kecil dan muted --}}
            <h4>Menu</h4>
 
            {{-- CHANGED: Link navigasi Projects mendapat padding dan hover state yang dihandle CSS --}}
            <a href="{{ route('projects.index') }}">Projects</a>
        </div>
 
        {{-- CHANGED: Area konten utama dengan class app-content --}}
        <div class="content app-content">
            @yield('content')
        </div>
 
    </div>
    
    @stack('scripts')
    
</body>
</html>