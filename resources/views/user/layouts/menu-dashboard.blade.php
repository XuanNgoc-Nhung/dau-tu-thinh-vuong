<!-- Sidebar Menu -->
<div class="sidebar-menu">
    <div class="menu-section">
        <h6 class="menu-title">Tài khoản</h6>
        <ul class="menu-list">
            <li class="{{ request()->routeIs('dashboard.profile') ? 'menu-item active' : '' }}"><a href="{{ route('dashboard.profile') }}" class="menu-item"><i class="bi bi-person me-2"></i>Hồ sơ cá nhân</a></li>
            <li class="{{ request()->routeIs('dashboard.bao-mat') ? 'menu-item active' : '' }}"><a href="{{ route('dashboard.bao-mat') }}" class="menu-item"><i class="bi bi-shield-check me-2"></i>Bảo mật</a></li>
            <li><a href="#" class="menu-item"><i class="bi bi-bell me-2"></i>Thông báo</a></li>
        </ul>
    </div>

    <div class="menu-section">
        <h6 class="menu-title">Tài chính</h6>
        <ul class="menu-list">
            <li><a href="#" class="menu-item"><i class="bi bi-wallet2 me-2"></i>Ví điện tử</a></li>
            <li class="{{ request()->routeIs('dashboard.ngan-hang') ? 'menu-item active' : '' }}"><a href="{{ route('dashboard.ngan-hang') }}" class="menu-item"><i class="bi bi-credit-card me-2"></i>Thẻ ngân hàng</a></li>
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
