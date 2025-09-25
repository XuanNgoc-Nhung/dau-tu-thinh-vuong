<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\NganHangNapTien;
use App\Models\ThongBao;
use App\Models\NapRut;
use App\Models\SanPhamDauTu;

class UserDashboardController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }
    
    public function profile()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('user.dashboard.profiles', compact('user', 'profile'));
    }
    public function baoMat()
    {
        Log::info('UserDashboardController@baoMat: Bắt đầu hiển thị trang bảo mật', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        
        try {
            $view = view('user.dashboard.bao-mat');
            Log::info('UserDashboardController@baoMat: Hiển thị trang bảo mật thành công', [
                'user_id' => Auth::id()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@baoMat: Lỗi khi hiển thị trang bảo mật', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function changePassword(Request $request)
    {
        Log::info('UserDashboardController@changePassword: Bắt đầu thay đổi mật khẩu đăng nhập', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@changePassword: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['current_password', 'new_password', 'new_password_confirmation'])
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        Log::info('UserDashboardController@changePassword: Bắt đầu kiểm tra mật khẩu hiện tại', [
            'user_id' => $user->id
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            Log::warning('UserDashboardController@changePassword: Mật khẩu hiện tại không đúng', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['Mật khẩu hiện tại không đúng']]
            ], 422);
        }

        Log::info('UserDashboardController@changePassword: Mật khẩu hiện tại đúng, bắt đầu cập nhật mật khẩu mới', [
            'user_id' => $user->id
        ]);

        try {
            // Cập nhật mật khẩu mới
            $user->password = Hash::make($request->new_password);
            $user->save();

            Log::info('UserDashboardController@changePassword: Cập nhật mật khẩu thành công', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mật khẩu đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@changePassword: Lỗi khi cập nhật mật khẩu', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật mật khẩu'
            ], 500);
        }
    }

    public function changeWithdrawalPassword(Request $request)
    {
        Log::info('UserDashboardController@changeWithdrawalPassword: Bắt đầu thay đổi mật khẩu rút tiền', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'login_password' => 'required',
            'new_withdrawal_password' => 'required|min:4|confirmed',
        ], [
            'login_password.required' => 'Vui lòng nhập mật khẩu đăng nhập',
            'new_withdrawal_password.required' => 'Vui lòng nhập mật khẩu rút tiền mới',
            'new_withdrawal_password.min' => 'Mật khẩu rút tiền phải có ít nhất 4 ký tự',
            'new_withdrawal_password.confirmed' => 'Xác nhận mật khẩu rút tiền không khớp',
        ]);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@changeWithdrawalPassword: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['login_password', 'new_withdrawal_password', 'new_withdrawal_password_confirmation'])
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        Log::info('UserDashboardController@changeWithdrawalPassword: Bắt đầu kiểm tra mật khẩu đăng nhập', [
            'user_id' => $user->id
        ]);

        // Kiểm tra mật khẩu đăng nhập
        if (!Hash::check($request->login_password, $user->password)) {
            Log::warning('UserDashboardController@changeWithdrawalPassword: Mật khẩu đăng nhập không đúng', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => ['login_password' => ['Mật khẩu đăng nhập không đúng']]
            ], 422);
        }

        Log::info('UserDashboardController@changeWithdrawalPassword: Mật khẩu đăng nhập đúng, bắt đầu cập nhật mật khẩu rút tiền', [
            'user_id' => $user->id
        ]);

        try {
            // Lấy hoặc tạo profile cho user
            $profile = $user->profile;
            if (!$profile) {
                $profile = $user->profile()->create([]);
            }
            
            // Cập nhật mật khẩu rút tiền vào profile (không mã hóa)
            $profile->mat_khau_rut_tien = $request->new_withdrawal_password;
            $profile->save();

            Log::info('UserDashboardController@changeWithdrawalPassword: Cập nhật mật khẩu rút tiền thành công', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mật khẩu rút tiền đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@changeWithdrawalPassword: Lỗi khi cập nhật mật khẩu rút tiền', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật mật khẩu rút tiền'
            ], 500);
        }
    }
    public function nganHang(){
        Log::info('UserDashboardController@nganHang: Bắt đầu hiển thị trang ngân hàng', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        
        try {
            $user = Auth::user();
            $view = view('user.dashboard.ngan-hang', compact('user'));
            Log::info('UserDashboardController@nganHang: Hiển thị trang ngân hàng thành công', [
                'user_id' => Auth::id()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@nganHang: Lỗi khi hiển thị trang ngân hàng', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function updateBankInfo(Request $request)
    {
        Log::info('UserDashboardController@updateBankInfo: Bắt đầu cập nhật thông tin ngân hàng', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
            'password' => 'required',
        ], [
            'bank_name.required' => 'Vui lòng chọn ngân hàng',
            'bank_name.max' => 'Tên ngân hàng không được vượt quá 255 ký tự',
            'account_number.required' => 'Vui lòng nhập số tài khoản',
            'account_number.max' => 'Số tài khoản không được vượt quá 50 ký tự',
            'account_holder.required' => 'Vui lòng nhập tên chủ tài khoản',
            'account_holder.max' => 'Tên chủ tài khoản không được vượt quá 255 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu để xác nhận',
        ]);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@updateBankInfo: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['_token', '_method', 'password'])
            ]);
            
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ]);
        }

        $user = Auth::user();
        Log::info('UserDashboardController@updateBankInfo: Bắt đầu cập nhật thông tin ngân hàng', [
            'user_id' => $user->id,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder
        ]);

        // Kiểm tra mật khẩu đăng nhập trước khi cho phép cập nhật
        if (!Hash::check($request->password, $user->password)) {
            Log::warning('UserDashboardController@updateBankInfo: Mật khẩu xác nhận không đúng', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu không đúng',
                'errors' => ['password' => ['Mật khẩu không đúng']]
            ]);
        }

        try {
            // Lấy hoặc tạo profile cho user
            $profile = $user->profile;
            if (!$profile) {
                $profile = $user->profile()->create([]);
                Log::info('UserDashboardController@updateBankInfo: Tạo profile mới cho user', [
                    'user_id' => $user->id,
                    'profile_id' => $profile->id
                ]);
            }
            
            // Cập nhật thông tin ngân hàng
            $profile->ngan_hang = $request->bank_name;
            $profile->so_tai_khoan = $request->account_number;
            $profile->chu_tai_khoan = $request->account_holder;
            $profile->save();

            Log::info('UserDashboardController@updateBankInfo: Cập nhật thông tin ngân hàng thành công', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thông tin ngân hàng đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@updateBankInfo: Lỗi khi cập nhật thông tin ngân hàng', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông tin ngân hàng'
            ], 500);
        }
    }
    public function napTien(){
        Log::info('UserDashboardController@napTien: Bắt đầu hiển thị trang nạp tiền', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]); 
        try {
            $user = Auth::user();
            $banks = NganHangNapTien::query()
                ->where('trang_thai', 1)
                ->orderBy('ten_ngan_hang')
                ->get();
            $view = view('user.dashboard.nap-tien', compact('user', 'banks'));
            Log::info('UserDashboardController@napTien: Hiển thị trang nạp tiền thành công', [
                'user_id' => Auth::id()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@napTien: Lỗi khi hiển thị trang nạp tiền', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function createNapTienRequest(Request $request)
    {
        Log::info('UserDashboardController@createNapTienRequest: Bắt đầu tạo yêu cầu nạp tiền', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'so_tien' => 'required|numeric|min:10000',
            'ngan_hang' => 'required|string|max:255',
            'so_tai_khoan' => 'required|string|max:50',
            'chu_tai_khoan' => 'required|string|max:255',
            'noi_dung' => 'required|string|max:255',
        ], [
            'so_tien.required' => 'Vui lòng nhập số tiền',
            'so_tien.numeric' => 'Số tiền phải là số',
            'so_tien.min' => 'Số tiền tối thiểu là 10,000 VND',
            'ngan_hang.required' => 'Vui lòng chọn ngân hàng',
            'ngan_hang.max' => 'Tên ngân hàng không được vượt quá 255 ký tự',
            'so_tai_khoan.required' => 'Vui lòng nhập số tài khoản',
            'so_tai_khoan.max' => 'Số tài khoản không được vượt quá 50 ký tự',
            'chu_tai_khoan.required' => 'Vui lòng nhập tên chủ tài khoản',
            'chu_tai_khoan.max' => 'Tên chủ tài khoản không được vượt quá 255 ký tự',
            'noi_dung.required' => 'Vui lòng nhập nội dung chuyển khoản',
            'noi_dung.max' => 'Nội dung chuyển khoản không được vượt quá 255 ký tự',
        ]);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@createNapTienRequest: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['_token'])
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        Log::info('UserDashboardController@createNapTienRequest: Bắt đầu tạo yêu cầu nạp tiền', [
            'user_id' => $user->id,
            'so_tien' => $request->so_tien,
            'ngan_hang' => $request->ngan_hang,
            'so_tai_khoan' => $request->so_tai_khoan,
            'chu_tai_khoan' => $request->chu_tai_khoan,
            'noi_dung' => $request->noi_dung
        ]);

        try {
            // Tạo yêu cầu nạp tiền
            $napRut = NapRut::create([
                'user_id' => $user->id,
                'loai' => 'nap', // Loại nạp tiền
                'so_tien' => $request->so_tien,
                'ngan_hang' => $request->ngan_hang,
                'so_tai_khoan' => $request->so_tai_khoan,
                'chu_tai_khoan' => $request->chu_tai_khoan,
                'noi_dung' => $request->noi_dung,
                'trang_thai' => 0 // 0: chờ xử lý, 1: thành công, 2: từ chối
            ]);

            Log::info('UserDashboardController@createNapTienRequest: Tạo yêu cầu nạp tiền thành công', [
                'user_id' => $user->id,
                'nap_rut_id' => $napRut->id,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu nạp tiền đã được tạo thành công!',
                'data' => [
                    'id' => $napRut->id,
                    'so_tien' => $napRut->so_tien,
                    'ngan_hang' => $napRut->ngan_hang,
                    'so_tai_khoan' => $napRut->so_tai_khoan,
                    'chu_tai_khoan' => $napRut->chu_tai_khoan,
                    'noi_dung' => $napRut->noi_dung,
                    'trang_thai' => $napRut->trang_thai,
                    'trang_thai_text' => $napRut->trang_thai == 0 ? 'Chờ xử lý' : ($napRut->trang_thai == 1 ? 'Thành công' : 'Từ chối'),
                    'created_at' => $napRut->created_at->format('d/m/Y H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@createNapTienRequest: Lỗi khi tạo yêu cầu nạp tiền', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo yêu cầu nạp tiền'
            ], 500);
        }
    }

    public function lichSuNapRut(Request $request)
    {
        Log::info('UserDashboardController@lichSuNapRut: Bắt đầu hiển thị trang lịch sử nạp rút', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        
        try {
            $user = Auth::user();
            $query = NapRut::where('user_id', $user->id);

            // Bộ lọc theo loại giao dịch: 'nap' hoặc 'rut'
            if ($request->filled('loai') && in_array($request->loai, ['nap', 'rut'])) {
                $query->where('loai', $request->loai);
            }

            // Bộ lọc theo nội dung (tìm kiếm mơ hồ theo nội dung, số TK, ngân hàng, mã GD)
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('noi_dung', 'like', "%{$search}%")
                      ->orWhere('ngan_hang', 'like', "%{$search}%")
                      ->orWhere('so_tai_khoan', 'like', "%{$search}%")
                      ->orWhere('id', $search);
                });
            }

            $napRutHistory = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->appends($request->only(['loai', 'search']));
            
            $view = view('user.dashboard.lich-su-nap-rut', compact('user', 'napRutHistory'));
            Log::info('UserDashboardController@lichSuNapRut: Hiển thị trang lịch sử nạp rút thành công', [
                'user_id' => Auth::id(),
                'total_records' => $napRutHistory->total()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@lichSuNapRut: Lỗi khi hiển thị trang lịch sử nạp rút', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    public function rutTien(){
        Log::info('UserDashboardController@rutTien: Bắt đầu hiển thị trang rút tiền', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        try {
            $user = Auth::user();
            $view = view('user.dashboard.rut-tien', compact('user'));
            Log::info('UserDashboardController@rutTien: Hiển thị trang rút tiền thành công', [
                'user_id' => Auth::id()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@rutTien: Lỗi khi hiển thị trang rút tiền', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    public function thongBao(Request $request){
        Log::info('UserDashboardController@thongBao: Bắt đầu hiển thị trang thông báo', [
            'user_id' => Auth::id(),
            'q' => $request->q
        ]);

        try {
            $query = ThongBao::query()->where('trang_thai', 1);
            if ($request->filled('q')) {
                $keyword = trim($request->q);
                $query->where(function($q) use ($keyword) {
                    $q->where('tieu_de', 'like', "%{$keyword}%")
                      ->orWhere('noi_dung', 'like', "%{$keyword}%");
                });
            }

            $thongBao = $query
                ->orderByDesc('id')
                ->paginate(10)
                ->appends($request->only('q'));

            $view = view('user.dashboard.thong-bao', compact('thongBao'));
            Log::info('UserDashboardController@thongBao: Hiển thị trang thông báo thành công', [
                'user_id' => Auth::id(),
                'total_records' => $thongBao->total()
            ]);
            return $view;
        } catch (\Exception $e) {
            Log::error('UserDashboardController@thongBao: Lỗi khi hiển thị trang thông báo', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    public function createRutTienRequest(Request $request)
    {
        Log::info('UserDashboardController@createRutTienRequest: Bắt đầu tạo yêu cầu rút tiền', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $validator = Validator::make($request->all(), [
            'so_tien' => 'required|numeric|min:50000',
            'mat_khau_rut_tien' => 'required|string',
        ], [
            'so_tien.required' => 'Vui lòng nhập số tiền',
            'so_tien.numeric' => 'Số tiền phải là số',
            'so_tien.min' => 'Số tiền tối thiểu là 50,000 VND',
            'mat_khau_rut_tien.required' => 'Vui lòng nhập mật khẩu rút tiền',
        ]);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@createRutTienRequest: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['_token', 'mat_khau_rut_tien'])
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $profile = $user->profile;
        
        // Kiểm tra profile và thông tin ngân hàng
        if (!$profile || !$profile->ngan_hang || !$profile->so_tai_khoan || !$profile->chu_tai_khoan) {
            Log::warning('UserDashboardController@createRutTienRequest: User chưa cập nhật thông tin ngân hàng', [
                'user_id' => $user->id,
                'has_profile' => $profile ? true : false,
                'has_bank_info' => $profile && $profile->ngan_hang && $profile->so_tai_khoan && $profile->chu_tai_khoan
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cập nhật thông tin ngân hàng trước khi rút tiền'
            ], 422);
        }

        // Kiểm tra mật khẩu rút tiền
        if (!$profile->mat_khau_rut_tien || $profile->mat_khau_rut_tien !== $request->mat_khau_rut_tien) {
            Log::warning('UserDashboardController@createRutTienRequest: Mật khẩu rút tiền không đúng', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu rút tiền không đúng'
            ], 422);
        }

        // Kiểm tra số dư
        if ($profile->so_du < $request->so_tien) {
            Log::warning('UserDashboardController@createRutTienRequest: Số dư không đủ', [
                'user_id' => $user->id,
                'current_balance' => $profile->so_du,
                'requested_amount' => $request->so_tien
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Số dư không đủ để thực hiện giao dịch'
            ], 422);
        }

        Log::info('UserDashboardController@createRutTienRequest: Bắt đầu tạo yêu cầu rút tiền', [
            'user_id' => $user->id,
            'so_tien' => $request->so_tien,
            'ngan_hang' => $profile->ngan_hang,
            'so_tai_khoan' => $profile->so_tai_khoan,
            'chu_tai_khoan' => $profile->chu_tai_khoan,
            'current_balance' => $profile->so_du
        ]);

        try {
            // Trừ tiền ngay lập tức khi tạo yêu cầu rút tiền
            $profile->so_du = $profile->so_du - $request->so_tien;
            $profile->save();

            // Tạo yêu cầu rút tiền
            $napRut = NapRut::create([
                'user_id' => $user->id,
                'loai' => 'rut', // Loại rút tiền
                'so_tien' => $request->so_tien,
                'ngan_hang' => $profile->ngan_hang,
                'so_tai_khoan' => $profile->so_tai_khoan,
                'chu_tai_khoan' => $profile->chu_tai_khoan,
                'noi_dung' => $user->phone,
                'trang_thai' => 0 // 0: chờ xử lý, 1: thành công, 2: từ chối
            ]);

            Log::info('UserDashboardController@createRutTienRequest: Tạo yêu cầu rút tiền thành công và đã trừ tiền', [
                'user_id' => $user->id,
                'nap_rut_id' => $napRut->id,
                'so_tien_rut' => $request->so_tien,
                'so_du_con_lai' => $profile->so_du,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu rút tiền đã được tạo thành công!',
                'data' => [
                    'id' => $napRut->id,
                    'so_tien' => $napRut->so_tien,
                    'ngan_hang' => $napRut->ngan_hang,
                    'so_tai_khoan' => $napRut->so_tai_khoan,
                    'chu_tai_khoan' => $napRut->chu_tai_khoan,
                    'noi_dung' => $napRut->noi_dung,
                    'trang_thai' => $napRut->trang_thai,
                    'trang_thai_text' => $napRut->trang_thai == 0 ? 'Chờ xử lý' : ($napRut->trang_thai == 1 ? 'Thành công' : 'Từ chối'),
                    'created_at' => $napRut->created_at->format('d/m/Y H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@createRutTienRequest: Lỗi khi tạo yêu cầu rút tiền', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo yêu cầu rút tiền'
            ], 500);
        }
    }
    public function kyc(){
        Log::info('UserDashboardController@kyc: Bắt đầu hiển thị trang kyc', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        
        $user = Auth::user();
        $profile = $user->profile;
        
        return view('user.dashboard.kyc', compact('user', 'profile'));
    }

    public function createKycRequest(Request $request)
    {
        Log::info('UserDashboardController@createKycRequest: Bắt đầu tạo yêu cầu KYC', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'is_ajax' => $request->ajax(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $user = Auth::user();
        $profile = $user->profile;
        
        // Check if user has existing KYC images
        $hasExistingPortrait = $profile && $profile->anh_chan_dung;
        $hasExistingIdFront = $profile && $profile->anh_mat_truoc;
        $hasExistingIdBack = $profile && $profile->anh_mat_sau;
        
        // Build validation rules based on existing images
        $rules = [
            'login_password' => 'required',
        ];
        
        $messages = [
            'login_password.required' => 'Vui lòng nhập mật khẩu đăng nhập',
        ];
        
        // Only require images if they don't exist
        if (!$hasExistingPortrait) {
            $rules['portrait_photo'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['portrait_photo.required'] = 'Vui lòng tải lên ảnh chân dung';
            $messages['portrait_photo.image'] = 'Ảnh chân dung phải là file hình ảnh';
            $messages['portrait_photo.mimes'] = 'Ảnh chân dung phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['portrait_photo.max'] = 'Ảnh chân dung không được vượt quá 5MB';
        } else {
            $rules['portrait_photo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['portrait_photo.image'] = 'Ảnh chân dung phải là file hình ảnh';
            $messages['portrait_photo.mimes'] = 'Ảnh chân dung phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['portrait_photo.max'] = 'Ảnh chân dung không được vượt quá 5MB';
        }
        
        if (!$hasExistingIdFront) {
            $rules['id_front_photo'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['id_front_photo.required'] = 'Vui lòng tải lên ảnh giấy tờ mặt trước';
            $messages['id_front_photo.image'] = 'Ảnh giấy tờ mặt trước phải là file hình ảnh';
            $messages['id_front_photo.mimes'] = 'Ảnh giấy tờ mặt trước phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['id_front_photo.max'] = 'Ảnh giấy tờ mặt trước không được vượt quá 5MB';
        } else {
            $rules['id_front_photo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['id_front_photo.image'] = 'Ảnh giấy tờ mặt trước phải là file hình ảnh';
            $messages['id_front_photo.mimes'] = 'Ảnh giấy tờ mặt trước phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['id_front_photo.max'] = 'Ảnh giấy tờ mặt trước không được vượt quá 5MB';
        }
        
        if (!$hasExistingIdBack) {
            $rules['id_back_photo'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['id_back_photo.required'] = 'Vui lòng tải lên ảnh giấy tờ mặt sau';
            $messages['id_back_photo.image'] = 'Ảnh giấy tờ mặt sau phải là file hình ảnh';
            $messages['id_back_photo.mimes'] = 'Ảnh giấy tờ mặt sau phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['id_back_photo.max'] = 'Ảnh giấy tờ mặt sau không được vượt quá 5MB';
        } else {
            $rules['id_back_photo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120';
            $messages['id_back_photo.image'] = 'Ảnh giấy tờ mặt sau phải là file hình ảnh';
            $messages['id_back_photo.mimes'] = 'Ảnh giấy tờ mặt sau phải có định dạng jpeg, png, jpg, gif hoặc webp';
            $messages['id_back_photo.max'] = 'Ảnh giấy tờ mặt sau không được vượt quá 5MB';
        }
        
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Log::warning('UserDashboardController@createKycRequest: Validation thất bại', [
                'user_id' => Auth::id(),
                'errors' => $validator->errors()->toArray(),
                'input_data' => $request->except(['portrait_photo', 'id_front_photo', 'id_back_photo'])
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        Log::info('UserDashboardController@createKycRequest: Bắt đầu kiểm tra mật khẩu đăng nhập', [
            'user_id' => $user->id
        ]);

        // Kiểm tra mật khẩu đăng nhập
        if (!Hash::check($request->login_password, $user->password)) {
            Log::warning('UserDashboardController@createKycRequest: Mật khẩu đăng nhập không đúng', [
                'user_id' => $user->id,
                'ip_address' => $request->ip()
            ]);
            
            return response()->json([
                'success' => false,
                'errors' => ['login_password' => ['Mật khẩu đăng nhập không đúng']]
            ], 422);
        }

        Log::info('UserDashboardController@createKycRequest: Mật khẩu đăng nhập đúng, bắt đầu xử lý yêu cầu KYC', [
            'user_id' => $user->id
        ]);

        try {
            // Lấy hoặc tạo profile cho user
            $profile = $user->profile;
            if (!$profile) {
                $profile = $user->profile()->create([]);
                Log::info('UserDashboardController@createKycRequest: Tạo profile mới cho user', [
                    'user_id' => $user->id,
                    'profile_id' => $profile->id
                ]);
            }

            // Xử lý upload ảnh vào public/uploads/kyc/
            // Chỉ cập nhật ảnh mới nếu có file được upload
            if ($request->hasFile('portrait_photo')) {
                $portraitFile = $request->file('portrait_photo');
                $portraitName = 'uploads/kyc/' . 'portrait_' . time() . '_' . $user->id . '.' . $portraitFile->getClientOriginalExtension();
                $portraitFile->move(public_path('uploads/kyc'), $portraitName);
                $profile->anh_chan_dung = $portraitName;
            }

            if ($request->hasFile('id_front_photo')) {
                $idFrontFile = $request->file('id_front_photo');
                $idFrontName = 'uploads/kyc/' . 'id_front_' . time() . '_' . $user->id . '.' . $idFrontFile->getClientOriginalExtension();
                $idFrontFile->move(public_path('uploads/kyc'), $idFrontName);
                $profile->anh_mat_truoc = $idFrontName;
            }

            if ($request->hasFile('id_back_photo')) {
                $idBackFile = $request->file('id_back_photo');
                $idBackName = 'uploads/kyc/' . 'id_back_' . time() . '_' . $user->id . '.' . $idBackFile->getClientOriginalExtension();
                $idBackFile->move(public_path('uploads/kyc'), $idBackName);
                $profile->anh_mat_sau = $idBackName;
            }

            // Lưu profile với hình ảnh KYC
            $profile->save();
            $user->save();

            Log::info('UserDashboardController@createKycRequest: Tạo yêu cầu KYC thành công', [
                'user_id' => $user->id,
                'profile_id' => $profile->id,
                'anh_chan_dung' => $profile->anh_chan_dung,
                'anh_mat_truoc' => $profile->anh_mat_truoc,
                'anh_mat_sau' => $profile->anh_mat_sau,
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Yêu cầu xác thực danh tính đã được gửi thành công! Chúng tôi sẽ xem xét và phản hồi trong vòng 1-3 ngày làm việc.',
                'data' => [
                    'kyc_status' => 'pending'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('UserDashboardController@createKycRequest: Lỗi khi tạo yêu cầu KYC', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi yêu cầu xác thực danh tính'
            ], 500);
        }
    }
    public function dauTu(\Illuminate\Http\Request $request){
        $search = trim((string) $request->get('search', ''));
        Log::info('UserDashboardController@dauTu: Bắt đầu hiển thị trang đầu tư', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A',
            'search' => $search !== '' ? $search : null
        ]);

        $query = SanPhamDauTu::query()->where('trang_thai', 1);
        if ($search !== '') {
            $query->where('ten', 'like', '%'.$search.'%');
        }

        $sanPhamDauTu = $query->orderByDesc('id')->get();
        return view('user.dashboard.dau-tu', compact('sanPhamDauTu'));
    }
    public function duAnCuaToi(){
        Log::info('UserDashboardController@duAnCuaToi: Bắt đầu hiển thị trang dự án của tôi', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        return view('user.dashboard.du-an-cua-toi');
    }
}
