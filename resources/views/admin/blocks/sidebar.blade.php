<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sidebar Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background-color: #2C3E50;
        color: white;
        padding: 20px;
        box-sizing: border-box;
        position: fixed; /* Cố định sidebar */
        top: 0;
        left: 0;
        bottom: 0;
        overflow-y: auto;
        transition: width 0.3s;
        z-index: 1000; /* Đảm bảo nằm trên content */
    }

    .sidebar.minimized {
        width: 80px;
    }

    .toggle-btn {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-admin {
        text-align: center;
        margin-bottom: 20px;
        transition: opacity 0.3s;
    }

    .sidebar.minimized .header-admin h4 {
        display: none;
    }

    .profile {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        transition: opacity 0.3s;
    }

    .profile img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .sidebar.minimized .profile-text {
        display: none;
    }

    .menu-title {
        font-weight: bold;
        font-size: 12px;
        letter-spacing: 1px;
        margin-top: 20px;
        margin-bottom: 10px;
        transition: opacity 0.3s;
    }

    ul.menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    ul.menu li {
        margin: 10px 0;
    }

    ul.menu a {
        text-decoration: none;
        color: white;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-radius: 4px;
        transition: background 0.3s;
    }

    ul.menu a:hover {
        background-color: #34495E;
    }

    ul.submenu {
        list-style: none;
        padding-left: 30px;
        margin-top: 5px;
        transition: max-height 0.3s ease;
        overflow: hidden;
        max-height: 0;
    }

    ul.submenu.open {
        max-height: 500px;
    }

    ul.submenu li {
        margin: 5px 0;
    }

    ul.submenu a {
        display: block;
        font-size: 14px;
    }

    .sidebar.minimized .menu-title,
    .sidebar.minimized a span {
        display: none;
    }

    .logout {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        color: white;
        padding: 10px 0;
        transition: background 0.3s;
    }

    .logout-btn:hover {
        background-color: #34495E;
    }

    .sidebar.minimized .logout-btn span {
        display: none;
    }

    /* Phần nội dung */
    .content {
        margin-left: 250px; /* Để tránh bị che bởi sidebar */
        padding: 20px;
        background-color: #f4f4f4; /* Nền sáng để che sidebar */
        min-height: 100vh;
        flex: 1;
    }

    /* Khi sidebar bị thu gọn */
    .sidebar.minimized + .content {
        margin-left: 80px; /* Khi sidebar bị thu nhỏ, phần nội dung sẽ rộng hơn */
    }
</style>

</head>
<body>

<div class="sidebar" id="sidebar">
    <!-- Toggle button -->
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i> 
    </button>

    <!-- Header Admin -->
    <div class="header-admin">
        <i class="fas fa-user-circle" style="font-size: 50px;"></i>
        <h4>Admin</h4>
    </div>

    <!-- Menu -->
    <p class="menu-title" style="font-size: 20px">TỔNG QUAN</p>
    <ul class="menu">
        <li>
            <a href="{{ route('dashboardpage') }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin-list-user') }}">
                <i class="fas fa-users"></i> <span>Quản lý người dùng</span>
            </a>
        </li>
        <!-- Quản lý Tours có submenu -->
        <li>
            <a href="javascript:void(0)" onclick="toggleSubmenu()">
                <i class="fas fa-map-marker-alt"></i> <span>Quản lý Tours</span>
            </a>
            <ul id="submenuTours" class="submenu">
                <li><a href="{{ route('admin-page-add-tour') }}">Thêm tour</a></li>
                <li><a href="{{ route('admin-list-tour') }}">Danh sách tour</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('admin-list-booking') }}">
                <i class="fas fa-file-alt"></i><span>Quản lý Booking</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin-list-promotion') }}">
                <i class="fas fa-gift"></i>
                <span>Quản lý khuyến mãi</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin-list-coupon') }}">
                <i class="fas fa-gift"></i>
                <span>Quản lý phiếu giảm giá</span>
            </a>
        </li>
       
    </ul>

    <!-- Nút Đăng xuất -->
    <div class="logout">
        <a href="{{ route('admin-logout') }}" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
        </a>
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('minimized');
    }

    function toggleSubmenu() {
        var submenu = document.getElementById('submenuTours');
        submenu.classList.toggle('open');
    }
</script>

</body>
</html>
