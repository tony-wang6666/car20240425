<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Members\WorkOrderController; 
use App\Http\Controllers\LoginController; 

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

Route::match(['get', 'post'],'/', [LoginController::class, 'Login'])->name('Login');
Route::match(['get', 'post'],'/Login', [LoginController::class, 'Login'])->name('Login'); 
Route::match(['get', 'post'],'/Logout', [LoginController::class, 'Logout'])->name('Logout'); 



Route::match(['get', 'post'],'/MemberWorkOrderAdd', [WorkOrderController::class, 'MemberWorkOrderAdd'])->name('MemberWorkOrderAdd'); //新增工單
Route::match(['get', 'post'],'/MemberWorkOrderEdit', [WorkOrderController::class, 'MemberWorkOrderEdit'])->name('MemberWorkOrderEdit'); //編輯工單
Route::match(['get', 'post'],'/MemberWorkOrderList', [WorkOrderController::class, 'MemberWorkOrderList'])->name('MemberWorkOrderList'); //工單清單

// Route::match(['get', 'post'],'/WODetailDelete', [WorkOrderController::class, 'WODetailDelete'])->name('WODetailDelete'); //工單明細刪除(被編輯取代)


//ajax 1
Route::match(['post'],'/get_wo_number', [WorkOrderController::class, 'get_wo_number'])->name('get_wo_number'); #獲取工單編號
Route::match(['post'],'/vehicle_data', [WorkOrderController::class, 'vehicle_data'])->name('vehicle_data'); #獲取汽車資料
// Route::match(['post'],'/vehicle_part_data', [WorkOrderController::class, 'vehicle_part_data'])->name('vehicle_part_data'); #獲取汽車零件資料 被tr_wo_detail_add() 取代
Route::match(['get'],'/tr_wo_detail_add', [WorkOrderController::class, 'tr_wo_detail_add'])->name('tr_wo_detail_add'); #明細列
Route::match(['get'],'/m_part_information', [WorkOrderController::class, 'm_part_information'])->name('m_part_information'); #零件資料
Route::match(['get'],'/m_tire_information', [WorkOrderController::class, 'm_tire_information'])->name('m_tire_information'); #輪胎資料

