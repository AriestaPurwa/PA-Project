@extends('layouts.app')

@section('content')

<div class="user-guide-page">

    <div class="page-header">
        <div>
            <h2>User Guide</h2>
            <p>Panduan penggunaan sistem Risk Breakdown Structure.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="btn app-btn">
            Start from Projects
        </a>
    </div>

    <div class="guide-hero">

        <div>
            <span class="guide-label">RBS System Guide</span>
            <h3>Kelola project, identifikasi risiko, dan analisis tingkat risiko secara terstruktur.</h3>
            <p>
                Halaman ini berisi panduan singkat untuk membantu pengguna memahami alur penggunaan sistem,
                mulai dari membuat project sampai mengekspor laporan.
            </p>
        </div>

        <div class="guide-hero-icon">
            📘
        </div>

    </div>

    <div class="guide-section">

        <h3>Quick Start</h3>

        <div class="guide-steps">

            <div class="guide-step">
                <div class="guide-step-number">1</div>
                <div>
                    <h4>Buat Project</h4>
                    <p>
                        Masuk ke menu Projects, lalu klik tombol Tambah Project.
                        Isi nama project, tipe project, status, progress, dan estimasi anggaran.
                    </p>
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-number">2</div>
                <div>
                    <h4>Kelola Kategori Risiko</h4>
                    <p>
                        Setelah project dibuat, sistem menampilkan kategori awal berdasarkan tipe project.
                        Pengguna dapat menambah sub-kategori sesuai struktur RBS.
                    </p>
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-number">3</div>
                <div>
                    <h4>Tambahkan Risiko</h4>
                    <p>
                        Pada setiap kategori, tambahkan risiko dengan mengisi nama risiko,
                        probability, impact, dan deskripsi risiko.
                    </p>
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-number">4</div>
                <div>
                    <h4>Analisis Risk Matrix</h4>
                    <p>
                        Sistem menghitung risk score secara otomatis dari probability × impact,
                        kemudian menentukan risk level Low, Medium, atau High.
                    </p>
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-number">5</div>
                <div>
                    <h4>Lihat Rekomendasi Mitigasi</h4>
                    <p>
                        Sistem memberikan rekomendasi mitigasi berbasis rule berdasarkan tipe project
                        dan tingkat risiko.
                    </p>
                </div>
            </div>

            <div class="guide-step">
                <div class="guide-step-number">6</div>
                <div>
                    <h4>Export Diagram dan Report</h4>
                    <p>
                        Pengguna dapat mengekspor diagram RBS dari halaman detail project,
                        serta membuka laporan analisis risiko melalui menu Reports.
                    </p>
                </div>
            </div>

        </div>

    </div>

    <div class="guide-section">

        <h3>Menu Guide</h3>

        <div class="guide-card-grid">

            <div class="guide-card">
                <div class="guide-card-icon">📊</div>
                <h4>Dashboard</h4>
                <p>
                    Menampilkan ringkasan umum seperti total project, total risiko,
                    high risk, recent project, dan recent activity.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-card-icon">📁</div>
                <h4>Projects</h4>
                <p>
                    Digunakan untuk membuat, mengedit, menghapus, dan membuka detail project.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-card-icon">🛡️</div>
                <h4>Risk Overview</h4>
                <p>
                    Menampilkan ringkasan risiko dari semua project, termasuk jumlah High,
                    Medium, dan Low risk.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-card-icon">📝</div>
                <h4>Activity Log</h4>
                <p>
                    Menampilkan riwayat aktivitas user pada seluruh project.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-card-icon">📄</div>
                <h4>Reports</h4>
                <p>
                    Menampilkan daftar laporan project dan preview laporan analisis risiko.
                </p>
            </div>

            <div class="guide-card">
                <div class="guide-card-icon">⚙️</div>
                <h4>Settings</h4>
                <p>
                    Menampilkan informasi akun dan pengaturan dasar pengguna.
                </p>
            </div>

        </div>

    </div>

    <div class="guide-section">

        <h3>Risk Level Explanation</h3>

        <div class="guide-risk-grid">

            <div class="guide-risk-card low">
                <span>Low Risk</span>
                <h4>Score 1 - 6</h4>
                <p>
                    Risiko rendah. Perlu dipantau secara rutin, tetapi tidak membutuhkan tindakan mendesak.
                </p>
            </div>

            <div class="guide-risk-card medium">
                <span>Medium Risk</span>
                <h4>Score 7 - 14</h4>
                <p>
                    Risiko sedang. Perlu diperhatikan dan direncanakan tindakan mitigasi.
                </p>
            </div>

            <div class="guide-risk-card high">
                <span>High Risk</span>
                <h4>Score 15 - 25</h4>
                <p>
                    Risiko tinggi. Perlu mendapatkan prioritas penanganan dan monitoring lebih intensif.
                </p>
            </div>

        </div>

    </div>

</div>

@endsection