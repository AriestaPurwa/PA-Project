@extends('layouts.app')

@section('content')

<div class="timeline-page">

    <div class="page-header">
        <div>
            <h2>Project Timeline</h2>
            <p>Kelola task, subtask, dan risk monitoring untuk project ini.</p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Kembali ke Project
        </a>
    </div>

    @if ($errors->any())
        <div class="alert-error" style="margin-bottom:16px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="timeline-success-alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="timeline-project-card">

        <div>
            <span>Project</span>
            <h3>{{ $project->nama_project }}</h3>
            <p>
                Progress project dihitung otomatis dari rata-rata progress semua task.
            </p>
        </div>

        <div class="timeline-progress-box">
            <span>Progress</span>
            <strong>{{ $project->progress ?? 0 }}%</strong>
            <div class="timeline-progress-track">
                <div
                    class="timeline-progress-fill"
                    style="width: {{ $project->progress ?? 0 }}%;"
                ></div>
            </div>
        </div>

    </div>

    <div class="timeline-summary-grid">

        <div class="timeline-summary-card">
            <span>Total Task</span>
            <h3>{{ $totalTasks }}</h3>
        </div>

        <div class="timeline-summary-card">
            <span>Total Subtask</span>
            <h3>{{ $totalSubtasks }}</h3>
        </div>

        <div class="timeline-summary-card">
            <span>Done Subtask</span>
            <h3>{{ $doneSubtasks }}</h3>
        </div>

        <div class="timeline-summary-card">
            <span>Assigned Risk</span>
            <h3>{{ $assignedRisks }}</h3>
        </div>

    </div>

    <div class="timeline-setup-card">

        <div class="timeline-setup-header">
            <h3>Tambah Task</h3>
            <p>Tambahkan task utama project beserta tanggal mulai dan durasi pengerjaan.</p>
        </div>

        <form
            action="{{ route('projects.timeline.tasks.store', $project->id) }}"
            method="POST"
        >
            @csrf

            <div class="timeline-setup-grid">

                <div class="form-group">
                    <label class="form-label" for="name">
                        Nama Task
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-input"
                        placeholder="Contoh: Analisis Kebutuhan"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="start_date">
                        Tanggal Mulai
                    </label>

                    <input
                        id="start_date"
                        type="date"
                        name="start_date"
                        class="form-input"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="duration_days">
                        Durasi Hari
                    </label>

                    <input
                        id="duration_days"
                        type="number"
                        name="duration_days"
                        class="form-input"
                        min="1"
                        max="365"
                        value="7"
                        required
                    >
                </div>

            </div>

            <div class="timeline-setup-actions">
                <button type="submit" class="btn app-btn">
                    + Tambah Task
                </button>
            </div>

        </form>

    </div>

    @if($tasks->count() > 0)

        <div class="timeline-list" style="margin-top:24px;">

            @foreach($tasks as $task)

                @php
                    $statusClass = match($task->status) {
                        'In Progress' => 'ongoing',
                        'Done' => 'completed',
                        default => 'planned',
                    };
                @endphp

                <div class="timeline-sprint-card">

                    <div class="timeline-sprint-header">

                        <div>
                            <span class="timeline-sprint-number">
                                Task {{ $loop->iteration }}
                            </span>

                            <h3>{{ $task->name }}</h3>

                            <p>
                                {{ $task->start_date->format('d M Y') }}
                                -
                                {{ $task->end_date->format('d M Y') }}
                                · {{ $task->duration_days }} hari
                            </p>
                        </div>

                        <div class="timeline-task-progress-area">
                            <span class="timeline-status-badge {{ $statusClass }}">
                                {{ $task->status }}
                            </span>

                            <strong>{{ $task->progress }}%</strong>
                        </div>

                    </div>

                    <div class="timeline-sprint-content">

                        <div class="timeline-column">

                            <div class="timeline-column-header">
                                <h4>Subtasks</h4>
                            </div>

                            @if($task->subtasks->count() > 0)

                                <div class="timeline-task-list">

                                    @foreach($task->subtasks as $subtask)

                                        <div class="timeline-task-item">

                                            <div>
                                                <strong>{{ $subtask->name }}</strong>
                                                <span>Status: {{ $subtask->status }}</span>
                                            </div>

                                            <div class="timeline-task-actions">

                                                <form
                                                    action="{{ route('projects.timeline.subtasks.update', [$project->id, $task->id, $subtask->id]) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <select
                                                        name="status"
                                                        class="timeline-small-select"
                                                        onchange="this.form.submit()"
                                                    >
                                                        <option value="To Do" {{ $subtask->status == 'To Do' ? 'selected' : '' }}>
                                                            To Do
                                                        </option>

                                                        <option value="In Progress" {{ $subtask->status == 'In Progress' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>

                                                        <option value="Done" {{ $subtask->status == 'Done' ? 'selected' : '' }}>
                                                            Done
                                                        </option>
                                                    </select>
                                                </form>

                                                <form
                                                    action="{{ route('projects.timeline.subtasks.destroy', [$project->id, $task->id, $subtask->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus subtask ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="timeline-delete-btn">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="timeline-empty-box">
                                    Belum ada subtask pada task ini.
                                </div>

                            @endif

                            <form
                                action="{{ route('projects.timeline.subtasks.store', [$project->id, $task->id]) }}"
                                method="POST"
                                class="timeline-add-form timeline-subtask-add-form"
                            >
                                @csrf

                                <input
                                    type="text"
                                    name="name"
                                    class="form-input"
                                    placeholder="Nama subtask"
                                    required
                                >

                                <button type="submit" class="btn app-btn">
                                    + Subtask
                                </button>

                            </form>

                        </div>

                        <div class="timeline-column">

                            <div class="timeline-column-header">
                                <h4>Risk Monitoring</h4>
                            </div>

                            @if($task->risks->count() > 0)

                                <div class="timeline-risk-list">

                                    @foreach($task->risks as $risk)

                                        <div class="timeline-risk-item">

                                            <div>
                                                <strong>{{ $risk->nama_risiko }}</strong>

                                                <div class="timeline-risk-meta">
                                                    <span class="risk-badge {{ strtolower($risk->risk_level ?? 'none') }}">
                                                        {{ $risk->risk_level ?? '-' }}
                                                    </span>

                                                    <span>
                                                        Score: {{ $risk->risk_score }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="timeline-task-actions">

                                                <form
                                                    action="{{ route('projects.timeline.risks.update', [$project->id, $task->id, $risk->id]) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <select
                                                        name="monitoring_status"
                                                        class="timeline-small-select"
                                                        onchange="this.form.submit()"
                                                    >
                                                        <option value="Open" {{ $risk->pivot->monitoring_status == 'Open' ? 'selected' : '' }}>
                                                            Open
                                                        </option>

                                                        <option value="In Progress" {{ $risk->pivot->monitoring_status == 'In Progress' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>

                                                        <option value="Handled" {{ $risk->pivot->monitoring_status == 'Handled' ? 'selected' : '' }}>
                                                            Handled
                                                        </option>
                                                    </select>
                                                </form>

                                                <form
                                                    action="{{ route('projects.timeline.risks.detach', [$project->id, $task->id, $risk->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus risk dari task ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="timeline-delete-btn">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @else

                                <div class="timeline-empty-box">
                                    Belum ada risk yang dimonitor pada task ini.
                                </div>

                            @endif

                            <form
                                action="{{ route('projects.timeline.risks.attach', [$project->id, $task->id]) }}"
                                method="POST"
                                class="timeline-add-form timeline-risk-add-form"
                            >
                                @csrf

                                <select name="risk_id" class="form-select" required>
                                    <option value="">— Pilih Risk —</option>

                                    @foreach($risks as $risk)
                                        <option value="{{ $risk->id }}">
                                            {{ $risk->nama_risiko }}
                                            -
                                            {{ $risk->risk_level }}
                                            ({{ $risk->risk_score }})
                                        </option>
                                    @endforeach
                                </select>

                                <select name="monitoring_status" class="form-select">
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Handled">Handled</option>
                                </select>

                                <button type="submit" class="btn app-btn">
                                    + Risk
                                </button>

                            </form>

                        </div>

                    </div>

                    <div class="timeline-task-footer">
                        <form
                            action="{{ route('projects.timeline.tasks.destroy', [$project->id, $task->id]) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus task ini beserta subtask dan risk monitoring?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="timeline-delete-btn">
                                Hapus Task
                            </button>
                        </form>
                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="timeline-empty-main">
            Belum ada task. Tambahkan task pertama untuk mulai membuat timeline project.
        </div>

    @endif

</div>

@endsection