@extends('layouts.app')

@section('content')

<div class="activity-log-page">

    <div class="page-header">
        <div>
            <h2>Activity History</h2>
            <p>Riwayat aktivitas khusus untuk project ini.</p>
        </div>

        <a href="{{ route('projects.show', $project->id) }}" class="btn-secondary">
            ← Back to Project
        </a>
    </div>

    <div class="project-history-summary">

        <div class="project-history-card main">
            <span>Project</span>
            <h3>{{ $project->nama_project }}</h3>

            <div class="project-history-meta">
                @php
                    $statusClass = match($project->status) {
                        'Ongoing'   => 'ongoing',
                        'Completed' => 'completed',
                        default     => 'planning',
                    };

                    $statusLabel = $project->status ?? 'Planning';
                @endphp

                <span class="project-status-badge {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>

        <div class="project-history-card">
            <span>Total Activity</span>
            <h3>{{ $totalActivities ?? $logs->total() }}</h3>
        </div>

        <div class="project-history-card">
            <span>Last Activity</span>

            @if($lastActivity)
                <h3 class="last-activity-time">
                    {{ $lastActivity->created_at->format('d M Y') }}
                </h3>
                <p>{{ $lastActivity->created_at->format('H:i') }}</p>
            @else
                <h3>-</h3>
                <p>Belum ada aktivitas</p>
            @endif
        </div>

    </div>

    <div class="activity-log-panel">

        <div class="panel-header">
            <h3>Project Timeline</h3>
        </div>

        @if($logs->count() > 0)

            <div class="activity-timeline">

                @foreach($logs as $log)

                    @php
                        $logText = $log->description ?? '-';
                        $action = $log->action ?? '-';
                        $targetType = strtolower($log->target_type ?? 'general');

                        if ($targetType === 'risk') {
                            $activityType = 'risk';
                            $activityIcon = '🛡️';
                            $targetLabel = 'Risk';
                        } elseif ($targetType === 'category' || $targetType === 'risk_category') {
                            $activityType = 'category';
                            $activityIcon = '🗂️';
                            $targetLabel = 'Category';
                        } elseif ($targetType === 'project') {
                            $activityType = 'project';
                            $activityIcon = '📁';
                            $targetLabel = 'Project';
                        } else {
                            $activityType = 'general';
                            $activityIcon = '📝';
                            $targetLabel = ucfirst($targetType);
                        }
                    @endphp

                    <div class="activity-log-item">

                        <div class="activity-log-icon {{ $activityType }}">
                            {{ $activityIcon }}
                        </div>

                        <div class="activity-log-content">

                            <div class="activity-log-main">

                                <div class="activity-badge-row">
                                    <span class="activity-action-badge">
                                        {{ $action }}
                                    </span>

                                    <span class="target-type-badge {{ $activityType }}">
                                        {{ $targetLabel }}
                                    </span>
                                </div>

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

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="pagination-wrapper">
                {{ $logs->links() }}
            </div>

        @else

            <div class="empty-state">
                <p>Belum ada aktivitas yang tercatat untuk project ini.</p>
            </div>

        @endif

    </div>

</div>

@endsection