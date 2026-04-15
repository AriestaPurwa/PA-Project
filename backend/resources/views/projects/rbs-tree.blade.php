<ul class="rbs-tree">
    @foreach($categories as $category)
        @include('projects.partials.category-node', [
                'category' => $category,
                'project' => $project
        ])
    @endforeach
</ul>


