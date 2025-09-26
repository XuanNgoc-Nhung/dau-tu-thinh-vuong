@extends('admin.layout.app')

@section('title', 'Quản lý đầu tư')
@section('nav.dau-tu_active', 'active')

@section('breadcrumb')
<span class="text-secondary">Admin</span> / <span class="text-dark">Quản lý đầu tư</span>
@endsection
@section('content')
<div class="mb-3">
	<div class="card border-0 shadow-sm">
		<div class="card-header bg-white">
			<strong class="text-success">Bộ lọc</strong>
		</div>
		<div class="card-body">
			<form method="GET" action="{{ route('admin.dau-tu') }}" class="row g-2 align-items-center" role="search">
				<div class="col-12 col-md-3 col-lg-2">
					<select name="trang_thai" class="form-select form-select-sm">
						<option value="">Tất cả trạng thái</option>
						<option value="0" {{ request('trang_thai') == '0' ? 'selected' : '' }}>Chờ xử lý</option>
						<option value="1" {{ request('trang_thai') == '1' ? 'selected' : '' }}>Đang hoạt động</option>
						<option value="2" {{ request('trang_thai') == '2' ? 'selected' : '' }}>Hoàn thành</option>
						<option value="3" {{ request('trang_thai') == '3' ? 'selected' : '' }}>Hủy bỏ</option>
					</select>
				</div>
				<div class="col-12 col-md-3 col-lg-2">
					<select name="san_pham_id" class="form-select form-select-sm">
						<option value="">Tất cả gói đầu tư</option>
						@foreach($sanPhamDauTu as $sanPham)
							<option value="{{ $sanPham->id }}" {{ request('san_pham_id') == $sanPham->id ? 'selected' : '' }}>
								{{ $sanPham->ten }}
							</option>
						@endforeach
					</select>
				</div>
				<div class="col-12 col-md-6 col-lg-4">
					<input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Tìm theo tên, email người dùng...">
				</div>
				<div class="col-12 col-md-auto d-flex gap-2">
					<button class="btn btn-sm btn-primary" type="submit">Tìm kiếm</button>
					@if(request('q') || request('trang_thai') || request('san_pham_id'))
						<a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.dau-tu') }}">Xoá lọc</a>
					@endif
				</div>
			</form>
		</div>
	</div>
</div>

