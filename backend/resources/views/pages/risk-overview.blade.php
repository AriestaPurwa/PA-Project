@extends('layouts.app')

@section('content')

<div class="risk-overview-page">

    <div class="page-header">
        <div>
            <h2>Risk Overview</h2>
            <p>Ringkasan risiko dari seluruh project yang Anda kelola.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="btn app-btn">
            View Projects
        </a>
    </div>

    <div class="risk-overview-summary">

        <div class="risk-overview-card">
            <span>Total Projects</span>
            <h3>{{ $totalProjects }}</h3>
        </div>

        <div class="risk-overview-card">
            <span>Total Risks</span>
            <h3>{{ $totalRisks }}</h3>
        </div>

        <div class="risk-overview-card high">
            <span>High Risks</span>
            <h3>{{ $totalHighRisks }}</h3>
        </div>

        <div class="risk-overview-card medium">
            <span>Medium Risks</span>
            <h3>{{ $totalMediumRisks }}</h3>
        </div>

        <div class="risk-overview-card low">
            <span>Low Risks</span>
            <h3>{{ $totalLowRisks }}</h3>
        </div>

    </div>

    <div class="risk-overview-panel">

        <div class="panel-header">
            <h3>Project Risk Summary</h3>
        </div>

        @if($riskOverview->count() > 0)

            <div class="table-wrapper">
                <table class="risk-overview-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Categories</th>
                            <th>Total Risk</th>
                            <th>High</th>
                            <th>Medium</th>
                            <th>Low</th>
                            <th>Highest Risk</th>
                            <th>Progress</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($riskOverview as $project)
                            @php
                                $highestRiskClass = $project->highest_risk_level === '-'
                                    ? 'none'
                                    : strtolower($project->highest_risk_level);

                                $statusClass = strtolower($project->status ?? 'Planning');
                            @endphp

                            <tr>
                                <td>
                                    <div class="project-cell">
                                        <strong>{{ $project->nama_project }}</strong>
                                        <span>{{ $project->projectType->name ?? $project->projectType->nama_tipe ?? 'General Project' }}</span>
                                    </div>
                                </td>

                                <td>
                                    <span class="project-status-badge {{ $statusClass }}">
                                        {{ $project->status ?? 'Planning' }}
                                    </span>
                                </td>

                                <td>{{ $project->total_categories }}</td>

                                <td>{{ $project->total_risks }}</td>

                                <td>
                                    <span class="risk-count-badge high">
                                        {{ $project->high_risks }}
                                    </span>
                                </td>

                                <td>
                                    <span class="risk-count-badge medium">
                                        {{ $project->medium_risks }}
                                    </span>
                                </td>

                                <td>
                                    <span class="risk-count-badge low">
                                        {{ $project->low_risks }}
                                    </span>
                                </td>

                                <td>
                                    <span class="risk-badge {{ $highestRiskClass }}">
                                        {{ $project->highest_risk_level }}
                                    </span>
                                </td>

                                <td>
                                    <div class="table-progress">
                                        <div class="table-progress-track">
                                            <div
                                                class="table-progress-fill"
                                                style="width: {{ $project->progress ?? 0 }}%;"
                                            ></div>
                                        </div>

                                        <span>{{ $project->progress ?? 0 }}%</span>
                                    </div>
                                </td>

                                <td>
                                    <a href="{{ route('projects.show', $project->id) }}" class="table-link">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="empty-state">
                <p>Belum ada project yang dapat ditampilkan.</p>

                <a href="{{ route('projects.create') }}" class="btn app-btn">
                    Create Project
                </a>
            </div>

        @endif

    </div>

</div>

@endsection