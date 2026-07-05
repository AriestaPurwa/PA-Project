@extends('layouts.auth')

@section('content')

<div class="form-page">
    <div class="auth-brand">
        <div class="auth-brand-icon"></div>
        <h1>RBS System</h1>
        <p>Risk Breakdown Structure System</p>
    </div>

    <div class="form-card">

        <h2 class="form-title">Register</h2>

        <p class="form-subtitle">
            Buat akun untuk menyimpan project secara permanen.
        </p>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-input"
                        required
                    >
                </div>

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
                        Register
                    </button>
                </div>

                <div style="margin-top:10px;">
                    Sudah punya akun?
                    <a href="/login">Login</a>
                </div>

            </div>

        </form>

    </div>

</div>

@endsection