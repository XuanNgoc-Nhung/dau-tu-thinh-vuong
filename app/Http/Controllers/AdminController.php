<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Profile;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\SanPhamDauTu;
use App\Models\NapRut;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use App\Models\NganHangNapTien;
use App\Models\ThongBao;
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
    public function sanPhamDauTu(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));
        $sanPhamDauTu = SanPhamDauTu::orderByDesc('id')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $keyword) . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('ten', 'like', $like);
                });
            })
            ->paginate(10);
        return view('admin.san-pham-dau-tu', compact('sanPhamDauTu'));
    }
    public function updateSanPhamDauTu(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:san_pham_dau_tu,id'],
                'ten' => ['nullable','string','max:255'],
                'slug' => ['nullable','string','max:255'],
                // allow optional image upload on update, including webp
                'hinh_anh' => ['nullable','file','image','mimes:jpeg,jpg,png,webp','max:5120'],
                'von_toi_thieu' => ['nullable','numeric'],
                'von_toi_da' => ['nullable','numeric'],
                'so_luong_chu_ky' => ['nullable','integer'],
                'thoi_gian_mot_chu_ky' => ['nullable','integer'],
                'nhan_dan' => ['nullable','string','max:255'],
                'mo_ta' => ['nullable','string','max:255'],
                'trang_thai' => ['nullable','boolean'],
            ]);
            $sanPhamDauTu = SanPhamDauTu::findOrFail($validated['id']);
            if (array_key_exists('ten', $validated)) {
                $sanPhamDauTu->ten = $validated['ten'];
            }
            if (array_key_exists('slug', $validated)) {
                $newSlug = trim((string) $validated['slug']);
                if ($newSlug !== '') {
                    $newSlug = Str::slug($newSlug);
                    // uniqueness check, if conflicts then append random suffix
                    if (SanPhamDauTu::where('slug', $newSlug)->where('id', '!=', $sanPhamDauTu->id)->exists()) {
                        $base = $newSlug;
                        $attempt = 0;
                        do {
                            $attempt++;
                            $candidate = $base . '-' . Str::lower(Str::random(6));
                        } while (SanPhamDauTu::where('slug', $candidate)->where('id', '!=', $sanPhamDauTu->id)->exists() && $attempt < 60);
                        $newSlug = $candidate;
                    }
                    $sanPhamDauTu->slug = $newSlug;
                } else {
                    $sanPhamDauTu->slug = null;
                }
            }
            // Handle optional image upload
            if ($request->hasFile('hinh_anh')) {
                $file = $request->file('hinh_anh');
                $destinationPath = public_path('uploads/products');
                if (!is_dir($destinationPath)) {
                    @mkdir($destinationPath, 0755, true);
                }
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                $sanPhamDauTu->hinh_anh = 'uploads/products/' . $filename;
            }
            if (array_key_exists('von_toi_thieu', $validated)) {
                $sanPhamDauTu->von_toi_thieu = $validated['von_toi_thieu'];
            }
            if (array_key_exists('von_toi_da', $validated)) {
                $sanPhamDauTu->von_toi_da = $validated['von_toi_da'];
            }
            if (array_key_exists('so_luong_chu_ky', $validated)) {
                $sanPhamDauTu->so_luong_chu_ky = $validated['so_luong_chu_ky'];
            }
            if (array_key_exists('thoi_gian_mot_chu_ky', $validated)) {
                $sanPhamDauTu->thoi_gian_mot_chu_ky = $validated['thoi_gian_mot_chu_ky'];
            }
            if (array_key_exists('nhan_dan', $validated)) {
                $sanPhamDauTu->nhan_dan = $validated['nhan_dan'];
            }
            if (array_key_exists('mo_ta', $validated)) {
                $sanPhamDauTu->mo_ta = $validated['mo_ta'];
            }
            if (array_key_exists('trang_thai', $validated)) {
                $sanPhamDauTu->trang_thai = (int) $validated['trang_thai'];
            }
            $sanPhamDauTu->save();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật sản phẩm đầu tư thành công'
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
                'message' => 'Không tìm thấy sản phẩm đầu tư'
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật sản phẩm đầu tư. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    public function storeSanPhamDauTu(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten' => ['required','string','max:255'],
                'slug' => ['nullable','string','max:255'],
                // accept webp as well
                'hinh_anh' => ['required','file','image','mimes:jpeg,jpg,png,webp','max:5120'],
                'von_toi_thieu' => ['required','numeric'],
                'von_toi_da' => ['required','numeric'],
                'so_luong_chu_ky' => ['required','integer','min:0'],
                'thoi_gian_mot_chu_ky' => ['required','integer','min:0'],
                'lai_suat' => ['required','numeric'],
                'nhan_dan' => ['nullable','string','max:255'],
                'mo_ta' => ['required','string'],
                'trang_thai' => ['required','boolean'],
            ]);

            // Build slug; ensure uniqueness by appending random suffix if needed
            $baseSlug = Str::slug($validated['ten']);
            $providedSlug = isset($validated['slug']) && trim($validated['slug']) !== '' ? Str::slug($validated['slug']) : null;
            $slug = $providedSlug ?: $baseSlug;
            if ($slug === '') {
                $slug = Str::random(8);
            }
            // Ensure unique slug
            $original = $slug;
            $i = 0;
            while (SanPhamDauTu::where('slug', $slug)->exists()) {
                $i++;
                $slug = $original . '-' . Str::lower(Str::random(6));
                if ($i > 50) { // safety guard
                    $slug = $original . '-' . time() . '-' . Str::lower(Str::random(4));
                }
                if ($i > 60) break;
            }

            $payload = [
                'ten' => $validated['ten'],
                'slug' => $slug,
                'von_toi_thieu' => $validated['von_toi_thieu'],
                'von_toi_da' => $validated['von_toi_da'],
                'lai_suat' => $validated['lai_suat'],
                'so_luong_chu_ky' => $validated['so_luong_chu_ky'],
                'thoi_gian_mot_chu_ky' => $validated['thoi_gian_mot_chu_ky'],
                'nhan_dan' => $validated['nhan_dan'] ?? null,
                'mo_ta' => $validated['mo_ta'],
                'trang_thai' => (int) $validated['trang_thai'],
            ];

            if ($request->hasFile('hinh_anh')) {
                $file = $request->file('hinh_anh');
                $destinationPath = public_path('uploads/products');
                if (!is_dir($destinationPath)) {
                    @mkdir($destinationPath, 0755, true);
                }
                $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $filename);
                // Lưu đường dẫn tương đối tính từ public để dùng với asset()
                $payload['hinh_anh'] = 'uploads/products/' . $filename;
            }

            $created = SanPhamDauTu::create($payload);

            return response()->json([
                'success' => true,
                'message' => 'Tạo sản phẩm đầu tư thành công',
                'data' => $created,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tạo sản phẩm đầu tư. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    public function destroySanPhamDauTu(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:san_pham_dau_tu,id']
            ]);

            $item = SanPhamDauTu::findOrFail((int) $validated['id']);

            // Remove associated image file if exists
            $relativePath = (string) ($item->hinh_anh ?? '');
            if ($relativePath !== '') {
                $fullPath = public_path($relativePath);
                if (is_string($fullPath) && $fullPath !== '' && file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xoá sản phẩm đầu tư thành công'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm đầu tư'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá sản phẩm đầu tư. Vui lòng thử lại sau.'
            ], 500);
        }
    }
    public function nganHangNapTien(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));
        $banks = NganHangNapTien::orderByDesc('id')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $keyword) . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('ten_ngan_hang', 'like', $like)
                      ->orWhere('so_tai_khoan', 'like', $like)
                      ->orWhere('chu_tai_khoan', 'like', $like)
                      ->orWhere('chi_nhanh', 'like', $like);
                });
            })
            ->paginate(10);
        return view('admin.ngan-hang-nap-tien', compact('banks'));
    }
    public function storeNganHangNapTien(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten_ngan_hang' => ['required','string','max:255'],
                // accept URL string for image/logo
                'hinh_anh' => ['nullable','string','max:2048'],
                'so_tai_khoan' => ['required','string','max:100'],
                'chu_tai_khoan' => ['required','string','max:150'],
                'chi_nhanh' => ['nullable','string','max:255'],
                'ghi_chu' => ['nullable','string','max:255'],
                'trang_thai' => ['required','boolean'],
            ]);

            $payload = [
                'ten_ngan_hang' => $validated['ten_ngan_hang'],
                'so_tai_khoan' => $validated['so_tai_khoan'],
                'chu_tai_khoan' => $validated['chu_tai_khoan'],
                'chi_nhanh' => $validated['chi_nhanh'] ?? null,
                'ghi_chu' => $validated['ghi_chu'] ?? null,
                'trang_thai' => (int) $validated['trang_thai'],
            ];

            // If url provided, save as-is
            if (array_key_exists('hinh_anh', $validated)) {
                $url = trim((string) ($validated['hinh_anh'] ?? ''));
                $payload['hinh_anh'] = $url !== '' ? $url : null;
            }

            $created = NganHangNapTien::create($payload);

            return response()->json([
                'success' => true,
                'message' => 'Tạo ngân hàng nạp tiền thành công',
                'data' => $created,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tạo ngân hàng. Vui lòng thử lại sau.',
            ], 500);
        }
    }
    public function updateNganHangNapTien(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:ngan_hang_nap_tien,id'],
                'ten_ngan_hang' => ['nullable','string','max:255'],
                // accept URL string for image/logo
                'hinh_anh' => ['nullable','string','max:2048'],
                'so_tai_khoan' => ['nullable','string','max:100'],
                'chu_tai_khoan' => ['nullable','string','max:150'],
                'chi_nhanh' => ['nullable','string','max:255'],
                'ghi_chu' => ['nullable','string','max:255'],
                'trang_thai' => ['nullable','boolean'],
            ]);
            $item = NganHangNapTien::findOrFail((int) $validated['id']);

            foreach (['ten_ngan_hang','so_tai_khoan','chu_tai_khoan','chi_nhanh','ghi_chu'] as $field) {
                if (array_key_exists($field, $validated)) {
                    $item->{$field} = $validated[$field];
                }
            }
            if (array_key_exists('trang_thai', $validated)) {
                $item->trang_thai = (int) $validated['trang_thai'];
            }
            if (array_key_exists('hinh_anh', $validated)) {
                $url = trim((string) ($validated['hinh_anh'] ?? ''));
                $item->hinh_anh = $url !== '' ? $url : null;
            }

            $item->save();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật ngân hàng thành công'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy ngân hàng'
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật ngân hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
    public function destroyNganHangNapTien(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:ngan_hang_nap_tien,id']
            ]);
            $item = NganHangNapTien::findOrFail((int) $validated['id']);
            $old = (string) ($item->hinh_anh ?? '');
            if ($old !== '') {
                $fullPath = public_path($old);
                if (is_string($fullPath) && $fullPath !== '' && file_exists($fullPath) && is_file($fullPath)) {
                    @unlink($fullPath);
                }
            }
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xoá ngân hàng thành công'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy ngân hàng'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá ngân hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
    public function napRut(Request $request)
    {
        $keyword = trim((string) $request->input('q', ''));
        $loai = $request->input('loai', '');
        $trangThai = $request->input('trang_thai', '');
        
        $transactions = NapRut::with('user')
            ->when($keyword !== '', function ($query) use ($keyword) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $keyword) . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('so_tai_khoan', 'like', $like)
                        ->orWhere('chu_tai_khoan', 'like', $like)
                        ->orWhere('ngan_hang', 'like', $like)
                        ->orWhere('noi_dung', 'like', $like)
                        ->orWhereHas('user', function ($userQuery) use ($like) {
                            $userQuery->where('name', 'like', $like)
                                     ->orWhere('email', 'like', $like);
                        });
                });
            })
            ->when($loai != '', function ($query) use ($loai) {
                $query->where('loai', $loai);
            })
            ->when($trangThai != '', function ($query) use ($trangThai) {
                $query->where('trang_thai', $trangThai);
            })
            ->orderByDesc('id')
            ->paginate(10);
            
        return view('admin.nap-rut', compact('transactions'));
    }

    public function updateNapRutStatus(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required', 'integer', 'exists:nap_rut,id'],
                'trang_thai' => ['required', 'integer', 'in:0,1,2']
            ]);

            $transaction = NapRut::findOrFail($validated['id']);
            
            // Lưu trạng thái cũ để kiểm tra
            $oldStatus = $transaction->trang_thai;
            $transaction->trang_thai = $validated['trang_thai'];
            $transaction->save();

            // Xử lý cộng số dư khi duyệt giao dịch nạp tiền
            if ($validated['trang_thai'] == 1 && $transaction->loai == 'nap' && $oldStatus != 1) {
                $profile = Profile::where('user_id', $transaction->user_id)->first();
                if ($profile) {
                    $profile->so_du = $profile->so_du + $transaction->so_tien;
                    $profile->save();
                }
            }

            // Xử lý hoàn lại số dư khi từ chối giao dịch rút tiền (tiền đã bị trừ khi tạo yêu cầu)
            if ($validated['trang_thai'] == 2 && $transaction->loai == 'rut' && $oldStatus != 2) {
                $profile = Profile::where('user_id', $transaction->user_id)->first();
                if ($profile) {
                    $profile->so_du = $profile->so_du + $transaction->so_tien;
                    $profile->save();
                }
            }

            // Xử lý trường hợp admin thay đổi từ "từ chối" về "đã duyệt" cho giao dịch rút tiền
            if ($validated['trang_thai'] == 1 && $transaction->loai == 'rut' && $oldStatus == 2) {
                $profile = Profile::where('user_id', $transaction->user_id)->first();
                if ($profile) {
                    $profile->so_du = $profile->so_du - $transaction->so_tien;
                    $profile->save();
                }
            }

            // Xử lý trường hợp admin thay đổi từ "đã duyệt" về "từ chối" cho giao dịch rút tiền
            if ($validated['trang_thai'] == 2 && $transaction->loai == 'rut' && $oldStatus == 1) {
                $profile = Profile::where('user_id', $transaction->user_id)->first();
                if ($profile) {
                    $profile->so_du = $profile->so_du + $transaction->so_tien;
                    $profile->save();
                }
            }

            $statusText = '';
            switch($validated['trang_thai']) {
                case 0: $statusText = 'Chờ xử lý'; break;
                case 1: $statusText = 'Đã duyệt'; break;
                case 2: $statusText = 'Từ chối'; break;
            }

            return response()->json([
                'success' => true,
                'message' => "Đã cập nhật trạng thái giao dịch thành '{$statusText}'"
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy giao dịch'
            ], 404);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật trạng thái giao dịch. Vui lòng thử lại sau.'
            ], 500);
        }
    }
    public function thongBao(Request $request){
        $keyword = trim((string) $request->input('q', ''));
        $trangThai = $request->input('trang_thai', '');

        $thongBaos = ThongBao::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $keyword) . '%';
                $query->where(function ($q) use ($like) {
                    $q->where('tieu_de', 'like', $like)
                      ->orWhere('noi_dung', 'like', $like);
                });
            })
            ->when($trangThai !== '', function ($query) use ($trangThai) {
                $query->where('trang_thai', (int) $trangThai);
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.thong-bao', compact('thongBaos', 'keyword', 'trangThai'));
    }
    public function storeThongBao(Request $request)
    {
        try {
            $validated = $request->validate([
                'tieu_de' => ['required','string','max:255'],
                'noi_dung' => ['required','string'],
                'trang_thai' => ['required','boolean'],
            ]);

            $created = ThongBao::create([
                'tieu_de' => $validated['tieu_de'],
                'noi_dung' => $validated['noi_dung'],
                'trang_thai' => (int) $validated['trang_thai'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tạo thông báo thành công',
                'data' => $created,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tạo thông báo. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    public function updateThongBao(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:thong_baos,id'],
                'tieu_de' => ['required','string','max:255'],
                'noi_dung' => ['required','string'],
                'trang_thai' => ['required','boolean'],
            ]);

            $item = ThongBao::findOrFail((int) $validated['id']);
            $item->tieu_de = $validated['tieu_de'];
            $item->noi_dung = $validated['noi_dung'];
            $item->trang_thai = (int) $validated['trang_thai'];
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông báo thành công',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông báo',
            ], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật thông báo. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    public function destroyThongBao(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => ['required','integer','exists:thong_baos,id'],
            ]);

            $item = ThongBao::findOrFail((int) $validated['id']);
            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xoá thông báo thành công',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông báo',
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xoá thông báo. Vui lòng thử lại sau.',
            ], 500);
        }
    }
}