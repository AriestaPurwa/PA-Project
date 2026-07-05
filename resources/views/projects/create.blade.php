@extends('layouts.app')

@section('content')

<div class="project-form-page modern-project-form-page">

    {{-- ===== HEADER ===== --}}
    <div class="project-form-hero">
        <div>
            <span class="page-label">Create Project</span>
            <h2>Tambah Project</h2>
            <p>
                Buat project baru untuk mulai menyusun Risk Breakdown Structure,
                kategori risiko, risk matrix, dan rekomendasi mitigasi.
            </p>
        </div>

        <a href="{{ route('projects.index') }}" class="project-form-back-btn">
            ← Kembali
        </a>
    </div>

    {{-- ===== GUEST NOTICE ===== --}}
    @if(request('guest'))
        <div class="project-form-alert warning modern-form-alert">
            <div class="form-alert-icon">⚠</div>

            <div>
                <strong>Guest Mode Active</strong>
                <p>Project ini bersifat sementara dan tidak tersimpan secara permanen.</p>
            </div>
        </div>
    @endif

    {{-- ===== FORM CARD ===== --}}
    <div class="project-form-card modern-project-form-card">

        <div class="project-form-card-header modern-project-form-card-header">
            <div>
                <span class="section-kicker">Project Information</span>
                <h3>Informasi Project</h3>
                <p>Lengkapi data dasar project sebelum menyusun kategori risiko.</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert-error modern-alert-error">
                <strong>Terjadi kesalahan input</strong>

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

            <div class="project-form-section modern-project-form-section">

                {{-- ===== BASIC INFORMATION ===== --}}
                <div class="form-section-title">
                    <span>01</span>
                    <div>
                        <h4>Data Utama</h4>
                        <p>Nama project dan tipe project sebagai dasar struktur RBS.</p>
                    </div>
                </div>

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

                {{-- ===== TRACKING INFORMATION ===== --}}
                <div class="form-section-title">
                    <span>02</span>
                    <div>
                        <h4>Schedule & Cost</h4>
                        <p>Tentukan periode pengerjaan project dan total estimasi biaya.</p>
                    </div>
                </div>

                <div class="form-row three-columns">

                    <div class="form-group">
                        <label class="form-label" for="start_date">
                            Start Date
                        </label>

                        <input
                            id="start_date"
                            type="date"
                            name="start_date"
                            class="form-input"
                            value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="end_date">
                            End Date
                        </label>

                        <input
                            id="end_date"
                            type="date"
                            name="end_date"
                            class="form-input"
                            value="{{ old('end_date', isset($project) && $project->end_date ? $project->end_date->format('Y-m-d') : '') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="estimated_budget">
                            Project Cost / Budget (Rp)
                        </label>

                        <input
                            id="estimated_budget"
                            type="number"
                            name="estimated_budget"
                            min="0"
                            class="form-input"
                            value="{{ old('budget_estimate', $project->budget_estimate ?? 0) }}"
                            required
                        >
                    </div>

                </div>

                {{-- ===== DESCRIPTION ===== --}}
                <div class="form-section-title">
                    <span>03</span>
                    <div>
                        <h4>Deskripsi Project</h4>
                        <p>Tambahkan penjelasan singkat agar project lebih mudah dipahami.</p>
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

            <div class="project-form-actions modern-project-form-actions">
                <a href="{{ route('projects.index') }}" class="project-form-cancel-btn">
                    Batal
                </a>

                <button type="submit" class="project-form-submit-btn">
                    Simpan Project
                </button>
            </div>

        </form>

    </div>

</div>

@endsection