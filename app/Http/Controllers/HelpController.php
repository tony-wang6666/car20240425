<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;

class HelpController extends Controller
{
    public static function create_wo_number(){ //工單號碼
        $now = Carbon::now();
        $now->setTimezone('Asia/Taipei');
        $today = $now->toDateString();
        $wo_number_id = DB::table("work_order_main")->whereDate('created_at',$today)->count() + 1;
        $area_character = DB::table("set__area_character")->where('id',1)->first()->s_name;
        $cdate = $now->year - 1911 . str_pad($now->month, 2, '0', STR_PAD_LEFT) . str_pad($now->day, 2, '0', STR_PAD_LEFT);
        return $area_character.'A'.$cdate.str_pad($wo_number_id, 3, '0', STR_PAD_LEFT);
    }
}
