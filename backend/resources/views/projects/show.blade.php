@extends('layouts.app')

@section('content')

<div class="diagram-page">
    @if($project->is_guest)

        <div class="card app-card" style="margin-bottom:20px;">

            <strong>Guest Mode Active</strong><br>

            This project is temporary and may be deleted automatically later.

            <div style="margin-top:10px;">
                <a href="/login" class="btn app-btn">
                    Login to Save Permanently
                </a>
            </div>

        </div>

    @endif

    <div class="diagram-toolbar" data-export-ignore>
        <button type="button" class="btn app-btn" id="export-png-btn">
            Export PNG
        </button>

        <button type="button" class="btn app-btn" id="export-jpg-btn">
            Export JPG
        </button>

        <button type="button" class="btn app-btn" id="export-pdf-btn">
            Export PDF
        </button>
    </div>

    {{-- ===== INFORMASI PROYEK ===== --}}
    <div class="project-info-card">

        <h3 class="project-info-title">
            📋 Informasi Proyek
        </h3>

        <div class="project-info-grid">

            <div class="project-info-item">
                <span class="info-label">Tipe Proyek</span>
                <span class="info-value">
                    {{ $project->projectType->name ?? '-' }}
                </span>
            </div>

            <div class="project-info-item">
                <span class="info-label">Status Proyek</span>
                <span class="info-value">
                    {{ $project->status ?? 'Planning' }}
                </span>
            </div>

            <div class="project-info-item">
                <span class="info-label">Progress Proyek</span>
                <span class="info-value">
                    {{ $project->progress ?? 0 }}%
                </span>
            </div>

            <div class="project-info-item">
                <span class="info-label">Estimasi Anggaran</span>
                <span class="info-value">
                    @if($project->estimated_budget)
                        Rp {{ number_format($project->estimated_budget, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </span>
            </div>

            <div class="project-info-item">
                <span class="info-label">Progress Mitigasi</span>
                <span class="info-value">
                    {{ $project->mitigation_progress ?? 0 }}%
                </span>
            </div>

        </div>

        {{-- Deskripsi Proyek --}}
        <div class="project-description">
            <h4>Deskripsi Proyek</h4>

            <p margin-bottom-20>
                {{ $project->deskripsi ?: 'Belum ada deskripsi proyek.' }}
            </p>
        </div>

        <div class="project-info-actions padding-top-20">

            <a href="{{ route('projects.edit', $project->id) }}"
            class="btn app-btn">
                ✏ Edit Project
            </a>

            <a href="{{ route('projects.history', $project->id) }}"
            class="btn-secondary">
                📜 View History
            </a>

            <!-- <a href="{{ route('projects.timeline.index', $project->id) }}" class="btn app-btn">
                Project Timeline
            </a> -->

        </div>

    </div>

    <div class="project-gantt-card">
        <div class="project-gantt-header">
            <div>
                <h3>Project Gantt Chart</h3>
                <p>Visualisasi jadwal task berdasarkan tanggal mulai dan tanggal selesai.</p>
            </div>
            <a href="{{ route('projects.timeline.index', $project->id) }}" class="btn-secondary">
                Manage Timeline
            </a>
        </div>
        @if(isset($ganttTasks) && $ganttTasks->count() > 0)
            <div class="project-gantt-scroll">
                <div class="project-gantt">
                    @foreach($ganttTasks as $task)
                        @php
                            $taskStart = \Carbon\Carbon::parse($task->start_date);
                            $taskEnd = \Carbon\Carbon::parse($task->end_date);

                            $offset = $ganttStart ? $ganttStart->diffInDays($taskStart) : 0;
                            $duration = $taskStart->diffInDays($taskEnd) + 1;

                            $left = $ganttTotalDays > 0 ? ($offset / $ganttTotalDays) * 100 : 0;
                            $width = $ganttTotalDays > 0 ? ($duration / $ganttTotalDays) * 100 : 100;

                            $statusClass = match($task->status) {
                                'In Progress' => 'ongoing',
                                'Done' => 'completed',
                                default => 'planned',
                            };
                        @endphp
                        <div class="gantt-row">
                            <div class="gantt-label">
                                <strong>{{ $task->name }}</strong>
                                <span>
                                    {{ $task->start_date->format('d M') }}
                                    -
                                    {{ $task->end_date->format('d M Y') }}
                                </span>
                            </div>
                            <div class="gantt-track">
                                <div
                                    class="gantt-bar {{ $statusClass }}"
                                    style="left: {{ $left }}%; width: {{ $width }}%;">
                                    <span>{{ $task->progress }}%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="gantt-empty-state">
                <div class="gantt-empty-icon">
                    📅
                </div>

                <div>
                    <h4>Timeline belum dibuat</h4>
                    <p>
                        Klik Manage Timeline untuk menambahkan task dan menampilkan Gantt Chart project.
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div class="rbs-scroll-wrap">
        <div class="rbs-board export-report-area" id="export-report-area">
            <div class="diagram-header">
                <div class="project-diagram-head">
                    <div class="project-node-wrap">
                        <div class="project-node-label">PROJECT</div>
                        <div class="project-node">
                            {{ $project->nama_project }}
                        </div>
                    </div>

                    <a class="btn app-btn root-category-btn"
                       href="{{ route('projects.categories.create', $project->id) }}"
                       data-export-ignore>
                        + Category
                    </a>
                </div>
            </div>
            <ul class="rbs-tree">
                @foreach($categories as $category)
                    @include('projects.partials.category-node', [
                        'category' => $category,
                        'project' => $project,
                        'level' => 0
                    ])
                @endforeach
            </ul>
            <div class="export-matrix-section">
                @include('projects.partials.risk-matrix')
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

<script>
document.addEventListener('click', function(e) {
    if (document.body.classList.contains('is-exporting')) return;

    const node = e.target.closest('.caret');
    if (!node) return;

    const categoryItem = node.closest('.category-item');
    if (!categoryItem) return;

    const nested = categoryItem.querySelector(':scope > .nested');
    if (!nested) return;

    nested.classList.toggle('active');

    const arrow = node.querySelector('.arrow');
    if (arrow) {
        arrow.textContent = nested.classList.contains('active') ? '▼' : '▶';
    }
});

function expandAllNodes() {
    document.querySelectorAll('#export-report-area .nested').forEach(function(el) {
        el.classList.add('active');
    });

    document.querySelectorAll('#export-report-area .arrow').forEach(function(el) {
        el.textContent = '▼';
    });
}

function makeSafeFilename(name) {
    return String(name || 'rbs-report')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

async function renderExportCanvas() {
    const target = document.getElementById('export-report-area');
    if (!target) return null;

    expandAllNodes();
    document.body.classList.add('is-exporting');

    await new Promise(resolve => setTimeout(resolve, 200));

    const canvas = await html2canvas(target, {
        backgroundColor: '#ffffff',
        scale: 2,
        useCORS: true,
        logging: false,
        scrollX: 0,
        scrollY: -window.scrollY
    });

    document.body.classList.remove('is-exporting');
    return canvas;
}

function downloadDataUrl(dataUrl, filename) {
    const link = document.createElement('a');
    link.href = dataUrl;
    link.download = filename;
    link.click();
}

document.getElementById('export-png-btn')?.addEventListener('click', async function() {
    const canvas = await renderExportCanvas();
    if (!canvas) return;

    const filename = 'rbs-report-' + makeSafeFilename(@json($project->nama_project)) + '.png';
    downloadDataUrl(canvas.toDataURL('image/png'), filename);
});

document.getElementById('export-jpg-btn')?.addEventListener('click', async function() {
    const canvas = await renderExportCanvas();
    if (!canvas) return;

    const filename = 'rbs-report-' + makeSafeFilename(@json($project->nama_project)) + '.jpg';
    downloadDataUrl(canvas.toDataURL('image/jpeg', 0.95), filename);
});

document.getElementById('export-pdf-btn')?.addEventListener('click', async function() {
    const canvas = await renderExportCanvas();
    if (!canvas) return;

    const { jsPDF } = window.jspdf;
    const imgData = canvas.toDataURL('image/png');

    const pdf = new jsPDF({
        orientation: 'landscape',
        unit: 'px',
        format: 'a4'
    });

    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();
    const margin = 20;

    const availableWidth = pageWidth - (margin * 2);
    const availableHeight = pageHeight - (margin * 2);

    const ratio = Math.min(
        availableWidth / canvas.width,
        availableHeight / canvas.height
    );

    const imgWidth = canvas.width * ratio;
    const imgHeight = canvas.height * ratio;

    const x = (pageWidth - imgWidth) / 2;
    const y = (pageHeight - imgHeight) / 2;

    pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);

    const filename = 'rbs-report-' + makeSafeFilename(@json($project->nama_project)) + '.pdf';
    pdf.save(filename);
});
</script>
@endpush