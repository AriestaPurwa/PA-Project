{{-- file views\projects\create.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="form-page">

    {{-- CHANGED: Tombol back dengan label yang lebih jelas --}}
    <div class="mb-3">
        <a href="{{ route('projects.index') }}" class="btn-secondary">
            ← Kembali ke Daftar Project
        </a>
    </div>

    {{-- CHANGED: Guest mode notice tampil lebih mencolok dengan icon --}}
    @if(request('guest'))
        <div class="card app-card">
            {{-- CHANGED: Icon warning di depan teks --}}
            <strong>⚠️ Guest Mode Active</strong><br>
            {{-- CHANGED: Teks lebih informatif --}}
            <span style="font-size:13px; color:#78350f;">Project ini bersifat sementara dan tidak tersimpan secara permanen.</span>
        </div>
    @endif

    <div class="form-card">

        {{-- CHANGED: Judul dan subtitle dipisahkan dengan lebih jelas --}}
        <h2 class="form-title">Tambah Project</h2>
        <p class="form-subtitle">Buat project baru untuk mulai menyusun kategori risiko dan risk matrix.</p>

        {{-- CHANGED: Error alert tampil di dalam form-card --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            @if(request()->has('guest'))
                <input type="hidden" name="guest_mode" value="1">
            @endif

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label" for="nama_project">Nama Project</label>
                    <input
                        id="nama_project"
                        type="text"
                        name="nama_project"
                        class="form-input"
                        placeholder="Contoh: Pembangunan Gedung A"
                        value="{{ old('nama_project') }}"
                        required
                        autocomplete="off"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">Deskripsi <span style="font-weight:400; color:#94a3b8;">(opsional)</span></label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                        placeholder="Tulis deskripsi singkat tentang project ini..."
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn app-btn">Simpan Project</button>
                    <a href="{{ route('projects.index') }}" class="btn-secondary">Batal</a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection