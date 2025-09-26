@extends('user.layouts.app')

@section('title', 'Web Đầu Tư - Landing Page')

@section('content')
<!-- Top Banner (Background cover) -->
<section class="banner-cover"
    style="background-image:url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1920&auto=format&fit=crop');">
    <div class="container py-5 py-lg-6 content">
        <div class="row">
            <div class="col-12 col-lg-8 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                <span class="badge text-bg-primary rounded-pill mb-2">Khẩu hiệu</span>
                <h2 class="fw-bold mb-2"><span id="typedSlogan" class="typing responsive-slogan"></span></h2>
                <p class="mb-0">An toàn – Minh bạch – Hiệu quả</p>
            </div>
        </div>
    </div>
</section>

<!-- Hero / Slider -->
<section id="hero" class="py-4 bg-tint-slate">
    <div class="container">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner rounded-4 shadow">
                <div class="carousel-item active" data-bs-interval="4500">
                    <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1600&auto=format&fit=crop"
                        class="d-block w-100 carousel-image" alt="Toà nhà hiện đại">
                    <div class="carousel-caption text-start bg-dark bg-opacity-50 rounded p-3">
                        <h5>Dự án A</h5>
                        <p>Tối ưu lợi nhuận bền vững</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4500">
                    <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop"
                        class="d-block w-100 carousel-image" alt="Thành phố về đêm">
                    <div class="carousel-caption text-start bg-dark bg-opacity-50 rounded p-3">
                        <h5>Dự án B</h5>
                        <p>Đa dạng hoá danh mục đầu tư</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4500">
                    <img src="https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=1600&auto=format&fit=crop"
                        class="d-block w-100 carousel-image" alt="Khu đô thị xanh">
                    <div class="carousel-caption text-start bg-dark bg-opacity-50 rounded p-3">
                        <h5>Dự án C</h5>
                        <p>An toàn – Minh bạch – Hiệu quả</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Projects -->
