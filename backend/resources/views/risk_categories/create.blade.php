@extends('layouts.app')

@section('content')

<div class="project-form-page category-form-page">

    <div class="project-form-header">
        <div>
            <h2>Tambah Category</h2>
            <p>Tambahkan kategori risiko baru ke dalam struktur RBS project.</p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Kembali ke Project
        </a>
    </div>

    <div class="category-context-card">

        <div class="category-context-icon">
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

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Informasi Category</h3>
                <p>Tentukan nama kategori dan posisi parent pada struktur RBS.</p>
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

        <form method="POST" action="{{ route('projects.categories.store', $project->id) }}">
            @csrf

            <div class="project-form-section">

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

                <div class="category-guide-box">

                    <div class="category-guide-item">
                        <span>🌳</span>
                        <div>
                            <strong>Root Category</strong>
                            <p>Kategori utama yang langsung berada di bawah project.</p>
                        </div>
                    </div>

                    <div class="category-guide-item">
                        <span>↳</span>
                        <div>
                            <strong>Sub Category</strong>
                            <p>Kategori turunan yang berada di bawah parent category tertentu.</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Simpan Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection