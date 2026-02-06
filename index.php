<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Usaha Jahit</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --sidebar-bg: #4e73df;
            --sidebar-hover: #2e59d9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background: #f8f9fc;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, var(--sidebar-bg) 10%, #224abe 100%);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h3 {
            color: white;
            font-weight: 700;
            font-size: 1.3 rem;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85 rem;
            margin: 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75 rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 20px;
            letter-spacing: 1px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            background: var(--sidebar-hover);
            color: white;
            padding-left: 25px;
        }

        .menu-item.active {
            background: var(--sidebar-hover);
            color: white;
            border-left: 4px solid white;
        }

        .menu-item i {
            width: 30px;
            font-size: 1.1 rem;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 0;
        }

        /* Topbar */
        .topbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .topbar-left h4 {
            margin: 0;
            color: #5a5c69;
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: #5a5c69;
            font-size: 0.9rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #858796;
        }

        /* Content Container */
        .content-container {
            padding: 30px;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 15px 20px;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block !important;
            }
        }

        .menu-toggle {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Loading Spinner */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 50px;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>

<body>
    <?php
    // ambil page dari URL parameter, default ke dashboard
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

    // validasi page yang diizinkan
    $allowed_pages = ['dashboard', 'pelanggan', 'pesanan'];
    if (!in_array($page, $allowed_pages)) {
        $page = 'dashboard';
    }
    ?>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-cut" style="font-size: 2rem; color: white; margin-bottom: 10px"></i>
            <h3>Usaha Jahit</h3>
            <p>Management System</p>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section-title">Menu Utama</div>

            <a href="index.php?page=dashboard" class="menu-item <?php echo ($page == 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <div class="menu-section-title">Data Master</div>

            <a href="index.php?page=pelanggan" class="menu-item <?php echo ($page == 'pelanggan') ? 'active' : '' ?>">
                <i class="fas fa-users"></i>
                <span>Data Pelanggan</span>
            </a>

            <a href="index.php?page=pesanan" class="menu-item <?php echo ($page == 'pesanan') ? 'active' : '' ?>">
                <i class="fas fa-shopping-bag"></i>
                <span>Data Pesanan</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>
                    <?php
                    switch ($page) {
                        case 'dashboard':
                            echo '<i class="fas fa-tachometer-alt me-2"></i>Dashboard';
                            break;
                        case 'pelanggan':
                            echo '<i class="fas fa-users me-2"></i>Data Pelanggan';
                            break;
                        case 'pesanan':
                            echo '<i class="fas fa-shopping-bag me-2"></i>Data Pesanan';
                            break;
                        default:
                            echo '<i class="fas fa-tachometer-alt me-2"></i>Dashboard';
                    }
                    ?>
                </h4>
            </div>
            <div class="topbar-right">
                <div class="user-profile">
                    <div class="user-info">
                        <span class="user-name">Admin</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Container -->
        <div class="content-container">
            <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <div id="pageContent">
                <?php
                // include file sesuai page yang dipilih
                $file = $page . '.php';
                if (file_exists($file)) {
                    include($file);
                } else {
                    echo '<div class="alert alert-danger">Halaman tidak ditemukan!</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // toggle sidebar untuk mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // smooth scroll untuk navigasi
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                // loading animation bisa ditambahkan disini
            })
        })
    </script>
</body>

</html>