<section id="du-an" class="py-5 bg-tint-green">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Danh mục</span>
            <h2 class="mt-2">Dự án tiêu biểu</h2>
            <p class="text-muted">Tổng hợp các dự án đang được quan tâm nhiều nhất.</p>
        </div>
        <div class="row g-3">
            @forelse($sanPhamDauTu as $index => $sanPham)
            <div class="col-6 col-md-6 col-lg-3 wow animate__animated animate__fadeInUp"
                data-wow-delay="{{ ($index + 1) * 0.1 }}s">
                <div class="card h-100 shadow-sm border-0 product-card">
                    <div class="position-relative">
                        @if($sanPham->hinh_anh)
                        <img src="{{ asset($sanPham->hinh_anh) }}" class="card-img-top product-image"
                            style="border-radius:24px" alt="{{ $sanPham->ten }}">
                        @else
                        <img src="https://images.unsplash.com/photo-1451976426598-a7593bd6d0b2?q=80&w=1200&auto=format&fit=crop"
                            class="card-img-top product-image" style="border-radius:6px" alt="{{ $sanPham->ten }}">
                        @endif
                        <div class="position-absolute top-0 end-0 m-2">
                            @if($sanPham->nhan_dan)
                            <span class="badge text-bg-info border border-white">{{ $sanPham->nhan_dan }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark">{{ $sanPham->ten }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($sanPham->mo_ta, 80) }}</p>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="border rounded-3 text-center bg-light">
                                    <small class="text-muted d-block mb-1 fw-bold" style="font-size: 0.6rem;">Vốn tối
                                        thiểu</small>
                                    <div class="text-primary fw-bold" style="font-size: 0.7rem;">
                                        {{ number_format($sanPham->von_toi_thieu, 0, ',', '.') }}$</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded-3 text-center bg-light">
                                    <small class="text-muted d-block mb-1 fw-bold" style="font-size: 0.6rem;">Vốn tối
                                        đa</small>
                                    <div class="text-danger fw-bold" style="font-size: 0.7rem;">
                                        {{ number_format($sanPham->von_toi_da, 0, ',', '.') }}$</div>
                                </div>
                            </div>
                        </div>

                        <!-- Thời gian và Lợi nhuận cùng hàng -->
                        <div class="row g-2 mb-3">
                            @if($sanPham->thoi_gian_mot_chu_ky)
                            <div class="col-6">
                                <div class="border rounded-3 text-center bg-light">
                                    <small class="text-muted d-block mb-1 fw-bold">Thời gian</small>
                                    <div class="fw-bold text-dark">
                                        {{ \App\Helpers\TimeHelper::formatTimeFromHours($sanPham->thoi_gian_mot_chu_ky) }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-6">
                                <div class="border rounded-3 text-center bg-light">
                                    <small class="text-muted d-block mb-1 fw-bold">Lợi nhuận</small>
                                    <div class="fw-bold text-success">{{ number_format($sanPham->lai_suat, 2) }}%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Thời gian mở bán một mình một hàng -->
                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <div class="border rounded-3 text-center bg-light">
                                    <small class="text-muted d-block mb-1 fw-bold">Mở bán</small>
                                    <div class="fw-bold text-info">
                                        {{ \Carbon\Carbon::parse($sanPham->created_at)->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Button đầu tư ngay -->
                        <div class="d-grid">
                            <button class="btn btn-primary btn-sm fw-semibold">
                                <i class="bi bi-cash-coin me-1"></i>Đầu tư ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Chưa có dự án nào</h4>
                    <p class="text-muted">Hiện tại chưa có dự án đầu tư nào được hiển thị.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

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

<!-- Testimonials -->
<section id="nhan-xet" class="py-5 bg-tint-sky">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Đánh giá</span>
            <h2 class="mt-2">Nhận xét của khách hàng</h2>
            <p class="text-muted">Sự hài lòng của bạn là ưu tiên hàng đầu của chúng tôi.</p>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Đội ngũ tư vấn chuyên nghiệp, giúp tôi xây dựng danh mục đầu tư hợp lý."</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary" style="width:40px;height:40px;border-radius:50%">
                            </div>
                            <div>
                                <div class="fw-semibold">Minh Anh</div>
                                <div class="text-muted small">Nhà đầu tư cá nhân</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Thông tin minh bạch, cập nhật liên tục. Tôi rất yên tâm khi hợp tác."</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary" style="width:40px;height:40px;border-radius:50%">
                            </div>
                            <div>
                                <div class="fw-semibold">Quốc Huy</div>
                                <div class="text-muted small">CEO, Công ty thương mại</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Tỷ suất sinh lời ổn định và dịch vụ hỗ trợ nhanh chóng."</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary" style="width:40px;height:40px;border-radius:50%">
                            </div>
                            <div>
                                <div class="fw-semibold">Thu Trang</div>
                                <div class="text-muted small">Chuyên viên tài chính</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Us -->
<section id="ve-chung-toi" class="py-5 bg-corners-brand">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-12 col-lg-6 wow animate__animated animate__fadeInLeft" data-wow-delay=".1s">
                <span class="text-primary fw-bold text-uppercase small">Về chúng tôi</span>
                <h2 class="mt-2">Nền tảng đầu tư minh bạch và hiệu quả</h2>
                <p class="text-muted mb-3">Chúng tôi kết nối nhà đầu tư với các cơ hội sinh lời an toàn, được thẩm định
                    kỹ lưỡng, minh bạch thông tin và tối ưu trải nghiệm người dùng.</p>
                <ul class="list-unstyled m-0">
                    <li class="d-flex align-items-start gap-3 mb-2"><span class="icon-circle"><i
                                class="bi bi-shield-check"></i></span> Hơn 5 năm kinh nghiệm trong lĩnh vực đầu tư.</li>
                    <li class="d-flex align-items-start gap-3 mb-2"><span class="icon-circle"><i
                                class="bi bi-people"></i></span> Đội ngũ chuyên gia tài chính giàu kinh nghiệm.</li>
                    <li class="d-flex align-items-start gap-3"><span class="icon-circle"><i
                                class="bi bi-graph-up-arrow"></i></span> Quy trình thẩm định chặt chẽ – thông tin cập
                        nhật liên tục.</li>
                </ul>
            </div>
            <div class="col-12 col-lg-6 wow animate__animated animate__fadeInRight" data-wow-delay=".15s">
                <img class="img-fluid rounded-4 shadow-sm"
                    src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop"
                    style="border-radius:20px" alt="Về chúng tôi">
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section id="loi-the" class="py-5 bg-tint-amber">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Lợi thế</span>
            <h2 class="mt-2">Vì sao chọn chúng tôi</h2>
            <p class="text-muted">6 lý do giúp bạn an tâm đầu tư cùng chúng tôi.</p>
        </div>
        <div class="row g-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-green h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-clipboard-data"></i></div>
                    <div class="fw-semibold mb-1">Minh bạch tuyệt đối</div>
                    <div class="text-muted">Báo cáo, tiến độ, dòng tiền được cập nhật rõ ràng.</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-teal h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-shield-lock"></i></div>
                    <div class="fw-semibold mb-1">An toàn đầu tư</div>
                    <div class="text-muted">Quy trình thẩm định đa tầng, kiểm soát rủi ro chặt chẽ.</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-amber h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="fw-semibold mb-1">Lợi nhuận ổn định</div>
                    <div class="text-muted">Danh mục đa dạng, tối ưu hóa lợi nhuận dài hạn.</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-sky h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-lightning-charge"></i></div>
                    <div class="fw-semibold mb-1">Thủ tục đơn giản</div>
                    <div class="text-muted">Đăng ký nhanh chóng, chỉ vài phút để bắt đầu.</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-rose h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-headset"></i></div>
                    <div class="fw-semibold mb-1">Hỗ trợ tận tâm</div>
                    <div class="text-muted">Chuyên gia đồng hành, giải đáp mọi thắc mắc 24/7.</div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="feature-card fc-indigo h-100 p-4 border rounded-4 shadow-sm text-center">
                    <div class="icon-circle mb-2"><i class="bi bi-cpu"></i></div>
                    <div class="fw-semibold mb-1">Công nghệ hiện đại</div>
                    <div class="text-muted">Theo dõi và quản lý danh mục thời gian thực.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Steps To Become Member -->
<section id="buoc-thanh-vien" class="py-5 bg-tint-slate">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Bắt đầu</span>
            <h2 class="mt-2">3 bước để trở thành thành viên</h2>
            <p class="text-muted">Làm theo từng bước đơn giản dưới đây.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <div class="stepper">
                    <div class="step mb-3">
                        <div class="d-flex align-items-start gap-3 p-3 p-md-4 border rounded-4 shadow-sm bg-white">
                            <span class="icon-circle step-index"><i class="bi bi-person-plus"></i></span>
                            <div>
                                <div class="fw-semibold">Bước 1: Đăng ký tài khoản</div>
                                <div class="text-muted">Điền thông tin cơ bản và xác minh email/số điện thoại.</div>
                            </div>
                        </div>
                    </div>
                    <div class="step mb-3">
                        <div class="d-flex align-items-start gap-3 p-3 p-md-4 border rounded-4 shadow-sm bg-white">
                            <span class="icon-circle step-index"><i class="bi bi-fingerprint"></i></span>
                            <div>
                                <div class="fw-semibold">Bước 2: Xác thực KYC</div>
                                <div class="text-muted">Tải giấy tờ cần thiết để xác thực danh tính của bạn.</div>
                            </div>
                        </div>
                    </div>
                    <div class="step">
                        <div class="d-flex align-items-start gap-3 p-3 p-md-4 border rounded-4 shadow-sm bg-white">
                            <span class="icon-circle step-index"><i class="bi bi-cash-coin"></i></span>
                            <div>
                                <div class="fw-semibold">Bước 3: Nạp tiền và đầu tư</div>
                                <div class="text-muted">Chọn dự án phù hợp và bắt đầu với số vốn linh hoạt.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Questions (FAQ) -->
<section id="faq" class="py-5 bg-tint-sky">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Hỏi đáp</span>
            <h2 class="mt-2">Câu hỏi nhanh khi đăng ký</h2>
            <p class="text-muted">Một số thắc mắc thường gặp của người dùng mới.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-lightbulb text-primary"></i>
                            <span class="fw-semibold">Câu hỏi nhanh</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="accordion accordion-flush" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q1">
                                    <button class="accordion-button faq-question" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true"
                                        aria-controls="a1">
                                        <i class="bi bi-question-circle"></i> Tôi cần những gì để đăng ký tài khoản?
                                    </button>
                                </h2>
                                <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body ps-5 faq-answer">Bạn cần email, số điện thoại đang sử
                                        dụng và giấy tờ tùy thân để xác thực KYC.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q2">
                                    <button class="accordion-button collapsed faq-question" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false"
                                        aria-controls="a2">
                                        <i class="bi bi-clock"></i> Thời gian xác thực KYC mất bao lâu?
                                    </button>
                                </h2>
                                <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body ps-5 faq-answer">Thông thường từ 5-15 phút trong giờ làm
                                        việc.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q3">
                                    <button class="accordion-button collapsed faq-question" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false"
                                        aria-controls="a3">
                                        <i class="bi bi-cash-stack"></i> Số vốn tối thiểu để bắt đầu là bao nhiêu?
                                    </button>
                                </h2>
                                <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body ps-5 faq-answer">Bạn có thể bắt đầu với số vốn linh hoạt,
                                        từ 1.000.000 VNĐ.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="q4">
                                    <button class="accordion-button collapsed faq-question" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#a4" aria-expanded="false"
                                        aria-controls="a4">
                                        <i class="bi bi-arrow-repeat"></i> Tôi có thể rút tiền khi nào?
                                    </button>
                                </h2>
                                <div id="a4" class="accordion-collapse collapse" aria-labelledby="q4"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body ps-5 faq-answer">Tùy vào điều khoản của từng dự án; thông
                                        tin rút tiền luôn được hiển thị rõ ràng.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="lien-he" class="py-5 bg-tint-green">
    <div class="container">
        <div class="text-center mb-4">
            <span class="text-primary fw-bold text-uppercase small">Liên hệ</span>
            <h2 class="mt-2">Nhận tư vấn miễn phí</h2>
            <p class="text-muted">Điền thông tin, chúng tôi sẽ liên hệ trong 24 giờ.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <form id="contactForm" class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" placeholder="Ví dụ: Nguyễn Văn A"
                                    required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="you@example.com"
                                    required>
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" placeholder="090x xxx xxx">
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Nội dung</label>
                                <textarea class="form-control" id="message" rows="4"
                                    placeholder="Bạn quan tâm đến dự án nào?"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .text-left {
        text-align: left !important;
    }

    .responsive-slogan {
        font-size: 2.5rem;
        line-height: 1.2;
        word-wrap: break-word;
        white-space: normal;
        max-width: 100%;
        overflow-wrap: break-word;
        word-break: break-word;
    }

    /* Product Card Styles */
    .product-card {
        border-radius: 16px !important;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef !important;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        border-color: #007bff !important;
    }

    .product-image {
        height: 180px;
        width: 100%;
        object-fit: cover;
        border-radius: 6px;
        transition: transform 0.3s ease;
        border: 12px solid #f8f9fa;
        box-sizing: border-box;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Badge positioning */
    .position-absolute .badge {
        font-size: 0.6rem;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Card body styling */
    .product-card .card-body {
        background: #fff;
        padding: 0.75rem !important;
    }

    /* Card title styling for smaller cards */
    .product-card .card-title {
        font-size: 0.9rem;
        line-height: 1.3;
        margin-bottom: 0.5rem !important;
    }

    /* Card text styling */
    .product-card .card-text {
        font-size: 0.75rem;
        line-height: 1.4;
        margin-bottom: 0.75rem !important;
    }

    /* Info boxes styling */
    .bg-light {
        background-color: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        transition: all 0.2s ease;
        padding: 0.5rem !important;
        min-height: 60px;
        /* Chiều cao tối thiểu cố định */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .bg-light:hover {
        background-color: #e9ecef !important;
        border-color: #007bff !important;
    }

    .bg-light small {
        font-size: 0.65rem;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }

    .bg-light .fw-bold,
    .bg-light .fw-semibold {
        font-size: 0.75rem;
        line-height: 1.2;
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }

    /* Mobile responsive - 2 sản phẩm/hàng */
    @media (max-width: 767.98px) {
        .responsive-slogan {
            font-size: 2rem;
            line-height: 1.3;
        }

        .product-image {
            height: 140px;
        }

        .product-card .card-body {
            padding: 0.6rem !important;
        }

        .product-card .card-title {
            font-size: 0.85rem;
        }

        .product-card .card-text {
            font-size: 0.72rem;
        }

        .bg-light {
            padding: 0.5rem !important;
            min-height: 55px;
            /* Chiều cao nhỏ hơn cho mobile */
        }

        .bg-light small {
            font-size: 0.65rem;
        }

        .bg-light .fw-bold,
        .bg-light .fw-semibold {
            font-size: 0.75rem;
        }

        .position-absolute .badge {
            font-size: 0.6rem;
            padding: 0.25rem 0.5rem;
        }
    }

    /* Tablet responsive - 2 sản phẩm/hàng */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .responsive-slogan {
            font-size: 2.2rem;
            line-height: 1.25;
        }

        .product-image {
            height: 160px;
        }

        .product-card .card-body {
            padding: 0.7rem !important;
        }

        .product-card .card-title {
            font-size: 0.9rem;
        }

        .product-card .card-text {
            font-size: 0.75rem;
        }

        .bg-light {
            min-height: 58px;
            /* Chiều cao cho tablet */
        }
    }

    /* Desktop responsive - 4 sản phẩm/hàng */
    @media (min-width: 992px) {
        .responsive-slogan {
            font-size: 2.5rem;
            line-height: 1.2;
        }

        .product-image {
            height: 180px;
        }

        .product-card .card-body {
            padding: 0.8rem !important;
        }

        .product-card .card-title {
            font-size: 1rem;
        }

        .product-card .card-text {
            font-size: 0.8rem;
        }

        .bg-light {
            min-height: 60px;
            /* Chiều cao cho desktop */
        }
    }

    /* Button đầu tư ngay styling */
    .product-card .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
    }

    .product-card .btn-primary:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    .product-card .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.2);
    }

    /* Mobile responsive cho button */
    @media (max-width: 767.98px) {
        .product-card .btn-primary {
            font-size: 0.75rem;
            padding: 0.4rem 0.6rem;
        }
    }

    /* Gold Price Table Styles */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        padding: 1rem 0.75rem;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table .h6 {
        font-size: 0.95rem;
        margin: 0;
        font-weight: 600;
    }

    /* Mobile responsive cho bảng */
    @media (max-width: 767.98px) {

        .table thead th,
        .table tbody td {
            padding: 0.5rem 0.25rem;
            font-size: 0.7rem;
        }

        .table .h6 {
            font-size: 0.75rem;
        }

        /* Điều chỉnh độ rộng cột cho mobile */
        .table thead th:nth-child(1),
        .table tbody td:nth-child(1) {
            width: 8%;
            min-width: 40px;
        }

        .table thead th:nth-child(2),
        .table tbody td:nth-child(2) {
            width: 25%;
            min-width: 80px;
        }

        .table thead th:nth-child(3),
        .table tbody td:nth-child(3) {
            width: 20%;
            min-width: 70px;
        }

        .table thead th:nth-child(4),
        .table tbody td:nth-child(4) {
            width: 20%;
            min-width: 70px;
        }

        .table thead th:nth-child(5),
        .table tbody td:nth-child(5) {
            width: 17%;
            min-width: 60px;
        }

        .table thead th:nth-child(6),
        .table tbody td:nth-child(6) {
            width: 10%;
            min-width: 50px;
        }

        /* Điều chỉnh nút Mua cho mobile */
        .table .btn-success {
            font-size: 0.65rem;
            padding: 0.25rem 0.4rem;
            white-space: nowrap;
        }

        .table .btn-success i {
            font-size: 0.6rem;
        }
    }

    /* Tablet responsive cho bảng */
    @media (min-width: 768px) and (max-width: 991.98px) {

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .table .h6 {
            font-size: 0.85rem;
        }

        .table .btn-success {
            font-size: 0.75rem;
            padding: 0.3rem 0.5rem;
        }
    }

    /* Carousel Image Styles - Đảm bảo tất cả hình ảnh có cùng kích thước */
    .carousel-image {
        height: 460px;
        width: 100%;
        object-fit: cover;
        object-position: center;
        border-radius: 16px;
    }

    /* Responsive cho carousel images */
    @media (max-width: 767.98px) {
        .carousel-image {
            height: 300px;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .carousel-image {
            height: 380px;
        }
    }

    @media (min-width: 992px) {
        .carousel-image {
            height: 460px;
        }
    }

</style>
@endpush

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm.');
        this.reset();
    });

    // Function xử lý khi click button "Đầu tư ngay"
    function investNow(productId) {
        // Kiểm tra xem user đã đăng nhập chưa
        @auth
        // Nếu đã đăng nhập, chuyển đến trang đầu tư
        window.location.href = '/dau-tu/' + productId;
        @else
        // Nếu chưa đăng nhập, chuyển đến trang đăng nhập
        window.location.href = '/login?redirect=/dau-tu/' + productId;
        @endauth
    }

    // Function làm mới dữ liệu giá vàng
    function refreshGiaVang() {
        const button = event.target;
        const originalText = button.innerHTML;

        // Hiển thị loading
        button.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i>Đang tải...';
        button.disabled = true;

        fetch('/refresh-gia-vang', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload trang để hiển thị dữ liệu mới
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra khi cập nhật dữ liệu');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật dữ liệu');
            })
            .finally(() => {
                // Khôi phục button
                button.innerHTML = originalText;
                button.disabled = false;
            });
    }

    // Function xử lý khi click nút "Mua" trong bảng giá vàng
    function buyGold(goldType, price) {
        // Kiểm tra xem user đã đăng nhập chưa
        @auth
        // Nếu đã đăng nhập, hiển thị thông báo xác nhận
        if (confirm('Bạn có muốn mua ' + goldType + ' với giá ' + price + ' VNĐ không?')) {
            // Ở đây có thể thêm logic xử lý mua vàng
            alert('Chức năng mua vàng đang được phát triển. Vui lòng liên hệ hotline để được hỗ trợ!');
        }
        @else
        // Nếu chưa đăng nhập, chuyển đến trang đăng nhập
        alert('Vui lòng đăng nhập để sử dụng chức năng mua vàng!');
        window.location.href = '/login';
        @endauth
    }

</script>
@endpush
