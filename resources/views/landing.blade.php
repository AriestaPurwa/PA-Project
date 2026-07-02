{{-- file views\landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBS System — Risk Breakdown Structure</title>
    {{-- CHANGED: Font dan CSS baru, terpisah dari app.css --}}
    <link rel="stylesheet" href="{{ asset('css/landing-style.css') }}">
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar">
        <div class="container navbar-inner">

            <a href="/" class="nav-logo">
                <div class="nav-logo-icon">
                    {{-- Ikon shield --}}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                RBS System
            </a>

            {{-- CHANGED: Nav links tambahan --}}
            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="#guide">Risk Guide</a></li>
            </ul>

            <div class="nav-cta">
                <a href="/login" class="btn btn-secondary">Login</a>
                <a href="/register" class="btn btn-primary">Register</a>
            </div>

        </div>
    </nav>

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="container hero-inner">

            <div class="hero-text">
                {{-- CHANGED: Badge referensi standar --}}
                <div class="hero-badge">Based on PMBOK Risk Management</div>

                <h1 class="hero-title">
                    Build <span>Risk Breakdown</span> Structures Easily
                </h1>

                <p class="hero-desc">
                    Create, visualize, and manage hierarchical risk structures
                    for your projects. Identify, classify, and analyze risks
                    professionally using PMBOK-based methodology.
                </p>

                <div class="hero-actions">
                    <a href="/guest-mode" class="btn btn-primary btn-lg">Try Without Login</a>
                    <a href="#how-it-works" class="btn btn-secondary btn-lg">See How It Works</a>
                </div>

                {{-- CHANGED: Trust note --}}
                <p class="hero-note">No account required to try the editor</p>
            </div>

            {{-- CHANGED: Preview diagram mini --}}
            <div class="hero-visual">
                <div class="preview-card">
                    <div class="preview-float">
                        <span class="preview-float-dot"></span>
                        Live Preview
                    </div>

                    <div class="prev-root">Website Development Project</div>
                    <div class="prev-connector"></div>

                    <div class="prev-cols">
                        <div class="prev-col">
                            <div class="prev-category">📁 Technical</div>
                            <div class="prev-risks">
                                <div class="prev-risk l">Requirement</div>
                                <div class="prev-risk m">Technology</div>
                                <div class="prev-risk h">Complexity</div>
                            </div>
                        </div>
                        <div class="prev-col">
                            <div class="prev-category">📁 External</div>
                            <div class="prev-risks">
                                <div class="prev-risk l">Regulator</div>
                                <div class="prev-risk h">Customer</div>
                                <div class="prev-risk m">Market</div>
                            </div>
                        </div>
                        <div class="prev-col">
                            <div class="prev-category">📁 Org.</div>
                            <div class="prev-risks">
                                <div class="prev-risk m">Staffing</div>
                                <div class="prev-risk l">Decision</div>
                                <div class="prev-risk h">Funding</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ===== FEATURES ===== --}}
    <section class="section section-alt" id="features">
        <div class="container">

            <div class="section-head center">
                <span class="section-label">Features</span>
                <h2 class="section-title">Everything You Need for Risk Management</h2>
                <p class="section-desc">
                    A complete toolkit for building, analyzing, and exporting
                    risk breakdown structures for any project.
                </p>
            </div>

            <div class="features-grid">

                <div class="feature-card">
                    <div class="feature-icon">🗂️</div>
                    <h3>Create RBS</h3>
                    <p>Build hierarchical risk structures with unlimited categories and subcategories using an interactive diagram editor.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Risk Matrix</h3>
                    <p>Visualize risk distribution with a 5×5 probability-impact matrix. Auto-classify risks into High, Medium, and Low levels.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">📤</div>
                    <h3>Export Report</h3>
                    <p>Export your complete risk analysis as PNG, JPG, or PDF for presentations, documentation, and stakeholder reports.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">👤</div>
                    <h3>Guest Mode</h3>
                    <p>Try the full editor instantly without registering. Create and explore RBS diagrams without any commitment.</p>
                </div>

            </div>

        </div>
    </section>

    {{-- ===== HOW IT WORKS ===== --}}
    <section class="section" id="how-it-works">
        <div class="container">

            <div class="section-head center">
                <span class="section-label">How It Works</span>
                <h2 class="section-title">Three Steps to Your Risk Analysis</h2>
                <p class="section-desc">
                    From project creation to a complete risk breakdown structure — fast, structured, and professional.
                </p>
            </div>

            <div class="steps-grid">

                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Create a Project</h3>
                    <p>Start by creating a new project or jumping straight into the guest editor to explore without signing up.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Build Risk Structure</h3>
                    <p>Add risk categories, subcategories, and individual risks. Assign probability and impact values to each risk.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Analyze & Export</h3>
                    <p>Review your risk matrix, see automatic High/Medium/Low classification, then export your results as a report.</p>
                </div>

            </div>

        </div>
    </section>

    {{-- ===== RISK GUIDE ===== --}}
    {{-- CHANGED: Section baru — panduan probability & impact berdasarkan PMBOK --}}
    <section class="section section-alt" id="guide">
        <div class="container">

            <div class="section-head">
                <span class="section-label">Risk Guide</span>
                <h2 class="section-title">Probability & Impact Reference</h2>
                <p class="section-desc">
                    Scale values are based on <strong>PMBOK Guide (Project Management Body of Knowledge)</strong>
                    by PMI — the international standard for project risk management.
                    Use this as your reference when assigning values in the risk editor.
                </p>
            </div>

            <div class="guide-grid">

                {{-- Tabel Probability --}}
                <div class="guide-table-wrap">
                    <div class="guide-table-title">📈 Probability Scale (Likelihood)</div>
                    <table class="guide-table">
                        <thead>
                            <tr>
                                <th>Val</th>
                                <th>Level</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Very Low</td>
                                <td>Very unlikely to occur (&lt;10% chance)</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Low</td>
                                <td>Unlikely but possible (10–30%)</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Medium</td>
                                <td>May occur under some circumstances (30–50%)</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>High</td>
                                <td>Likely to occur in most circumstances (50–70%)</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Very High</td>
                                <td>Almost certain to occur (&gt;70%)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Tabel Impact --}}
                <div class="guide-table-wrap">
                    <div class="guide-table-title">💥 Impact Scale (Consequence)</div>
                    <table class="guide-table">
                        <thead>
                            <tr>
                                <th>Val</th>
                                <th>Level</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Very Low</td>
                                <td>Negligible effect on project objectives</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Low</td>
                                <td>Minor effect, easily manageable</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Medium</td>
                                <td>Moderate effect, requires management attention</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>High</td>
                                <td>Significant effect on cost, time, or scope</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Very High</td>
                                <td>Severe or catastrophic effect on project success</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Risk Score Matrix --}}
                <div class="score-matrix" style="grid-column: 1 / -1;">
                    <div class="score-matrix-title">🔢 Risk Score = Probability × Impact — Level Classification</div>
                    <div class="score-matrix-grid">

                        {{-- Header row --}}
                        <div class="sm-header"></div>
                        <div class="sm-header">P=1</div>
                        <div class="sm-header">P=2</div>
                        <div class="sm-header">P=3</div>
                        <div class="sm-header">P=4</div>
                        <div class="sm-header">P=5</div>

                        {{-- I=5 --}}
                        <div class="sm-row-label">I=5</div>
                        <div class="sm-cell m">5</div>
                        <div class="sm-cell m">10</div>
                        <div class="sm-cell h">15</div>
                        <div class="sm-cell h">20</div>
                        <div class="sm-cell h">25</div>

                        {{-- I=4 --}}
                        <div class="sm-row-label">I=4</div>
                        <div class="sm-cell l">4</div>
                        <div class="sm-cell m">8</div>
                        <div class="sm-cell m">12</div>
                        <div class="sm-cell h">16</div>
                        <div class="sm-cell h">20</div>

                        {{-- I=3 --}}
                        <div class="sm-row-label">I=3</div>
                        <div class="sm-cell l">3</div>
                        <div class="sm-cell l">6</div>
                        <div class="sm-cell m">9</div>
                        <div class="sm-cell m">12</div>
                        <div class="sm-cell h">15</div>

                        {{-- I=2 --}}
                        <div class="sm-row-label">I=2</div>
                        <div class="sm-cell l">2</div>
                        <div class="sm-cell l">4</div>
                        <div class="sm-cell l">6</div>
                        <div class="sm-cell m">8</div>
                        <div class="sm-cell m">10</div>

                        {{-- I=1 --}}
                        <div class="sm-row-label">I=1</div>
                        <div class="sm-cell l">1</div>
                        <div class="sm-cell l">2</div>
                        <div class="sm-cell l">3</div>
                        <div class="sm-cell l">4</div>
                        <div class="sm-cell m">5</div>

                    </div>
                    <div class="score-matrix-legend">
                        <span class="level-badge high">● High (score ≥ 15)</span>
                        <span class="level-badge medium">● Medium (score 8–14)</span>
                        <span class="level-badge low">● Low (score &lt; 8)</span>
                        <span class="ref">Source: PMBOK Guide, 6th ed. — PMI</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="cta-section">
        <div class="container cta-inner">
            <h2>Start Building Your RBS Today</h2>
            <p>Try the system instantly — no registration required.</p>
            <div class="cta-buttons">
                <a href="/guest-mode" class="btn btn-primary btn-lg">Try Without Login</a>
                <a href="/register" class="btn btn-secondary btn-lg">Create Free Account</a>
            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-inner">

                <div class="footer-brand">
                    <div class="nav-logo">
                        <div class="nav-logo-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        RBS System
                    </div>
                    <p>A web-based Risk Breakdown Structure tool for project risk management, based on PMBOK methodology.</p>
                </div>

                <div class="footer-col">
                    <h4>Features</h4>
                    <ul>
                        <li><a href="#features">Create RBS</a></li>
                        <li><a href="#features">Risk Matrix</a></li>
                        <li><a href="#features">Export Report</a></li>
                        <li><a href="#features">Guest Mode</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Account</h4>
                    <ul>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                        <li><a href="/guest-mode">Try as Guest</a></li>
                    </ul>
                </div>

            </div>

            <div class="footer-bottom">
                <span>© 2026 Risk Breakdown Structure System</span>
                <span>Based on PMBOK Guide — PMI</span>
            </div>
        </div>
    </footer>

</body>
</html>