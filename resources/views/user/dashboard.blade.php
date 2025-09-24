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
<div class="container-fluid py-4">
    <div class="row">
        <!-- Sidebar Menu - col-3 -->
        <div class="col-12 col-md-3 content-sidebar" id="contentSidebar">
            <div class="sidebar-menu">
                <div class="menu-section">
                    <h6 class="menu-title">Tài khoản</h6>
                    <ul class="menu-list">
                        <li><a href="#" class="menu-item"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
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
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card dashboard-card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="mb-3">
                                        <i class="bi bi-emoji-smile me-2 text-primary"></i>Chào mừng
                                        {{ auth()->user()->name }}!
                                    </h2>
                                    <p class="text-muted mb-3">
                                        Bạn đã đăng nhập thành công vào hệ thống Web Đầu Tư.
                                        Hãy bắt đầu hành trình đầu tư thông minh của bạn ngay hôm nay.
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="#" class="btn btn-primary">
                                            <i class="bi bi-graph-up-arrow me-2"></i>Bắt đầu đầu tư
                                        </a>
                                        <a href="#" class="btn btn-outline-primary">
                                            <i class="bi bi-book me-2"></i>Tìm hiểu thêm
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="user-avatar-large">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="mt-3">
                                            <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                                            <span class="badge bg-primary">
                                                @if(auth()->user()->role == 1)
                                                Quản trị viên
                                                @else
                                                Thành viên
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Stats Cards -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card dashboard-card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Tổng đầu tư</div>
                            <small class="text-muted">VND</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card dashboard-card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Lợi nhuận</div>
                            <small class="text-muted">VND</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card dashboard-card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Tiết kiệm</div>
                            <small class="text-muted">VND</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card dashboard-card stat-card">
                        <div class="card-body text-center">
                            <div class="stat-number">0</div>
                            <div class="stat-label">Tổng tài sản</div>
                            <small class="text-muted">VND</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Activities -->
                <div class="col-lg-8 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-clock-history me-2"></i>Hoạt động gần đây
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-3">Chưa có hoạt động nào</p>
                                <a href="#" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Bắt đầu đầu tư
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="col-lg-4 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-lightning me-2"></i>Thao tác nhanh
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="bi bi-graph-up-arrow me-2"></i>Đầu tư mới
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="bi bi-piggy-bank me-2"></i>Tiết kiệm
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <i class="bi bi-wallet2 me-2"></i>Nạp tiền
                                </a>
                                <a href="#" class="btn btn-outline-warning">
                                    <i class="bi bi-arrow-up-circle me-2"></i>Rút tiền
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Investment Portfolio -->
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-pie-chart me-2"></i>Danh mục đầu tư
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-pie-chart display-4 text-muted"></i>
                                <p class="text-muted mt-3">Chưa có danh mục đầu tư</p>
                                <a href="#" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Tạo danh mục
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Savings Goals -->
                <div class="col-lg-6 mb-4">
                    <div class="card dashboard-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-bullseye me-2"></i>Mục tiêu tiết kiệm
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="bi bi-bullseye display-4 text-muted"></i>
                                <p class="text-muted mt-3">Chưa có mục tiêu tiết kiệm</p>
                                <a href="#" class="btn btn-success">
                                    <i class="bi bi-plus-circle me-2"></i>Đặt mục tiêu
                                </a>
                            </div>
                        </div>
                    </div>
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
                width: 120px;
                height: 120px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--bs-primary), #20c997);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                font-size: 3rem;
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

            /* Mobile Sidebar Toggle Button */
            .mobile-sidebar-toggle {
                position: fixed;
                top: 100px;
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
                    top: 0;
                    left: -100%;
                    width: 280px;
                    height: 100vh;
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
                    padding-left: 0;
                }

                /* Adjust mobile toggle button position */
                .mobile-sidebar-toggle {
                    top: 4rem;
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
