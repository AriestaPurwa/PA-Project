@extends('layouts.app')

@section('content')

<div class="project-form-page category-form-page modern-project-form-page modern-category-form-page">

    {{-- ===== HEADER ===== --}}
    <div class="project-form-hero category-form-hero">
        <div>
            <span class="page-label">Create Category</span>
            <h2>Tambah Category</h2>
            <p>
                Tambahkan kategori risiko baru ke dalam struktur Risk Breakdown Structure project.
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
            <span>Project</span>
            <h3>{{ $project->nama_project }}</h3>
            <p>
                Kategori dapat dibuat sebagai root category atau sub-category dari kategori yang sudah ada.
            </p>
        </div>

    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="project-form-card modern-project-form-card">

        <div class="project-form-card-header modern-project-form-card-header">
            <div>
                <span class="section-kicker">Category Information</span>
                <h3>Informasi Category</h3>
                <p>Tentukan nama kategori dan posisi parent pada struktur RBS.</p>
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

        <form method="POST" action="{{ route('projects.categories.store', $project->id) }}">
            @csrf

            <div class="project-form-section modern-project-form-section">

                {{-- ===== BASIC CATEGORY ===== --}}
                <div class="form-section-title">
                    <span>01</span>
                    <div>
                        <h4>Data Category</h4>
                        <p>Masukkan nama category dan tentukan posisinya dalam struktur RBS.</p>
                    </div>
                </div>

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="nama_kategori">
                            Nama Category
                        </label>

                        <input
                            id="nama_kategori"
                            type="text"
                            name="nama_kategori"
                            class="form-input"
                            placeholder="Contoh: Technical, External, Organizational"
                            value="{{ old('nama_kategori') }}"
                            required
                            autocomplete="off"
                        >

                        <small class="form-help">
                            Gunakan nama kategori yang mewakili sumber risiko.
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="parent_id">
                            Parent Category
                        </label>

                        <select
                            id="parent_id"
                            name="parent_id"
                            class="form-select"
                        >
                            <option value="">
                                — Jadikan Root Category —
                            </option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('parent_id', request('parent')) == $category->id ? 'selected' : '' }}
                                >
                                    {{ str_repeat('— ', $category->level ?? 0) }}{{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        <small class="form-help">
                            Biarkan kosong jika kategori ini berada pada level utama.
                        </small>
                    </div>

                </div>

                {{-- ===== GUIDE ===== --}}
                <div class="form-section-title">
                    <span>02</span>
                    <div>
                        <h4>Panduan Struktur</h4>
                        <p>Pilih apakah category menjadi level utama atau turunan category lain.</p>
                    </div>
                </div>

                <div class="category-guide-box modern-category-guide-box">

                    <div class="category-guide-item modern-category-guide-item">
                        <span>🌳</span>
                        <div>
                            <strong>Root Category</strong>
                            <p>Kategori utama yang langsung berada di bawah project.</p>
                        </div>
                    </div>

                    <div class="category-guide-item modern-category-guide-item">
                        <span>↳</span>
                        <div>
                            <strong>Sub Category</strong>
                            <p>Kategori turunan yang berada di bawah parent category tertentu.</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="project-form-actions modern-project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Simpan Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection