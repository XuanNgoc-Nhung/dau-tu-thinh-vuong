@extends('user.layouts.dashboard')

@section('content-dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Lịch sử nạp rút tiền
                    </h3>
                </div>
                <div class="card-body">
                    @if($napRutHistory->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Mã giao dịch</th>
                                        <th>Loại</th>
                                        <th>Số tiền</th>
                                        <th>Ngân hàng</th>
                                        <th>Số tài khoản</th>
                                        <th>Nội dung</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($napRutHistory as $item)
                                        <tr>
                                            <td>
                                                <span class="badge badge-secondary">#{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</span>
                                            </td>
                                            <td>
                                                @if($item->loai == 'nap')
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-arrow-down mr-1"></i>Nạp tiền
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-arrow-up mr-1"></i>Rút tiền
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-weight-bold text-primary">
                                                    {{ number_format($item->so_tien, 0, ',', '.') }} VND
                                                </span>
                                            </td>
                                            <td>{{ $item->ngan_hang }}</td>
                                            <td>
                                                <code>{{ $item->so_tai_khoan }}</code>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $item->noi_dung }}</span>
                                            </td>
                                            <td>
                                                @if($item->trang_thai == 0)
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock mr-1"></i>Chờ xử lý
                                                    </span>
                                                @elseif($item->trang_thai == 1)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check mr-1"></i>Thành công
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        <i class="fas fa-times mr-1"></i>Từ chối
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $item->created_at->format('d/m/Y H:i:s') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $napRutHistory->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Chưa có giao dịch nào</h5>
                            <p class="text-muted">Bạn chưa có lịch sử nạp rút tiền nào.</p>
                            <a href="{{ route('dashboard.nap-tien') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i>Nạp tiền ngay
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .badge-success {
        background-color: #28a745;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-danger {
        background-color: #dc3545;
    }
    
    .badge-secondary {
        background-color: #6c757d;
    }
    
    .table-responsive {
        border-radius: 0.375rem;
        overflow: hidden;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    code {
        background-color: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
    
    .text-primary {
        color: #0d6efd !important;
    }
    
    .font-weight-bold {
        font-weight: 600 !important;
    }
</style>
@endpush
