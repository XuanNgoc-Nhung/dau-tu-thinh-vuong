@extends('user.layouts.dashboard')

@section('content-dashboard')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-wallet mr-2"></i>
                        Nạp tiền
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <form id="depositForm" autocomplete="off">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold">Chọn ngân hàng <span class="text-danger">*</span></label>
                                    <div id="bank_logo_grid" class="bank-grid">
                                        @foreach(($banks ?? []) as $bank)
                                            <div class="bank-logo-item" 
                                                 data-bank-id="{{ $bank->id }}"
                                                 data-ten="{{ $bank->ten_ngan_hang }}"
                                                 data-stk="{{ $bank->so_tai_khoan }}"
                                                 data-chu="{{ $bank->chu_tai_khoan }}"
                                                 data-cn="{{ $bank->chi_nhanh }}"
                                                 data-img="{{ $bank->hinh_anh }}">
                                                <img src="{{ $bank->hinh_anh ? (str_starts_with($bank->hinh_anh, 'http') ? $bank->hinh_anh : '/storage/' . ltrim($bank->hinh_anh, '/')) : '/images/default-bank.png' }}" 
                                                     alt="{{ $bank->ten_ngan_hang }}" 
                                                     class="bank-logo-img">
                                                <span class="bank-name">{{ $bank->ten_ngan_hang }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="bank_info" class="border rounded p-3 mb-3 is-disabled">
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <img id="bank_logo" src="" alt="bank" style="height:52px;width:auto;" class="d-none">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Tên ngân hàng</label>
                                                <input type="text" id="bank_name_input" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Số tài khoản</label>
                                                <div class="input-group">
                                                    <input type="text" id="bank_account" class="form-control" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button" id="copy_stk">Sao chép</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Chủ tài khoản</label>
                                                <input type="text" id="bank_holder" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Chi nhánh</label>
                                                <input type="text" id="bank_branch" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Số tiền muốn nạp (VND) <span class="text-danger">*</span></label>
                                                <input type="text" id="amount" class="form-control" placeholder="Nhập số tiền" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold mb-1">Nội dung chuyển khoản <span class="text-danger">*</span></label>
                                                <input type="text" id="transfer_content" class="form-control" placeholder="Nội dung chuyển khoản" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Quick amount selection -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="amount-buttons">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="100000">100K</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="200000">200K</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="500000">500K</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="1000000">1M</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="2000000">2M</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="5000000">5M</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="10000000">10M</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="15000000">15M</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm amount-btn" data-amount="20000000">20M</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Submit button centered in the form -->
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="button" id="submitBtn" class="btn btn-primary" disabled>
                                            <i class="fas fa-paper-plane mr-1"></i> Tạo yêu cầu nạp
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-4">
                            <!-- QR Code Section -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-qrcode mr-2"></i>
                                        QR Chuyển khoản
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <div id="qr-placeholder" class="qr-placeholder">
                                        <i class="fas fa-qrcode fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Chọn ngân hàng để hiển thị QR</p>
                                    </div>
                                    <div id="qr-loading" class="qr-loading d-none">
                                        <div class="spinner-border text-primary mb-3" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p class="text-muted mb-0">Đang tạo QR code...</p>
                                    </div>
                                    <div id="qr-code-container" class="d-none">
                                        <div id="qr-code" class="mb-3"></div>
                                        <p class="text-muted small mb-0">Quét mã QR để chuyển khoản nhanh</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Lưu ý section moved to bottom -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6 class="mb-2"><i class="fas fa-info-circle mr-1"></i> Lưu ý</h6>
                                <ul class="mb-0 pl-3">
                                    <li>Chọn đúng ngân hàng và chuyển khoản theo thông tin hiển thị.</li>
                                    <li>Nội dung chuyển khoản ghi rõ: Nap tien + số điện thoại.</li>
                                    <li>Sau khi chuyển, hệ thống sẽ kiểm tra và cộng tiền vào ví.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .input-group-text { min-width: 70px; justify-content: center; }
    .d-none { display: none !important; }
    .mr-2 { margin-right: .5rem; }
    .mb-1 { margin-bottom: .25rem; }
    .pl-3 { padding-left: 1rem; }
    .border { border: 1px solid #dee2e6; }
    .rounded { border-radius: .25rem; }
    .p-3 { padding: 1rem; }
    .alert-info { color: #055160; background-color: #cff4fc; border-color: #b6effb; }
    .input-group-append .btn { border-top-left-radius: 0; border-bottom-left-radius: 0; }
    .input-group .form-control[readonly] { background-color: #e9ecef; }
    .form-control.is-invalid { border-color: #dc3545; }
    /* Enhance input borders for clearer visuals */
    .form-control { border: 1.5px solid #b6b9be; }
    .form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 .2rem rgba(13,110,253,.15); }
    .form-control:disabled,
    .form-control[readonly] { border-color: #bfc5ca; color: #000; }
    .input-group-text { border: 1.5px solid #b6b9be; }
    /* Ensure input-group elements have consistent strong borders */
    .input-group .form-control { border-width: 1.5px; }
    .input-group-append .btn { border-width: 1.5px; }
    /* Bank logo border */
    #bank_logo { border: 1.5px solid #b6b9be; border-radius: .375rem; background-color: #fff; padding: .25rem; }
    
    /* Bank logo grid styles */
    .bank-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); 
        gap: 1rem; 
        margin-top: .5rem; 
    }
    .bank-logo-item { 
        display: flex; 
        flex-direction: column; 
        align-items: center; 
        padding: 1rem; 
        border: 2px solid #e9ecef; 
        border-radius: .5rem; 
        cursor: pointer; 
        transition: all 0.2s ease; 
        background: #fff;
    }
    .bank-logo-item:hover { 
        border-color: #0d6efd; 
        box-shadow: 0 2px 8px rgba(13,110,253,0.15); 
        transform: translateY(-2px); 
    }
    .bank-logo-item.selected { 
        border-color: #0d6efd; 
        background-color: #f8f9ff; 
        box-shadow: 0 2px 8px rgba(13,110,253,0.2); 
    }
    .bank-logo-img { 
        height: 48px; 
        width: auto; 
        max-width: 100px; 
        object-fit: contain; 
        margin-bottom: .5rem; 
        border-radius: .25rem;
    }
    .bank-name { 
        font-size: .8rem; 
        font-weight: 500; 
        text-align: center; 
        color: #495057; 
        line-height: 1.2;
    }
    .is-disabled { opacity: .6; pointer-events: none; }
    
    /* QR Code Section Styles */
    .qr-placeholder {
        padding: 2rem 1rem;
        border: 2px dashed #dee2e6;
        border-radius: .5rem;
        background-color: #f8f9fa;
    }
    .qr-placeholder i {
        color: #6c757d;
    }
    .qr-loading {
        padding: 2rem 1rem;
        border: 2px solid #0d6efd;
        border-radius: .5rem;
        background-color: #f8f9ff;
    }
    .qr-loading .spinner-border {
        width: 3rem;
        height: 3rem;
    }
    #qr-code {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
    #qr-code img {
        max-width: 100%;
        height: auto;
        border-radius: .5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .col-lg-4 {
            margin-top: 1.5rem;
        }
    }
    
    /* Bank info form adjustments */
    #bank_info .form-group {
        margin-bottom: 1rem;
    }
    #bank_info small.text-muted {
        font-size: 0.75rem;
        line-height: 1.2;
    }
    
    /* Action buttons styling */
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
    }
    
    /* Amount buttons styling */
    .amount-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
    }
    .amount-btn {
        font-size: 0.8rem;
        padding: 0.375rem 0.75rem;
        min-width: 60px;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    .amount-btn:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(13,110,253,0.3);
    }
    .amount-btn.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
        box-shadow: 0 2px 4px rgba(13,110,253,0.3);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bankGrid = document.getElementById('bank_logo_grid');
    const bankInfo = document.getElementById('bank_info');
    const bankLogo = document.getElementById('bank_logo');
    const bankNameInput = document.getElementById('bank_name_input');
    const bankAccount = document.getElementById('bank_account');
    const bankHolder = document.getElementById('bank_holder');
    const bankBranch = document.getElementById('bank_branch');
    const copyStkBtn = document.getElementById('copy_stk');
    const amountInput = document.getElementById('amount');
    const submitBtn = document.getElementById('submitBtn');
    const qrPlaceholder = document.getElementById('qr-placeholder');
    const qrLoading = document.getElementById('qr-loading');
    const qrCodeContainer = document.getElementById('qr-code-container');
    const qrCode = document.getElementById('qr-code');
    const transferContent = document.getElementById('transfer_content');
    
    let selectedBankId = null;

    function formatCurrency(value) {
        const digits = value.replace(/[^0-9]/g, '');
        if (!digits) return '';
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function generateRandomContent() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 12; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    function setFormEnabled(enabled) {
        // Toggle disabled state for interactive elements
        submitBtn.disabled = !enabled;
        copyStkBtn.disabled = !enabled;
        bankNameInput.disabled = !enabled;
        bankAccount.disabled = !enabled;
        bankHolder.disabled = !enabled;
        bankBranch.disabled = !enabled;
        // Visual cue
        bankInfo.classList.toggle('is-disabled', !enabled);
    }

    function hideQRCode() {
        // Hide QR code and loading, show placeholder
        qrPlaceholder.classList.remove('d-none');
        qrLoading.classList.add('d-none');
        qrCodeContainer.classList.add('d-none');
    }

    // Initialize state: visible but disabled until a bank is selected
    setFormEnabled(false);
    bankLogo.classList.add('d-none');
    bankNameInput.value = '';
    bankAccount.value = '';
    bankHolder.value = '';
    bankBranch.value = '';
    transferContent.value = '';

    amountInput.addEventListener('input', function(){
        const selStart = this.selectionStart;
        const lenBefore = this.value.length;
        this.value = formatCurrency(this.value);
        const lenAfter = this.value.length;
        const diff = lenAfter - lenBefore;
        this.setSelectionRange(selStart + diff, selStart + diff);
        this.classList.remove('is-invalid');
        
        // Clear active state of amount buttons when user types manually
        document.querySelectorAll('.amount-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Generate new transfer content when amount changes
        if (selectedBankId && this.value.replace(/[^0-9]/g, '')) {
            const newContent = generateRandomContent();
            transferContent.value = newContent;
            transferContent.classList.remove('is-invalid');
        }
        
        // Hide QR code when amount changes
        hideQRCode();
    });
    
    // Clear validation for transfer content when it changes
    transferContent.addEventListener('input', function(){
        this.classList.remove('is-invalid');
        // Hide QR code when transfer content changes
        hideQRCode();
    });

    // Handle amount buttons click
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('amount-btn')) {
            const amount = e.target.getAttribute('data-amount');
            amountInput.value = formatCurrency(amount);
            amountInput.classList.remove('is-invalid');
            
            // Update button states
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            e.target.classList.add('active');
            
            // Generate new transfer content when amount button is clicked
            if (selectedBankId) {
                const newContent = generateRandomContent();
                transferContent.value = newContent;
                transferContent.classList.remove('is-invalid');
            }
            
            // Hide QR code when amount button is clicked
            hideQRCode();
        }
    });

    // Handle bank logo clicks
    bankGrid.addEventListener('click', function(e) {
        const bankItem = e.target.closest('.bank-logo-item');
        if (!bankItem) return;
        
        // Remove previous selection
        document.querySelectorAll('.bank-logo-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        // Add selection to clicked item
        bankItem.classList.add('selected');
        
        // Get bank data
        selectedBankId = bankItem.getAttribute('data-bank-id');
        const bankName = bankItem.getAttribute('data-ten') || '';
        const bankStk = bankItem.getAttribute('data-stk') || '';
        const bankChu = bankItem.getAttribute('data-chu') || '';
        const bankCn = bankItem.getAttribute('data-cn') || '';
        const bankImg = bankItem.getAttribute('data-img') || '';
        
        // Update form fields
        bankNameInput.value = bankName;
        bankAccount.value = bankStk;
        bankHolder.value = bankChu;
        bankBranch.value = bankCn;
        
        // Update logo in info section
        if (bankImg) {
            bankLogo.src = bankImg.startsWith('http') ? bankImg : ('/storage/' + bankImg.replace(/^\/+/, ''));
            bankLogo.classList.remove('d-none');
        } else {
            bankLogo.classList.add('d-none');
        }
        
        setFormEnabled(true);
        
        // Generate transfer content automatically
        const transferContentValue = generateRandomContent();
        transferContent.value = transferContentValue;
        
        // Hide QR code when bank changes
        hideQRCode();
    });
    
    function showQRCode(accountNumber, bankName, transferContent, amount) {
        // Show loading state
        qrPlaceholder.classList.add('d-none');
        qrLoading.classList.remove('d-none');
        qrCodeContainer.classList.add('d-none');
        
        // Wait 1 second before showing QR code
        setTimeout(() => {
            // Hide loading and show QR container
            qrLoading.classList.add('d-none');
            qrCodeContainer.classList.remove('d-none');
            
            // Generate QR code data (this would typically be a payment URL or bank transfer data)
            const qrData = generateQRData(accountNumber, bankName, transferContent, amount);
            
            // For demo purposes, we'll create a simple QR code using a service
            // In production, you might want to use a QR code library like qrcode.js
            generateQRCodeImage(qrData);
        }, 1000);
    }
    
    function generateQRData(accountNumber, bankName, transferContent, amount) {
        // This is a simplified example - in reality, you'd generate proper bank transfer data
        return `bank://transfer?bank=${encodeURIComponent(bankName)}&account=${accountNumber}&amount=${amount}&note=${encodeURIComponent(transferContent)}`;
    }
    
    function generateQRCodeImage(data) {
        // Using a free QR code API for demo purposes
        // In production, consider using a proper QR code library
        const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(data)}`;
        
        qrCode.innerHTML = `<img src="${qrUrl}" alt="QR Code" class="img-fluid">`;
    }

    copyStkBtn.addEventListener('click', function(){
        bankAccount.select();
        document.execCommand('copy');
        if (typeof showToast === 'function') {
            showToast('success', 'Đã sao chép số tài khoản');
        }
    });


    submitBtn.addEventListener('click', function(){
        let valid = true;
        
        // Clear previous validation errors
        amountInput.classList.remove('is-invalid');
        transferContent.classList.remove('is-invalid');
        
        if (!selectedBankId) { 
            // Show error for bank selection
            const firstBankItem = document.querySelector('.bank-logo-item');
            if (firstBankItem) {
                firstBankItem.style.borderColor = '#dc3545';
                setTimeout(() => firstBankItem.style.borderColor = '', 2000);
            }
            valid = false; 
        }
        
        if (!amountInput.value.replace(/[^0-9]/g, '')) { 
            amountInput.classList.add('is-invalid'); 
            valid = false; 
        }
        
        if (!transferContent.value.trim()) { 
            transferContent.classList.add('is-invalid'); 
            valid = false; 
        }
        
        if (!valid) return;

        // Show QR code when creating deposit request
        const amount = amountInput.value.replace(/[^0-9]/g, '');
        showQRCode(bankAccount.value, bankNameInput.value, transferContent.value, amount);

        if (typeof confirm === 'function') {
            confirm({
                title: 'Xác nhận tạo yêu cầu',
                message: 'Bạn xác nhận đã chuyển khoản theo đúng thông tin?\nSau khi xác minh, tiền sẽ được cộng vào ví.',
                confirmText: 'Xác nhận',
                onConfirm: () => {
                    if (typeof showToast === 'function') showToast('success', 'Đã tạo yêu cầu nạp (demo)');
                }
            });
        } else {
            alert('Đã tạo yêu cầu nạp (demo)');
        }
    });
});
</script>
@endpush
