@extends('layouts.app')

@section('content')

<div class="dashboard-page">

    {{-- ===== HEADER ===== --}}
    <div class="page-header dashboard-hero">
        <div>
            <span class="page-label">Dashboard Overview</span>
            <h2>Dashboard</h2>
            <p>Ringkasan project, kategori, risiko, dan aktivitas terbaru dalam sistem RBS.</p>
        </div>

        <a href="{{ route('projects.create') }}" class="btn app-btn">
            + New Project
        </a>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="dashboard-grid">

        <div class="dashboard-card modern-stat-card">
            <div class="dashboard-stat-icon blue">📁</div>
            <div>
                <span>Total Projects</span>
                <h3>{{ $totalProjects }}</h3>
            </div>
        </div>

        <div class="dashboard-card modern-stat-card">
            <div class="dashboard-stat-icon purple">🗂️</div>
            <div>
                <span>Total Categories</span>
                <h3>{{ $totalCategories }}</h3>
            </div>
        </div>

        <div class="dashboard-card modern-stat-card">
            <div class="dashboard-stat-icon green">🛡️</div>
            <div>
                <span>Total Risks</span>
                <h3>{{ $totalRisks }}</h3>
            </div>
        </div>

        <div class="dashboard-card modern-stat-card">
            <div class="dashboard-stat-icon orange">📈</div>
            <div>
                <span>Average Progress</span>
                <h3>{{ $averageProgress }}%</h3>
            </div>
        </div>

    </div>

    {{-- ===== RISK SUMMARY & QUICK ACTION ===== --}}
    <div class="dashboard-section">

        <div class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3>Risk Level Summary</h3>
                    <p>Distribusi risiko berdasarkan tingkat prioritas.</p>
                </div>

                <a href="{{ url('/risk-overview') }}">View Risk Overview</a>
            </div>

            <div class="risk-summary">
                <div class="risk-summary-item high">
                    <span>High Risk</span>
                    <strong>{{ $highRisks }}</strong>
                    <small>Need immediate attention</small>
                </div>

                <div class="risk-summary-item medium">
                    <span>Medium Risk</span>
                    <strong>{{ $mediumRisks }}</strong>
                    <small>Need monitoring</small>
                </div>

                <div class="risk-summary-item low">
                    <span>Low Risk</span>
                    <strong>{{ $lowRisks }}</strong>
                    <small>Under control</small>
                </div>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3>Quick Actions</h3>
                    <p>Akses cepat ke fitur utama sistem.</p>
                </div>
            </div>

            <div class="quick-actions modern-quick-actions">
                <a href="{{ route('projects.create') }}" class="quick-action-link">
                    <span>＋</span>
                    <div>
                        <strong>Create New Project</strong>
                        <small>Buat project RBS baru</small>
                    </div>
                </a>

                <a href="{{ route('projects.index') }}" class="quick-action-link">
                    <span>📁</span>
                    <div>
                        <strong>View All Projects</strong>
                        <small>Lihat semua project</small>
                    </div>
                </a>

                <a href="{{ url('/risk-overview') }}" class="quick-action-link">
                    <span>⚠</span>
                    <div>
                        <strong>View Risk Overview</strong>
                        <small>Analisis ringkasan risiko</small>
                    </div>
                </a>

                <a href="{{ url('/reports') }}" class="quick-action-link">
                    <span>📄</span>
                    <div>
                        <strong>Open Reports</strong>
                        <small>Lihat laporan project</small>
                    </div>
                </a>
            </div>
        </div>

    </div>

    {{-- ===== RECENT PROJECTS ===== --}}
    <div class="dashboard-section">

        <div class="dashboard-panel full-width-panel">
            <div class="panel-header">
                <div>
                    <h3>Recent Projects</h3>
                    <p>Project terbaru yang sedang dikelola.</p>
                </div>

                <a href="{{ route('projects.index') }}">View All</a>
            </div>

            @if($recentProjects->count() > 0)

                <div class="table-wrapper">
                    <table class="dashboard-table modern-table">
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
                                @php
                                    $highestRisk = $project->highest_risk_level ?? 'None';
                                    $highestRiskClass = strtolower($highestRisk);

                                    $statusClass = match($project->status) {
                                        'Ongoing' => 'ongoing',
                                        'Completed' => 'completed',
                                        default => 'planning',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <strong>{{ $project->nama_project }}</strong>
                                    </td>

                                    <td>
                                        <span class="project-status-badge {{ $statusClass }}">
                                            {{ $project->status ?? 'Planning' }}
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

                                    <td>{{ $project->total_risks }}</td>

                                    <td>
                                        <span class="risk-badge {{ $highestRiskClass }}">
                                            {{ $highestRisk }}
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

                <div class="empty-state modern-empty-state">
                    <div class="empty-state-icon">📋</div>
                    <p>Belum ada project.</p>
                    <a href="{{ route('projects.create') }}" class="btn app-btn">
                        Create Project
                    </a>
                </div>

            @endif
        </div>

    </div>

    {{-- ===== HIGH RISK & ACTIVITY ===== --}}
    <div class="dashboard-section">

        <div class="dashboard-panel">
            <div class="panel-header">
                <div>
                    <h3>High Risk Projects</h3>
                    <p>Project yang memiliki risiko tingkat tinggi.</p>
                </div>
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
                <div>
                    <h3>Recent Activity</h3>
                    <p>Aktivitas terbaru pada project.</p>
                </div>

                <a href="{{ url('/activity-log') }}">View All</a>
            </div>

            @if($recentActivities->count() > 0)

                <div class="activity-list">
                    @foreach($recentActivities as $activity)
                        <div class="activity-item modern-activity-item">
                            <div class="activity-mini-icon">•</div>
                            <div>
                                <p>{{ $activity->description ?? $activity->activity ?? '-' }}</p>
                                <span>{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
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