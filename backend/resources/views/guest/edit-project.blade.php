@extends('layouts.guest')

@section('content')

<div class="form-page">

    <div class="mb-3">
        <a href="/guest/editor" class="btn-secondary">
            ← Back to Guest Tree
        </a>
    </div>

    <div class="form-card">

        <h2 class="form-title">
            Edit Guest Project
        </h2>

        <p class="form-subtitle">
            Update the temporary guest project information.
        </p>

        <form action="/guest/project/update"
              method="POST">

            @csrf

            <div class="form-grid">

                <div class="form-group">

                    <label class="form-label">
                        Project Name
                    </label>

                    <input type="text"
                           name="nama_project"
                           class="form-input"
                           value="{{ old('nama_project', $project['nama_project'] ?? '') }}"
                           required>

                    <div class="field-hint">
                        Enter the project name displayed at the root of the RBS tree.
                    </div>

                </div>

                <div class="form-group">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="deskripsi"
                              class="form-textarea"
                              placeholder="Optional project description">{{ old('deskripsi', $project['deskripsi'] ?? '') }}</textarea>

                    <div class="field-hint">
                        This description is optional and only used while editing the guest project.
                    </div>

                </div>

            </div>

            <div class="form-actions">

                <button type="submit"
                        class="btn app-btn">
                    Update Project
                </button>

                <a href="/guest/editor" class="btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection