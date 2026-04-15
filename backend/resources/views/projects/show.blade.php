@extends('layouts.app')

@section('content')

<h2>{{ $project->nama_project }}</h2>

{{-- ✅ ROOT CATEGORY BUTTON --}}
<div style="margin-bottom:15px;">
    <a class="btn app-btn"
       href="{{ route('projects.categories.create', $project->id) }}">
        + Tambah Category
    </a>
</div>

<ul class="rbs-tree">

    @foreach($categories as $category)
        @include('projects.partials.category-node', [
            'category' => $category,
            'project' => $project
        ])
    @endforeach

</ul>

<div class="app-card mt-4">
    <h5>Risk Matrix</h5>

    @include('projects.partials.risk-matrix')
</div>

@endsection

<script>
document.addEventListener('click', function(e) {

    const node = e.target.closest('.caret');
    if (!node) return;

    const nested = node.parentElement.querySelector('.nested');
    if (!nested) return;

    nested.classList.toggle('active');

    const arrow = node.querySelector('.arrow');
    if (arrow) {
        arrow.textContent = nested.classList.contains('active') ? '▼' : '▶';
    }
});
</script>

</table>