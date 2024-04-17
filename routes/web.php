<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Members\WorkOrderController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::match(['get', 'post'],'/', [WorkOrderController::class, 'MemberWorkOrder'])->name('MemberWorkOrder'); #首頁
Route::match(['get', 'post'],'/MemberWorkOrder', [WorkOrderController::class, 'MemberWorkOrder'])->name('MemberWorkOrder'); #首頁



//ajax
Route::match(['post'],'/vehicle_data', [WorkOrderController::class, 'vehicle_data'])->name('vehicle_data'); #獲取汽車資料
Route::match(['post'],'/vehicle_part_data', [WorkOrderController::class, 'vehicle_part_data'])->name('vehicle_part_data'); #獲取汽車零件資料
Route::match(['get'],'/tr_wo_detail_add', [WorkOrderController::class, 'tr_wo_detail_add'])->name('tr_wo_detail_add'); #明細列
Route::match(['get'],'/m_part_information', [WorkOrderController::class, 'm_part_information'])->name('m_part_information'); #零件資料

