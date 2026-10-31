
<?php
// Tiêu đề của từng trang
$pageTitle = $pageTitle ?? 'Quản lý thư viện';

// Xác định menu đang được chọn
$activeMenu = $activeMenu ?? 'home';

// Hàm xử lý dữ liệu an toàn
if (!function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars(
            (string) ($value ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?> | Library Management System</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background-color: #f3f6fb;
            font-family: Arial, sans-serif;
            color: #263445;
        }

        /* Khung giao diện chính */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar bên trái */
        .sidebar {
            width: 260px;
            min-width: 260px;
            background-color: #193f6b;
            color: white;
            min-height: 100vh;
        }

        /* Logo */
        .sidebar-brand {
            padding: 30px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar-brand i {
            font-size: 42px;
        }

        .sidebar-brand h4 {
            font-weight: bold;
            margin-top: 12px;
        }

        /* Tiêu đề nhóm menu */
        .menu-heading {
            color: #b7cce4;
            font-size: 13px;
            font-weight: bold;
            padding: 25px 20px 10px;
        }

        /* Các liên kết menu */
        .sidebar .nav-link {
            color: #e4edf8;
            padding: 13px 16px;
            margin: 5px 12px;
            border-radius: 10px;
            font-size: 16px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.12);
            color: white;
        }

        /* Menu đang được chọn */
        .sidebar .nav-link.active {
            background-color: white;
            color: #1769d2;
        }

        /* Khu vực nội dung bên phải */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* Thanh tiêu đề phía trên */
        .topbar {
            height: 70px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #e5eaf0;
        }

        .topbar h5 {
            margin: 0;
            font-weight: bold;
        }

        /* Nội dung từng trang */
        .content {
            flex: 1;
            padding: 28px;
        }

        /* Footer */
        .footer {
            background-color: white;
            padding: 18px;
            text-align: center;
            color: #718096;
            border-top: 1px solid #e5eaf0;
        }

        /* Responsive cho màn hình nhỏ */
        @media (max-width: 768px) {

            .sidebar {
                width: 190px;
                min-width: 190px;
            }

            .content {
                padding: 15px;
            }

            .topbar {
                padding: 0 15px;
            }
        }

    </style>

</head>

<body>

<div class="main-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <!-- Logo thư viện -->
        <div class="sidebar-brand">

            <i class="bi bi-book-half"></i>

            <h4>LIBRARY</h4>

            <div>Management System</div>

        </div>

        <!-- Menu chính -->
        <div class="menu-heading">
            MENU CHÍNH
        </div>

        <nav class="nav flex-column">

            <a href="<?= e(DOMAIN) ?>?controller=home"
               class="nav-link <?= $activeMenu === 'home' ? 'active' : '' ?>">

                <i class="bi bi-grid"></i>
                Tổng quan

            </a>

            <a href="<?= e(DOMAIN) ?>?controller=book"
               class="nav-link <?= $activeMenu === 'book' ? 'active' : '' ?>">

                <i class="bi bi-book"></i>
                Quản lý sách

            </a>

            <a href="<?= e(DOMAIN) ?>?controller=category"
               class="nav-link <?= $activeMenu === 'category' ? 'active' : '' ?>">

                <i class="bi bi-tags"></i>
                Quản lý thể loại

            </a>

        </nav>

       
        

    </aside>

    <!-- KHU VỰC NỘI DUNG -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">

            <h5>
                <i class="bi bi-book-half text-primary me-2"></i>
                QUẢN LÝ SÁCH THƯ VIỆN
            </h5>

            <span class="text-secondary">
                Library Management System
            </span>

        </div>

        <!-- Phần nội dung riêng của từng trang -->
        <main class="content">
