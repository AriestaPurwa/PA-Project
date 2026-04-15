@extends('layouts.app')

@section('content')

<div class="mb-3">
    <a href="{{ route('projects.show', $project->id) }}"
       class="btn btn-secondary">
        ← Back
    </a>
</div>

<h3>Tambah Category</h3>

<form method="POST"
      action="{{ route('projects.categories.store', $project->id) }}">

    @csrf

    {{-- NAMA CATEGORY --}}
    <div style="margin-bottom:10px;">
        <label>Nama Category</label><br>
        <input type="text"
               name="nama_kategori"
               required
               style="width:300px;">
    </div>

    {{-- PARENT CATEGORY --}}
    <div style="margin-bottom:10px;">
        <label>Parent (optional)</label><br>

        <select name="parent_id">
            <option value="">-- Root Category --</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('parent') == $category->id ? 'selected' : '' }}>
                    {{ $category->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- SAVE BUTTON --}}
    <button type="submit" class="btn app-btn">
        💾 Save Category
    </button>

</form>

@endsection