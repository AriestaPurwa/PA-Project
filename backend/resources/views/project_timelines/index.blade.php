@extends('layouts.app')

@section('content')

<div class="timeline-page">

    <div class="page-header">
        <div>
            <h2>Project Timeline</h2>
            <p>Kelola sprint, task, dan risk monitoring untuk project ini.</p>
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
                Progress project dihitung otomatis berdasarkan task pada sprint.
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

    @if($sprints->count() === 0)

        <div class="timeline-setup-card">

            <div class="timeline-setup-header">
                <h3>Setup Project Timeline</h3>
                <p>Buat sprint otomatis berdasarkan tanggal mulai dan jumlah sprint.</p>
            </div>

            <form
                action="{{ route('projects.timeline.generate', $project->id) }}"
                method="POST"
            >
                @csrf

                <div class="timeline-setup-grid">

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
                        <label class="form-label" for="total_sprints">
                            Jumlah Sprint
                        </label>

                        <input
                            id="total_sprints"
                            type="number"
                            name="total_sprints"
                            class="form-input"
                            min="1"
                            max="52"
                            value="8"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="sprint_duration">
                            Durasi per Sprint
                        </label>

                        <select
                            id="sprint_duration"
                            name="sprint_duration"
                            class="form-select"
                            required
                        >
                            <option value="1" selected>1 Minggu</option>
                            <option value="2">2 Minggu</option>
                            <option value="3">3 Minggu</option>
                            <option value="4">4 Minggu</option>
                        </select>
                    </div>

                </div>

                <div class="timeline-setup-actions">
                    <button type="submit" class="btn app-btn">
                        Generate Sprint
                    </button>
                </div>

            </form>

        </div>

    @else

        <div class="timeline-summary-grid">

            <div class="timeline-summary-card">
                <span>Total Sprint</span>
                <h3>{{ $totalSprints }}</h3>
            </div>

            <div class="timeline-summary-card">
                <span>Total Task</span>
                <h3>{{ $totalTasks }}</h3>
            </div>

            <div class="timeline-summary-card">
                <span>Done Task</span>
                <h3>{{ $doneTasks }}</h3>
            </div>

            <div class="timeline-summary-card">
                <span>Assigned Risk</span>
                <h3>{{ $assignedRisks }}</h3>
            </div>

        </div>

        <div class="timeline-list">

            @foreach($sprints as $sprint)

                @php
                    $statusClass = match($sprint->status) {
                        'Ongoing' => 'ongoing',
                        'Completed' => 'completed',
                        default => 'planned',
                    };
                @endphp

                <div class="timeline-sprint-card">

                    <div class="timeline-sprint-header">

                        <div>
                            <span class="timeline-sprint-number">
                                Sprint {{ $sprint->sprint_number }}
                            </span>

                            <h3>{{ $sprint->name }}</h3>

                            <p>
                                {{ $sprint->start_date->format('d M Y') }}
                                -
                                {{ $sprint->end_date->format('d M Y') }}
                            </p>
                        </div>

                        <span class="timeline-status-badge {{ $statusClass }}">
                            {{ $sprint->status }}
                        </span>

                    </div>

                    <div class="timeline-sprint-content">

                        <div class="timeline-column">

                            <div class="timeline-column-header">
                                <h4>Tasks</h4>
                            </div>

                            @if($sprint->tasks->count() > 0)

                                <div class="timeline-task-list">

                                    @foreach($sprint->tasks as $task)

                                        <div class="timeline-task-item">

                                            <div>
                                                <strong>{{ $task->name }}</strong>

                                                @if($task->description)
                                                    <p>{{ $task->description }}</p>
                                                @endif

                                                <span>Bobot: {{ $task->weight }}</span>
                                            </div>

                                            <div class="timeline-task-actions">

                                                <form
                                                    action="{{ route('projects.timeline.tasks.update', [$project->id, $sprint->id, $task->id]) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <select
                                                        name="status"
                                                        class="timeline-small-select"
                                                        onchange="this.form.submit()"
                                                    >
                                                        <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>
                                                            To Do
                                                        </option>

                                                        <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>

                                                        <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>
                                                            Done
                                                        </option>
                                                    </select>
                                                </form>

                                                <form
                                                    action="{{ route('projects.timeline.tasks.destroy', [$project->id, $sprint->id, $task->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus task ini?')"
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
                                    Belum ada task pada sprint ini.
                                </div>

                            @endif

                            <form
                                action="{{ route('projects.timeline.tasks.store', [$project->id, $sprint->id]) }}"
                                method="POST"
                                class="timeline-add-form"
                            >
                                @csrf

                                <input
                                    type="text"
                                    name="name"
                                    class="form-input"
                                    placeholder="Nama task"
                                    required
                                >

                                <input
                                    type="number"
                                    name="weight"
                                    class="form-input"
                                    placeholder="Bobot"
                                    min="0.1"
                                    step="0.1"
                                    value="1"
                                    required
                                >

                                <select name="status" class="form-select">
                                    <option value="To Do">To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Done">Done</option>
                                </select>

                                <button type="submit" class="btn app-btn">
                                    + Task
                                </button>

                            </form>

                        </div>

                        <div class="timeline-column">

                            <div class="timeline-column-header">
                                <h4>Risk Monitoring</h4>
                            </div>

                            @if($sprint->risks->count() > 0)

                                <div class="timeline-risk-list">

                                    @foreach($sprint->risks as $risk)

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
                                                    action="{{ route('projects.timeline.risks.update', [$project->id, $sprint->id, $risk->id]) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('PUT')

                                                    <select
                                                        name="mitigation_status"
                                                        class="timeline-small-select"
                                                        onchange="this.form.submit()"
                                                    >
                                                        <option value="Open" {{ $risk->pivot->mitigation_status == 'Open' ? 'selected' : '' }}>
                                                            Open
                                                        </option>

                                                        <option value="In Progress" {{ $risk->pivot->mitigation_status == 'In Progress' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>

                                                        <option value="Handled" {{ $risk->pivot->mitigation_status == 'Handled' ? 'selected' : '' }}>
                                                            Handled
                                                        </option>
                                                    </select>
                                                </form>

                                                <form
                                                    action="{{ route('projects.timeline.risks.detach', [$project->id, $sprint->id, $risk->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus risk dari sprint ini?')"
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
                                    Belum ada risk yang dimonitor pada sprint ini.
                                </div>

                            @endif

                            <form
                                action="{{ route('projects.timeline.risks.attach', [$project->id, $sprint->id]) }}"
                                method="POST"
                                class="timeline-add-form"
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

                                <select name="mitigation_status" class="form-select">
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

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection