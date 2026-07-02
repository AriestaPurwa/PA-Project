@extends('layouts.app')

@section('content')

<div class="project-form-page">

    <div class="project-form-hero">
        <div>
            <span class="page-label">Edit Subtask</span>
            <h2>Edit Subtask</h2>
            <p>
                Perbarui nama dan status subtask pada task {{ $task->name }}.
            </p>
        </div>

        <a href="{{ route('projects.timeline.index', $project->id) }}" class="project-form-back-btn">
            ← Kembali
        </a>
    </div>

    <div class="project-form-card">

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

        <form
            action="{{ route('projects.timeline.subtasks.update', [$project->id, $task->id, $subtask->id]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="project-form-section">

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="name">
                            Subtask Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-input"
                            value="{{ old('name', $subtask->name) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="status">
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select"
                            required
                        >
                            <option value="To Do" {{ old('status', $subtask->status) == 'To Do' ? 'selected' : '' }}>
                                To Do
                            </option>

                            <option value="In Progress" {{ old('status', $subtask->status) == 'In Progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option value="Done" {{ old('status', $subtask->status) == 'Done' ? 'selected' : '' }}>
                                Done
                            </option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.timeline.index', $project->id) }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Update Subtask
                </button>
            </div>

        </form>

    </div>

</div>

@endsection