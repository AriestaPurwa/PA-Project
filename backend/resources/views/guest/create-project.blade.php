@extends('layouts.app')

@section('content')

<div class="project-form-page guest-project-page">

    <div class="project-form-header">
        <div>
            <h2>Guest Mode</h2>
            <p>Buat project sementara tanpa login untuk mencoba fitur RBS.</p>
        </div>

        <a href="{{ url('/') }}" class="btn-secondary">
            ← Back to Home
        </a>
    </div>

    <div class="guest-mode-banner">

        <div class="guest-mode-icon">
            👤
        </div>

        <div>
            <span>Guest Access</span>
            <h3>Project ini hanya tersimpan sementara</h3>
            <p>
                Data guest tidak disimpan secara permanen ke akun pengguna.
                Gunakan fitur ini untuk mencoba membuat struktur RBS dan melakukan export diagram.
            </p>
        </div>

    </div>

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Informasi Guest Project</h3>
                <p>Masukkan informasi dasar project sebelum masuk ke editor RBS.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/guest-mode') }}" method="POST">
            @csrf

            <div class="project-form-section">

                <div class="form-group">
                    <label class="form-label" for="nama_project">
                        Nama Project
                    </label>

                    <input
                        id="nama_project"
                        type="text"
                        name="nama_project"
                        class="form-input"
                        placeholder="Contoh: Project Simulasi Risiko"
                        value="{{ old('nama_project') }}"
                        required
                        autocomplete="off"
                    >

                    <small class="form-help">
                        Nama ini akan digunakan sebagai root pada diagram RBS.
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">
                        Deskripsi
                        <span class="label-optional">(opsional)</span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                        placeholder="Tulis deskripsi singkat tentang project guest ini..."
                    >{{ old('deskripsi') }}</textarea>

                    <small class="form-help">
                        Deskripsi hanya digunakan sebagai informasi tambahan pada project sementara.
                    </small>
                </div>

                <div class="guest-feature-list">

                    <div class="guest-feature-item">
                        <span>🌳</span>
                        <p>Membuat struktur RBS sementara</p>
                    </div>

                    <div class="guest-feature-item">
                        <span>🛡️</span>
                        <p>Menambahkan kategori dan risiko</p>
                    </div>

                    <div class="guest-feature-item">
                        <span>📤</span>
                        <p>Export diagram tanpa login</p>
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ url('/') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Start Guest Project
                </button>
            </div>

        </form>

    </div>

</div>

@endsection