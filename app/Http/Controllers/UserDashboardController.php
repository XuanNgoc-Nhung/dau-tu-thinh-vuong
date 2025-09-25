<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\NganHangNapTien;
use App\Models\NapRut;

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

    public function lichSuNapRut()
    {
        Log::info('UserDashboardController@lichSuNapRut: Bắt đầu hiển thị trang lịch sử nạp rút', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email ?? 'N/A'
        ]);
        
        try {
            $user = Auth::user();
            $napRutHistory = NapRut::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
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
}
