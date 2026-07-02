@extends('layouts.guest')

@section('content')

<div class="guest-form-page">

    <div class="guest-form-card">

        <div class="guest-form-header">
            <div>
                <span class="page-label">Guest Category</span>
                <h2>Edit Category</h2>
                <p>Perbarui nama category atau subcategory pada project guest.</p>
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
            action="{{ route('guest.category.update', $category['id']) }}"
            method="POST"
            class="guest-modern-form"
        >
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="nama_kategori">
                    Nama Category
                </label>

                <input
                    id="nama_kategori"
                    type="text"
                    name="nama_kategori"
                    class="form-input"
                    value="{{ old('nama_kategori', $category['nama_kategori'] ?? '') }}"
                    required
                >
            </div>

            <div class="guest-form-actions">
                <a href="{{ route('guest.editor') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Update Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection