<li style="margin-left:20px">

    {{-- CARET TOGGLE --}}
    @if($category->children->count())
        <span class="caret" style="cursor:pointer; font-weight:bold;">
            ▶
        </span>
    @else
        <span style="display:inline-block; width:15px;"></span>
    @endif

    <strong>{{ $category->nama_kategori }}</strong>

    {{-- ACTION --}}
    <div style="display:inline-block; margin-left:10px;">

        <a href="{{ route('projects.categories.create', $project->id) }}
            ?parent={{ $category->id }}">
            [+ Sub]
        </a>

        <a href="{{ route('projects.risks.create', [
            'project' => $project->id,
            'category' => $category->id
        ]) }}">
            [+ Risk]
        </a>

    </div>

    {{-- CHILDREN --}}
    @if($category->children->count())
        <ul class="nested" style="display:none;">
            @foreach($category->children as $child)
                @include('risk_categories.partials.category-node', [
                    'category' => $child,
                    'project' => $project
                ])
            @endforeach
        </ul>
    @endif

    {{-- tampilkan risks jika leaf node --}}
    @if($category->children->isEmpty())
        @if($category->risks->count())
            <ul class="ms-4">
                @foreach($category->risks as $risk)
                    <li class="text-danger">
                        ⚠ {{ $risk->title }}
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

</li>