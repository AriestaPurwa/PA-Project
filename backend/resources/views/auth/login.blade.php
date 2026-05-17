@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">Login</h2>

        <p class="form-subtitle">
            Login untuk menyimpan dan mengelola project RBS Anda.
        </p>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/login" method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-input"
                        required
                    >
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn app-btn">
                        Login
                    </button>
                </div>

                <div style="margin-top:10px;">
                    Belum punya akun?
                    <a href="/register">Register</a>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection