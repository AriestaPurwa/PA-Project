@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <div class="detail-header">

            <h2 class="form-title">
                ⚠ {{ $risk->nama_risiko }}
            </h2>

            <div class="detail-actions">

                <a href="{{ route('projects.risks.edit',
                    [$project->id, $risk->id]) }}"
                    class="btn app-btn">

                    ✏ Edit Risk

                </a>

                <form
                    action="{{ route('projects.risks.destroy',
                        [$project->id, $risk->id]) }}"
                    method="POST"
                    class="inline-form"
                    onsubmit="return confirm(
                        'Delete this risk?'
                    )"
                >

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn-danger">

                        🗑 Delete

                    </button>

                </form>

            </div>

        </div>

        <div class="detail-grid">

            <div class="detail-item">

                <label>Probability</label>

                <div class="detail-value">
                    {{ $risk->probability }}
                </div>

            </div>

            <div class="detail-item">

                <label>Impact</label>

                <div class="detail-value">
                    {{ $risk->impact }}
                </div>

            </div>

            <div class="detail-item">

                <label>Risk Score</label>

                <div class="detail-value">
                    {{ $risk->probability * $risk->impact }}
                </div>

            </div>

            <div class="detail-item">

                <label>Risk Level</label>

                <div class="detail-value">
                    {{ $risk->risk_level }}
                </div>

            </div>

        </div>

        <div class="detail-section">

            <h3>Description</h3>

            <p>
                {{ $risk->deskripsi ?? 'No description available.' }}
            </p>

        </div>

        <div class="detail-section">

            <h3>💡 Mitigation Recommendation</h3>

            <p>
                {{ $recommendation }}
            </p>

        </div>

        <div class="detail-footer">

            <a href="{{ route('projects.show',
                $project->id) }}"
                class="btn-secondary">

                ← Back to Project

            </a>

        </div>

    </div>

</div>

@endsection