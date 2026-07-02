@extends('layouts.guest')

@section('content')

<div class="guest-form-page">

    <div class="guest-form-card">

        <div class="guest-form-header">
            <div>
                <span class="page-label">Guest Project</span>
                <h2>Edit Guest Project</h2>
                <p>Perbarui nama dan deskripsi project guest sementara.</p>
            </div>

            <a href="{{ route('guest.editor') }}" class="btn-secondary">
                ← Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="guest-alert-error">
                <strong>Terjadi kesalahan input</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('guest.project.update') }}"
            method="POST"
            class="guest-modern-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="nama_project">
                    Nama Project
                </label>

                <input
                    id="nama_project"
                    type="text"
                    name="nama_project"
                    class="form-input"
                    value="{{ old('nama_project', $project['nama_project'] ?? '') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="deskripsi">
                    Deskripsi
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    class="form-textarea"
                    rows="5"
                >{{ old('deskripsi', $project['deskripsi'] ?? '') }}</textarea>
            </div>

            <div class="guest-form-actions">
                <a href="{{ route('guest.editor') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Update Project
                </button>
            </div>

        </form>

    </div>

</div>

@endsection