@extends('layouts.app')

@section('content')

@php
    $riskScore = $risk->probability * $risk->impact;

    $riskLevel = $risk->risk_level ?? (
        $riskScore <= 6 ? 'Low' : ($riskScore <= 14 ? 'Medium' : 'High')
    );

    $riskLevelClass = strtolower($riskLevel);

    $categoryName = $risk->category->nama_kategori ?? '-';
@endphp

<div class="risk-detail-page">

    {{-- ===== HERO ===== --}}
    <div class="risk-detail-hero">

        <div class="risk-detail-main">
            <span class="page-label">Risk Detail</span>

            <div class="risk-detail-title-row">
                <h2>{{ $risk->nama_risiko }}</h2>

                <span class="risk-detail-level-badge {{ $riskLevelClass }}">
                    {{ $riskLevel }} Risk
                </span>
            </div>

            <p>
                Detail risiko pada project
                <strong>{{ $project->nama_project }}</strong>
                dalam category
                <strong>{{ $categoryName }}</strong>.
            </p>
        </div>

        <div class="risk-detail-actions" data-export-ignore>

            <a
                href="{{ route('projects.risks.edit', [$project->id, $risk->id]) }}"
                class="risk-action-btn primary"
            >
                <span>✏</span>
                Edit Risk
            </a>

            <form
                action="{{ route('projects.risks.destroy', [$project->id, $risk->id]) }}"
                method="POST"
                class="inline-form"
                onsubmit="return confirm('Delete this risk?')"
            >
                @csrf
                @method('DELETE')

                <button type="submit" class="risk-action-btn danger">
                    <span>🗑</span>
                    Delete
                </button>
            </form>

        </div>

    </div>

    {{-- ===== SCORE SUMMARY ===== --}}
    <div class="risk-detail-score-grid">

        <div class="risk-detail-score-card">
            <div class="risk-score-icon blue">P</div>

            <div>
                <span>Probability</span>
                <strong>{{ $risk->probability }}</strong>
                <p>Skala kemungkinan risiko terjadi.</p>
            </div>
        </div>

        <div class="risk-detail-score-card">
            <div class="risk-score-icon purple">I</div>

            <div>
                <span>Impact</span>
                <strong>{{ $risk->impact }}</strong>
                <p>Skala dampak jika risiko terjadi.</p>
            </div>
        </div>

        <div class="risk-detail-score-card">
            <div class="risk-score-icon orange">×</div>

            <div>
                <span>Risk Score</span>
                <strong>{{ $riskScore }}</strong>
                <p>Probability × Impact.</p>
            </div>
        </div>

        <div class="risk-detail-score-card {{ $riskLevelClass }}">
            <div class="risk-score-icon {{ $riskLevelClass }}">!</div>

            <div>
                <span>Risk Level</span>
                <strong>{{ $riskLevel }}</strong>
                <p>Tingkat prioritas penanganan risiko.</p>
            </div>
        </div>

    </div>

    {{-- ===== CONTENT GRID ===== --}}
    <div class="risk-detail-content-grid">

        {{-- ===== DESCRIPTION ===== --}}
        <div class="risk-detail-panel">
            <div class="risk-detail-panel-header">
                <span class="section-kicker">Description</span>
                <h3>Deskripsi Risiko</h3>
                <p>Penjelasan singkat mengenai risiko yang telah diidentifikasi.</p>
            </div>

            <div class="risk-detail-text-box">
                <p>
                    {{ $risk->deskripsi ?: 'No description available.' }}
                </p>
            </div>
        </div>

        {{-- ===== RECOMMENDATION ===== --}}
        <div class="risk-detail-panel recommendation-panel">
            <div class="risk-detail-panel-header">
                <span class="section-kicker">Mitigation</span>
                <h3>💡 Mitigation Recommendation</h3>
                <p>Rekomendasi mitigasi berdasarkan tipe project dan risk level.</p>
            </div>

            <div class="risk-recommendation-box {{ $riskLevelClass }}">
                <div class="recommendation-icon">💡</div>

                <p>
                    {{ $recommendation }}
                </p>
            </div>
        </div>

    </div>

    {{-- ===== META INFORMATION ===== --}}
    <div class="risk-detail-panel risk-detail-meta-panel">

        <div class="risk-detail-panel-header">
            <span class="section-kicker">Risk Context</span>
            <h3>Konteks Risk</h3>
            <p>Informasi lokasi risiko dalam project dan struktur RBS.</p>
        </div>

        <div class="risk-context-grid">

            <div class="risk-context-item">
                <span>Project</span>
                <strong>{{ $project->nama_project }}</strong>
            </div>

            <div class="risk-context-item">
                <span>Category</span>
                <strong>{{ $categoryName }}</strong>
            </div>

            <div class="risk-context-item">
                <span>Created At</span>
                <strong>
                    {{ $risk->created_at ? $risk->created_at->format('d M Y') : '-' }}
                </strong>
            </div>

            <div class="risk-context-item">
                <span>Last Updated</span>
                <strong>
                    {{ $risk->updated_at ? $risk->updated_at->format('d M Y') : '-' }}
                </strong>
            </div>

        </div>

    </div>

    {{-- ===== FOOTER ACTION ===== --}}
    <div class="risk-detail-footer">
        <a
            href="{{ route('projects.show', $project->id) }}"
            class="project-form-back-btn"
        >
            ← Back to Project
        </a>
    </div>

</div>

@endsection