@extends('layouts.app')

@section('content')

<div class="project-form-page risk-form-page modern-project-form-page modern-risk-form-page">

    {{-- ===== HEADER ===== --}}
    <div class="project-form-hero risk-form-hero">
        <div>
            <span class="page-label">Create Risk</span>
            <h2>Tambah Risk</h2>
            <p>
                Tambahkan risiko baru ke dalam kategori RBS. Risk score akan dihitung otomatis dari nilai
                probability × impact.
            </p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="project-form-back-btn">
            ← Kembali ke Project
        </a>
    </div>

    {{-- ===== CONTEXT CARD ===== --}}
    <div class="risk-context-card modern-risk-context-card">

        <div class="risk-context-icon modern-risk-context-icon">
            🛡️
        </div>

        <div>
            <span>Project</span>
            <h3>{{ $project->nama_project }}</h3>
            <p>
                Risk akan ditempatkan pada kategori tertentu dan ditampilkan pada diagram RBS serta risk matrix.
            </p>
        </div>

    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="project-form-card modern-project-form-card">

        <div class="project-form-card-header modern-project-form-card-header">
            <div>
                <span class="section-kicker">Risk Information</span>
                <h3>Informasi Risk</h3>
                <p>Isi detail risiko, kategori, probability, impact, dan deskripsi risiko.</p>
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

        <form action="{{ route('projects.risks.store', $project->id) }}" method="POST">
            @csrf

            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="project-form-section modern-project-form-section">

                {{-- ===== BASIC RISK ===== --}}
                <div class="form-section-title">
                    <span>01</span>
                    <div>
                        <h4>Data Risk</h4>
                        <p>Masukkan nama risk dan pilih category tempat risk berada.</p>
                    </div>
                </div>

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="nama_risiko">
                            Risk Name
                        </label>

                        <input
                            id="nama_risiko"
                            type="text"
                            name="nama_risiko"
                            class="form-input"
                            placeholder="Contoh: Technology Availability Risk"
                            value="{{ old('nama_risiko') }}"
                            required
                            autocomplete="off"
                        >

                        <small class="form-help">
                            Gunakan nama risiko yang jelas dan spesifik.
                        </small>
                    </div>

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
                            <option value="">— Pilih Category —</option>

                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id', $selectedCategory ?? '') == $category->id ? 'selected' : '' }}
                                >
                                    {{ str_repeat('— ', $category->level ?? 0) }}{{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>

                        <small class="form-help">
                            Pilih kategori tempat risiko ini berada.
                        </small>
                    </div>

                </div>

                {{-- ===== RISK SCORING ===== --}}
                <div class="form-section-title">
                    <span>02</span>
                    <div>
                        <h4>Penilaian Risk</h4>
                        <p>Risk score dihitung dari probability × impact.</p>
                    </div>
                </div>

                <div class="risk-score-layout modern-risk-score-layout">

                    <div class="risk-score-inputs">

                        <div class="form-row two-columns">

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
                                    placeholder="1 - 5"
                                    value="{{ old('probability') }}"
                                    required
                                >

                                <small class="form-help">
                                    Kemungkinan risiko terjadi. Skala 1 sampai 5.
                                </small>
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
                                    placeholder="1 - 5"
                                    value="{{ old('impact') }}"
                                    required
                                >

                                <small class="form-help">
                                    Besarnya dampak jika risiko terjadi. Skala 1 sampai 5.
                                </small>
                            </div>

                        </div>

                        <div class="risk-scale-info modern-risk-scale-info">

                            <div class="risk-scale-item low">
                                <strong>Low</strong>
                                <span>1 - 6</span>
                            </div>

                            <div class="risk-scale-item medium">
                                <strong>Medium</strong>
                                <span>7 - 14</span>
                            </div>

                            <div class="risk-scale-item high">
                                <strong>High</strong>
                                <span>15 - 25</span>
                            </div>

                        </div>

                    </div>

                    <div class="risk-score-preview modern-risk-score-preview">
                        <span>Risk Score Preview</span>

                        <strong id="risk_score_value">
                            -
                        </strong>

                        <p id="risk_level_value" class="risk-preview-level none">
                            Isi probability dan impact
                        </p>
                    </div>

                </div>

                {{-- ===== PROJECT STATUS ===== --}}
                <div class="form-section-title">
                    <span>03</span>
                    <div>
                        <h4>Status Project</h4>
                        <p>Status project saat risk dicatat.</p>
                    </div>
                </div>

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

                    <small class="form-help">
                        Digunakan untuk menggambarkan tahap project saat risiko ini dicatat.
                    </small>
                </div>

                {{-- ===== DESCRIPTION ===== --}}
                <div class="form-section-title">
                    <span>04</span>
                    <div>
                        <h4>Deskripsi Risk</h4>
                        <p>Tambahkan penjelasan singkat mengenai penyebab atau dampak risk.</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">
                        Description
                        <span class="label-optional">(opsional)</span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                        placeholder="Tulis penjelasan singkat mengenai risiko ini..."
                    >{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div class="project-form-actions modern-project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Simpan Risk
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    function updateRiskPreview() {
        const probability = parseInt(document.getElementById('probability').value);
        const impact = parseInt(document.getElementById('impact').value);

        const scoreValue = document.getElementById('risk_score_value');
        const levelValue = document.getElementById('risk_level_value');

        levelValue.className = 'risk-preview-level none';

        if (!probability || !impact) {
            scoreValue.textContent = '-';
            levelValue.textContent = 'Isi probability dan impact';
            return;
        }

        const score = probability * impact;

        scoreValue.textContent = score;

        if (score <= 6) {
            levelValue.textContent = 'Low Risk';
            levelValue.className = 'risk-preview-level low';
        } else if (score <= 14) {
            levelValue.textContent = 'Medium Risk';
            levelValue.className = 'risk-preview-level medium';
        } else {
            levelValue.textContent = 'High Risk';
            levelValue.className = 'risk-preview-level high';
        }
    }

    document.getElementById('probability').addEventListener('input', updateRiskPreview);
    document.getElementById('impact').addEventListener('input', updateRiskPreview);

    updateRiskPreview();
</script>

@endsection