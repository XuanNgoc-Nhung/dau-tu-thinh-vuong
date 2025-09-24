@extends('user.layouts.app')

@section('title', 'Dashboard - Web Đầu Tư')

@section('content')
<!-- Mobile Sidebar Toggle Button -->
<button class="mobile-sidebar-toggle d-md-none" onclick="toggleContentSidebar()">
    <i class="bi bi-list"></i>
</button>

<!-- Content Sidebar Overlay for Mobile -->
<div class="content-sidebar-overlay d-md-none" id="contentSidebarOverlay" onclick="closeContentSidebar()"></div>

<!-- Dashboard Container with Bootstrap Grid -->
<div class="container-fluid py-4 pt-2">
    <div class="row">
        <!-- Sidebar Menu - col-3 -->
        <div class="col-12 col-md-3 content-sidebar" id="contentSidebar">
            <div class="sidebar-menu">
                <div class="menu-section">
                    <h6 class="menu-title">Tài khoản</h6>
                    <ul class="menu-list">
                        <li><a href="{{ route('dashboard.profile') }}" class="menu-item"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-shield-check me-2"></i>Bảo mật</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-bell me-2"></i>Thông báo</a></li>
                    </ul>
                </div>

                <div class="menu-section">
                    <h6 class="menu-title">Tài chính</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-wallet2 me-2"></i>Ví điện tử</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-credit-card me-2"></i>Thẻ ngân hàng</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-arrow-repeat me-2"></i>Chuyển khoản</a></li>
                    </ul>
                </div>

                <div class="menu-section">
                    <h6 class="menu-title">Đầu tư</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-graph-up-arrow me-2"></i>Danh mục đầu tư</a>
                        </li>
                        <li><a href="#" class="menu-item"><i class="bi bi-pie-chart me-2"></i>Phân tích</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-trophy me-2"></i>Thành tích</a></li>
                    </ul>
                </div>

                <div class="menu-section">
                    <h6 class="menu-title">Tiết kiệm</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-piggy-bank me-2"></i>Mục tiêu tiết kiệm</a>
                        </li>
                        <li><a href="#" class="menu-item"><i class="bi bi-calendar-check me-2"></i>Kế hoạch</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-graph-up me-2"></i>Lãi suất</a></li>
                    </ul>
                </div>

                <div class="menu-section">
                    <h6 class="menu-title">Báo cáo</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-clock-history me-2"></i>Lịch sử giao dịch</a>
                        </li>
                        <li><a href="#" class="menu-item"><i class="bi bi-file-earmark-text me-2"></i>Báo cáo thuế</a>
                        </li>
                        <li><a href="#" class="menu-item"><i class="bi bi-download me-2"></i>Xuất dữ liệu</a></li>
                    </ul>
                </div>

                @if(auth()->user()->role == 1)
                <div class="menu-section">
                    <h6 class="menu-title">Quản trị</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-people me-2"></i>Quản lý người dùng</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-gear me-2"></i>Cài đặt hệ thống</a></li>
                        <li><a href="#" class="menu-item"><i class="bi bi-bar-chart me-2"></i>Thống kê</a></li>
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Main Content - col-9 -->
        <div class="col-12 col-md-9 main-content-area">
            @yield('content-dashboard')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Dashboard specific styles */
    .user-avatar-large {
        text-align: center;
    }

    .avatar-circle {
        width: 150px;
        height: 150px;
        border-radius: 15px;
        background: linear-gradient(135deg, var(--bs-primary), #20c997);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 3.5rem;
        color: white;
        font-weight: bold;
        box-shadow: 0 8px 25px rgba(22, 163, 74, 0.3);
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: none;
        transition: all 0.3s ease;
        height: 100%;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Stats Cards */
    .stat-card {
        background: linear-gradient(135deg, #fff, #f8f9fa);
        border-left: 4px solid var(--bs-primary);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--bs-primary);
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    /* Compact Cards */
    .compact-stat .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--bs-primary);
    }

    .compact-stat .stat-label {
        font-size: 0.8rem;
        margin-top: 0.25rem;
    }

    .compact-card .card-header {
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .compact-card .card-body {
        padding: 0.75rem 1rem;
    }

    /* Responsive adjustments for compact cards */
    @media (max-width: 575.98px) {
        .compact-stat .stat-number {
            font-size: 1.25rem;
        }
        
        .compact-stat .stat-label {
            font-size: 0.75rem;
        }
    }

    /* Welcome Section Styles */
    .user-avatar-large .avatar-circle {
        width: 120px;
        height: 160px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--bs-primary), #6f42c1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0 auto;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    @media (max-width: 767.98px) {
        .user-avatar-large .avatar-circle {
            width: 120px;
            height: 160px;
            max-width: 100%;
            font-size: 2rem;
        }
    }

    /* Mobile Sidebar Toggle Button */
    .mobile-sidebar-toggle {
        position: fixed;
        top: calc(56px + 12px); /* navbar height + 4px */
        left: 1rem;
        z-index: 1002;
        background: var(--bs-primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .mobile-sidebar-toggle:hover {
        background: #15803d;
        transform: scale(1.05);
    }

    /* Content Sidebar Styles */
    .content-sidebar {
        position: relative;
        transition: all 0.3s ease;
    }

    /* Content Sidebar Overlay */
    .content-sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1001;
        display: none;
    }

    .content-sidebar-overlay.show {
        display: block;
    }

    /* Mobile Responsive for Content Sidebar */
    @media (max-width: 767.98px) {
        .content-sidebar {
            position: fixed;
            top: calc(56px + 12px); /* navbar height + 4px */
            left: -100%;
            width: 280px;
            height: calc(100vh - 56px - 4px); /* full height minus navbar and gap */
            background: white;
            z-index: 1002;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: left 0.3s ease;
        }

        .content-sidebar.show {
            left: 0;
        }

        .main-content-area {
            width: 100%;
        }

        /* Adjust mobile toggle button position */
        .mobile-sidebar-toggle {
            top: calc(56px + 12px); /* navbar height + 4px */
            left: 1rem;
        }
    }

    @media (min-width: 768px) {
        .mobile-sidebar-toggle {
            display: none !important;
        }

        .content-sidebar-overlay {
            display: none !important;
        }
    }

</style>
@endpush

@push('scripts')
<script>
    // Content Sidebar Toggle Functions
    function toggleContentSidebar() {
        const sidebar = document.getElementById('contentSidebar');
        const overlay = document.getElementById('contentSidebarOverlay');

        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    function closeContentSidebar() {
        const sidebar = document.getElementById('contentSidebar');
        const overlay = document.getElementById('contentSidebarOverlay');

        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    }

    // Close content sidebar when clicking outside on mobile
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('contentSidebar');
        const toggleBtn = document.querySelector('.mobile-sidebar-toggle');

        if (window.innerWidth <= 767.98) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                closeContentSidebar();
            }
        }
    });

    // Handle window resize for content sidebar
    window.addEventListener('resize', function () {
        if (window.innerWidth > 767.98) {
            closeContentSidebar();
        }
    });

    // Close content sidebar when clicking on menu items on mobile
    document.addEventListener('DOMContentLoaded', function () {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function () {
                if (window.innerWidth <= 767.98) {
                    closeContentSidebar();
                }
            });
        });
    });

</script>
@endpush
