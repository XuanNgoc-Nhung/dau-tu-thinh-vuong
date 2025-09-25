@extends('user.layouts.dashboard')

@section('content-dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user mr-2"></i>
                        Thông tin hồ sơ cá nhân
                    </h3>
                </div>
                <div class="card-body">
                    @if($profile)
                        <div class="row">
                            <!-- Thông tin cơ bản -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Thông tin cơ bản
                                </h5>
                                
                                <p class="mb-2"><strong>Họ và tên:</strong> {{ $user->name }}</p>
                                <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
                                <p class="mb-2"><strong>Số điện thoại:</strong> {{ $user->phone ?? 'Chưa cập nhật' }}</p>
                                <p class="mb-2"><strong>Ngày sinh:</strong> {{ $profile->ngay_sinh ? $profile->ngay_sinh->format('d/m/Y') : 'Chưa cập nhật' }}</p>
                                <p class="mb-2"><strong>Giới tính:</strong> {{ $profile->gioi_tinh == 1 ? 'Nam' : ($profile->gioi_tinh == 2 ? 'Nữ' : 'Chưa cập nhật') }}</p>
                                <p class="mb-2"><strong>Địa chỉ:</strong> <span style="white-space: pre-line;">{{ $profile->dia_chi ?? 'Chưa cập nhật' }}</span></p>
                            </div>

                            <!-- Thông tin tài khoản ngân hàng -->
                            <div class="col-md-6">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-university mr-2"></i>
                                    Thông tin tài khoản ngân hàng
                                </h5>
                                
                                <p class="mb-2"><strong>Ngân hàng:</strong> {{ $profile->ngan_hang ?? 'Chưa cập nhật' }}</p>
                                <p class="mb-2"><strong>Số tài khoản:</strong> {{ $profile->so_tai_khoan ?? 'Chưa cập nhật' }}</p>
                                <p class="mb-2"><strong>Chủ tài khoản:</strong> {{ $profile->chu_tai_khoan ?? 'Chưa cập nhật' }}</p>
                                <p class="mb-2"><strong>Số dư:</strong> <span class="text-success font-weight-bold">{{ $profile->so_du ? number_format($profile->so_du, 0, ',', '.') . ' VNĐ' : '0 VNĐ' }}</span></p>
                                <p class="mb-2"><strong>Trạng thái tài khoản:</strong> {{ $user->status == 1 ? 'Hoạt động' : 'Tạm khóa' }}</p>
                            </div>
                        </div>

                        <!-- Thông tin giấy tờ tùy thân -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-warning mb-3">
                                    <i class="fas fa-id-card mr-2"></i>
                                    Giấy tờ tùy thân
                                </h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h6 class="mb-0">Ảnh mặt trước CCCD</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                @if($profile->anh_mat_truoc)
                                                    <img src="{{ asset('storage/' . $profile->anh_mat_truoc) }}" 
                                                         class="img-fluid" 
                                                         style="max-height: 200px; border: 1px solid #ddd; border-radius: 5px;"
                                                         alt="Ảnh mặt trước CCCD"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="display: none; height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Ảnh bị lỗi</p>
                                                    </div>
                                                @else
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Chưa tải lên</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h6 class="mb-0">Ảnh mặt sau CCCD</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                @if($profile->anh_mat_sau)
                                                    <img src="{{ asset('storage/' . $profile->anh_mat_sau) }}" 
                                                         class="img-fluid" 
                                                         style="max-height: 200px; border: 1px solid #ddd; border-radius: 5px;"
                                                         alt="Ảnh mặt sau CCCD"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="display: none; height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Ảnh bị lỗi</p>
                                                    </div>
                                                @else
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Chưa tải lên</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <h6 class="mb-0">Ảnh chân dung</h6>
                                            </div>
                                            <div class="card-body text-center">
                                                @if($profile->anh_chan_dung)
                                                    <img src="{{ asset('storage/' . $profile->anh_chan_dung) }}" 
                                                         class="img-fluid" 
                                                         style="max-height: 200px; border: 1px solid #ddd; border-radius: 5px;"
                                                         alt="Ảnh chân dung"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="display: none; height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Ảnh bị lỗi</p>
                                                    </div>
                                                @else
                                                    <div class="text-muted d-flex flex-column justify-content-center align-items-center" style="height: 200px; border: 1px solid #ddd; border-radius: 5px; background-color: #f8f9fa;">
                                                        <i class="fas fa-image fa-3x mb-2"></i>
                                                        <p>Chưa tải lên</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <h4>Chưa có thông tin hồ sơ</h4>
                            <p>Bạn chưa có thông tin hồ sơ cá nhân. Vui lòng cập nhật thông tin để sử dụng đầy đủ các tính năng.</p>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>
                                Tạo hồ sơ cá nhân
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
