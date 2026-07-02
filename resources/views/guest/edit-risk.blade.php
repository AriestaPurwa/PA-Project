@extends('layouts.guest')

@section('content')

<div class="form-page">

    <div class="mb-3">
        <a href="/guest/editor" class="btn-secondary">
            ← Back to Guest Tree
        </a>
    </div>

    <div class="form-card">

        <h2 class="form-title">
            Edit Risk
        </h2>

        <p class="form-subtitle">
            Update the risk name, probability, and impact. The risk score will be recalculated after saving.
        </p>

        <form action="/guest/risk/update/{{ $riskId }}"
              method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Risk Name
                    </label>

                    <input type="text"
                           name="nama_risiko"
                           class="form-input"
                           value="{{ old('nama_risiko', $risk['nama_risiko'] ?? '') }}"
                           required>

                    <div class="field-hint">
                        Enter the risk name that belongs to this category.
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group">

                        <label class="form-label">
                            Probability
                        </label>

                        <select name="probability"
                                class="form-select"
                                required>

                            @for($i = 1; $i <= 5; $i++)

                                <option value="{{ $i }}"
                                    {{ old('probability', $risk['probability'] ?? 1) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>

                            @endfor

                        </select>

                        <div class="field-hint">
                            1 = very low, 5 = very high.
                        </div>

                    </div>

                    <div class="form-group">

                        <label class="form-label">
                            Impact
                        </label>

                        <select name="impact"
                                class="form-select"
                                required>

                            @for($i = 1; $i <= 5; $i++)

                                <option value="{{ $i }}"
                                    {{ old('impact', $risk['impact'] ?? 1) == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>

                            @endfor

                        </select>

                        <div class="field-hint">
                            1 = minor impact, 5 = major impact.
                        </div>

                    </div>

                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn app-btn">
                    Update Risk
                </button>

                <a href="/guest/editor" class="btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection