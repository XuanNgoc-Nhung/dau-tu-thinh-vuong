<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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
}
