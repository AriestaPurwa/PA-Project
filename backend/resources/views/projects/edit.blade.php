@extends('layouts.app')

@section('content')

<div class="form-page">

    <div class="form-card">

        <h2 class="form-title">
            Edit Project
        </h2>

        <form
            action="{{ route('projects.update', $project->id) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label class="form-label">
                    Project Name
                </label>

                <input
                    type="text"
                    name="nama_project"
                    class="form-input"
                    value="{{ old('nama_project', $project->nama_project) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Description
                </label>

                <textarea
                    name="deskripsi"
                    class="form-textarea"
                >{{ old('deskripsi', $project->deskripsi) }}</textarea>

            </div>

            <div class="form-actions">

                <button type="submit" class="btn app-btn">
                    Update Project
                </button>

                <a
                    href="{{ route('projects.show', $project->id) }}"
                    class="btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection