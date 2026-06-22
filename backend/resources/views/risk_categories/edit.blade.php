@extends('layouts.app')

@section('content')

<div class="project-form-page category-form-page">

    <div class="project-form-header">
        <div>
            <h2>Edit Category</h2>
            <p>Perbarui nama kategori risiko pada struktur RBS project.</p>
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
            <span>Current Category</span>
            <h3>{{ $category->nama_kategori }}</h3>
            <p>
                Category ini berada pada project <strong>{{ $project->nama_project }}</strong>.
            </p>
        </div>

    </div>

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Informasi Category</h3>
                <p>Ubah nama category sesuai struktur risiko yang digunakan.</p>
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

        <form
            action="{{ route('projects.categories.update', [$project->id, $category->id]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="project-form-section">

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

                <div class="category-guide-box single">

                    <div class="category-guide-item">
                        <span>ℹ️</span>
                        <div>
                            <strong>Catatan</strong>
                            <p>
                                Halaman ini hanya mengubah nama category.
                                Posisi parent category tetap mengikuti struktur sebelumnya.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
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