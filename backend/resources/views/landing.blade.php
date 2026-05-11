<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBS System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        /* NAVBAR */

        .navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
        }

        .nav-buttons {
            display: flex;
            gap: 12px;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            border: 1px solid #cbd5e1;
            color: #334155;
            background: white;
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        /* HERO */

        .hero {
            padding: 90px 0;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 52px;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-text p {
            font-size: 18px;
            color: #64748b;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        /* PREVIEW */

        .preview-box {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .preview-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .project-node {
            background: #eff6ff;
            border: 2px solid #93c5fd;
            border-radius: 14px;
            padding: 16px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .risk-group {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-left: 25px;
        }

        .risk-item {
            background: #ffffff;
            border: 1px solid #dbe4f0;
            border-radius: 12px;
            padding: 12px 16px;
        }

        /* FEATURES */

        .features {
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            font-size: 36px;
            margin-bottom: 50px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .feature-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 5px 14px rgba(0,0,0,0.05);
        }

        .feature-card h3 {
            margin-bottom: 14px;
            font-size: 20px;
        }

        .feature-card p {
            color: #64748b;
            font-size: 15px;
        }

        /* HOW IT WORKS */

        .steps {
            padding: 80px 0;
            background: white;
        }

        .step-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 50px;
        }

        .step-card {
            text-align: center;
            padding: 30px;
        }

        .step-number {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 20px;
        }

        .step-card h3 {
            margin-bottom: 10px;
        }

        /* CTA */

        .cta {
            padding: 90px 0;
            text-align: center;
        }

        .cta h2 {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .cta p {
            color: #64748b;
            margin-bottom: 30px;
            font-size: 18px;
        }

        /* FOOTER */

        footer {
            background: #0f172a;
            color: white;
            text-align: center;
            padding: 24px;
            margin-top: 40px;
        }

        /* RESPONSIVE */

        @media (max-width: 992px) {

            .hero-content,
            .feature-grid,
            .step-grid {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 40px;
            }

            .section-title {
                font-size: 30px;
            }

            .cta h2 {
                font-size: 34px;
            }
        }

    </style>
</head>
<body>

    <!-- NAVBAR -->

    <div class="navbar">
        <div class="container navbar-content">

            <div class="logo">
                RBS System
            </div>

            <div class="nav-buttons">
                <a href="#" class="btn btn-secondary">
                    Login
                </a>

                <a href="#" class="btn btn-primary">
                    Register
                </a>
            </div>

        </div>
    </div>

    <!-- HERO -->

    <section class="hero">
        <div class="container hero-content">

            <div class="hero-text">

                <h1>
                    Build Risk Breakdown Structures Easily
                </h1>

                <p>
                    Create, visualize, and manage hierarchical risk structures
                    for project risk management efficiently and professionally.
                </p>

                <div class="hero-buttons">

                    <a href="/try" class="btn btn-primary">
                        Try Without Login
                    </a>

                    <a href="#" class="btn btn-secondary">
                        Learn More
                    </a>

                </div>

            </div>

            <!-- PREVIEW -->

            <div class="preview-box">

                <div class="preview-title">
                    RBS Diagram Preview
                </div>

                <div class="project-node">
                    Website Development Project
                </div>

                <div class="risk-group">

                    <div class="risk-item">
                        Technical Risks
                    </div>

                    <div class="risk-item">
                        Financial Risks
                    </div>

                    <div class="risk-item">
                        Schedule Risks
                    </div>

                    <div class="risk-item">
                        Operational Risks
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- FEATURES -->

    <section class="features">

        <div class="container">

            <h2 class="section-title">
                Main Features
            </h2>

            <div class="feature-grid">

                <div class="feature-card">
                    <h3>Create RBS</h3>

                    <p>
                        Build hierarchical risk structures for projects
                        using interactive diagrams.
                    </p>
                </div>

                <div class="feature-card">
                    <h3>Risk Matrix</h3>

                    <p>
                        Analyze risk levels using visual risk matrix
                        classification.
                    </p>
                </div>

                <div class="feature-card">
                    <h3>Export Report</h3>

                    <p>
                        Export project risk analysis into printable reports
                        and documentation.
                    </p>
                </div>

                <div class="feature-card">
                    <h3>Guest Mode</h3>

                    <p>
                        Try creating diagrams instantly without needing
                        to register first.
                    </p>
                </div>

            </div>

        </div>

    </section>

    <!-- HOW IT WORKS -->

    <section class="steps">

        <div class="container">

            <h2 class="section-title">
                How It Works
            </h2>

            <div class="step-grid">

                <div class="step-card">

                    <div class="step-number">
                        1
                    </div>

                    <h3>Create Project</h3>

                    <p>
                        Start by creating a project or trying the guest editor.
                    </p>

                </div>

                <div class="step-card">

                    <div class="step-number">
                        2
                    </div>

                    <h3>Build Risk Structure</h3>

                    <p>
                        Add categories and risks into a hierarchical structure.
                    </p>

                </div>

                <div class="step-card">

                    <div class="step-number">
                        3
                    </div>

                    <h3>Export Result</h3>

                    <p>
                        Export and share your completed risk analysis result.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->

    <section class="cta">

        <div class="container">

            <h2>
                Start Building Your RBS Today
            </h2>

            <p>
                Try the system instantly and create your first
                Risk Breakdown Structure diagram.
            </p>

            <a href="/projects/create" class="btn btn-primary">
                Try Now
            </a>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>
        © 2026 Risk Breakdown Structure System
    </footer>

</body>
</html>