<!DOCTYPE html>
<html>
<head>
    <title>RBS System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <style>
        .body {
            margin: 0;
            font-family: Arial;
        }

        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
        }

        .container {
            display: flex;
        }

        .sidebar {
            width: 200px;
            background: #34495e;
            min-height: 100vh;
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
            padding: 20px;
        }

        .card {
            background: #f4f4f4;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .btn {
            padding: 8px 12px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .risk {
            padding: 3px 8px;
            border-radius: 6px;
            color: white;
            font-size: 13px;
        }

        /* HIGH */
        .risk.high {
            background-color: #e74c3c;
        }

        /* MEDIUM */
        .risk.medium {
            background-color: #f39c12;
        }

        /* LOW */
        .risk.low {
            background-color: #27ae60;
        }
        .category-title {
        cursor: pointer;
        user-select: none;
        padding: 6px 10px;
        background: #f8fafc;
        border-radius: 6px;
        margin: 4px 0;
        transition: 0.2s;
        }

        .category-title:hover {
            background: #e2e8f0;
        }

        .arrow {
            display: inline-block;
            transition: 0.2s;
        }

        .nested {
        display: none;
        margin-left: 20px;
        }

        .nested.active {
            display: block;
        }

        .rbs-node {
        display: inline-block;
        padding: 6px 12px;
        margin: 4px 0;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
        }

        .rbs-node:hover {
            background: #e0f2fe;
            transform: translateX(3px);
        }

        /* .rbs-tree {
            list-style: none;
            padding-left: 0;
        }
        
        .rbs-tree ul {
            list-style: none;
            padding-left: 20px;
        }

        .rbs-tree li {
            margin: 6px 0;
        } */

        /* ===== TREE DIAGRAM STYLE ===== */

.rbs-tree,
.rbs-tree ul {
    list-style: none;
    padding-left: 0;
    position: relative;
}

/* jarak antar level */
.rbs-tree ul {
    margin-left: 30px;
    padding-left: 20px;
}

/* tiap node */
.rbs-tree li {
    position: relative;
    margin: 10px 0;
}

/* garis vertikal */
.rbs-tree li::before {
    content: '';
    position: absolute;
    top: 0;
    left: -15px;
    width: 2px;
    height: 100%;
    background: #cbd5e1;
}

/* garis horizontal */
.rbs-tree li::after {
    content: '';
    position: absolute;
    top: 18px;
    left: -15px;
    width: 15px;
    height: 2px;
    background: #cbd5e1;
}

/* hilangkan garis di root */
.rbs-tree > li::before,
.rbs-tree > li::after {
    display: none;
}

/* node styling lebih "diagram" */
.rbs-node {
    display: inline-block;
    padding: 6px 12px;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.rbs-node:hover {
    background: #e0f2fe;
    transform: translateX(2px);
}

        .add-risk a {
            font-size: 13px;
        }

       .risk-matrix {
            display: grid;
            grid-template-columns: 80px repeat(5, 80px);
            gap: 6px;
            margin-top: 20px;
        }

        .header {
            font-weight: bold;
            text-align: center;
            padding: 8px;
        }

        .cell {
            height: 60px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .cell.low {
            background: #27ae60;
            color: white;
        }

        .cell.medium {
            background: #ffbc51;
            color: white;
        }

        .cell.high {
            background: #e74c3c;
            color: white;
        }

        .cell.extreme {
            background: #8e44ad;
            color: white;
        }

        /* contoh mapping (sesuaikan dengan service kamu) */
        .low { background: #27ae60; }
        .medium { background: #f39c12; }
        .high { background: #e74c3c; }
        .extreme { background: #8e44ad; }

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