<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function getDistricts() {
        $params = request()->all();
        
        try {
            if (data_get($params, 'matp')) {
                $districts = DB::select('SELECT maqh,name FROM devvn_quanhuyen WHERE matp = ?', [$params['matp']]);
                
                return [
                    'status' => true,
                    'districts' => $districts
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'status' => false
            ];
        }
    }

    public function getWards() {
        $params = request()->all();
        
        try {
            if (data_get($params, 'maqh')) {
                $wards = DB::select('SELECT xaid,name FROM devvn_xaphuongthitran WHERE maqh = ?', [$params['maqh']]);
                
                return [
                    'status' => true,
                    'wards' => $wards
                ];
            }
        } catch (\Exception $e) {
            Log::error($e);

            return [
                'status' => false
            ];
        }
    }
}
