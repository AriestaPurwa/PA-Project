@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <div class="detail-header">

            <h2 class="form-title">
                📜 Activity History
            </h2>

            <a
                href="{{ route('projects.show', $project->id) }}"
                class="btn-secondary"
            >
                ← Back to Project
            </a>

        </div>

        @forelse($logs as $log)

            <div class="history-item">

                <div class="history-date">
                    {{ $log->created_at->format('d M Y H:i') }}
                </div>

                <div class="history-content">

                    @if($log->action == 'create')
                        <span class="history-icon">➕</span>
                    @elseif($log->action == 'update')
                        <span class="history-icon">✏️</span>
                    @else
                        <span class="history-icon">🗑️</span>
                    @endif

                    {{ $log->description }}

                </div>

            </div>

        @empty

            <p>
                Belum ada aktivitas pada project ini.
            </p>

        @endforelse

        <div style="margin-top:20px;">
            {{ $logs->links() }}
        </div>

    </div>

</div>

@endsection