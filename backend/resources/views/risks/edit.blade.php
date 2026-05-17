@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Edit Risk
        </h2>

        <form
            action="{{ route('projects.risks.update',
                [$project->id, $risk->id]) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">
                    Risk Name
                </label>

                <input
                    type="text"
                    name="nama_risk"
                    class="form-input"
                    value="{{ old('nama_risk', $risk->nama_risk) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Likelihood
                </label>

                <input
                    type="number"
                    name="likelihood"
                    min="1"
                    max="5"
                    value="{{ old('likelihood', $risk->likelihood) }}"
                    class="form-input"
                    required
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Impact
                </label>

                <input
                    type="number"
                    name="impact"
                    min="1"
                    max="5"
                    value="{{ old('impact', $risk->impact) }}"
                    class="form-input"
                    required
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Description
                </label>

                <textarea
                    name="deskripsi"
                    class="form-textarea"
                >{{ old('deskripsi', $risk->deskripsi) }}</textarea>

            </div>

            <div class="form-actions">

                <button type="submit" class="btn app-btn">
                    Update Risk
                </button>

                <a
                    href="{{ route('projects.show', $project->id) }}"
                    class="btn-secondary"
                >
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection