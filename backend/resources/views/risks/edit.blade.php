@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="mb-3">
        <a href="{{ route('projects.show', $project->id) }}"
           class="btn-secondary">
            ← Kembali ke Project
        </a>
    </div>

    <div class="form-card">

        <h2 class="form-title">Edit Risk</h2>

        <p class="form-subtitle">
            Perbarui informasi risiko, kategori, probability, dan impact.
        </p>

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
            action="{{ route('projects.risks.update',
                [$project->id, $risk->id]) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-grid">

                {{-- Risk Name --}}
                <div class="form-group">

                    <label class="form-label" for="nama_risiko">
                        Risk Name
                    </label>

                    <input
                        id="nama_risiko"
                        type="text"
                        name="nama_risiko"
                        class="form-input"
                        value="{{ old('nama_risiko', $risk->nama_risiko) }}"
                        required
                        autocomplete="off"
                    >

                </div>

                {{-- Category --}}
                <div class="form-group">

                    <label class="form-label" for="category_id">
                        Category
                    </label>

                    <select
                        id="category_id"
                        name="category_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            — Pilih Category —
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id', $risk->category_id) == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Probability & Impact --}}
                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label" for="probability">
                            Probability
                        </label>

                        <input
                            id="probability"
                            type="number"
                            name="probability"
                            class="form-input"
                            min="1"
                            max="5"
                            value="{{ old('probability', $risk->probability) }}"
                            required
                        >

                        <span class="field-hint">
                            Kemungkinan terjadinya risiko.
                        </span>

                    </div>

                    <div class="form-group">

                        <label class="form-label" for="impact">
                            Impact
                        </label>

                        <input
                            id="impact"
                            type="number"
                            name="impact"
                            class="form-input"
                            min="1"
                            max="5"
                            value="{{ old('impact', $risk->impact) }}"
                            required
                        >

                        <span class="field-hint">
                            Besarnya dampak jika terjadi.
                        </span>

                    </div>

                </div>

                {{-- Project Status --}}
                <div class="form-group">

                    <label class="form-label" for="status">
                        Status Proyek Saat Ini
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-select"
                    >

                        <option value="Planning"
                            {{ old('status', $project->status ?? 'Planning') == 'Planning' ? 'selected' : '' }}>
                            Planning
                        </option>

                        <option value="Ongoing"
                            {{ old('status', $project->status ?? '') == 'Ongoing' ? 'selected' : '' }}>
                            Ongoing
                        </option>

                        <option value="Completed"
                            {{ old('status', $project->status ?? '') == 'Completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                    <span class="field-hint">
                        Digunakan untuk menggambarkan tahap pelaksanaan proyek saat risiko ini dicatat.
                    </span>

                </div>

                {{-- Description --}}
                <div class="form-group">

                    <label class="form-label" for="deskripsi">
                        Description
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                    >{{ old('deskripsi', $risk->deskripsi) }}</textarea>

                </div>

                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn app-btn"
                    >
                        Update Risk
                    </button>

                    <a
                        href="{{ route('projects.show', $project->id) }}"
                        class="btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection