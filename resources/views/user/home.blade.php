@extends('user.layouts.app')

@section('title', 'Web Đầu Tư - Landing Page')

@section('content')
    <!-- Top Banner (Background cover) -->
    <section class="banner-cover" style="background-image:url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1920&auto=format&fit=crop');">
        <div class="container py-5 py-lg-6 content">
            <div class="row">
                <div class="col-12 col-lg-8 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                    <span class="badge text-bg-primary rounded-pill mb-2">Khẩu hiệu</span>
                    <h2 class="fw-bold mb-2"><span id="typedSlogan" class="typing" style="font-size: 2.5rem;"></span></h2>
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
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner rounded-4 shadow">
                    <div class="carousel-item active" data-bs-interval="4500">
                        <img src="https://images.unsplash.com/photo-1501183638710-841dd1904471?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" style="max-height:460px;object-fit:cover" alt="Toà nhà hiện đại">
                        <div class="carousel-caption text-start bg-dark bg-opacity-50 rounded p-3">
                            <h5>Dự án A</h5>
                            <p>Tối ưu lợi nhuận bền vững</p>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="4500">
                        <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" style="max-height:460px;object-fit:cover" alt="Thành phố về đêm">
                        <div class="carousel-caption text-start bg-dark bg-opacity-50 rounded p-3">
                            <h5>Dự án B</h5>
                            <p>Đa dạng hoá danh mục đầu tư</p>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="4500">
                        <img src="https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?q=80&w=1600&auto=format&fit=crop" class="d-block w-100" style="max-height:460px;object-fit:cover" alt="Khu đô thị xanh">
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
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1451976426598-a7593bd6d0b2?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="Dự án 1">
                        <div class="card-body">
                            <span class="badge text-bg-info">Đang mở</span>
                            <h5 class="card-title mt-2">Quỹ Bất động sản Alpha</h5>
                            <p class="card-text text-muted">Lợi nhuận kỳ vọng 12-15%/năm, rủi ro thấp.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1462899006636-339e08d1844e?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="Dự án 2">
                        <div class="card-body">
                            <span class="badge text-bg-success">Hoàn thành</span>
                            <h5 class="card-title mt-2">Trái phiếu Doanh nghiệp Beta</h5>
                            <p class="card-text text-muted">Kỳ hạn 18 tháng, thanh khoản tốt.</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
                    <div class="card h-100 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1519683109079-d5f539e15488?q=80&w=1200&auto=format&fit=crop" class="card-img-top" alt="Dự án 3">
                        <div class="card-body">
                            <span class="badge text-bg-info">Đang mở</span>
                            <h5 class="card-title mt-2">Start-up Công nghệ Gamma</h5>
                            <p class="card-text text-muted">Gọi vốn vòng A, tiềm năng tăng trưởng mạnh.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                <div class="rounded-circle bg-secondary" style="width:40px;height:40px"></div>
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
                                <div class="rounded-circle bg-secondary" style="width:40px;height:40px"></div>
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
                                <div class="rounded-circle bg-secondary" style="width:40px;height:40px"></div>
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
                    <p class="text-muted mb-3">Chúng tôi kết nối nhà đầu tư với các cơ hội sinh lời an toàn, được thẩm định kỹ lưỡng, minh bạch thông tin và tối ưu trải nghiệm người dùng.</p>
                    <ul class="list-unstyled m-0">
                        <li class="d-flex align-items-start gap-3 mb-2"><span class="icon-circle"><i class="bi bi-shield-check"></i></span> Hơn 5 năm kinh nghiệm trong lĩnh vực đầu tư.</li>
                        <li class="d-flex align-items-start gap-3 mb-2"><span class="icon-circle"><i class="bi bi-people"></i></span> Đội ngũ chuyên gia tài chính giàu kinh nghiệm.</li>
                        <li class="d-flex align-items-start gap-3"><span class="icon-circle"><i class="bi bi-graph-up-arrow"></i></span> Quy trình thẩm định chặt chẽ – thông tin cập nhật liên tục.</li>
                    </ul>
                </div>
                <div class="col-12 col-lg-6 wow animate__animated animate__fadeInRight" data-wow-delay=".15s">
                    <img class="img-fluid rounded-4 shadow-sm" src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1600&auto=format&fit=crop" alt="Về chúng tôi">
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
                                <button class="accordion-button faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#a1" aria-expanded="true" aria-controls="a1">
                                    <i class="bi bi-question-circle"></i> Tôi cần những gì để đăng ký tài khoản?
                                </button>
                            </h2>
                                    <div id="a1" class="accordion-collapse collapse show" aria-labelledby="q1" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body ps-5 faq-answer">Bạn cần email, số điện thoại đang sử dụng và giấy tờ tùy thân để xác thực KYC.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="q2">
                                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#a2" aria-expanded="false" aria-controls="a2">
                                    <i class="bi bi-clock"></i> Thời gian xác thực KYC mất bao lâu?
                                </button>
                            </h2>
                                    <div id="a2" class="accordion-collapse collapse" aria-labelledby="q2" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body ps-5 faq-answer">Thông thường từ 5-15 phút trong giờ làm việc.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="q3">
                                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#a3" aria-expanded="false" aria-controls="a3">
                                    <i class="bi bi-cash-stack"></i> Số vốn tối thiểu để bắt đầu là bao nhiêu?
                                </button>
                            </h2>
                                    <div id="a3" class="accordion-collapse collapse" aria-labelledby="q3" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body ps-5 faq-answer">Bạn có thể bắt đầu với số vốn linh hoạt, từ 1.000.000 VNĐ.</div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="q4">
                                <button class="accordion-button collapsed faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#a4" aria-expanded="false" aria-controls="a4">
                                    <i class="bi bi-arrow-repeat"></i> Tôi có thể rút tiền khi nào?
                                </button>
                            </h2>
                                    <div id="a4" class="accordion-collapse collapse" aria-labelledby="q4" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body ps-5 faq-answer">Tùy vào điều khoản của từng dự án; thông tin rút tiền luôn được hiển thị rõ ràng.</div>
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
                                    <input type="text" class="form-control" id="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                                </div>
                                <div class="col-12">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="090x xxx xxx">
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Nội dung</label>
                                    <textarea class="form-control" id="message" rows="4" placeholder="Bạn quan tâm đến dự án nào?"></textarea>
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

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm.');
        this.reset();
    });
</script>
@endpush