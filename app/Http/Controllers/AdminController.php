<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function users(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));

        $users = User::with('profile')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $keyword) . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('email', 'like', $like)
                      ->orWhere('phone', 'like', $like);
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:users,id'],
                'name' => ['nullable','string','max:255'],
                'email' => ['nullable','email','max:255', Rule::unique('users')->ignore($request->input('id'))],
                // Không cho phép chỉnh sửa phone từ admin form
                'phone' => ['nullable','string','max:30'],
                'role' => ['nullable','in:0,1'],
                'status' => ['nullable','boolean'],
                'profile.ngay_sinh' => ['nullable','date'],
                'profile.gioi_tinh' => ['nullable','string','max:20'],
                'profile.dia_chi' => ['nullable','string','max:255'],
                'profile.mat_khau_rut_tien' => ['nullable','string','max:255'],
                'profile.ngan_hang' => ['nullable','string','max:100'],
                'profile.so_tai_khoan' => ['nullable','string','max:100'],
                'profile.chu_tai_khoan' => ['nullable','string','max:100'],
                'profile.so_du' => ['nullable','numeric'],
                'profile.anh_mat_truoc' => ['nullable','string','max:2048'],
                'profile.anh_mat_sau' => ['nullable','string','max:2048'],
                'profile.anh_chan_dung' => ['nullable','string','max:2048'],
            ]);

            $user = User::findOrFail($validated['id']);
            if (array_key_exists('name', $validated)) {
                $user->name = $validated['name'];
            }
            if (array_key_exists('email', $validated)) {
                $user->email = $validated['email'];
            }
            // Bỏ qua cập nhật phone để đảm bảo không chỉnh sửa số điện thoại
            if (array_key_exists('role', $validated)) {
                $user->role = (int) $validated['role'];
            }
            if (array_key_exists('status', $validated)) {
                $user->status = (int) $validated['status'];
            }

            $user->save();

            // Save profile if provided
            $profilePayload = $request->input('profile');
            if (is_array($profilePayload)) {
                $profile = $user->profile ?: new Profile([ 'user_id' => $user->id ]);
                $allowed = [
                    'ngan_hang','so_tai_khoan','chu_tai_khoan','so_du','ngay_sinh','gioi_tinh','dia_chi','mat_khau_rut_tien','anh_mat_truoc','anh_mat_sau','anh_chan_dung'
                ];
                foreach ($allowed as $field) {
                    if (array_key_exists($field, $profilePayload)) {
                        $profile->{$field} = $profilePayload[$field];
                    }
                }
                $profile->user_id = $user->id;
                $profile->save();
                // refresh relation
                $user->setRelation('profile', $profile->fresh());
            } else {
                $user->loadMissing('profile');
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật người dùng thành công',
                'user' => array_merge(
                    $user->only(['id','name','email','phone','role','status']),
                    [ 'profile' => optional($user->profile)?->only([
                        'ngan_hang','so_tai_khoan','chu_tai_khoan','so_du','ngay_sinh','gioi_tinh','dia_chi','mat_khau_rut_tien','anh_mat_truoc','anh_mat_sau','anh_chan_dung'
                    ]) ]
                )
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật người dùng. Vui lòng thử lại sau.',
            ]);
        }
    }

    public function destroyUser(Request $request)
    {
        try {
            $id = (int) $request->input('id');
            $user = User::findOrFail($id);
            // Optional: prevent deleting self or last admin, add rules as needed
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xoá người dùng thành công'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá người dùng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}
