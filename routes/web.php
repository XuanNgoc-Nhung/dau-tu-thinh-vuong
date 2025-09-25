<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // Người dùng
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::post('/delete-user', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    // Sản phẩm đầu tư
    Route::get('/san-pham-dau-tu', [AdminController::class, 'sanPhamDauTu'])->name('admin.san-pham-dau-tu');
    Route::post('/san-pham-dau-tu', [AdminController::class, 'storeSanPhamDauTu'])->name('admin.san-pham-dau-tu.store');
    Route::post('/san-pham-dau-tu/update', [AdminController::class, 'updateSanPhamDauTu'])->name('admin.san-pham-dau-tu.update');
    Route::post('/delete-san-pham-dau-tu', [AdminController::class, 'destroySanPhamDauTu'])->name('admin.san-pham-dau-tu.destroy');
    // end sản phẩm đầu tư
    //Ngân hàng nạp tiền
    Route::get('/ngan-hang-nap-tien', [AdminController::class, 'nganHangNapTien'])->name('admin.ngan-hang-nap-tien');
    Route::post('/ngan-hang-nap-tien', [AdminController::class, 'storeNganHangNapTien'])->name('admin.ngan-hang-nap-tien.store');
    Route::post('/ngan-hang-nap-tien/update', [AdminController::class, 'updateNganHangNapTien'])->name('admin.ngan-hang-nap-tien.update');
    Route::post('/delete-ngan-hang-nap-tien', [AdminController::class, 'destroyNganHangNapTien'])->name('admin.ngan-hang-nap-tien.destroy');
    // end Ngân hàng nạp tiền
});
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'postLogin'])->name('post-login');
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'postRegister'])->name('post-register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth','prefix' => 'dashboard'], function () {
    Route::get('/', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('dashboard.profile');
    // bao mat
    Route::get('/bao-mat', [UserDashboardController::class, 'baoMat'])->name('dashboard.bao-mat');
    Route::post('/change-password', [UserDashboardController::class, 'changePassword'])->name('user.change-password');
    Route::post('/change-withdrawal-password', [UserDashboardController::class, 'changeWithdrawalPassword'])->name('user.change-withdrawal-password');
    // end bao mat
    // Ngân hàng
    Route::get('/ngan-hang', [UserDashboardController::class, 'nganHang'])->name('dashboard.ngan-hang');
    Route::put('/ngan-hang/update', [UserDashboardController::class, 'updateBankInfo'])->name('user.bank.update');
    // end Ngân hàng
    // Nạp tiền
    Route::get('/nap-tien', [UserDashboardController::class, 'napTien'])->name('dashboard.nap-tien');
    // end Nạp tiền
});