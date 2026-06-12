@extends('layouts.app')

@section('content')

<div class="diagram-page">
    @if(session('guest_project'))

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

    <div class="rbs-scroll-wrap">
        <div class="rbs-board export-report-area" id="export-report-area">

            <div class="diagram-header">
                <div class="project-diagram-head">
                    <div class="project-node-wrap">
                        <div class="project-node-label">PROJECT</div>

                        <div class="project-node">
                            {{ $project['nama_project'] }}
                        </div>
                    </div>

                    <a class="btn app-btn root-category-btn"
                       href="/guest/category/create"
                       data-export-ignore>
                        + Category
                    </a>
                </div>

            </div>

            <ul class="rbs-tree">
                @foreach($categories as $category)
                    @include('guest.partials.category-node', [
                        'category' => $category,
                        'project' => $project,
                        'level' => 0
                    ])
                @endforeach
            </ul>

            <div class="export-matrix-section">
               {{-- @include('projects.partials.risk-matrix') --}}
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

    const filename = 'rbs-report-' + makeSafeFilename(@json($project['nama_project'])) + '.png';
    downloadDataUrl(canvas.toDataURL('image/png'), filename);
});

document.getElementById('export-jpg-btn')?.addEventListener('click', async function() {
    const canvas = await renderExportCanvas();
    if (!canvas) return;

    const filename = 'rbs-report-' + makeSafeFilename(@json($project['nama_project'])) + '.jpg';
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

    const filename = 'rbs-report-' + makeSafeFilename(@json($project['nama_project'])) + '.pdf';
    pdf.save(filename);
});
</script>
@endpush