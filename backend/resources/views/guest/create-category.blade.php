@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Add Category
        </h2>

        <form
            action="/guest/category/store"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="parent_id"
                value="{{ $parentId }}"
            >

            <div class="form-group">

                <label class="form-label">
                    Category Name
                </label>

                <input
                    type="text"
                    name="nama_kategori"
                    class="form-input"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn app-btn"
            >
                Save Category
            </button>

        </form>

    </div>

</div>

@endsection