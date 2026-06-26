@extends('layouts.app')

@section('content')

<div class="project-index-page">

    {{-- ===== HEADER ===== --}}
    <div class="project-index-header page-header project-page-hero">
        <div>
            <span class="page-label">Project Management</span>
            <h2>Daftar Project</h2>
            <p class="project-index-subtitle">
                Kelola seluruh project, kategori risiko, risk level, dan progress project.
            </p>
        </div>

        <a href="{{ route('projects.create') }}" class="btn app-btn">
            + Tambah Project
        </a>
    </div>

    {{-- ===== SUMMARY BAR ===== --}}
    <div class="summary-bar project-summary-bar">

        <div class="stat-card">
            <div class="stat-icon blue">📁</div>
            <div class="stat-body">
                <span class="stat-value">{{ $summaryTotalProjects }}</span>
                <span class="stat-label">Total Project</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">🗂️</div>
            <div class="stat-body">
                <span class="stat-value">{{ $summaryTotalCategories }}</span>
                <span class="stat-label">Total Kategori</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">🛡️</div>
            <div class="stat-body">
                <span class="stat-value">{{ $summaryTotalRisks }}</span>
                <span class="stat-label">Total Risk</span>
            </div>
        </div>

    </div>

    {{-- ===== PROJECT LIST ===== --}}
    @if($projects->isEmpty())

        <div class="project-empty">
            <div class="project-empty-icon">📋</div>
            <p class="project-empty-title">Belum ada project</p>
            <p class="project-empty-desc">
                Mulai dengan membuat project pertama untuk menyusun kategori risiko dan risk matrix.
            </p>

            <a href="{{ route('projects.create') }}" class="btn app-btn">
                + Buat Project Pertama
            </a>
        </div>

    @else

        <div class="project-list">

            @foreach($projects as $project)

                @php
                    $statusClass = match($project->status) {
                        'Ongoing' => 'ongoing',
                        'Completed' => 'completed',
                        default => 'planning',
                    };

                    $statusLabel = $project->status ?? 'Planning';
                    $progress = $project->progress ?? 0;
                    $budget = $project->budget_estimate ?? null;
                @endphp

                <div class="project-card-modern">

                    <div class="project-card-main">

                        <div class="project-card-top">
                            <div>
                                <div class="project-title-row">
                                    <h3>{{ $project->nama_project }}</h3>
                                    <span class="project-status-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </div>

                                <p class="project-type-text">
                                    {{ $project->projectType->name ?? $project->projectType->nama_tipe ?? 'General Project' }}
                                </p>
                            </div>
                        </div>

                        <div class="project-card-stats">

                            <div class="project-stat-item">
                                <span class="project-stat-label">Kategori</span>
                                <strong>{{ $project->risk_categories_count }}</strong>
                            </div>

                            <div class="project-stat-item">
                                <span class="project-stat-label">Risiko</span>
                                <strong>{{ $project->risks_count }}</strong>
                            </div>

                            <div class="project-stat-item">
                                <span class="project-stat-label">Budget</span>
                                <strong>
                                    @if($budget)
                                        Rp {{ number_format($budget, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </strong>
                            </div>

                            <div class="project-stat-item">
                                <span class="project-stat-label">Progress</span>

                                <div class="project-progress-mini">
                                    <div class="project-progress-track">
                                        <div
                                            class="project-progress-fill"
                                            style="width: {{ $progress }}%;"
                                        ></div>
                                    </div>

                                    <strong>{{ $progress }}%</strong>
                                </div>
                            </div>

                        </div>

                        <div class="project-meta project-card-risk-row">

                            <div class="risk-badges">
                                <span class="risk-badge high">
                                    {{ $project->high_risks_count }} High
                                </span>

                                <span class="risk-badge medium">
                                    {{ $project->medium_risks_count }} Medium
                                </span>

                                <span class="risk-badge low">
                                    {{ $project->low_risks_count }} Low
                                </span>
                            </div>

                            @if($project->high_risks_count > 0)
                                <div class="project-risk-warning">
                                    ⚠ Mengandung
                                    <strong>{{ $project->high_risks_count }}</strong>
                                    risiko tingkat tinggi yang memerlukan perhatian.
                                </div>
                            @elseif($project->risks_count > 0)
                                <div class="project-risk-status">
                                    ✅ Tidak ada risiko kritis.
                                </div>
                            @else
                                <div class="project-risk-neutral">
                                    Belum ada risiko yang ditambahkan.
                                </div>
                            @endif

                        </div>

                    </div>

                    <div class="project-card-actions project-card-actions-modern">

                        <a href="{{ route('projects.show', $project->id) }}" class="btn-primary">
                            Detail
                        </a>

                        <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit">
                            Edit
                        </a>

                        <form
                            action="{{ route('projects.destroy', $project->id) }}"
                            method="POST"
                            class="inline-form"
                            onsubmit="return confirm('Yakin ingin menghapus project ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-danger">
                                Hapus
                            </button>
                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection