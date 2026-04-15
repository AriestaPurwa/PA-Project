<li>

    {{-- CATEGORY NODE --}}
    <div class="rbs-node caret">
        <span class="arrow">▶</span>
        📁 {{ $category->nama_kategori }}
    </div>

    <form action="{{ route('projects.categories.destroy',
            [$project->id, $category->id]) }}"
        method="POST"
        style="display:inline;">

        @csrf
        @method('DELETE')

        <button type="submit"
            onclick="return confirm('Hapus kategori ini?')">
            🗑
        </button>
    </form>

    <ul class="nested">

        {{-- SUB CATEGORY --}}
        @foreach($category->children as $child)
            @include('projects.partials.category-node', [
                'category' => $child,
                'project' => $project
            ])
        @endforeach

        {{-- RISKS --}}
        @foreach($category->risks as $risk)
        <li>
            <span class="risk {{ strtolower($risk->risk_level ?? 'low') }}">
                ⚠ {{ $risk->nama_risiko }}
            </span>

            <form action="{{ route('projects.risks.destroy', [$project->id, $risk->id]) }}"
                method="POST"
                style="display:inline;">

                @csrf
                @method('DELETE')

                <button type="submit"
                    onclick="return confirm('Yakin ingin menghapus risk ini?')"
                    class="btn app-btn">
                    🗑
                </button>
            </form>
        </li>
        @endforeach

        {{-- ACTION --}}
        <li>
            <a class="btn app-btn"
            href="{{ route('projects.risks.create', [
                    'project' => $project->id,
                    'category_id' => $category->id
                ]) }}">
                + Tambah Risk
            </a>
        </li>

        <li>
            <a class="btn app-btn"
            href="{{ route('projects.categories.create', [
                'project' => $project->id,
                'parent' => $category->id]) }}">
                + Sub Category
            </a>
        </li>

    </ul>

</li>

