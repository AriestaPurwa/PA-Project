@extends('layouts.app')

@section('content')

<div class="dashboard-page">

    <div class="page-header">
        <div>
            <h2>Dashboard</h2>
            <p>Ringkasan project dan risiko secara keseluruhan.</p>
        </div>

        <a href="{{ route('projects.create') }}" class="btn app-btn">
            + New Project
        </a>
    </div>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <span>Total Projects</span>
            <h3>{{ $totalProjects }}</h3>
        </div>

        <div class="dashboard-card">
            <span>Total Categories</span>
            <h3>{{ $totalCategories }}</h3>
        </div>

        <div class="dashboard-card">
            <span>Total Risks</span>
            <h3>{{ $totalRisks }}</h3>
        </div>

        <div class="dashboard-card">
            <span>Average Progress</span>
            <h3>{{ $averageProgress }}%</h3>
        </div>

    </div>

    <div class="dashboard-section">

        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>Risk Level Summary</h3>
                <a href="{{ url('/risk-overview') }}">View Risk Overview</a>
            </div>

            <div class="risk-summary">
                <div class="risk-summary-item high">
                    <span>High Risk</span>
                    <strong>{{ $highRisks }}</strong>
                </div>

                <div class="risk-summary-item medium">
                    <span>Medium Risk</span>
                    <strong>{{ $mediumRisks }}</strong>
                </div>

                <div class="risk-summary-item low">
                    <span>Low Risk</span>
                    <strong>{{ $lowRisks }}</strong>
                </div>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>Quick Actions</h3>
            </div>

            <div class="quick-actions">
                <a href="{{ route('projects.create') }}" class="quick-action-link">
                    Create New Project
                </a>

                <a href="{{ route('projects.index') }}" class="quick-action-link">
                    View All Projects
                </a>

                <a href="{{ url('/risk-overview') }}" class="quick-action-link">
                    View Risk Overview
                </a>

                <a href="{{ url('/reports') }}" class="quick-action-link">
                    Open Reports
                </a>
            </div>
        </div>

    </div>

    <div class="dashboard-section">

        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>Recent Projects</h3>
                <a href="{{ route('projects.index') }}">View All</a>
            </div>

            @if($recentProjects->count() > 0)

                <div class="table-wrapper">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Total Risk</th>
                                <th>Highest Risk</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($recentProjects as $project)
                                <tr>
                                    <td>{{ $project->nama_project }}</td>
                                    <td>
                                        <span class="status-badge">
                                            {{ $project->status ?? 'Planning' }}
                                        </span>
                                    </td>
                                    <td>{{ $project->progress ?? 0 }}%</td>
                                    <td>{{ $project->total_risks }}</td>
                                    <td>
                                        <span class="risk-badge {{ strtolower($project->highest_risk_level) }}">
                                            {{ $project->highest_risk_level }}
                                        </span>
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
                    <p>Belum ada project.</p>
                    <a href="{{ route('projects.create') }}" class="btn app-btn">
                        Create Project
                    </a>
                </div>

            @endif
        </div>

    </div>

    <div class="dashboard-section">

        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>High Risk Projects</h3>
            </div>

            @if($highRiskProjects->count() > 0)

                <div class="high-risk-list">
                    @foreach($highRiskProjects as $project)
                        <div class="high-risk-item">
                            <div>
                                <strong>{{ $project->nama_project }}</strong>
                                <p>{{ $project->high_risks_count }} high risk need attention</p>
                            </div>

                            <a href="{{ route('projects.show', $project->id) }}" class="table-link">
                                View Detail
                            </a>
                        </div>
                    @endforeach
                </div>

            @else

                <div class="empty-state">
                    <p>Tidak ada project dengan risiko tinggi.</p>
                </div>

            @endif
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>Recent Activity</h3>
                <a href="{{ url('/activity-log') }}">View All</a>
            </div>

            @if($recentActivities->count() > 0)

                <div class="activity-list">
                    @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <p>{{ $activity->description ?? $activity->activity ?? '-' }}</p>
                            <span>{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                </div>

            @else

                <div class="empty-state">
                    <p>Belum ada aktivitas terbaru.</p>
                </div>

            @endif
        </div>

    </div>

</div>

@endsection