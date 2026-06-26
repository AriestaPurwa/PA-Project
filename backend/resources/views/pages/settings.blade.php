@extends('layouts.app')

@section('content')

<div class="settings-page">

    <div class="page-header">
        <div>
            <h2>Settings</h2>
            <p>Kelola profil akun dan lihat ringkasan penggunaan sistem.</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn app-btn">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="timeline-success-alert" style="margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-error" style="margin-bottom:16px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-profile-card">

        <div class="settings-profile-left">

            <div class="settings-avatar settings-avatar-photo">
                @if($user->profile_photo)
                    <img
                        src="{{ asset('storage/' . $user->profile_photo) }}"
                        alt="Profile Photo"
                    >
                @else
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                @endif
            </div>

            <div>
                <span class="settings-profile-label">Registered User</span>
                <h3>{{ $user->name ?? 'User' }}</h3>
                <p>{{ $user->email ?? '-' }}</p>
            </div>

        </div>

        <div class="settings-profile-status">
            <span>Account Status</span>
            <strong>Active</strong>
        </div>

    </div>

    <div class="settings-grid">

        <div class="settings-panel">

            <div class="panel-header">
                <h3>Profile Information</h3>
            </div>

            <form
                action="{{ route('settings.profile.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="profile-form"
            >
                @csrf
                @method('PUT')

                <div class="profile-upload-preview">

                    <div class="profile-photo-preview">
                        @if($user->profile_photo)
                            <img
                                src="{{ asset('storage/' . $user->profile_photo) }}"
                                alt="Profile Photo"
                            >
                        @else
                            <span>{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
                        @endif
                    </div>

                    <div>
                        <h4>Profile Photo</h4>
                        <p>Upload foto profil dengan format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                    </div>

                </div>

                <div class="form-group">
                    <label class="form-label" for="name">
                        Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="form-input"
                        value="{{ old('name', $user->name) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="profile_photo">
                        Upload Photo
                    </label>

                    <input
                        id="profile_photo"
                        type="file"
                        name="profile_photo"
                        class="form-input"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                    >

                    <small class="form-help">
                        Kosongkan jika tidak ingin mengganti foto.
                    </small>
                </div>

                <div class="settings-form-actions">
                    <button type="submit" class="btn app-btn">
                        Update Profile
                    </button>
                </div>

            </form>

        </div>

        <div class="settings-panel">

            <div class="panel-header">
                <h3>Account Information</h3>
            </div>

            <div class="settings-info-list">

                <div class="settings-info-item">
                    <span>Name</span>
                    <strong>{{ $user->name ?? '-' }}</strong>
                </div>

                <div class="settings-info-item">
                    <span>Email</span>
                    <strong>{{ $user->email ?? '-' }}</strong>
                </div>

                <div class="settings-info-item">
                    <span>Account Type</span>
                    <strong>Registered User</strong>
                </div>

                <div class="settings-info-item">
                    <span>Registered At</span>
                    <strong>
                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                    </strong>
                </div>

            </div>

        </div>

    </div>

    <div class="settings-summary-grid">

        <div class="settings-summary-card">
            <span>Total Project</span>
            <h3>{{ $totalProjects }}</h3>
        </div>

        <div class="settings-summary-card">
            <span>Total Risk</span>
            <h3>{{ $totalRisks }}</h3>
        </div>

        <div class="settings-summary-card high">
            <span>High Risk</span>
            <h3>{{ $highRisks }}</h3>
        </div>

        <div class="settings-summary-card medium">
            <span>Medium Risk</span>
            <h3>{{ $mediumRisks }}</h3>
        </div>

        <div class="settings-summary-card low">
            <span>Low Risk</span>
            <h3>{{ $lowRisks }}</h3>
        </div>

    </div>

    <div class="settings-panel">

        <div class="panel-header">
            <h3>System Preferences</h3>
        </div>

        <div class="settings-option-list">

            <div class="settings-option-item">
                <div>
                    <h4>Risk Level Calculation</h4>
                    <p>Risk score dihitung dari probability × impact.</p>
                </div>

                <span class="settings-badge active">
                    Active
                </span>
            </div>

            <div class="settings-option-item">
                <div>
                    <h4>Rule-Based Recommendation</h4>
                    <p>Rekomendasi mitigasi berdasarkan tipe project dan risk level.</p>
                </div>

                <span class="settings-badge active">
                    Active
                </span>
            </div>

            <div class="settings-option-item">
                <div>
                    <h4>Activity Tracking</h4>
                    <p>Aktivitas project, kategori, risk, dan timeline tercatat otomatis.</p>
                </div>

                <span class="settings-badge active">
                    Active
                </span>
            </div>

        </div>

    </div>

</div>

@endsection