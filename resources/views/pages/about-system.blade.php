@extends('layouts.app')

@section('content')

<div class="about-system-page">

    <div class="page-header">
        <div>
            <h2>About System</h2>
            <p>Informasi umum tentang sistem visualisasi Risk Breakdown Structure.</p>
        </div>

        <a href="{{ route('user-guide') }}" class="btn app-btn">
            View User Guide
        </a>
    </div>

    <div class="about-hero">

        <div>
            <span class="about-label">RBS Web Tool</span>
            <h3>Sistem Visualisasi Risk Breakdown Structure Berbasis Web</h3>
            <p>
                Sistem ini dirancang untuk membantu pengguna mengidentifikasi,
                mengelompokkan, menganalisis, dan memvisualisasikan risiko project
                menggunakan pendekatan Risk Breakdown Structure, Risk Matrix,
                dan rekomendasi mitigasi berbasis rule.
            </p>
        </div>

        <div class="about-hero-icon">
            🧩
        </div>

    </div>

    <div class="about-section-grid">

        <div class="about-card">
            <div class="about-card-icon">🎯</div>
            <h4>Tujuan Sistem</h4>
            <p>
                Membantu proses analisis risiko project secara lebih terstruktur
                melalui pemetaan kategori risiko, perhitungan tingkat risiko,
                dan penyajian visual dalam bentuk diagram RBS.
            </p>
        </div>

        <div class="about-card">
            <div class="about-card-icon">🌳</div>
            <h4>Risk Breakdown Structure</h4>
            <p>
                RBS digunakan untuk mengelompokkan risiko ke dalam struktur hierarkis
                sehingga pengguna dapat memahami sumber risiko berdasarkan kategori
                dan sub-kategori.
            </p>
        </div>

        <div class="about-card">
            <div class="about-card-icon">📊</div>
            <h4>Risk Matrix</h4>
            <p>
                Risk Matrix digunakan untuk menentukan tingkat risiko berdasarkan
                kombinasi nilai probability dan impact. Sistem menghitung risk score
                secara otomatis.
            </p>
        </div>

        <div class="about-card">
            <div class="about-card-icon">⚙️</div>
            <h4>Rule-Based Recommendation</h4>
            <p>
                Sistem memberikan rekomendasi mitigasi berdasarkan aturan sederhana
                yang menghubungkan tipe project dan level risiko.
            </p>
        </div>

    </div>

    <div class="about-section">

        <h3>Metode yang Digunakan</h3>

        <div class="method-timeline">

            <div class="method-item">
                <div class="method-number">1</div>
                <div>
                    <h4>Input Project</h4>
                    <p>
                        Pengguna membuat project dengan informasi dasar seperti nama,
                        deskripsi, tipe project, status, progress, dan estimasi anggaran.
                    </p>
                </div>
            </div>

            <div class="method-item">
                <div class="method-number">2</div>
                <div>
                    <h4>Penyusunan RBS</h4>
                    <p>
                        Sistem menampilkan struktur kategori risiko secara hierarkis.
                        Pengguna dapat menambah kategori, sub-kategori, dan risiko.
                    </p>
                </div>
            </div>

            <div class="method-item">
                <div class="method-number">3</div>
                <div>
                    <h4>Penilaian Risiko</h4>
                    <p>
                        Risiko dinilai menggunakan probability dan impact dengan skala 1 sampai 5.
                        Nilai risk score dihitung dari probability × impact.
                    </p>
                </div>
            </div>

            <div class="method-item">
                <div class="method-number">4</div>
                <div>
                    <h4>Klasifikasi Risk Level</h4>
                    <p>
                        Risk score diklasifikasikan menjadi Low, Medium, atau High
                        untuk membantu menentukan prioritas penanganan risiko.
                    </p>
                </div>
            </div>

            <div class="method-item">
                <div class="method-number">5</div>
                <div>
                    <h4>Rekomendasi Mitigasi</h4>
                    <p>
                        Sistem menampilkan rekomendasi mitigasi berdasarkan hasil
                        klasifikasi risiko dan tipe project.
                    </p>
                </div>
            </div>

        </div>

    </div>

    <div class="about-section">

        <h3>Fitur Utama</h3>

        <div class="feature-list-grid">

            <div class="feature-list-item">
                <span>01</span>
                <p>Register dan login pengguna</p>
            </div>

            <div class="feature-list-item">
                <span>02</span>
                <p>Manajemen project</p>
            </div>

            <div class="feature-list-item">
                <span>03</span>
                <p>Kategori risiko hierarkis</p>
            </div>

            <div class="feature-list-item">
                <span>04</span>
                <p>Input probability dan impact</p>
            </div>

            <div class="feature-list-item">
                <span>05</span>
                <p>Perhitungan risk score otomatis</p>
            </div>

            <div class="feature-list-item">
                <span>06</span>
                <p>Klasifikasi risk level</p>
            </div>

            <div class="feature-list-item">
                <span>07</span>
                <p>Risk matrix 5 × 5</p>
            </div>

            <div class="feature-list-item">
                <span>08</span>
                <p>Rekomendasi mitigasi berbasis rule</p>
            </div>

            <div class="feature-list-item">
                <span>09</span>
                <p>Activity log</p>
            </div>

            <div class="feature-list-item">
                <span>10</span>
                <p>Export diagram dan report</p>
            </div>

        </div>

    </div>

    <div class="about-section">

        <h3>Batasan Sistem</h3>

        <div class="limitation-box">
            <p>
                Sistem ini berfokus pada visualisasi Risk Breakdown Structure,
                penilaian risiko menggunakan Risk Matrix, serta pemberian rekomendasi
                mitigasi berbasis rule sederhana. Sistem belum mencakup manajemen project
                kompleks seperti penjadwalan detail, resource allocation, atau integrasi
                dengan sistem eksternal.
            </p>
        </div>

    </div>

</div>

@endsection