<div class="card border-0 shadow-sm">
	<div class="card-header bg-white d-flex justify-content-between align-items-center">
		<strong class="text-success">Danh sách đầu tư</strong>
		<div class="d-flex align-items-center gap-2">
			<div class="text-muted small me-2">Tổng: {{ $dauTu->total() }}</div>
		</div>
	</div>
	<div class="card-body p-0">
		<style>
			.admin-dau-tu-table th,
			.admin-dau-tu-table td { min-width: 120px; }
			.admin-dau-tu-table th:nth-child(1),
			.admin-dau-tu-table td:nth-child(1) { min-width: 70px; text-align:center; }
			.admin-dau-tu-table .action-col { position: sticky; right: 0; background: #fff; z-index: 2; min-width: 180px; }
			.admin-dau-tu-table thead th.action-col { z-index: 3; }
			.admin-dau-tu-table td.action-col { box-shadow: -4px 0 4px -4px rgba(0,0,0,.15); }
		</style>
		<div class="table-responsive">
			<table class="table table-bordered table-striped align-middle mb-0 admin-dau-tu-table">
				<thead class="table-light">
					<tr>
						<th>STT</th>
						<th>Người dùng</th>
						<th>Gói đầu tư</th>
						<th>Số tiền đầu tư</th>
						<th>Số chu kỳ</th>
						<th>Hoa hồng</th>
						<th>Trạng thái</th>
						<th>Thời gian</th>
						<th class="action-col text-center">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($dauTu as $index => $dt)
					<tr>
						<td class="text-muted">{{ $dauTu->firstItem() + $index }}</td>
						<td>
							<div class="d-flex flex-column">
								<strong>{{ $dt->user->name ?? '—' }}</strong>
								<small class="text-muted">{{ $dt->user->email ?? '—' }}</small>
							</div>
						</td>
						<td>
							<div class="d-flex flex-column">
								<strong>{{ $dt->sanPham->ten ?? '—' }}</strong>
								<small class="text-muted">Lãi suất: {{ $dt->sanPham->lai_suat ?? 0 }}%</small>
							</div>
						</td>
						<td>
							<strong class="text-success">
								{{ number_format($dt->so_tien, 0, ',', '.') }} VNĐ
							</strong>
						</td>
						<td class="text-center">
							<span class="badge bg-info">{{ $dt->so_chu_ky }} chu kỳ</span>
						</td>
						<td>
							<strong class="text-warning">
								{{ number_format($dt->hoa_hong, 0, ',', '.') }} VNĐ
							</strong>
						</td>
						<td>
							@php
								$statusConfig = [
									0 => ['class' => 'text-bg-warning', 'text' => 'Chờ xử lý'],
									1 => ['class' => 'text-bg-success', 'text' => 'Đang hoạt động'],
									2 => ['class' => 'text-bg-primary', 'text' => 'Hoàn thành'],
									3 => ['class' => 'text-bg-danger', 'text' => 'Hủy bỏ']
								];
								$status = $statusConfig[$dt->trang_thai] ?? $statusConfig[0];
							@endphp
							<span class="badge {{ $status['class'] }}">{{ $status['text'] }}</span>
						</td>
						<td>
							<div class="d-flex flex-column">
								<small>{{ $dt->created_at->format('d/m/Y') }}</small>
								<small class="text-muted">{{ $dt->created_at->format('H:i:s') }}</small>
							</div>
						</td>
						<td class="action-col text-center">
							<div class="btn-group btn-group-sm" role="group">
								<button type="button" class="btn {{ $dt->trang_thai == 0 ? 'btn-outline-success' : 'btn-success' }}" 
									data-id="{{ $dt->id }}" 
									{{ $dt->trang_thai != 0 ? 'disabled' : '' }}
									title="{{ $dt->trang_thai == 1 ? 'Đang hoạt động' : 'Kích hoạt' }}"
									onclick="activateInvestment({{ $dt->id }}, this)">
									<i class="bi bi-play-fill"></i>
								</button>
								<button type="button" class="btn {{ $dt->trang_thai == 1 ? 'btn-outline-primary' : 'btn-primary' }}" 
									data-id="{{ $dt->id }}" 
									{{ $dt->trang_thai != 1 ? 'disabled' : '' }}
									title="{{ $dt->trang_thai == 2 ? 'Hoàn thành' : 'Hoàn thành' }}"
									onclick="completeInvestment({{ $dt->id }}, this)">
									<i class="bi bi-check-circle-fill"></i>
								</button>
								<button type="button" class="btn {{ $dt->trang_thai == 0 || $dt->trang_thai == 1 ? 'btn-outline-danger' : 'btn-danger' }}" 
									data-id="{{ $dt->id }}" 
									{{ $dt->trang_thai == 2 || $dt->trang_thai == 3 ? 'disabled' : '' }}
									title="{{ $dt->trang_thai == 3 ? 'Đã hủy' : 'Hủy bỏ' }}"
									onclick="cancelInvestment({{ $dt->id }}, this)">
									<i class="bi bi-x-circle-fill"></i>
								</button>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="9" class="text-center text-muted py-4">Chưa có đầu tư nào.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
	<div class="card-footer bg-white d-flex justify-content-between align-items-center">
		<div>
			{{ $dauTu->withQueryString()->links('vendor.pagination.admin') }}
		</div>
	</div>
</div>


<script>
// Activate investment function
function activateInvestment(id, button) {
	// Không xử lý nếu button bị disabled
	if(button.disabled) return;
	
	if (window.showConfirm) {
		window.showConfirm({
			title: 'Kích hoạt đầu tư',
			message: 'Bạn có chắc chắn muốn kích hoạt đầu tư này?',
			confirmText: 'Kích hoạt',
			onConfirm: function(){
				updateInvestmentStatus(id, 1);
			}
		});
	} else if (window.confirm('Bạn có chắc chắn muốn kích hoạt đầu tư này?')) {
		updateInvestmentStatus(id, 1);
	}
}

// Complete investment function
function completeInvestment(id, button) {
	// Không xử lý nếu button bị disabled
	if(button.disabled) return;
	
	if (window.showConfirm) {
		window.showConfirm({
			title: 'Hoàn thành đầu tư',
			message: 'Bạn có chắc chắn muốn hoàn thành đầu tư này?',
			confirmText: 'Hoàn thành',
			onConfirm: function(){
				updateInvestmentStatus(id, 2);
			}
		});
	} else if (window.confirm('Bạn có chắc chắn muốn hoàn thành đầu tư này?')) {
		updateInvestmentStatus(id, 2);
	}
}

// Cancel investment function
function cancelInvestment(id, button) {
	// Không xử lý nếu button bị disabled
	if(button.disabled) return;
	
	if (window.showConfirm) {
		window.showConfirm({
			title: 'Hủy bỏ đầu tư',
			message: 'Bạn có chắc chắn muốn hủy bỏ đầu tư này?',
			confirmText: 'Hủy bỏ',
			onConfirm: function(){
				updateInvestmentStatus(id, 3);
			}
		});
	} else if (window.confirm('Bạn có chắc chắn muốn hủy bỏ đầu tư này?')) {
		updateInvestmentStatus(id, 3);
	}
}

// Update investment status
async function updateInvestmentStatus(id, status) {
	try {
		var url = "{{ route('admin.dau-tu.update-status') }}";
		var res = await axios.post(url, { 
			id: id, 
			trang_thai: status 
		}, { 
			headers: { 'Content-Type': 'application/json' } 
		});
		
		var ok = !!(res && res.data && res.data.success);
		var msg = (res && res.data && res.data.message) || (ok ? 'Đã cập nhật trạng thái' : 'Cập nhật thất bại');
		
		if(window.showToast) {
			window.showToast(ok ? 'success' : 'error', ok ? 'Thành công' : 'Lỗi', msg);
		}
		
		if(ok) { 
			setTimeout(function(){ window.location.reload(); }, 800); 
		}
	} catch(err) {
		var msg = (err && err.response && err.response.data && err.response.data.message) || 'Có lỗi xảy ra. Vui lòng thử lại';
		if(window.showToast) window.showToast('error', 'Lỗi', msg);
	}
}
</script>
@endsection
