@extends('layouts.guest')

@section('content')

<div class="form-page">

    <div class="mb-3">
        <a href="/guest/editor" class="btn-secondary">
            ← Back to Guest Tree
        </a>
    </div>

    <div class="form-card">

        <h2 class="form-title">
            Edit Category
        </h2>

        <p class="form-subtitle">
            Update the selected category name in the guest RBS tree.
        </p>

        <form action="/guest/category/update/{{ $categoryId }}"
              method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Category Name
                    </label>

                    <input type="text"
                           name="nama_kategori"
                           class="form-input"
                           value="{{ old('nama_kategori', $category['nama_kategori'] ?? '') }}"
                           required>

                    <div class="field-hint">
                        Use a clear name for this category or subcategory.
                    </div>

                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn app-btn">
                    Update Category
                </button>

                <a href="/guest/editor" class="btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection