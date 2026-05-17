@extends('layouts.app')

@section('content')

<div class="form-page">
    <div class="mb-3">
        <a href="{{ route('projects.index') }}" class="btn-secondary">
            ← Back
        </a>
    </div>

    @if(request('guest'))

        <div class="card app-card" style="margin-bottom:20px;">
            <strong>Guest Mode Active</strong><br>
            This project is temporary and will not be saved permanently.
        </div>
    @endif

    <div class="form-card">
        <h2 class="form-title">Tambah Project</h2>
        <p class="form-subtitle">Buat project baru untuk mulai menyusun kategori risiko dan risk matrix.</p>

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
                        placeholder="Masukkan nama project"
                        value="{{ old('nama_project') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">Deskripsi</label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                        placeholder="Tulis deskripsi singkat project"
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