<div class="risk-matrix">

    {{-- Header atas (Likelihood) --}}
    <div></div>
    @for ($probability = 1; $probability <= 5; $probability++)
        <div class="header">L{{ $probability }}</div>
    @endfor

    {{-- Matrix --}}
    @for ($impact = 5; $impact >= 1; $impact--)

        {{-- Label Impact --}}
        <div class="header">I{{ $impact }}</div>

        @for ($probability = 1; $probability <= 5; $probability++)

            @php
                $color = $heatmapService
                    ->getHeatmapColor($impact, $probability);

                $value = $matrix[$impact][$probability] ?? 0;
            @endphp

            <div class="cell {{ $color }}">
                {{ $value }}
            </div>

        @endfor
    @endfor

</div>