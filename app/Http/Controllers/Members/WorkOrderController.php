<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpController;
use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;


class WorkOrderController extends Controller
{
    public function MemberWorkOrder(Request $request){
        if (request()->isMethod('GET')) {
            $DB_set__wod_type = DB::table('set__wod_type')->get(); //維修類別
            $DB_set__wod_fault = DB::table('set__wod_fault')->get(); //故障原因
            $DB_s_technician = DB::table('staff_information')->where('s_delete','0')->where('s_technician','1')->get();
            $DB_set__no_money_remark = DB::table('set__no_money_remark')->get(); //不請款原因
            return view('Member.MemberWorkOrder',[
                'DB_set__wod_type' => $DB_set__wod_type,
                'DB_set__wod_fault' => $DB_set__wod_fault,
                'DB_s_technician' => $DB_s_technician,
                'DB_set__no_money_remark' => $DB_set__no_money_remark,
            ]);
        }elseif (request()->isMethod('POST')) {
            // $now = Carbon::now();
            // $now->setTimezone('Asia/Taipei');
            // $today = $now->toDateString();
            // $wo_number_id = DB::table("work_order_main")->whereDate('created_at',$today)->count() + 1;
            // $area_character = DB::table("set__area_character")->where('id',1)->first()->s_name;
            // $cdate = $now->year - 1911 . str_pad($now->month, 2, '0', STR_PAD_LEFT) . str_pad($now->day, 2, '0', STR_PAD_LEFT);
            $wo_number = HelpController::create_wo_number();
            //工單
            DB::table('work_order_main')->insert([
                'wo_number' => $wo_number,
                'wo_type' => $request->wo_type,
                'wo_in_date' => $request->wo_in_date,
                'wo_in_time' => $request->wo_in_time,
                'wo_out_date' => $request->wo_out_date,
                'wo_out_time' => $request->wo_out_time,
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
            foreach ($request->wod_part_id as $k => $v) {
                // if(!$v) continue; //沒有零件編號就跳過 ，暫時先不跳過
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
    public function vehicle_part_data(Request $request){ //獲取載具零件資料
        if (request()->isMethod('POST')) {
            $vehicle_area_type = $request->vehicle_area_type; //區隊
            $wod_part_id = $request->wod_part_id; //
            // return response()->json([
            //     "pi" => $wod_part_id,
            // ]);
            $DB_set__vehicle_area_type = DB::table('set__vehicle_area_type')
            ->select('s_discount')
            ->where('s_name',$vehicle_area_type)->first();

            $DB_part_information = DB::table('set__part_information')
            ->select('s_name', 's_unit', 's_money')
            ->where('s_delete','0')
            ->where('part_id',$wod_part_id)->first();
            if($DB_part_information){ //折扣計算
                $DB_part_information->s_money = round($DB_part_information->s_money * $DB_set__vehicle_area_type->s_discount);
            }
            

            
            return response()->json([
                "pi" => $DB_part_information,
            ]);
        }
    }
    public function tr_wo_detail_add(Request $request){ //明細列
        if (request()->isMethod('GET')) {
            $tr_num = $request->tr_num + 1;
            $tr = "<tr>
                <th scope='row'>".$tr_num."</th>
                <td><input type='text' class='form-control form-control-sm' name='wod_type[]' list='dl_wod_type'></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_fault[]' list='dl_wod_fault'></td>
                <td><input type='text' class='form-control form-control-sm bg-primary-subtle change_wod_part_id' name='wod_part_id[]' ></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_part_name[]' ></td>
                <td><input type='number' class='form-control form-control-sm' name='wod_part_number[]' ></td>
                <td><input type='text' class='form-control form-control-sm' name='wod_part_unit[]' ></td>
                <td><input type='number' class='form-control form-control-sm' name='wod_port_money[]' ></td>
                <td><input type='number' class='form-control form-control-sm' name='money_total[]' readonly></td>
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
            return response()->json([
                "table_mpi" => $DB_set__part_information,
            ]);
        }
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
