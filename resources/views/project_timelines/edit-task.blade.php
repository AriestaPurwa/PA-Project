@extends('layouts.app')

@section('content')

<div class="project-form-page">

    <div class="project-form-hero">
        <div>
            <span class="page-label">Edit Task</span>
            <h2>Edit Task</h2>
            <p>
                Perbarui nama task, rentang tanggal, dan cost task.
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

        <div class="timeline-project-limit-box" style="margin-bottom: 22px;">
            <div>
                <span>Project Period</span>
                <strong>
                    {{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}
                    -
                    {{ $project->end_date ? $project->end_date->format('d M Y') : '-' }}
                </strong>
            </div>

            <div>
                <span>Project Cost</span>
                <strong>Rp {{ number_format($project->estimated_budget ?? 0, 0, ',', '.') }}</strong>
            </div>

            <div>
                <span>Available Cost</span>
                <strong>Rp {{ number_format($remainingCost ?? 0, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form
            action="{{ route('projects.timeline.tasks.update', [$project->id, $task->id]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="project-form-section">

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="name">
                            Task Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="form-input"
                            value="{{ old('name', $task->name) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="task_cost">
                            Task Cost
                        </label>

                        <input
                            id="task_cost"
                            type="number"
                            name="task_cost"
                            class="form-input"
                            min="0"
                            max="{{ $remainingCost ?? 0 }}"
                            value="{{ old('task_cost', $task->task_cost ?? 0) }}"
                            required
                        >
                    </div>

                </div>

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="start_date">
                            Start Date
                        </label>

                        <input
                            id="start_date"
                            type="date"
                            name="start_date"
                            class="form-input"
                            min="{{ $project->start_date ? $project->start_date->format('Y-m-d') : '' }}"
                            max="{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}"
                            value="{{ old('start_date', $task->start_date ? $task->start_date->format('Y-m-d') : '') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="end_date">
                            End Date
                        </label>

                        <input
                            id="end_date"
                            type="date"
                            name="end_date"
                            class="form-input"
                            min="{{ $project->start_date ? $project->start_date->format('Y-m-d') : '' }}"
                            max="{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}"
                            value="{{ old('end_date', $task->end_date ? $task->end_date->format('Y-m-d') : '') }}"
                            required
                        >
                    </div>

                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.timeline.index', $project->id) }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Update Task
                </button>
            </div>

        </form>

    </div>

</div>

@endsection