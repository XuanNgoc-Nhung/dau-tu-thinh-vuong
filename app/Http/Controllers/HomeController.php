<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPhamDauTu;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm đầu tư có trạng thái active (giả sử 1 là active)
        $sanPhamDauTu = SanPhamDauTu::where('trang_thai', 1)
            ->orderBy('created_at', 'desc')
            ->limit(6) // Giới hạn 6 sản phẩm để hiển thị
            ->get();
        
        // Lấy dữ liệu giá vàng từ API BTMC
        $giaVangData = $this->getGiaVangDataDirect();
        
        // Lấy ra dataList từ giaVangData
        $dataList = $this->getDataListFromGiaVang($giaVangData);
        if ($dataList) {
            Log::info('DataList extracted successfully', ['count' => count($dataList)]);
        } else {
            Log::warning('DataList not found in giaVangData', ['giaVangData' => $giaVangData]);
        }
        return view('user.home', compact('sanPhamDauTu', 'giaVangData', 'dataList'));
    }
    
    /**
     * Lấy dữ liệu giá vàng trực tiếp từ API DOJI
     */
    private function getGiaVangDataDirect()
    {
        try {
            $link   = 'http://api.btmc.vn/api/BTMCAPI/getpricebtmc?key=3kd8ub1llcg9t45hnoh8hmn7t5kc2v';
            $response = Http::get($link);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Error fetching DOJI Gold data', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->getFallbackData();
        }
    }
    
    /**
     * Format tên hiển thị cho dữ liệu giá vàng
     */
    private function formatDisplayName($key)
    {
        $displayNames = [
            'SJC' => 'SJC',
            'PNJ' => 'PNJ',
            'DOJI' => 'DOJI',
            'BaoTinMinhChau' => 'Bảo Tín Minh Châu',
            'PhuQuySJC' => 'Phú Quý SJC',
            'MiHong' => 'Mi Hồng',
            'ThangLong' => 'Thăng Long',
            'Vang9999' => 'Vàng 9999',
            'Vang24K' => 'Vàng 24K',
            'Vang18K' => 'Vàng 18K',
            'Vang14K' => 'Vàng 14K',
            'Vang10K' => 'Vàng 10K',
            'VangSJC' => 'Vàng SJC',
            'VangPNJ' => 'Vàng PNJ',
            'VangDOJI' => 'Vàng DOJI'
        ];
        
        return $displayNames[$key] ?? ucfirst(str_replace('_', ' ', $key));
    }
    
    /**
     * Dữ liệu fallback khi API không khả dụng
     */
    private function getFallbackData()
    {
        return [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'raw_data' => null,
            'formatted_data' => [],
            'error' => 'Không thể tải dữ liệu giá vàng. Vui lòng thử lại sau.'
        ];
    }
    
    /**
     * Lấy dataList từ giaVangData
     */
    private function getDataListFromGiaVang($giaVangData)
    {
        if ($giaVangData && isset($giaVangData['DataList']['Data'])) {
            $dataList = $giaVangData['DataList']['Data'];
            
            // Log cấu trúc dữ liệu để debug
            if (!empty($dataList)) {
                Log::info('Sample dataList item structure', ['sample' => $dataList[0] ?? null]);
            }
            
            // Loại bỏ trùng lặp theo loại vàng
            return $this->removeDuplicateGoldTypes($dataList);
        }
        return null;
    }
    
    /**
     * Loại bỏ các bản ghi trùng nhau về loại vàng, chỉ giữ lại bản ghi có giá cập nhật gần nhất
     */
    private function removeDuplicateGoldTypes($dataList)
    {
        if (empty($dataList)) {
            return $dataList;
        }
        
        $groupedByType = [];
        
        // Nhóm các bản ghi theo loại vàng
        foreach ($dataList as $item) {
            $goldType = $item['@n_' . $item['@row']] ?? 'Unknown';
            
            if (!isset($groupedByType[$goldType])) {
                $groupedByType[$goldType] = [];
            }
            
            $groupedByType[$goldType][] = $item;
        }
        
        $result = [];
        
        // Với mỗi loại vàng, chọn bản ghi có thời gian cập nhật gần nhất
        foreach ($groupedByType as $goldType => $items) {
            if (count($items) === 1) {
                // Chỉ có 1 bản ghi, giữ nguyên
                $result[] = $items[0];
            } else {
                // Có nhiều bản ghi, chọn bản ghi có thời gian cập nhật gần nhất
                $latestItem = $this->getLatestItemByUpdateTime($items);
                $result[] = $latestItem;
                
                Log::info('Removed duplicate gold type', [
                    'gold_type' => $goldType,
                    'total_items' => count($items),
                    'kept_item' => $latestItem
                ]);
            }
        }
        
        Log::info('Duplicate removal completed', [
            'original_count' => count($dataList),
            'filtered_count' => count($result),
            'removed_count' => count($dataList) - count($result)
        ]);
        
        return $result;
    }
    
    /**
     * Tìm bản ghi có thời gian cập nhật gần nhất trong danh sách
     */
    private function getLatestItemByUpdateTime($items)
    {
        $latestItem = $items[0];
        $latestTime = $this->extractUpdateTime($items[0]);
        
        foreach ($items as $item) {
            $itemTime = $this->extractUpdateTime($item);
            
            if ($itemTime && (!$latestTime || $itemTime > $latestTime)) {
                $latestTime = $itemTime;
                $latestItem = $item;
            }
        }
        
        return $latestItem;
    }
    
    /**
     * Trích xuất thời gian cập nhật từ item
     */
    private function extractUpdateTime($item)
    {
        // Thử các trường có thể chứa thời gian cập nhật
        $timeFields = [
            '@d_' . $item['@row'], // Trường ghi chú có thể chứa thời gian
            'updated_at',
            'timestamp',
            'time'
        ];
        
        foreach ($timeFields as $field) {
            if (isset($item[$field]) && !empty($item[$field])) {
                $timeValue = $item[$field];
                
                // Thử parse thời gian
                $timestamp = strtotime($timeValue);
                if ($timestamp !== false) {
                    return $timestamp;
                }
            }
        }
        
        // Nếu không tìm thấy thời gian, trả về null
        return null;
    }
    
    /**
     * Làm mới dữ liệu giá vàng
     */
    public function refreshGiaVang()
    {
        $giaVangData = $this->getGiaVangDataDirect();
        
        // Lấy ra dataList từ giaVangData (đã được loại bỏ trùng lặp)
        $dataList = $this->getDataListFromGiaVang($giaVangData);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $giaVangData,
                'dataList' => $dataList,
                'message' => 'Dữ liệu giá vàng đã được cập nhật và loại bỏ trùng lặp'
            ]);
        }
        
        return redirect()->back()->with('success', 'Dữ liệu giá vàng đã được cập nhật và loại bỏ trùng lặp');
    }
    
    public function dashboard()
    {
        return view('user.dashboard');
    }
    
    /**
     * API endpoint để lấy dataList từ giaVangData (đã loại bỏ trùng lặp)
     */
    public function getGiaVangDataList()
    {
        $giaVangData = $this->getGiaVangDataDirect();
        $dataList = $this->getDataListFromGiaVang($giaVangData);
        
        return response()->json([
            'success' => true,
            'dataList' => $dataList,
            'count' => $dataList ? count($dataList) : 0,
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'note' => 'Dữ liệu đã được loại bỏ trùng lặp theo loại vàng'
        ]);
    }
    
}
