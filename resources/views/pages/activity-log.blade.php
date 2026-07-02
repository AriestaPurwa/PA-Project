@extends('layouts.app')

@section('content')

<div class="activity-log-page">

    <div class="page-header">
        <div>
            <h2>Activity Log</h2>
            <p>Riwayat aktivitas dari seluruh project yang Anda kelola.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="btn app-btn">
            View Projects
        </a>
    </div>

    <div class="activity-summary-grid">

        <div class="activity-summary-card">
            <span>Total Activity</span>
            <h3>{{ $totalActivities }}</h3>
        </div>

        <div class="activity-summary-card">
            <span>Today's Activity</span>
            <h3>{{ $todayActivities }}</h3>
        </div>

        <div class="activity-summary-card">
            <span>Total Project</span>
            <h3>{{ $totalProjects }}</h3>
        </div>

    </div>

    <div class="activity-log-panel">

        <div class="panel-header">
            <h3>Recent Activity</h3>
        </div>

        @if($activityLogs->count() > 0)

            <div class="activity-timeline">

                @foreach($activityLogs as $log)

                    @php
                        $logText = $log->description ?? '-';
                        $action = $log->action ?? '-';
                        $targetType = strtolower($log->target_type ?? 'general');

                        if ($targetType === 'risk') {
                            $activityType = 'risk';
                            $activityIcon = '🛡️';
                        } elseif ($targetType === 'category' || $targetType === 'risk_category') {
                            $activityType = 'category';
                            $activityIcon = '🗂️';
                        } elseif ($targetType === 'project') {
                            $activityType = 'project';
                            $activityIcon = '📁';
                        } else {
                            $activityType = 'general';
                            $activityIcon = '📝';
                        }
                    @endphp

                    <div class="activity-log-item">

                        <div class="activity-log-icon {{ $activityType }}">
                            {{ $activityIcon }}
                        </div>

                        <div class="activity-log-content">

                            <div class="activity-log-main">

                                <span class="activity-action-badge">
                                    {{ $action }}
                                </span>

                                <p>{{ $logText }}</p>

                                <div class="activity-log-meta">
                                    <span>
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </span>

                                    <span class="activity-dot"></span>

                                    <span>
                                        {{ $log->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <div class="activity-log-project">

                                @if($log->project)
                                    <span>{{ $log->project->nama_project }}</span>

                                    <a href="{{ route('projects.show', $log->project->id) }}">
                                        View Project
                                    </a>
                                @else
                                    <span>Project tidak tersedia</span>
                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="pagination-wrapper">
                {{ $activityLogs->links() }}
            </div>

        @else

            <div class="empty-state">
                <p>Belum ada aktivitas yang tercatat.</p>
            </div>

        @endif

    </div>

</div>

@endsection