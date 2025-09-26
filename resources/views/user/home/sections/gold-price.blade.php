<!-- Giá vàng DOJI -->
@if($dataList && count($dataList) > 0)
<section id="gia-vang" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Thị trường</span>
            <h2 class="mt-2">Giá vàng hôm nay</h2>
            <p class="text-muted">Cập nhật giá vàng từ BTMC - {{ now()->format('d/m/Y H:i') }}</p>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshGiaVang()">
                <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
            </button>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover mb-0 w-100">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center fw-bold" style="width: 8%;">STT</th>
                                        <th class="text-center fw-bold" style="width: 25%;">Loại vàng</th>
                                        <th class="text-center fw-bold" style="width: 20%;">Mua vào (VNĐ)</th>
                                        <th class="text-center fw-bold" style="width: 20%;">Bán ra (VNĐ)</th>
                                        <th class="text-center fw-bold" style="width: 17%;">Ghi chú</th>
                                        <th class="text-center fw-bold" style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataList as $index => $item)
                                    <tr>
                                        <td class="text-center fw-semibold text-dark">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="text-left fw-semibold text-primary">
                                            {{ $item['@n_' . $item['@row']] ?? 'N/A' }}
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['@pb_' . $item['@row']]) && is_numeric($item['@pb_' .
                                            $item['@row']]))
                                            <span
                                                class="h6 text-success fw-bold">{{ number_format($item['@pb_' . $item['@row']], 0, ',', '.') }}</span>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['@ps_' . $item['@row']]) && is_numeric($item['@ps_' .
                                            $item['@row']]) && $item['@ps_' . $item['@row']] > 0)
                                            <span
                                                class="h6 text-danger fw-bold">{{ number_format($item['@ps_' . $item['@row']], 0, ',', '.') }}</span>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($item['@d_' . $item['@row']]))
                                            <small class="text-muted">{{ $item['@d_' . $item['@row']] }}</small>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-sm fw-semibold" onclick="buyGold()">
                                                <i class="bi bi-cart-plus me-1"></i>Mua
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

        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Dữ liệu được cập nhật từ <a href="http://api.btmc.vn" target="_blank"
                    class="text-decoration-none">BTMC</a>
            </small>
        </div>
    </div>
</section>
@endif


