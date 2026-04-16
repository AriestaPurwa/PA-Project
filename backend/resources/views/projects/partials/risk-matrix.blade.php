@php
    $totalRisks = 0;
    $lowCount = 0;
    $mediumCount = 0;
    $highCount = 0;

    for ($impact = 1; $impact <= 5; $impact++) {
        for ($probability = 1; $probability <= 5; $probability++) {
            $value = $matrix[$impact][$probability] ?? 0;
            $totalRisks += $value;

            $color = strtolower($heatmapService->getHeatmapColor($impact, $probability));

            if ($color === 'low') {
                $lowCount += $value;
            } elseif ($color === 'medium') {
                $mediumCount += $value;
            } elseif ($color === 'high') {
                $highCount += $value;
            }
        }
    }

    $likelihoodLabels = [
        1 => 'Sangat Jarang',
        2 => 'Jarang',
        3 => 'Mungkin',
        4 => 'Sering',
        5 => 'Sangat Sering',
    ];

    $impactLabels = [
        1 => 'Sangat Rendah',
        2 => 'Rendah',
        3 => 'Sedang',
        4 => 'Tinggi',
        5 => 'Sangat Tinggi',
    ];
@endphp

<div class="matrix-section">

    <div class="matrix-intro">
        <h5 class="matrix-title">Risk Matrix</h5>
        <p class="matrix-description">
            Risk Matrix menampilkan sebaran risiko berdasarkan
            <strong>Likelihood</strong> (kemungkinan terjadinya risiko)
            dan <strong>Impact</strong> (besarnya dampak risiko).
            Angka pada setiap kotak menunjukkan jumlah risk pada kombinasi nilai tersebut.
            Semakin ke kanan atas, semakin tinggi prioritas penanganannya.
        </p>
    </div>

    <div class="matrix-summary">
        <div class="summary-card">
            <span class="summary-label">Total Risk</span>
            <span class="summary-value">{{ $totalRisks }}</span>
        </div>

        <div class="summary-card low">
            <span class="summary-label">Low</span>
            <span class="summary-value">{{ $lowCount }}</span>
        </div>

        <div class="summary-card medium">
            <span class="summary-label">Medium</span>
            <span class="summary-value">{{ $mediumCount }}</span>
        </div>

        <div class="summary-card high">
            <span class="summary-label">High</span>
            <span class="summary-value">{{ $highCount }}</span>
        </div>
    </div>

    <div class="matrix-legend">
        <span class="legend-title">Legend:</span>

        <span class="legend-item">
            <span class="legend-dot low"></span>
            Low
        </span>

        <span class="legend-item">
            <span class="legend-dot medium"></span>
            Medium
        </span>

        <span class="legend-item">
            <span class="legend-dot high"></span>
            High
        </span>
    </div>

    <div class="matrix-axis-top">Likelihood (Kemungkinan)</div>

    <div class="matrix-wrapper">
        <div class="matrix-axis-left">Impact (Dampak)</div>

        <div class="risk-matrix">
            <div></div>

            @for ($probability = 1; $probability <= 5; $probability++)
                <div class="header" title="{{ $likelihoodLabels[$probability] }}">
                    <div>L{{ $probability }}</div>
                    <small>{{ $likelihoodLabels[$probability] }}</small>
                </div>
            @endfor

            @for ($impact = 5; $impact >= 1; $impact--)
                <div class="header" title="{{ $impactLabels[$impact] }}">
                    <div>I{{ $impact }}</div>
                    <small>{{ $impactLabels[$impact] }}</small>
                </div>

                @for ($probability = 1; $probability <= 5; $probability++)
                    @php
                        $color = strtolower($heatmapService->getHeatmapColor($impact, $probability));
                        $value = $matrix[$impact][$probability] ?? 0;
                    @endphp

                    <div class="cell {{ $color }}"
                         title="Impact {{ $impact }} ({{ $impactLabels[$impact] }}) | Likelihood {{ $probability }} ({{ $likelihoodLabels[$probability] }}) | Jumlah risk: {{ $value }}">
                        <div class="cell-value">{{ $value }}</div>
                        <div class="cell-label">{{ ucfirst($color) }}</div>
                    </div>
                @endfor
            @endfor
        </div>
    </div>
</div>