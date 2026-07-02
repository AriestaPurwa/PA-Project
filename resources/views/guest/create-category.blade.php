@extends('layouts.guest')

@section('content')

<div class="project-form-page guest-category-page">

    <div class="project-form-header">
        <div>
            <h2>Add Guest Category</h2>
            <p>Tambahkan kategori sementara pada struktur RBS guest project.</p>
        </div>

        <a href="{{ url('/guest/editor') }}" class="btn-secondary">
            ← Back to Guest Editor
        </a>
    </div>

    <div class="guest-category-banner">

        <div class="guest-category-icon">
            🗂️
        </div>

        <div>
            <span>Guest Category</span>

            @if($parentId)
                <h3>Add Sub Category</h3>
                <p>
                    Category ini akan ditambahkan sebagai sub-category dari parent yang dipilih.
                </p>
            @else
                <h3>Add Root Category</h3>
                <p>
                    Category ini akan ditambahkan sebagai root category pada guest project.
                </p>
            @endif
        </div>

    </div>

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Category Information</h3>
                <p>Masukkan nama category untuk ditampilkan pada diagram RBS.</p>
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

        <form action="{{ url('/guest/category/store') }}" method="POST">
            @csrf

            <input
                type="hidden"
                name="parent_id"
                value="{{ $parentId }}"
            >

            <div class="project-form-section">

                <div class="form-group">
                    <label class="form-label" for="nama_kategori">
                        Category Name
                    </label>

                    <input
                        id="nama_kategori"
                        type="text"
                        name="nama_kategori"
                        class="form-input"
                        placeholder="Contoh: Technical, External, Resource"
                        value="{{ old('nama_kategori') }}"
                        required
                        autocomplete="off"
                    >

                    <small class="form-help">
                        Nama category akan tampil sebagai node pada diagram guest RBS.
                    </small>
                </div>

                <div class="guest-category-note">

                    <div class="guest-category-note-item">
                        <span>👤</span>
                        <div>
                            <strong>Guest Mode</strong>
                            <p>Data category hanya tersimpan sementara selama sesi guest aktif.</p>
                        </div>
                    </div>

                    <div class="guest-category-note-item">
                        <span>📤</span>
                        <div>
                            <strong>Export Available</strong>
                            <p>Diagram guest tetap dapat diexport setelah category dibuat.</p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ url('/guest/editor') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Save Category
                </button>
            </div>

        </form>

    </div>

</div>

@endsection