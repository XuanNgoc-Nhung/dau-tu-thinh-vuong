<?php

namespace App\Helpers;

class TimeHelper
{
    /**
     * Chuyển đổi thời gian từ giờ sang đơn vị phù hợp
     * 
     * @param int $hours Số giờ
     * @return array Mảng chứa ['value' => số, 'unit' => đơn vị, 'display' => chuỗi hiển thị]
     */
    public static function convertHoursToAppropriateUnit($hours)
    {
        if ($hours < 24) {
            return [
                'value' => $hours,
                'unit' => 'giờ',
                'display' => $hours . ' giờ'
            ];
        }
        
        $days = floor($hours / 24);
        if ($days < 7) {
            return [
                'value' => $days,
                'unit' => 'ngày',
                'display' => $days . ' ngày'
            ];
        }
        
        $weeks = floor($days / 7);
        if ($weeks < 4) {
            return [
                'value' => $weeks,
                'unit' => 'tuần',
                'display' => $weeks . ' tuần'
            ];
        }
        
        $months = floor($days / 30);
        if ($months < 12) {
            return [
                'value' => $months,
                'unit' => 'tháng',
                'display' => $months . ' tháng'
            ];
        }
        
        $years = floor($days / 365);
        return [
            'value' => $years,
            'unit' => 'năm',
            'display' => $years . ' năm'
        ];
    }
    
    /**
     * Chuyển đổi thời gian từ giờ sang đơn vị phù hợp cho hiển thị
     * 
     * @param int $hours Số giờ
     * @return string Chuỗi hiển thị thời gian
     */
    public static function formatTimeFromHours($hours)
    {
        $converted = self::convertHoursToAppropriateUnit($hours);
        return $converted['display'];
    }
    
    /**
     * Tính tổng thời gian cho nhiều chu kỳ
     * 
     * @param int $hoursPerCycle Số giờ mỗi chu kỳ
     * @param int $cycles Số chu kỳ
     * @return string Chuỗi hiển thị tổng thời gian
     */
    public static function formatTotalTimeForCycles($hoursPerCycle, $cycles)
    {
        $totalHours = $hoursPerCycle * $cycles;
        return self::formatTimeFromHours($totalHours);
    }
}