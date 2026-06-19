@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Edit Project
        </h2>

        <form
            action="{{ route('projects.update', $project->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">
                    Project Name
                </label>

                <input
                    type="text"
                    name="nama_project"
                    class="form-input"
                    value="{{ old('nama_project', $project->nama_project) }}"
                    required
                >

            </div>

            <h3>Manajemen Proyek</h3>

            <div class="form-group">
                <label for="status">Status Proyek</label>
                <select name="status" id="status" class="form-control">
                    <option value="Planning"
                        {{ old('status', $project->status) == 'Planning' ? 'selected' : '' }}>
                        Planning
                    </option>

                    <option value="Ongoing"
                        {{ old('status', $project->status) == 'Ongoing' ? 'selected' : '' }}>
                        Ongoing
                    </option>

                    <option value="Completed"
                        {{ old('status', $project->status) == 'Completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="progress">Progress Proyek (%)</label>
                <input
                    type="number"
                    id="progress"
                    name="progress"
                    min="0"
                    max="100"
                    class="form-control"
                    value="{{ old('progress', $project->progress) }}"
                >
            </div>

            <div class="form-group">
                <label for="estimated_budget">Estimasi Anggaran (Rp)</label>
                <input
                    type="number"
                    id="estimated_budget"
                    name="estimated_budget"
                    min="0"
                    class="form-control"
                    value="{{ old('estimated_budget', $project->estimated_budget) }}"
                >
            </div>

            <div class="form-group">

                <label class="form-label">
                    Description
                </label>

                <textarea
                    name="deskripsi"
                    class="form-textarea"
                >{{ old('deskripsi', $project->deskripsi) }}</textarea>

            </div>

            <div class="form-actions">

                <button type="submit" class="btn app-btn">
                    Update Project
                </button>

                <a
                    href="{{ route('projects.show', $project->id) }}"
                    class="btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection