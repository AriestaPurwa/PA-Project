@extends('layouts.app')

@section('content')

<div class="form-page">
    <div class="mb-3">
        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Back
        </a>
    </div>

    <div class="form-card">
        <h2 class="form-title">Tambah Category</h2>
        <p class="form-subtitle">Tambahkan kategori baru untuk project ini, baik sebagai root category maupun sub category.</p>

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

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="nama_kategori">Nama Category</label>
                    <input
                        id="nama_kategori"
                        type="text"
                        name="nama_kategori"
                        class="form-input"
                        placeholder="Masukkan nama category"
                        value="{{ old('nama_kategori') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="parent_id">Parent Category</label>
                    <select id="parent_id" name="parent_id" class="form-select">
                        <option value="">-- Root Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('parent_id', request('parent')) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <span class="field-hint">Kosongkan jika ingin membuat root category.</span>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn app-btn">Simpan Category</button>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection