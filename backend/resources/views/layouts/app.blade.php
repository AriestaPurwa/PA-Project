<!DOCTYPE html>
<html>
<head>
    <title>RBS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f6f9;
    }

    .navbar {
        background-color: #2c3e50;
        color: white;
        padding: 15px 20px;
    }

    .container {
        display: flex;
        min-height: calc(100vh - 70px);
    }

    .sidebar {
        width: 200px;
        background: #34495e;
        color: white;
        padding: 20px;
    }

    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        margin: 10px 0;
    }

    .content {
        flex: 1;
        padding: 20px 30px;
        background: #f3f5f8;
        overflow-x: auto;
    }

    .card,
    /* CARD MATRIX */
    .app-card {
        background: #fff;
        padding: 18px 20px;
        margin-top: 20px;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }

    .btn,
    .app-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 0 16px;
        background: #4b9be6;
        color: #fff;
        text-decoration: none;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        font-size: 15px;
        font-weight: 500;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .icon-btn {
        width: 40px;
        height: 40px;
        min-width: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #cfd8e3;
        background: #fff;
        border-radius: 10px;
        cursor: pointer;
        box-sizing: border-box;
    }

    .btn:hover,
    .app-btn:hover {
        background: #3a8edc;
    }

    .inline-form {
        display: inline-flex;
        align-items: center;
    }

    .risk {
        display: inline-flex;
        align-items: center;
        min-height: 44px;
        min-width: 170px;
        max-width: 320px;
        padding: 0 16px;
        border-radius: 12px;
        color: #fff;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.2;
        box-sizing: border-box;
        white-space: normal;
        word-break: break-word;
        border: 1.5px solid rgba(0, 0, 0, 0.12);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
    }


    .risk.high {
        background-color: #e74c3c;
        border-color: #cf3f31;
    }

    .risk.medium {
        background-color: #f39c12;
        border-color: #d68910;
    }

    .risk.low {
        background-color: #27ae60;
        border-color: #219150;
    }


    .arrow {
        display: inline-block;
        width: 16px;
        text-align: center;
        flex: 0 0 16px;
    }

    .rbs-tree,
    .rbs-tree ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    /* ROOT CATEGORY */
    .rbs-tree {
        display: flex;
        flex-wrap: nowrap;   /* sebelumnya wrap, sekarang jangan turun */
        gap: 48px;
        align-items: flex-start;
        width: max-content;
        min-width: 100%;
        margin: 0;
        padding: 0;
    }

    /* setiap root category seperti satu kolom diagram */
.rbs-tree > .category-item {
    flex: 0 0 320px;     /* lebar tetap per kolom */
    min-width: 320px;
    max-width: 320px;
    margin: 0;
}

    /* CATEGORY BLOCK */
    .category-item {
        list-style: none;
    }

    .category-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .rbs-node {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-height: 46px;
        min-width: 220px;
        max-width: 320px;
        width: fit-content;
        padding: 10px 16px;
        background: #fff;
        border: 1px solid #cfd8e3;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.2s ease;
        font-size: 16px;
        font-weight: 500;
        box-sizing: border-box;
    }

    .rbs-node:hover {
        background: #eef6ff;
        border-color: #aac8ea;
    }


    /* CHILD WRAPPER */
    .nested {
        display: none;
        margin-top: 8px;
        margin-left: 20px;
        padding-left: 16px;
        border-left: 2px solid #dbe4f0;
    }

    .nested.active {
        display: block;
    }

    /* SUB CATEGORY VERTICAL */
    .subcategory-row {
        display: flex;
        flex-direction: column;
        gap: 18px;
        padding-left: 0;
        margin: 8px 0 14px 0;
    }

    .subcategory-row > .category-item {
        width: 100%;
        min-width: 0;
        max-width: 100%;
    }

    * RISK LIST */
    .risk-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        padding-left: 0;
        margin: 14px 0 18px 0;
    }

    .risk-item {
        list-style: none;
        display: grid;
        grid-template-columns: minmax(180px, auto) 44px;
        gap: 12px;
        align-items: center;
        width: fit-content;
        max-width: 100%;
        padding-bottom: 10px;
    }


    /* ACTION BUTTONS */
    .category-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-top: 8px;
    }

    .risk-matrix {
        display: grid;
        grid-template-columns: 80px repeat(5, 80px);
        gap: 6px;
        margin-top: 20px;
        align-items: center;
    }

    .header {
        font-weight: bold;
        text-align: center;
        padding: 8px;
    }

   .cell {
    min-height: 76px;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    font-weight: bold;
    color: white;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.cell-value {
    font-size: 24px;
    line-height: 1;
}

.cell-label {
    font-size: 12px;
    font-weight: 600;
    opacity: 0.95;
}

.cell.low {
    background: #27ae60;
}

.cell.medium {
    background: #ffbc51;
    color: #1f2937;
}

.cell.high {
    background: #e74c3c;
}

.cell.none {
    background: #cbd5e1;
    color: #1f2937;
}

    .form-page {
    max-width: 720px;
}

.form-card {
    background: #ffffff;
    border: 1px solid #d9e2ec;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
}

.form-title {
    margin: 0 0 20px 0;
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
}

.form-subtitle {
    margin: -8px 0 20px 0;
    color: #64748b;
    font-size: 14px;
}

.form-grid {
    display: grid;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    min-height: 44px;
    padding: 10px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    background: #fff;
    font-size: 14px;
    color: #0f172a;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-textarea {
    min-height: 110px;
    resize: vertical;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.18);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.form-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 8px;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    padding: 0 16px;
    background: #e2e8f0;
    color: #1e293b;
    text-decoration: none;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-weight: 500;
}

