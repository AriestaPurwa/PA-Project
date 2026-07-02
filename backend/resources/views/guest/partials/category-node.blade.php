<li class="category-item">

    <div class="category-header">

        <div class="category-header-left">

            <div class="rbs-node caret">
                <span class="arrow">
                    {{ ($level ?? 0) === 0 ? '▼' : '▶' }}
                </span>

                📁 {{ $category['nama_kategori'] }}
            </div>

            <a class="btn app-btn subcategory-inline-btn"
               href="/guest/category/create/{{ $category['id'] }}"
               data-export-ignore>
                + Sub
            </a>

        </div>

        <div class="manage-dropdown" data-export-ignore>

            <button type="button" class="icon-btn manage-toggle" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="manage-menu">

                <a href="{{ route('guest.category.edit', $category['id']) }}"
                class="manage-item">
                    Edit
                </a>

                <form
                    action="{{ route('guest.category.delete', $category['id']) }}"
                    method="POST"
                    onsubmit="return confirm('Hapus category ini? Subcategory dan risk di dalamnya juga akan terhapus.')"
                    style="display:inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="danger">
                        Hapus
                    </button>
                </form>

            </div>

        </div>

    </div>

    <div class="nested {{ ($level ?? 0) === 0 ? 'active' : '' }}">

        @if(count($category['children'] ?? []) || count($category['risks'] ?? []))

            <div class="tree-children">

                @if(count($category['children'] ?? []))

                    <ul class="subcategory-row">

                        @foreach($category['children'] as $child)

                            @include('guest.partials.category-node', [
                                'category' => $child,
                                'project' => $project,
                                'level' => ($level ?? 0) + 1
                            ])

                        @endforeach

                    </ul>

                @endif

                @if(count($category['risks'] ?? []))

                    <ul class="risk-list">

                        @foreach($category['risks'] as $risk)

                            <li class="risk-item">

                                <a href="{{ route('guest.risk.show', $risk['id']) }}"
                                class="risk {{ strtolower($risk['risk_level'] ?? 'low') }}">
                                    {{ $risk['nama_risiko'] }}
                                </a>

                                <div class="manage-dropdown" data-export-ignore>

                                    <button type="button" class="icon-btn manage-toggle" aria-label="Menu">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>

                                    <div class="manage-menu">

                                       <a href="{{ route('guest.risk.edit', $risk['id']) }}"
                                        class="manage-item">
                                            Edit
                                        </a>

                                       <form
                                            action="{{ route('guest.risk.delete', $risk['id']) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus risk ini?')"
                                            style="display:inline;"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="danger">
                                                Hapus
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </li>

                        @endforeach

                    </ul>

                @endif

            </div>

        @endif

        <div class="category-actions" data-export-ignore>

            <a class="btn app-btn"
               href="/guest/risk/create/{{ $category['id'] }}">
                + Risk
            </a>

        </div>

    </div>

</li>