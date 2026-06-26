@extends('layouts.app')

@section('content')

<div class="project-form-page category-form-page modern-project-form-page modern-category-form-page">

    {{-- ===== HEADER ===== --}}
    <div class="project-form-hero category-form-hero">
        <div>
            <span class="page-label">Edit Category</span>
            <h2>Edit Category</h2>
            <p>
                Perbarui nama kategori risiko yang tampil pada struktur Risk Breakdown Structure project.
            </p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="project-form-back-btn">
            ← Kembali ke Project
        </a>
    </div>

    {{-- ===== CONTEXT CARD ===== --}}
    <div class="category-context-card modern-category-context-card">

        <div class="category-context-icon modern-category-context-icon">
            🗂️
        </div>

        <div>
            <span>Current Category</span>
            <h3>{{ $category->nama_kategori }}</h3>
            <p>
                Category ini berada pada project <strong>{{ $project->nama_project }}</strong>.
            </p>
        </div>

    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="project-form-card modern-project-form-card">

        <div class="project-form-card-header modern-project-form-card-header">
            <div>
                <span class="section-kicker">Category Information</span>
                <h3>Informasi Category</h3>
                <p>Ubah nama category sesuai struktur risiko yang digunakan.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-error modern-alert-error">
                <strong>Terjadi kesalahan input</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('projects.categories.update', [$project->id, $category->id]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="project-form-section modern-project-form-section">

                {{-- ===== BASIC CATEGORY ===== --}}
                <div class="form-section-title">
                    <span>01</span>
                    <div>
                        <h4>Data Category</h4>
                        <p>Perbarui nama category yang akan tampil pada diagram RBS.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama_kategori">
                        Nama Category
                    </label>

                    <input
                        id="nama_kategori"
                        type="text"
                        name="nama_kategori"
                        class="form-input"
                        value="{{ old('nama_kategori', $category->nama_kategori) }}"
                        required
                        autocomplete="off"
                    >

                    <small class="form-help">
                        Perubahan nama category akan langsung tampil pada diagram RBS.
                    </small>
                </div>

                {{-- ===== NOTE ===== --}}
                <div class="form-section-title">
                    <span>02</span>
                    <div>
                        <h4>Catatan Perubahan</h4>
                        <p>Halaman ini hanya mengubah nama category, bukan posisi parent category.</p>
                    </div>
                </div>

                <div class="category-guide-box single modern-category-guide-box">

                    <div class="category-guide-item modern-category-guide-item">
                        <span>ℹ️</span>
                        <div>
                            <strong>Posisi Category Tidak Berubah</strong>
                            <p>
                                Halaman ini hanya mengubah nama category.
                                Posisi parent category tetap mengikuti struktur sebelumnya.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="project-form-actions modern-project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Update Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection