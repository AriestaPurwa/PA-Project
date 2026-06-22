@extends('layouts.app')

@section('content')

<div class="project-form-page">

    <div class="project-form-header">
        <div>
            <h2>Tambah Project</h2>
            <p>Buat project baru untuk mulai menyusun Risk Breakdown Structure.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="btn-secondary">
            ← Kembali
        </a>
    </div>

    @if(request('guest'))
        <div class="project-form-alert warning">
            <strong>⚠️ Guest Mode Active</strong>
            <p>Project ini bersifat sementara dan tidak tersimpan secara permanen.</p>
        </div>
    @endif

    <div class="project-form-card">

        <div class="project-form-card-header">
            <div>
                <h3>Informasi Project</h3>
                <p>Lengkapi data dasar project sebelum menyusun kategori risiko.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            @if(request()->has('guest'))
                <input type="hidden" name="guest_mode" value="1">
            @endif

            <div class="project-form-section">

                <div class="form-row two-columns">

                    <div class="form-group">
                        <label class="form-label" for="nama_project">
                            Nama Project
                        </label>

                        <input
                            id="nama_project"
                            type="text"
                            name="nama_project"
                            class="form-input"
                            placeholder="Contoh: Pembangunan Gedung A"
                            value="{{ old('nama_project') }}"
                            required
                            autocomplete="off"
                        >

                        <small class="form-help">
                            Gunakan nama project yang mudah dikenali.
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="project_type_id">
                            Project Type
                        </label>

                        <select
                            name="project_type_id"
                            id="project_type_id"
                            class="form-select"
                            required
                        >
                            <option value="">-- Select Project Type --</option>

                            @foreach($projectTypes as $type)
                                <option
                                    value="{{ $type->id }}"
                                    {{ old('project_type_id') == $type->id ? 'selected' : '' }}
                                >
                                    {{ $type->name ?? $type->nama_tipe }}
                                </option>
                            @endforeach
                        </select>

                        <small class="form-help">
                            Tipe project digunakan untuk kategori awal dan rekomendasi mitigasi.
                        </small>
                    </div>

                </div>

                <div class="form-row three-columns">

                    <div class="form-group">
                        <label class="form-label" for="status">
                            Status Project
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                        >
                            <option value="Planning" {{ old('status', 'Planning') == 'Planning' ? 'selected' : '' }}>
                                Planning
                            </option>

                            <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>
                                Ongoing
                            </option>

                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="progress">
                            Progress Project (%)
                        </label>

                        <input
                            id="progress"
                            type="number"
                            name="progress"
                            min="0"
                            max="100"
                            class="form-input"
                            value="{{ old('progress', 0) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estimated_budget">
                            Estimasi Anggaran (Rp)
                        </label>

                        <input
                            id="estimated_budget"
                            type="number"
                            name="estimated_budget"
                            min="0"
                            class="form-input"
                            placeholder="Contoh: 5000000"
                            value="{{ old('estimated_budget') }}"
                        >
                    </div>

                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi">
                        Deskripsi
                        <span class="label-optional">(opsional)</span>
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        class="form-textarea"
                        placeholder="Tulis deskripsi singkat tentang project ini..."
                    >{{ old('deskripsi') }}</textarea>
                </div>

            </div>

            <div class="project-form-actions">
                <a href="{{ route('projects.index') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn app-btn">
                    Simpan Project
                </button>
            </div>

        </form>

    </div>

</div>

@endsection