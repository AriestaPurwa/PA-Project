<li class="category-item">
    <div class="category-header">
        <div class="rbs-node caret">
            <span class="arrow">▼</span>
            📁 {{ $category->nama_kategori }}
        </div>

        <form action="{{ route('projects.categories.destroy', [$project->id, $category->id]) }}"
              method="POST"
              class="inline-form"
              data-export-ignore>
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="icon-btn"
                    onclick="return confirm('Hapus kategori ini?')">
                🗑
            </button>
        </form>
    </div>

    <div class="nested active">
        @if($category->children->count())
            <ul class="subcategory-row">
                @foreach($category->children as $child)
                    @include('projects.partials.category-node', [
                        'category' => $child,
                        'project' => $project
                    ])
                @endforeach
            </ul>
        @endif

        @if($category->risks->count())
            <ul class="risk-list">
                @foreach($category->risks as $risk)
                    <li class="risk-item">
                        <span class="risk {{ strtolower($risk->risk_level ?? 'low') }}">
                            ⚠ {{ $risk->nama_risiko }}
                        </span>

                        <form action="{{ route('projects.risks.destroy', [$project->id, $risk->id]) }}"
                              method="POST"
                              class="inline-form"
                              data-export-ignore>
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus risk ini?')"
                                    class="icon-btn">
                                🗑
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="category-actions" data-export-ignore>
            <a class="btn app-btn"
               href="{{ route('projects.risks.create', [
                    'project' => $project->id,
                    'category_id' => $category->id
               ]) }}">
                + Tambah Risk
            </a>

            <a class="btn app-btn"
               href="{{ route('projects.categories.create', [
                    'project' => $project->id,
                    'parent' => $category->id
               ]) }}">
                + Sub Category
            </a>
        </div>
    </div>
</li>