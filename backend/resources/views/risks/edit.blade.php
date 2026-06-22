@extends('layouts.app')

@section('content')

<div class="project-form-page risk-form-page">

    <div class="project-form-header">
        <div>
            <h2>Edit Risk</h2>
            <p>Perbarui informasi risiko, kategori, probability, dan impact.</p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Kembali ke Project
        </a>
    </div>

    <div class="risk-context-card">

        <div class="risk-context-icon">
            🛡️
        </div>

        <div>
            <span>Current Risk</span>
            <h3>{{ $risk->nama_risiko }}</h3>
            <p>
                Risk ini berada pada project <strong>{{ $project->nama_project }}</strong>.
            </p>
        </div>

    </div>

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Informasi Risk</h3>
                <p>Perubahan probability dan impact akan memperbarui risk score.</p>
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
            action="{{ route('projects.risks.update', [$project->id, $risk->id]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="project-form-section">

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
                            value="{{ old('nama_risiko', $risk->nama_risiko) }}"
                            required
                            autocomplete="off"
                        >

                        <small class="form-help">
                            Nama risk akan tampil pada detail risk dan diagram.
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
                                    {{ old('category_id', $risk->category_id) == $category->id ? 'selected' : '' }}
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

                <div class="risk-score-layout">

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
                                    value="{{ old('probability', $risk->probability) }}"
                                    required
                                >

                                <small class="form-help">
                                    Kemungkinan terjadinya risiko.
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
                                    value="{{ old('impact', $risk->impact) }}"
                                    required
                                >

                                <small class="form-help">
                                    Besarnya dampak jika terjadi.
                                </small>
                            </div>

                        </div>

                    </div>

                    <div class="risk-score-preview">
                        <span>Risk Score Preview</span>

                        <strong id="risk_score_value">
                            -
                        </strong>

                        <p id="risk_level_value" class="risk-preview-level none">
                            Isi probability dan impact
                        </p>
                    </div>

                </div>

                <div class="risk-scale-info">

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
                        Digunakan untuk menggambarkan tahap pelaksanaan project saat risiko ini dicatat.
                    </small>
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
                    >{{ old('deskripsi', $risk->deskripsi) }}</textarea>
                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Update Risk
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