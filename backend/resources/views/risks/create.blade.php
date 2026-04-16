@extends('layouts.app')

@section('content')

<div class="form-page">
    <div class="mb-3">
        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Back
        </a>
    </div>

    <div class="form-card">
        <h2 class="form-title">Tambah Risk</h2>
        <p class="form-subtitle">Isi informasi risiko dan tentukan kategori, probability, serta impact.</p>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.risks.store', $project->id) }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="nama_risiko">Risk Name</label>
                    <input
                        id="nama_risiko"
                        type="text"
                        name="nama_risiko"
                        class="form-input"
                        placeholder="Masukkan nama risk"
                        value="{{ old('nama_risiko') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="">-- Pilih Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $selectedCategory) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="probability">Probability (1-5)</label>
                        <input
                            id="probability"
                            type="number"
                            name="probability"
                            class="form-input"
                            min="1"
                            max="5"
                            value="{{ old('probability') }}"
                        >
                        <span class="field-hint">Nilai kemungkinan terjadinya risiko.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="impact">Impact (1-5)</label>
                        <input
                            id="impact"
                            type="number"
                            name="impact"
                            class="form-input"
                            min="1"
                            max="5"
                            value="{{ old('impact') }}"
                        >
                        <span class="field-hint">Nilai dampak jika risiko terjadi.</span>
                    </div>
                </div>

                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="form-actions">
                    <button type="submit" class="btn app-btn">Simpan Risk</button>
                    <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection