@extends('layouts.app')

@section('content')

<div class="report-preview-page">

    <div class="page-header report-page-header" data-print-ignore>
        <div>
            <h2>Report Preview</h2>
            <p>Laporan analisis risiko project.</p>
        </div>

        <div class="report-header-actions">
            <a href="{{ route('reports.index') }}" class="btn-secondary">
                ← Back to Reports
            </a>

            <button type="button" class="btn app-btn" onclick="window.print()">
                Export / Print PDF
            </button>
        </div>
    </div>

    <div class="report-document">

        <div class="report-cover">
            <div>
                <span class="report-label">Risk Breakdown Structure Report</span>
                <h1>{{ $project->nama_project }}</h1>
                <p>
                    Laporan ini berisi informasi project, kategori risiko,
                    daftar risiko, nilai probability, impact, risk score,
                    risk level, dan ringkasan prioritas risiko.
                </p>
            </div>

            <div class="report-date">
                Generated: {{ now()->format('d M Y, H:i') }}
            </div>
        </div>

        <div class="report-section">

            <h3>1. Informasi Project</h3>

            <div class="report-info-grid">

                <div class="report-info-item">
                    <span>Tipe Project</span>
                    <strong>
                        {{ $project->projectType->name ?? $project->projectType->nama_tipe ?? 'General Project' }}
                    </strong>
                </div>

                <div class="report-info-item">
                    <span>Status Project</span>
                    <strong>{{ $project->status ?? 'Planning' }}</strong>
                </div>

                <div class="report-info-item">
                    <span>Progress Project</span>
                    <strong>{{ $project->progress ?? 0 }}%</strong>
                </div>

                <div class="report-info-item">
                    <span>Estimasi Anggaran</span>
                    <strong>
                        Rp {{ number_format($project->budget_estimate ?? 0, 0, ',', '.') }}
                    </strong>
                </div>

            </div>

            <div class="report-description">
                <span>Deskripsi Project</span>
                <p>{{ $project->deskripsi ?? '-' }}</p>
            </div>

        </div>

        <div class="report-section">

            <h3>2. Ringkasan Risiko</h3>

            <div class="report-risk-summary">

                <div class="report-risk-card">
                    <span>Total Risk</span>
                    <strong>{{ $totalRisks }}</strong>
                </div>

                <div class="report-risk-card high">
                    <span>High</span>
                    <strong>{{ $highRisks }}</strong>
                </div>

                <div class="report-risk-card medium">
                    <span>Medium</span>
                    <strong>{{ $mediumRisks }}</strong>
                </div>

                <div class="report-risk-card low">
                    <span>Low</span>
                    <strong>{{ $lowRisks }}</strong>
                </div>

            </div>

        </div>

        <div class="report-section">

            <h3>3. Kategori Risiko</h3>

            @if($categories->count() > 0)

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Level</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->nama_kategori }}</td>
                                <td>{{ $category->level ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else

                <p class="report-empty-text">Belum ada kategori risiko.</p>

            @endif

        </div>

        <div class="report-section">

            <h3>4. Daftar Risiko</h3>

            @if($risks->count() > 0)

                <table class="report-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Risk</th>
                            <th>Kategori</th>
                            <th>Probability</th>
                            <th>Impact</th>
                            <th>Score</th>
                            <th>Level</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($risks as $risk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $risk->nama_risiko }}</strong>
                                    @if($risk->deskripsi)
                                        <br>
                                        <small>{{ $risk->deskripsi }}</small>
                                    @endif
                                </td>
                                <td>{{ $risk->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $risk->probability }}</td>
                                <td>{{ $risk->impact }}</td>
                                <td>{{ $risk->risk_score }}</td>
                                <td>
                                    <span class="risk-badge {{ strtolower($risk->risk_level ?? 'none') }}">
                                        {{ $risk->risk_level ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else

                <p class="report-empty-text">Belum ada risiko yang tercatat.</p>

            @endif

        </div>

        <div class="report-section">

            <h3>5. Kesimpulan</h3>

            @if($highRisks > 0)
                <p>
                    Project ini memiliki <strong>{{ $highRisks }}</strong> risiko tingkat tinggi
                    yang perlu mendapatkan prioritas penanganan.
                </p>
            @elseif($mediumRisks > 0)
                <p>
                    Project ini memiliki risiko pada tingkat sedang dan perlu dilakukan
                    monitoring secara berkala.
                </p>
            @elseif($lowRisks > 0)
                <p>
                    Project ini memiliki risiko tingkat rendah dan dapat dipantau secara rutin.
                </p>
            @else
                <p>
                    Project ini belum memiliki data risiko yang dapat dianalisis.
                </p>
            @endif

        </div>

    </div>

</div>

@endsection