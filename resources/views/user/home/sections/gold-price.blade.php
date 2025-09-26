<!-- Giá vàng DOJI -->
@if($dataList && count($dataList) > 0)
<section id="gia-vang" class="py-5 bg-light">
    <div class="container">
        <style>
            /* Sticky action column inside the horizontal scroller */
            #gia-vang .sticky-col { position: sticky; right: 0; z-index: 12; background: #fffaf0; box-shadow: -6px 0 6px -6px rgba(0,0,0,.15); }
            #gia-vang thead .sticky-col { z-index: 13; }
            #gia-vang .w-action { width: 1%; white-space: nowrap; }

            /* Sticky first two columns on the left */
            #gia-vang .sticky-col-left { position: sticky; left: 0; z-index: 12; background: #fffaf0; }
            #gia-vang .sticky-col-left-2 { position: sticky; left: 60px; z-index: 12; background: #fffaf0; box-shadow: 6px 0 6px -6px rgba(0,0,0,.15); }
            #gia-vang thead .sticky-col-left, #gia-vang thead .sticky-col-left-2 { z-index: 13; }
            #gia-vang .w-index { min-width: 60px; }
            #gia-vang .w-name { width: 1%; white-space: nowrap; }
            /* Ivory background for all table cells */
            #gia-vang table thead th,
            #gia-vang table tbody th,
            #gia-vang table tbody td { background-color: #fffaf0 !important; }

            /* Make table text thinner */
            #gia-vang table thead th,
            #gia-vang table tbody th,
            #gia-vang table tbody td { font-weight: 400 !important; }
            #gia-vang table .fw-bold,
            #gia-vang table .fw-semibold,
            #gia-vang table h6 { font-weight: 400 !important; }

            /* Borders for all table cells */
            #gia-vang table { border-collapse: separate; border-spacing: 0; }
            #gia-vang table thead th,
            #gia-vang table tbody th,
            #gia-vang table tbody td { border: 1px solid #dee2e6; }

            /* Ensure sticky columns show bordering edges clearly */
            #gia-vang .sticky-col-left,
            #gia-vang .sticky-col-left-2 { border-right: 1px solid #dee2e6; }
            #gia-vang .sticky-col { border-left: 1px solid #dee2e6; }
        </style>
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Thị trường</span>
            <h2 class="mt-2">Giá vàng hôm nay</h2>
            <p class="text-muted">Cập nhật nhật gần đây nhất - {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive" style="overflow-x:auto;-webkit-overflow-scrolling:touch">
                            <table class="table table-bordered mb-0 text-nowrap" style="min-width: 720px;">
                                <thead class="bg-transparent">
                                    <tr>
                                        <th class="text-center sticky-col-left w-index">#</th>
                                        <th class="text-center sticky-col-left-2 w-name">Loại vàng</th>
                                        <th class="text-center ">Mua hôm qua <br> ({{ now()->subDay()->format('d/m/Y') }})</th>
                                        <th class="text-center">Mua hôm nay <br> ({{ now()->format('d/m/Y') }})</th>
                                        <th class="text-center">Bán hôm qua <br> ({{ now()->subDay()->format('d/m/Y') }})</th>
                                        <th class="text-center">Bán hôm nay <br> ({{ now()->format('d/m/Y') }})</th>
                                        <th class="text-center sticky-col w-action">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataList as $index => $item)
                                    <tr>
                                        <td class="text-center fw-semibold text-dark sticky-col-left w-index">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="text-left fw-semibold text-primary sticky-col-left-2 w-name">
                                            {{ $item['name'] ?? 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['prices']['giaMuaHomQua']) && is_numeric($item['prices']['giaMuaHomQua']))
                                                <span class="fw-semibold">{{ number_format($item['prices']['giaMuaHomQua'], 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['prices']['giaMuaHomNay']) && is_numeric($item['prices']['giaMuaHomNay']))
                                                <span class="h6 text-success fw-bold">{{ number_format($item['prices']['giaMuaHomNay'], 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['prices']['giaBanHomQua']) && is_numeric($item['prices']['giaBanHomQua']))
                                                <span class="fw-semibold">{{ number_format($item['prices']['giaBanHomQua'], 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['prices']['giaBanHomNay']) && is_numeric($item['prices']['giaBanHomNay']))
                                                <span class="h6 text-danger fw-bold">{{ number_format($item['prices']['giaBanHomNay'], 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center sticky-col w-action">
                                            <button class="btn btn-success btn-sm fw-semibold" onclick="buyGold('{{ $item['name'] ?? 'N/A' }}', '{{ isset($item['prices']['giaMuaHomNay']) && is_numeric($item['prices']['giaMuaHomNay']) ? number_format($item['prices']['giaMuaHomNay'], 0, ',', '.') : '-' }}')">
                                                <i class="bi bi-cart-plus me-1"></i>Mua ngay
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-2 d-md-none text-muted small">
            <i class="bi bi-arrow-left-right me-1"></i> Vuốt ngang để xem đầy đủ bảng
        </div>

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Dữ liệu hôm qua được lưu theo ngày, có thể trống nếu mới lần đầu tải.
            </small>
        </div>
    </div>
</section>
@endif