.btn-secondary:hover {
    background: #dbe3ec;
}

.field-hint {
    font-size: 12px;
    color: #64748b;
}

.alert-error {
    margin-bottom: 16px;
    padding: 12px 14px;
    border-radius: 10px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    font-size: 14px;
}

.alert-error ul {
    margin: 0;
    padding-left: 18px;
}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .form-card {
        padding: 18px;
    }

    /* area scroll horizontal untuk diagram */
.rbs-scroll-wrap {
    width: 100%;
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 12px;
    margin-top: 12px;
}

.rbs-board {
    min-width: max-content;
    padding-right: 24px;
}

/* jika nama panjang, biarkan turun rapi */
.rbs-node,
.risk {
    white-space: normal;
    word-break: break-word;
}

/* scrollbar horizontal lebih rapi */
.rbs-scroll-wrap::-webkit-scrollbar {
    height: 10px;
}

.rbs-scroll-wrap::-webkit-scrollbar-track {
    background: #e5e7eb;
    border-radius: 999px;
}

.rbs-scroll-wrap::-webkit-scrollbar-thumb {
    background: #94a3b8;
    border-radius: 999px;
}

.matrix-section {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.matrix-title {
    margin: 0 0 8px 0;
    font-size: 24px;
    font-weight: 700;
}

.matrix-description {
    margin: 0;
    max-width: 900px;
    color: #475569;
    line-height: 1.6;
    font-size: 14px;
}

.matrix-summary {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.summary-card {
    min-width: 120px;
    padding: 12px 16px;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #dbe4ee;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.summary-card.low {
    background: #ecfdf5;
    border-color: #86efac;
}

.summary-card.medium {
    background: #fffbeb;
    border-color: #fcd34d;
}

.summary-card.high {
    background: #fef2f2;
    border-color: #fca5a5;
}

.summary-label {
    font-size: 13px;
    color: #64748b;
}

.summary-value {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
}

.matrix-legend {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 14px;
}

.legend-title {
    font-weight: 600;
    color: #334155;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #334155;
}

.legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 999px;
    display: inline-block;
    border: 1px solid rgba(0, 0, 0, 0.12);
}

.legend-dot.low {
    background: #27ae60;
}

.legend-dot.medium {
    background: #ffbc51;
}

.legend-dot.high {
    background: #e74c3c;
}

.matrix-axis-top {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    text-align: center;
    margin-top: 4px;
}

.matrix-wrapper {
    display: flex;
    align-items: center;
    gap: 14px;
}

.matrix-axis-left {
    writing-mode: vertical-rl;
    transform: rotate(180deg);
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    min-width: 28px;
    text-align: center;
}

.risk-matrix {
    display: grid;
    grid-template-columns: 110px repeat(5, 110px);
    gap: 8px;
    margin-top: 0;
    align-items: stretch;
}

.header {
    font-weight: bold;
    text-align: center;
    padding: 8px 6px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 4px;
}

.header small {
    font-size: 11px;
    font-weight: 500;
    color: #64748b;
    line-height: 1.3;
}

.diagram-toolbar {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 16px;
}

#rbs-export-area {
    background: #ffffff;
    padding: 24px 28px;
    border-radius: 14px;
    display: inline-block;
    min-width: max-content;
}

.export-title {
    font-size: 24px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 22px;
}

.is-exporting [data-export-ignore] {
    display: none !important;
}

.is-exporting .rbs-scroll-wrap {
    overflow: visible !important;
}

.is-exporting #rbs-export-area {
    box-shadow: none !important;
}

.is-exporting .rbs-node,
.is-exporting .risk {
    box-shadow: none !important;
}

}
</style>
</head>
<body>

    <div class="navbar app-navbar">
        <h3>Risk Breakdown Structure System</h3>
    </div>

    <div class="container app-layout">
        
        <!-- Sidebar -->
        <div class="sidebar app-sidebar">
            <h4>Menu</h4>

            <!-- <a href="/projects"> Projects</a> -->
            <a href="{{ route('projects.index') }}"> Projects</a>
            <!-- <a href="/projects"> Add Risk</a> -->
        </div>

        <!-- Content -->
        <div class="content app-content">
            @yield('content')
        </div>

    </div>
    
    @stack('scripts')
    
</body>
</html>