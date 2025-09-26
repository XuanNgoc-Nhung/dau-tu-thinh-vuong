<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPhamDauTu;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm đầu tư có trạng thái active (giả sử 1 là active)
        $sanPhamDauTu = SanPhamDauTu::where('trang_thai', 1)
            ->orderBy('created_at', 'desc')
            ->limit(6) // Giới hạn 6 sản phẩm để hiển thị
            ->get();
            
        return view('user.home', compact('sanPhamDauTu'));
    }
    
    public function dashboard()
    {
        return view('user.dashboard');
    }
}
