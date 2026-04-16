@extends('layouts.app')

@section('content')

<h2>{{ $project->nama_project }}</h2>

<div class="diagram-toolbar" data-export-ignore>
    <a class="btn app-btn"
       href="{{ route('projects.categories.create', $project->id) }}">
        + Tambah Category
    </a>

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
    <div class="rbs-board" id="rbs-export-area">
        <div class="export-title">
            RBS Diagram - {{ $project->nama_project }}
        </div>

        <ul class="rbs-tree">
            @foreach($categories as $category)
                @include('projects.partials.category-node', [
                    'category' => $category,
                    'project' => $project
                ])
            @endforeach
        </ul>
    </div>
</div>

<div class="app-card mt-4">
    @include('projects.partials.risk-matrix')
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
    document.querySelectorAll('#rbs-export-area .nested').forEach(function(el) {
        el.classList.add('active');
    });

    document.querySelectorAll('#rbs-export-area .arrow').forEach(function(el) {
        el.textContent = '▼';
    });
}

async function renderRbsCanvas() {
    const target = document.getElementById('rbs-export-area');
    if (!target) return null;

    expandAllNodes();
    document.body.classList.add('is-exporting');

    await new Promise(resolve => setTimeout(resolve, 150));

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

function makeSafeFilename(name) {
    return String(name || 'rbs-diagram')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

document.getElementById('export-png-btn')?.addEventListener('click', async function() {
    const canvas = await renderRbsCanvas();
    if (!canvas) return;

    const filename = 'rbs-diagram-' + makeSafeFilename(@json($project->nama_project)) + '.png';
    downloadDataUrl(canvas.toDataURL('image/png'), filename);
});

document.getElementById('export-jpg-btn')?.addEventListener('click', async function() {
    const canvas = await renderRbsCanvas();
    if (!canvas) return;

    const filename = 'rbs-diagram-' + makeSafeFilename(@json($project->nama_project)) + '.jpg';
    downloadDataUrl(canvas.toDataURL('image/jpeg', 0.95), filename);
});

document.getElementById('export-pdf-btn')?.addEventListener('click', async function() {
    const canvas = await renderRbsCanvas();
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
    const y = margin;

    pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
    const filename = 'rbs-diagram-' + makeSafeFilename(@json($project->nama_project)) + '.pdf';
    pdf.save(filename);
});
</script>
@endpush