<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Profile;

class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }
    
    public function register()
    {
        return view('user.register');
    }
    
    public function postRegister(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^(0|\+84)[0-9]{9,10}$/|unique:users,phone',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'terms' => 'required|accepted'
        ], [
            'name.required' => 'Họ và tên là bắt buộc',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'terms.required' => 'Bạn phải đồng ý với điều khoản sử dụng',
            'terms.accepted' => 'Bạn phải đồng ý với điều khoản sử dụng'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 0, // 0 = user, 1 = admin
                'status' => 1 // 1 = active, 0 = inactive
            ]);

            // Create profile for user
            Profile::create([
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công!',
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đăng ký. Vui lòng thử lại.'
            ], 500);
        }
    }
}
