{{-- file views\projects\index.blade.php --}}
@extends('layouts.app')

@section('content')

{{-- Header: judul kiri, tombol tambah kanan --}}
<div class="project-index-header">
    <div>
        <h2>Daftar Project</h2>
        <p class="project-index-subtitle">Kelola seluruh project risk breakdown Anda.</p>
    </div>
    <a href="{{ route('projects.create') }}" class="btn app-btn">+ Tambah Project</a>
</div>

{{-- ===== SUMMARY BAR ===== --}}
{{-- CHANGED: 3 stat card (High Risk card tetap di-nonaktifkan sesuai perubahan Anda) --}}
<div class="summary-bar">

    {{-- Total Projects --}}
    <div class="stat-card">
        <div class="stat-icon blue">📁</div>
        <div class="stat-body">
            <span class="stat-value">{{ $summaryTotalProjects }}</span>
            <span class="stat-label">Total Project</span>
        </div>
    </div>

    {{-- Total Categories --}}
    <div class="stat-card">
        <div class="stat-icon purple">🗂️</div>
        <div class="stat-body">
            <span class="stat-value">{{ $summaryTotalCategories }}</span>
            <span class="stat-label">Total Kategori</span>
        </div>
    </div>

    {{-- Total Risks --}}
    <div class="stat-card">
        <div class="stat-icon blue">🛡️</div>
        <div class="stat-body">
            <span class="stat-value">{{ $summaryTotalRisks }}</span>
            <span class="stat-label">Total Risk</span>
        </div>
    </div>

    {{-- High Risks --}}
    {{-- <div class="stat-card">
        <div class="stat-icon red">⚠️</div>
        <div class="stat-body">
            CHANGED: Warna merah jika ada high risk
            <span class="stat-value" style="{{ $summaryHighRisks > 0 ? 'color:#dc2626;' : '' }}">
                {{ $summaryHighRisks }}
            </span>
            <span class="stat-label">High Risk</span>
        </div>
    </div>--}}

</div>

{{-- ===== DAFTAR PROJECT ===== --}}
@if($projects->isEmpty())

    <div class="project-empty">
        <div class="project-empty-icon">📋</div>
        <p class="project-empty-title">Belum ada project</p>
        <p class="project-empty-desc">Mulai dengan membuat project pertama Anda untuk menyusun kategori risiko dan risk matrix.</p>
        <a href="{{ route('projects.create') }}" class="btn app-btn" style="margin-top:4px;">+ Buat Project Pertama</a>
    </div>

@else

    @foreach($projects as $project)
        <div class="card app-card">

            {{-- CHANGED: Nama project + status badge sejajar --}}
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <h4 style="margin:0;">{{ $project->nama_project }}</h4>

                {{-- CHANGED: Status badge (Planning/Ongoing/Completed) --}}
                @php
                    $statusClass = match($project->status) {
                        'Ongoing'   => 'ongoing',
                        'Completed' => 'completed',
                        default     => 'planning', // Planning atau null
                    };
                    $statusLabel = $project->status ?? 'Planning';
                @endphp
                <span class="project-status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            {{-- Meta info --}}
            <div class="project-meta">

                <span class="project-meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    {{-- CHANGED: Hapus duplikasi angka kategori --}}
                    {{ $project->risk_categories_count }} kategori
                </span>

                <span class="project-meta-sep"></span>

                <span class="project-meta-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    {{-- CHANGED: Hapus duplikasi angka risiko --}}
                    {{ $project->risks_count }} risiko
                </span>

                <span class="project-meta-sep"></span>

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
                @endif

            </div>

            {{-- CHANGED: Progress Mitigasi — hanya tampil jika project punya risk --}}
            {{--@if($project->risks_count > 0)
                <div class="project-progress-row">
                    <div class="mitigation-progress">
                        <span class="mitigation-progress-label">Progress Mitigasi</span>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width: {{ $project->mitigation_progress }}%;"></div>
                        </div>
                        <span class="mitigation-progress-value">{{ $project->mitigation_progress }}%</span>
                    </div>
                </div>
            @endif--}}

            <div class="project-card-divider"></div>

            <div class="project-card-actions">
                <a href="{{ route('projects.show', $project->id) }}" class="btn-primary">Lihat Detail</a>
                <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('projects.destroy', $project->id) }}"
                    method="POST"
                    class="inline-form"
                    onsubmit="return confirm('Yakin ingin menghapus project ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">Hapus</button>
                </form>
            </div>

        </div>
    @endforeach

@endif

@endsection