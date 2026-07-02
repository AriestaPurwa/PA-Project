@extends('layouts.app')

@section('content')

<div class="reports-page">

    <div class="page-header">
        <div>
            <h2>Reports</h2>
            <p>Pusat laporan project dan ringkasan risiko.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="btn app-btn">
            View Projects
        </a>
    </div>

    <div class="reports-summary-grid">

        <div class="reports-summary-card">
            <span>Total Project</span>
            <h3>{{ $totalProjects }}</h3>
        </div>

        <div class="reports-summary-card">
            <span>Total Risk</span>
            <h3>{{ $totalRisks }}</h3>
        </div>

        <div class="reports-summary-card high">
            <span>High Risk</span>
            <h3>{{ $totalHighRisks }}</h3>
        </div>

        <div class="reports-summary-card">
            <span>Ready Report</span>
            <h3>{{ $readyReports }}</h3>
        </div>

    </div>

    <div class="reports-panel">

        <div class="panel-header">
            <h3>Project Reports</h3>
        </div>

        @if($projects->count() > 0)

            <div class="table-wrapper">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Total Risk</th>
                            <th>High</th>
                            <th>Medium</th>
                            <th>Low</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($projects as $project)

                            @php
                                $projectTypeName = $project->projectType->name
                                    ?? $project->projectType->nama_tipe
                                    ?? 'General Project';

                                $statusClass = match($project->status) {
                                    'Ongoing'   => 'ongoing',
                                    'Completed' => 'completed',
                                    default     => 'planning',
                                };

                                $statusLabel = $project->status ?? 'Planning';
                            @endphp

                            <tr>
                                <td>
                                    <div class="project-cell">
                                        <strong>{{ $project->nama_project }}</strong>
                                        <span>{{ $project->risk_categories_count }} kategori</span>
                                    </div>
                                </td>

                                <td>{{ $projectTypeName }}</td>

                                <td>
                                    <span class="project-status-badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td>{{ $project->risks_count }}</td>

                                <td>
                                    <span class="risk-count-badge high">
                                        {{ $project->high_risks_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="risk-count-badge medium">
                                        {{ $project->medium_risks_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="risk-count-badge low">
                                        {{ $project->low_risks_count }}
                                    </span>
                                </td>

                                <td>
                                    <div class="report-action-group">
                                        <a href="{{ route('reports.show', $project->id) }}" class="report-action primary">
                                            Preview Report
                                        </a>

                                        <a href="{{ route('projects.show', $project->id) }}" class="report-action secondary">
                                            Project Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="empty-state">
                <p>Belum ada project untuk dibuat laporan.</p>

                <a href="{{ route('projects.create') }}" class="btn app-btn">
                    Create Project
                </a>
            </div>

        @endif

    </div>

</div>

@endsection