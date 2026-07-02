@extends('layouts.app')

@section('content')

<div class="diagram-page project-detail-page">

    {{-- ===== GUEST NOTICE ===== --}}
    @if($project->is_guest)
        <div class="project-detail-alert guest">
            <div class="project-detail-alert-icon">⚠</div>

            <div>
                <strong>Guest Mode Active</strong>
                <p>This project is temporary and may be deleted automatically later.</p>

                <a href="/login" class="btn app-btn">
                    Login to Save Permanently
                </a>
            </div>
        </div>
    @endif

    {{-- ===== PROJECT DETAIL HERO ===== --}}
    @php
        $statusClass = match($project->status) {
            'Ongoing' => 'ongoing',
            'Completed' => 'completed',
            default => 'planning',
        };

        $statusLabel = $project->status ?? 'Planning';

        $progress = $project->progress ?? 0;
        $mitigationProgress = $project->mitigation_progress ?? 0;

        $budgetValue = $project->estimated_budget ?? $project->budget_estimate ?? null;
    @endphp

    <div class="project-detail-hero">

        <div class="project-detail-main">
            <span class="page-label">Project Detail</span>

            <div class="project-detail-title-row">
                <h2>{{ $project->nama_project }}</h2>

                <span class="project-status-badge {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <p>
                {{ $project->deskripsi ?: 'Belum ada deskripsi proyek.' }}
            </p>
        </div>

        <div class="project-detail-actions" data-export-ignore>
            <a href="{{ route('projects.edit', $project->id) }}" class="project-action-btn primary">
                <span>✏</span>
                Edit Project
            </a>

            <a href="{{ route('projects.history', $project->id) }}" class="project-action-btn secondary">
                <span>📜</span>
                View History
            </a>
        </div>

    </div>

    {{-- ===== PROJECT INFORMATION ===== --}}
    <div class="project-info-card project-detail-info-card">

        <div class="project-detail-section-header">
            <div>
                <h3>Project Information</h3>
                <p>Informasi utama mengenai tipe project, status, progress, dan estimasi anggaran.</p>
            </div>
        </div>

        <div class="project-info-grid project-detail-info-grid">

            <div class="project-info-item detail-info-item">
                <span class="info-label">Tipe Proyek</span>
                <span class="info-value">
                    {{ $project->projectType->name ?? $project->projectType->nama_tipe ?? '-' }}
                </span>
            </div>

            <div class="project-info-item detail-info-item">
                <span class="info-label">Status Proyek</span>
                <span class="info-value">
                    {{ $statusLabel }}
                </span>
            </div>

            <div class="project-info-item detail-info-item">
                <span class="info-label">Progress Proyek</span>

                <div class="detail-progress-box">
                    <div class="project-progress-track">
                        <div
                            class="project-progress-fill"
                            style="width: {{ $progress }}%;"
                        ></div>
                    </div>

                    <strong>{{ $progress }}%</strong>
                </div>
            </div>

            <div class="project-info-item detail-info-item">
                <span class="info-label">Estimasi Anggaran</span>
                <span class="info-value">
                    @if($budgetValue)
                        Rp {{ number_format($budgetValue, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </span>
            </div>

            <!-- <div class="project-info-item detail-info-item">
                <span class="info-label">Progress Mitigasi</span>

                <div class="detail-progress-box">
                    <div class="progress-bar-track">
                        <div
                            class="progress-bar-fill"
                            style="width: {{ $mitigationProgress }}%;"
                        ></div>
                    </div>

                    <strong>{{ $mitigationProgress }}%</strong>
                </div>
            </div> -->

        </div>

    </div>

    {{-- ===== GANTT CHART ===== --}}
    <div class="project-gantt-card project-detail-gantt-card">

        <div class="project-gantt-header">
            <div>
                <span class="section-kicker">Timeline</span>
                <h3>Project Gantt Chart</h3>
                <p>Visualisasi jadwal task berdasarkan tanggal mulai dan tanggal selesai.</p>
            </div>

            <a href="{{ route('projects.timeline.index', $project->id) }}" class="btn-secondary" data-export-ignore>
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

                            // $statusClass = match($task->status) {
                            //     'In Progress' => 'ongoing',
                            //     'Done' => 'completed',
                            //     default => 'planned',
                            // };

                            $statusClass = match (true) {
                                $task->progress >= 100 => 'completed',
                                $task->progress > 0 => 'ongoing',
                                default => 'not-started',
                            };
                        @endphp

                        <div class="gantt-row">
                            <div class="gantt-label">
                                <strong>{{ $task->name }}</strong>
                                <span>
                                    {{ $taskStart->format('d M') }}
                                    -
                                    {{ $taskEnd->format('d M Y') }}
                                </span>
                            </div>

                            <div class="gantt-track">
                                <div
                                    class="gantt-bar {{ $statusClass }}"
                                    style="left: {{ $left }}%; width: {{ $width }}%;"
                                >
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

    {{-- ===== RBS DIAGRAM SECTION ===== --}}
    <div class="project-detail-section-card">

        <div class="project-detail-section-header diagram-section-header">
            <div>
                <span class="section-kicker">RBS Diagram</span>
                <h3>Risk Breakdown Structure</h3>
                <p>Visualisasi hierarki kategori risiko dan risk item pada project.</p>
            </div>

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
        </div>

        {{-- DIAGRAM TIDAK DIUBAH --}}
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

                        <a
                            class="btn app-btn root-category-btn"
                            href="{{ route('projects.categories.create', $project->id) }}"
                            data-export-ignore
                        >
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