@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Edit Category
        </h2>

        <p class="form-subtitle">
            Update category name.
        </p>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('projects.categories.update',
                [$project->id, $category->id]) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">
                    Category Name
                </label>

                <input
                    type="text"
                    name="nama_kategori"
                    class="form-input"
                    value="{{ old('nama_kategori',
                        $category->nama_kategori) }}"
                    required
                >

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn app-btn">

                    Update Category

                </button>

                <a href="{{ route('projects.show',
                    $project->id) }}"
                    class="btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection