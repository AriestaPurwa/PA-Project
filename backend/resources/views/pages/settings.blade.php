@extends('layouts.app')

@section('content')

<div class="settings-page">

    <div class="page-header">
        <div>
            <h2>Settings</h2>
            <p>Informasi akun dan ringkasan penggunaan sistem.</p>
        </div>

        <a href="{{ route('dashboard') }}" class="btn app-btn">
            Back to Dashboard
        </a>
    </div>

    <div class="settings-profile-card">

        <div class="settings-profile-left">

            <div class="settings-avatar">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
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

    <div class="settings-grid">

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
                        <p>Aktivitas project, kategori, dan risiko tercatat otomatis.</p>
                    </div>

                    <span class="settings-badge active">
                        Active
                    </span>
                </div>

            </div>

        </div>

    </div>

    <div class="settings-note">

        <div class="settings-note-icon">
            ℹ️
        </div>

        <div>
            <h4>Catatan</h4>
            <p>
                Halaman Settings saat ini digunakan untuk menampilkan informasi akun
                dan ringkasan penggunaan sistem. Fitur edit profil atau ubah password
                dapat dikembangkan pada tahap berikutnya.
            </p>
        </div>

    </div>

</div>

@endsection