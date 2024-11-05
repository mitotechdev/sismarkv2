<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UniqueNumber {
    public static function generateNumberSalesOrder() {
        $prefix = 'PO-';
        $currentDate = date('y') . date('m');

        try {
            $latestNumber = DB::table('sales_orders')
                ->where('code', 'like', $prefix . $currentDate . '%')
                ->orderBy('code', 'desc')
                ->value(DB::raw('CAST(SUBSTRING(code, 9, 5) AS UNSIGNED)'));

            if(!$latestNumber) {
                $latestNumber = 0;
            }

            $nextNumber = $latestNumber + 1;
            $formattedNumber = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $uniqueNumber = $prefix . $currentDate . $formattedNumber;
            return $uniqueNumber;

        } catch (\Exception $e) {
            Log::error('Failed to generate unique number: ' . $e->getMessage());
            throw $e;
        }
    }
}


