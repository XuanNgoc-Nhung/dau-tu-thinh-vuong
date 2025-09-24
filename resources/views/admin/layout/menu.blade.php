<aside class="cms-sidebar">
  <nav class="cms-nav nav flex-column">
    <a class="nav-link @yield('nav.dashboard_active')" href="{{ route('admin.index') }}" title="Bảng điều khiển" data-bs-toggle="tooltip" data-bs-placement="right">
      <i class="bi bi-grid"></i> <span class="label">Bảng điều khiển</span>
    </a>
    <a class="nav-link @yield('nav.users_active')" href="{{ route('admin.users') }}" title="Người dùng" data-bs-toggle="tooltip" data-bs-placement="right">
      <i class="bi bi-people"></i> <span class="label">Người dùng</span>
    </a>
    <a class="nav-link @yield('nav.transactions_active')" href="#" title="Giao dịch" data-bs-toggle="tooltip" data-bs-placement="right">
      <i class="bi bi-cash-coin"></i> <span class="label">Giao dịch</span>
    </a>
    <a class="nav-link @yield('nav.settings_active')" href="#" title="Cài đặt" data-bs-toggle="tooltip" data-bs-placement="right">
      <i class="bi bi-gear"></i> <span class="label">Cài đặt</span>
    </a>
    <div class="border-top border-light opacity-50 my-2"></div>
    <form method="post" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="nav-link bg-transparent border-0 w-100 d-flex align-items-center gap-2 logout-btn" title="Đăng xuất" data-bs-toggle="tooltip" data-bs-placement="right">
        <i class="bi bi-box-arrow-right"></i> <span class="label">Đăng xuất</span>
      </button>
    </form>
  </nav>
</aside>


