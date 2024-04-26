@extends('Layouts.HeaderMem')
@section('title', '工單清單')
@section('content')
    @include('Layouts.HeaderWOM')

    <div class="container">
        <div class="mb-4">
            <form action="" method="get">
                <div class="d-flex flex-wrap justify-content-center ">
                    <div class="input-group me-2" style="width: 250px">
                        <span class="input-group-text">入廠日起</span>
                        <input type="date" class="form-control" id='wo_in_date1' name='wo_in_date1'
                            value="{{ $wo_in_date1 }}">
                    </div>
                    <div class="input-group me-2" style="width: 250px">
                        <span class="input-group-text">入廠日訖</span>
                        <input type="date" class="form-control" id='wo_in_date2' name='wo_in_date2'
                            value="{{ $wo_in_date2 }}">
                    </div>
                    <div class="input-group me-2" style="width: 250px">
                        <span class="input-group-text">車主</span>
                        <input type="text" class="form-control" id='vehicle_owner' name='vehicle_owner' value="{{$vehicle_owner}}">
                    </div>
                    <div class="input-group me-2" style="width: 250px">
                        <span class="input-group-text">車牌</span>
                        <input type="text" class="form-control" id='vehicle_number' name='vehicle_number' value="{{$vehicle_number}}">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class='btn btn-primary'>查詢</button>
                </div>
            </form>
        </div>
        <div class='table-responsive'>
            <table id='mwol_table' class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">工單號碼</th>
                        <th scope="col">請修編號</th>
                        <th scope="col">入廠日期</th>
                        <th scope="col">入廠時間</th>
                        <th scope="col">車牌號碼</th>
                        <th scope="col">公里數</th>
                        <th scope="col">車主簡稱</th>
                        <th scope="col">出廠日期</th>
                        <th scope="col">出廠時間</th>
                        <th scope="col">維修時數</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($work_order_main as $v)
                        <tr>
                            <td class="">
                                <a href="{{ route('MemberWorkOrderEdit', ['wo_number' => $v->wo_number]) }}"
                                    class='btn btn-warning'>編輯</a>
                            </td>
                            <td>{{ $v->wo_number }}</td>
                            <td>{{ $v->repair_order }}</td>
                            <td>{{ $v->wo_in_date }}</td>
                            <td>{{ $v->wo_in_time }}</td>
                            <td>{{ $v->vehicle_number }}</td>
                            <td>{{ $v->vehicle_km }}</td>
                            <td>{{ $v->vehicle_owner }}</td>
                            <td>{{ $v->wo_out_date }}</td>
                            <td>{{ $v->wo_out_time }}</td>
                            <td>{{ $v->wo_m_hours }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $('#mwol_table').DataTable({
            "language": {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/zh-HANT.json',
            },
            "stateSave": true,
            "pageLength": 8, // 預設每頁顯示
            "lengthMenu": [8, 16, 32, 64] // 可選擇的每頁顯示
        });
    </script>

@endsection
