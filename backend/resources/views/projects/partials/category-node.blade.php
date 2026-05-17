<li class="category-item">
    <div class="category-header">
        <div class="category-header-left">
            <div class="rbs-node caret">
                <span class="arrow">{{ ($level ?? 0) === 0 ? '▼' : '▶' }}</span>
                📁 {{ $category->nama_kategori }}
            </div>

            <a class="btn app-btn subcategory-inline-btn"
               data-export-ignore
               href="{{ route('projects.categories.create', [
                    'project' => $project->id,
                    'parent' => $category->id
               ]) }}">
                + Sub 
            </a>
        </div>

        <div class="manage-dropdown" data-export-ignore>

            <button type="button" class="icon-btn manage-toggle">
                ⋮
            </button>

            <div class="manage-menu">

                <a href="{{ route('projects.categories.edit',
                    [$project->id, $category->id]) }}"
                    class="manage-item">
                    ✏ Edit
                </a>

                <form action="{{ route('projects.categories.destroy',
                    [$project->id, $category->id]) }}"
                    method="POST"
                    class="inline-form"
                    onsubmit="return confirm(
                        'Deleting this category will also delete all subcategories and risks inside it. Continue?'
                    )">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="manage-item delete-btn">
                        🗑 Delete
                    </button>

                </form>

            </div>

        </div>
    </div>

    <div class="nested {{ ($level ?? 0) === 0 ? 'active' : '' }}">
        @if($category->children->count())
            <ul class="subcategory-row">
                @foreach($category->children as $child)
                    @include('projects.partials.category-node', [
                        'category' => $child,
                        'project' => $project,
                        'level' => ($level ?? 0) + 1
                    ])
                @endforeach
            </ul>
        @endif

        @if($category->risks->count())
            <ul class="risk-list">
                @foreach($category->risks as $risk)
                    <li class="risk-item">
                        <!-- <span class="risk {{ strtolower($risk->risk_level ?? 'low') }}">
                            ⚠ {{ $risk->nama_risiko }}
                        </span> -->
                        <a href="{{ route('projects.risks.show',[$project->id, $risk->id]) }}"
                            class="risk {{ strtolower($risk->risk_level ?? 'low') }}">

                             {{ $risk->nama_risiko }}

                        </a>

                        <form action="{{ route('projects.risks.destroy', [$project->id, $risk->id]) }}"
                              method="POST"
                              onsubmit="return confirm('Deleting this category will also delete all subcategories and risks inside it. Continue?')"
                              class="inline-form"
                              data-export-ignore>
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="icon-btn"> 🗑</button>
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
                + Risk
            </a>
        </div>
    </div>
</li>