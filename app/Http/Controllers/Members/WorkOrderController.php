<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt; //加密解密
use Illuminate\Contracts\Encryption\DecryptException; //加密解密 try catch

use DB;
use Carbon\Carbon;


class WorkOrderController extends Controller
{
    public static $web_access = 'MemberWorkOrder'; #頁面權限
    public static $c_types = ['一般客戶','環保局']; #頁面權限


    public function MemberWorkOrderList(Request $request){
        $web_access = self::$web_access;
        if(!in_array($web_access,session('WebAccess') ?? [])) return redirect()->route('Login');

        $now = Carbon::now();
        $now->setTimezone('Asia/Taipei');
        $year = $now->year;
        $end_date = $now->toDateString();
        $start_date = Carbon::parse($end_date)->subYear(2)->toDateString();
        $wo_in_date1 = $request->wo_in_date1 ?? $start_date;
        $wo_in_date2 = $request->wo_in_date2 ?? $end_date;
        $vehicle_owner = $request->vehicle_owner;
        $vehicle_number = $request->vehicle_number;

        if (request()->isMethod('GET')) {
            $work_order_main = DB::table('work_order_main as w1')
            ->selectRaw("w1.*, 
                CONCAT(RIGHT(YEAR(wo_in_date_si) - 1911, 2), LPAD(MONTH(wo_in_date_si), 2, '0'), s2.s_number, LPAD(w1.repair_order, 3, '0')) AS repair_order
            ")
            ->join('set__vehicle_area_type as s2', 'w1.vehicle_area_type', '=', 's2.s_name')
            ->whereBetween('wo_in_date', [$wo_in_date1, $wo_in_date2])
            ->where('vehicle_owner', 'like', '%' . $vehicle_owner . '%')
            ->where('vehicle_number', 'like', '%' . $vehicle_number . '%')
            ->orderBy('repair_order')
            ->get();
            

            // return $work_order_main;
            
            return view('Member.WorkOrder.MemberWorkOrderList',[
                'page' => 'wo_page',
                'work_order_main' => $work_order_main,
                'wo_in_date1' => $wo_in_date1,
                'wo_in_date2' => $wo_in_date2,
                'vehicle_owner' => $vehicle_owner,
                'vehicle_number' => $vehicle_number,
            ]);
            
            
            return $work_order_main;
        }elseif (request()->isMethod('POST')) {

        }
    }

    public function MemberWorkOrderAdd(Request $request){
        $web_access = self::$web_access;
        $c_types = self::$c_types;
        if(!in_array($web_access,session('WebAccess') ?? [])) return redirect()->route('Login');
        
        if (request()->isMethod('GET')) {
            $DB_set__wod_type = DB::table('set__wod_type')->get(); //維修類別
            $DB_set__wod_fault = DB::table('set__wod_fault')->get(); //故障原因
            $DB_s_technician = DB::table('staff_information')->where('s_delete','0')->where('s_technician','1')->get();
            $DB_set__no_money_remark = DB::table('set__no_money_remark')->get(); //不請款原因
            $DB_set__no_money_remark = DB::table('set__no_money_remark')->get(); //客戶類別
            return view('Member.WorkOrder.MemberWorkOrderAdd',[
                'page' => 'wo_page',
                'c_types' => $c_types,
                'DB_set__wod_type' => $DB_set__wod_type,
                'DB_set__wod_fault' => $DB_set__wod_fault,
                'DB_s_technician' => $DB_s_technician,
                'DB_set__no_money_remark' => $DB_set__no_money_remark,
            ]);
        }elseif (request()->isMethod('POST')) {
            $wo_number = HelpController::create_wo_number();
            //工單
            DB::table('work_order_main')->insert([
                'wo_number' => $wo_number,
                'wo_type' => $request->wo_type,
                'wo_in_date' => $request->wo_in_date,
                'wo_in_time' => $request->wo_in_time,
                'wo_out_date' => $request->wo_out_date,
                'wo_out_time' => $request->wo_out_time,
                'wo_m_hours' => $request->wo_m_hours,
                'c_type' => $request->c_type,
                'vehicle_number' => $request->vehicle_number,
                'vehicle_km' => $request->vehicle_km,
                'vehicle_owner' => $request->vehicle_owner,
                'c_tel' => $request->c_tel,
                'vehicle_capacity' => $request->vehicle_capacity,
                'vehicle_tonnes' => $request->vehicle_tonnes,
                'vehicle_y' => $request->vehicle_y,
                'vehicle_area_type' => $request->vehicle_area_type,
                'contract' => $request->contract,
                'repair_remark' => $request->repair_remark,
                'wo_money' => $request->wo_money,
                'wo_money_tax_type' => $request->wo_money_tax_type,
                'wo_money_tax' => $request->wo_money_tax,
                'last_owe' => $request->last_owe,
                'sugggest_money' => $request->sugggest_money,
                'this_owe' => $request->this_owe,
                'receive_money' => $request->receive_money,
                'wo_in_date_si' => $request->wo_in_date_si,
                'wo_out_date_si' => $request->wo_out_date_si,
            ]);

            //工單明細
            foreach ($request->wod_part_name as $k => $v) {
                if(!$v) continue; //沒有零件名稱就跳過 
                $wod_part_id = str_replace(' ', '', $request->wod_part_id[$k]);
                DB::table('work_order_detail')->insert([
                    'wo_number' => $wo_number,
                    'wod_type' => $request->wod_type[$k],
                    'wod_fault' => $request->wod_fault[$k],
                    'wod_part_id' => $wod_part_id,
                    'wod_part_name' => $request->wod_part_name[$k],
                    'wod_part_number' => $request->wod_part_number[$k],
                    'wod_part_unit' => $request->wod_part_unit[$k],
                    'wod_port_money' => $request->wod_port_money[$k],
                    'wod_money_total' => $request->wod_money_total[$k],
                    'wod_technician_1' => $request->wod_technician_1[$k],
                    'wod_technician_2' => $request->wod_technician_2[$k],
                    'wod_remark' => $request->wod_remark[$k],
                    'no_money_remark' => $request->no_money_remark[$k],
                ]);
            }
            session()->flash('message', '工單新增成功');
            return redirect()->back();
        }
    }

    public function MemberWorkOrderEdit(Request $request){
        $web_access = self::$web_access;
        $c_types = self::$c_types;
        if(!in_array($web_access,session('WebAccess') ?? [])) return redirect()->route('Login');

        if (request()->isMethod('GET')) {
            if(!$wo_number = $request->wo_number) return 'error';
            //工單主檔
            $wo_main = DB::table("work_order_main")
            ->where('wo_number', $wo_number)
            ->first();
            if(!$wo_main) return 'error';
            
            $DB_set__wod_type = DB::table('set__wod_type')->get(); //維修類別
            $DB_set__wod_fault = DB::table('set__wod_fault')->get(); //故障原因
            $DB_s_technician = DB::table('staff_information')->where('s_delete','0')->where('s_technician','1')->get();
            $DB_set__no_money_remark = DB::table('set__no_money_remark')->get(); //不請款原因

            //工單明細
            $wo_detail = DB::table("work_order_detail")
            ->where('wod_delete', 0)
            ->where('wo_number', $wo_number)
            ->get();

            return view('Member.WorkOrder.MemberWorkOrderEdit',[
                'page' => 'wo_page',
                'c_types' => $c_types,
                'DB_set__wod_type' => $DB_set__wod_type,
                'DB_set__wod_fault' => $DB_set__wod_fault,
                'DB_s_technician' => $DB_s_technician,
                'DB_set__no_money_remark' => $DB_set__no_money_remark,
                'wo_main' => $wo_main,
                'wo_detail' => $wo_detail,
            ]);


        }elseif(request()->isMethod('POST')){
            DB::table('work_order_main')
            ->where('wo_number', $request->wo_number)
            ->update([
                'wo_type' => $request->wo_type,
                'wo_in_date' => $request->wo_in_date,
                'wo_in_time' => $request->wo_in_time,
                'wo_out_date' => $request->wo_out_date,
                'wo_out_time' => $request->wo_out_time,
                'wo_m_hours' => $request->wo_m_hours,
                'c_type' => $request->c_type,
                'vehicle_number' => $request->vehicle_number,
                'vehicle_km' => $request->vehicle_km,
                'vehicle_owner' => $request->vehicle_owner,
                'c_tel' => $request->c_tel,
                'vehicle_capacity' => $request->vehicle_capacity,
                'vehicle_tonnes' => $request->vehicle_tonnes,
                'vehicle_y' => $request->vehicle_y,
                'vehicle_area_type' => $request->vehicle_area_type,
                'contract' => $request->contract,
                'repair_remark' => $request->repair_remark,
                'wo_money' => $request->wo_money,
                'wo_money_tax_type' => $request->wo_money_tax_type,
                'wo_money_tax' => $request->wo_money_tax,
                'last_owe' => $request->last_owe,
                'sugggest_money' => $request->sugggest_money,
                'this_owe' => $request->this_owe,
                'receive_money' => $request->receive_money,
                'wo_in_date_si' => $request->wo_in_date_si,
                'wo_out_date_si' => $request->wo_out_date_si,
            ]);

            //工單明細
            foreach ($request->wod_part_name as $k => $v) {
                if(!$v) continue; //沒有零件名稱就跳過 
                $wod_part_id = str_replace(' ', '', $request->wod_part_id[$k]);
                DB::table('work_order_detail')->updateOrInsert(
                    [ 'id'=> $request->ids[$k] ],
                    [
                        'wo_number' => $request->wo_number,
                        'wod_type' => $request->wod_type[$k],
                        'wod_fault' => $request->wod_fault[$k],
                        'wod_part_id' => $wod_part_id,
                        'wod_part_name' => $request->wod_part_name[$k],
                        'wod_part_number' => $request->wod_part_number[$k],
                        'wod_part_unit' => $request->wod_part_unit[$k],
                        'wod_port_money' => $request->wod_port_money[$k],
                        'wod_money_total' => $request->wod_money_total[$k],
                        'wod_technician_1' => $request->wod_technician_1[$k],
                        'wod_technician_2' => $request->wod_technician_2[$k],
                        'wod_remark' => $request->wod_remark[$k],
                        'no_money_remark' => $request->no_money_remark[$k],
                    ]
                );
            }

            //工單明細刪除
            if($request->delete_datas){
                foreach ($request->delete_datas as $k => $v) {
                    try {
                        $id = Crypt::decryptString($v);
                    } catch (DecryptException $e) {
                        return 'error';
                    }
                    DB::table('work_order_detail')->where('id',$id)->update(['wod_delete'=>1]);
                }
            }

            session()->flash('message', '修改成功');
            return redirect()->back();
        }


    }
    
    // public function WODetailDelete(Request $request){ //被 編輯 取代
    //     try {
    //         $data = Crypt::decryptString($request->data);
    //     } catch (DecryptException $e) {
    //         return 'error';
    //     }
    //     $id = $data;
    //     DB::table('work_order_detail')->where('id',$id)->update(['wod_delete'=>1]);
    //     return redirect()->back();
    // }


    #--ajax--
    public function vehicle_data(Request $request){ //獲取載具資料
        if (request()->isMethod('POST')) {
            $vehicle_number = $request->vehicle_number;

            $DB_vehicle_information = DB::table('vehicle_information')
            ->select('vehicle_owner','c_tel','vehicle_capacity','vehicle_tonnes','vehicle_y','vehicle_area_type','contract','c_type')
            ->where('vehicle_delete','0')->where('vehicle_number',$vehicle_number)->first();
            
            return response()->json([
                "vi" => $DB_vehicle_information,
            ]);
        }
    }
    // public function vehicle_part_data(Request $request){ //獲取載具零件資料 //被tr_wo_detail_add() 取代
    //     if (request()->isMethod('POST')) {
    //         $vehicle_area_type = $request->vehicle_area_type; //區隊
    //         $wod_part_id = $request->wod_part_id; //
    //         // return response()->json([
    //         //     "pi" => $wod_part_id,
    //         // ]);
    //         $DB_set__vehicle_area_type = DB::table('set__vehicle_area_type')
    //         ->select('s_discount')
    //         ->where('s_name',$vehicle_area_type)->first();

    //         $DB_part_information = DB::table('set__part_information')
    //         ->select('s_name', 's_unit', 's_money')
    //         ->where('s_delete','0')
    //         ->where('part_id',$wod_part_id)->first();
    //         if($DB_part_information){ //折扣計算
    //             $DB_part_information->s_money = round($DB_part_information->s_money * $DB_set__vehicle_area_type->s_discount);
    //         }
            

            
    //         return response()->json([
    //             "pi" => $DB_part_information,
    //         ]);
    //     }
    // }
    public function tr_wo_detail_add(Request $request){ //明細列
        if (request()->isMethod('GET')) {
            $type = $request->type; //0 = 空的， 1 = 有帶編碼
            $part_id = $request->partid;
            $vehicle_area_type = $request->vehicle_area_type; //區隊
            $wod_type = $request->wod_type; //維修類別
            $wod_fault = $request->wod_fault; //故障原因
            $part_type = $request->part_type; //零件類別
            
            // 折數 
            $s_discount_col = 's_money_97'; //預設值
            $DB_set__vehicle_area_type = DB::table('set__vehicle_area_type')->where('s_name',$vehicle_area_type)->first();
            if($DB_set__vehicle_area_type) $s_discount_col = $DB_set__vehicle_area_type->s_discount_col;
            
            // 零件資料帶入
            $wod_part_id = '';
            $wod_part_name = '';
            $wod_part_number = '';
            $wod_part_unit = '';
            $wod_port_money = 0;
            $wod_money_total = 0;

            $part_information = "";
            if($part_type == 'part'){
                $part_information = DB::table('set__part_information')->where('part_id',$part_id)->first();
            }else if($part_type == 'tire'){
                $part_information = DB::table('set__tire_information')->where('part_id',$part_id)->first();
            }

            if($part_information){
                $wod_part_id = $part_information->part_id;
                $wod_part_name = $part_information->s_name; // 零件名稱
                $wod_part_number = 1; //零件數量 預設值
                $wod_part_unit = $part_information->s_unit;
                $wod_port_money = $part_information->$s_discount_col;
                $wod_money_total = $wod_part_number * $wod_port_money;
            }

            $tr = "<tr>
                <input type='hidden' name='ids[]' value=''>
                <td></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_type[]' list='dl_wod_type' value='".$wod_type."'></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_fault[]' list='dl_wod_fault' value='".$wod_fault."'></td>
                <td><input type='text' class='form-control form-control-sm bg-primary-subtle change_wod_part_id' name='wod_part_id[]' value=".$wod_part_id." ></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_part_name[]' value=".$wod_part_name." ></td>
                <td><input type='number' class='form-control form-control-sm' name='wod_part_number[]' value=".$wod_part_number." ></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_part_unit[]' value=".$wod_part_unit." ></td>
                <td><input type='number' class='form-control form-control-sm' name='wod_port_money[]' value=".$wod_port_money." ></td>
                <td><input type='number' class='form-control form-control-sm' name='wod_money_total[]' value=".$wod_money_total." ></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_technician_1[]' list='dl_wod_technician'></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_technician_2[]' list='dl_wod_technician'></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_remark[]' ></td>
                <td><input type='text' class='form-control form-control-sm' name='no_money_remark[]' list='dl_no_money_remark' ></td>
            </tr>";

            return response()->json([
                "tr" => $tr,
            ]);
        }
    }
    public function m_part_information(Request $request){ //零件資料
        if (request()->isMethod('GET')) {
            // $DB_set__part_information = DB::table('set__part_information')->where('s_delete','0')->limit(5)->get();
            $DB_set__part_information = DB::table('set__part_information')->where('s_delete','0')->get();
            foreach ($DB_set__part_information as $k => $v) {
                $v->in_part_id = "<button class='btn btn-success in_part_id' data-partid='".$v->part_id."' >+</button>";
            }
            return response()->json([
                "table_mpi" => $DB_set__part_information,
            ]);
        }
    }
    public function m_tire_information(Request $request){ //輪胎資料
        if (request()->isMethod('GET')) {
            $DB_set__tire_information = DB::table('set__tire_information')->where('s_delete','0')->get();
            foreach ($DB_set__tire_information as $k => $v) {
                $v->in_part_id = "<button class='btn btn-success in_tire_id' data-partid='".$v->part_id."' >+</button>";
            }
            return response()->json([
                "table_mti" => $DB_set__tire_information,
            ]);
        }
    }
    public function wod_money_total(Request $request){
        $s_acc = session('LoginAcc' ); #會員編號
        if(!$s_acc) return redirect()->route('Login');

        $part_id = $request->part_id;
        $s_name = $request->s_name;


        $s_money_col = ""; //價格類型(使用的價格欄位)
        return $s_name;
    }

    #example
    // public function example(Request $request){
    //     if (request()->isMethod('GET')) {
    //         return view('Member.MemberWorkOrder',[
    //         ]);
    //     }elseif (request()->isMethod('POST')) {
    //         return $request->all();

    //     }
    // }


    


}
