@extends('Layouts.HeaderMem')
@section('title', '修改工單')
@section('content')
    @include('Layouts.HeaderWOM')
    <form action="" method="post" class='no_submit'>
        @csrf
        <div class="container-fluid">
            <div class="d-flex flex-wrap justify-content-center ">
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">入廠日期</span>
                        <input type="date" class="form-control" id='wo_in_date' name='wo_in_date'
                            value="{{ old('wo_in_date', $wo_main->wo_in_date) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">入廠時間</span>
                        <input type="time" class="form-control" id='wo_in_time' name='wo_in_time'
                            value="{{ old('wo_in_time', $wo_main->wo_in_time) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">出廠日期</span>
                        <input type="date" class="form-control" id='wo_out_date' name='wo_out_date'
                            value="{{ old('wo_out_date', $wo_main->wo_out_date) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">出廠時間</span>
                        <input type="time" class="form-control" id='wo_out_time' name='wo_out_time'
                            value="{{ old('wo_out_time', $wo_main->wo_out_time) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">維修時數</span>
                        <input type="text" class="form-control bg-body-secondary" id='wo_m_hours' name='wo_m_hours'
                            value="{{ old('wo_m_hours', $wo_main->wo_m_hours) }}">
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">車牌號碼</span>
                        <input type="text" class="form-control bg-primary-subtle" id='vehicle_number'
                            name='vehicle_number' value="{{ old('vehicle_number', $wo_main->vehicle_number) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">公里數　</span>
                        <input type="text" class="form-control" id='vehicle_km' name='vehicle_km'
                            value="{{ old('vehicle_km', $wo_main->vehicle_km) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">車主簡稱</span>
                        <input type="text" class="form-control bg-body-secondary" id='vehicle_owner' name='vehicle_owner'
                            value="{{ old('vehicle_owner', $wo_main->vehicle_owner) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">電話　　</span>
                        <input type="text" class="form-control bg-body-secondary" id='c_tel' name='c_tel'
                            value="{{ old('c_tel', $wo_main->c_tel) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">車種容量</span>
                        <input type="text" class="form-control bg-body-secondary" id='vehicle_capacity'
                            name='vehicle_capacity' value="{{ old('vehicle_capacity', $wo_main->vehicle_capacity) }}">
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">廠牌噸數</span>
                        <input type="text" class="form-control bg-body-secondary" id='vehicle_tonnes'
                            name='vehicle_tonnes' value="{{ old('vehicle_tonnes', $wo_main->vehicle_tonnes) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">年份　　</span>
                        <input type="text" class="form-control bg-body-secondary" id='vehicle_y' name='vehicle_y'
                            value="{{ old('vehicle_y', $wo_main->vehicle_y) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">區隊　　</span>
                        <input type="text" class="form-control bg-body-secondary" id='vehicle_area_type'
                            name='vehicle_area_type' value="{{ old('vehicle_area_type', $wo_main->vehicle_area_type) }}">
                    </div>
                    {{-- <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                    <span class="input-group-text" >二次進廠</span>
                    <input type="text" class="form-control bg-body-secondary" id='' name='' >
                </div> --}}
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">合約　　</span>
                        <input type="text" class="form-control bg-body-secondary" id='contract' name='contract'
                            value="{{ old('contract', $wo_main->contract) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">客戶類別</span>
                        <select name="c_types" id="c_types" class="form-control bg-body-secondary">
                            @foreach ($c_types as $v)
                                <option value="{{ $v }}" @selected($v == $wo_main->c_type)>{{ $v }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <input type="text" class="form-control bg-body-secondary" id='c_type' name='c_type'
                            value="{{ old('c_type', $wo_main->c_type) }}"> --}}
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm pb-1 me-1 h-100 " style="width: 200px">
                        <span class="input-group-text">維修建議</span>
                        <textarea class="form-control" id='repair_remark' name='repair_remark' cols="30">{{ old('repair_remark', $wo_main->repair_remark) }}</textarea>
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 150px">
                        <span class="input-group-text">金額　　</span>
                        <input type="number" class="form-control bg-body-secondary" id='wo_money' name='wo_money'
                            value="{{ old('wo_money', $wo_main->wo_money) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 150px">
                        <span class="input-group-text">稅額別　</span>
                        {{-- <input type="text" class="form-control" id='wo_money_tax_type' name='wo_money_tax_type'> --}}
                        <select class='form-control' id='wo_money_tax_type' name='wo_money_tax_type'>
                            <option value=""></option>
                            <option value="未稅" @selected(old('wo_money_tax_type', $wo_main->wo_money_tax_type) == '未稅')>未稅</option>
                            <option value="外加" @selected(old('wo_money_tax_type', $wo_main->wo_money_tax_type) == '外加')>外加</option>
                            <option value="含稅" @selected(old('wo_money_tax_type', $wo_main->wo_money_tax_type) == '含稅')>含稅</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 150px">
                        <span class="input-group-text">稅金　　</span>
                        <input type="number" class="form-control bg-body-secondary" id='wo_money_tax'
                            name='wo_money_tax' value="{{ old('wo_money_tax', $wo_main->wo_money_tax) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 150px">
                        <span class="input-group-text">上期欠款</span>
                        <input type="number" class="form-control bg-body-secondary" id='last_owe' name='last_owe'
                            value="{{ old('last_owe', $wo_main->last_owe) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 150px">
                        <span class="input-group-text">應收　　</span>
                        <input type="text" class="form-control bg-body-secondary" id='sugggest_money'
                            name='sugggest_money' value="{{ old('sugggest_money', $wo_main->sugggest_money) }}">
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">本期欠款</span>
                        <input type="text" class="form-control" id='this_owe' name='this_owe'
                            value="{{ old('this_owe', $wo_main->this_owe) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">收款　　</span>
                        {{-- <input type="text" class="form-control" id='receive_money' name='receive_money'> --}}
                        <select class='form-control' id='receive_money' name='receive_money'>
                            <option value=""></option>
                            <option value="已收" @selected(old('receive_money', $wo_main->receive_money) == '已收')>已收</option>
                            <option value="未收" @selected(old('receive_money', $wo_main->receive_money) == '未收')>未收</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">工單號碼</span>
                        <input type="text" class="form-control bg-body-secondary" id='wo_number' name='wo_number'
                            value="{{ $wo_main->wo_number }}" readonly>
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 200px">
                        <span class="input-group-text">工單類型</span>
                        {{-- <input type="text" class="form-control" id='wo_type' name='wo_type'> --}}
                        <select class='form-control' id='wo_type' name='wo_type'>
                            {{-- <option value=""></option> --}}
                            <option value="一般單" @selected(old('wo_type', $wo_main->wo_type) == '一般單')>一般單</option>
                            <option value="預約單" @selected(old('wo_type', $wo_main->wo_type) == '預約單')>預約單</option>
                        </select>
                    </div>
                </div>
                <div class="my-2">
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 230px">
                        <span class="input-group-text">入廠日(請款用)</span>
                        <input type="date" class="form-control" id='wo_in_date_si' name='wo_in_date_si'
                            value="{{ old('wo_in_date_si', $wo_main->wo_in_date_si) }}">
                    </div>
                    <div class="input-group input-group-sm mb-1 me-1" style="width: 230px">
                        <span class="input-group-text">出廠日(請款用)</span>
                        <input type="date" class="form-control" id='wo_out_date_si' name='wo_out_date_si'
                            value="{{ old('wo_out_date_si', $wo_main->wo_out_date_si) }}">
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button id='tr_wo_detail_add' type="button" class='btn btn-success'>+</button>
                <button type="button" class='btn btn-success' data-bs-toggle="modal"
                    data-bs-target="#partInformationModal">查零件</button>
                <button type="button" class='btn btn-success' data-bs-toggle="modal"
                    data-bs-target="#tireInformationModal">查輪胎</button>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <table id='table_wo_detail' class="table text-nowrap">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">維修類別</th>
                        <th scope="col">故障原因</th>
                        <th scope="col">零件編號</th>
                        <th scope="col">零件名稱</th>
                        <th scope="col">數量</th>
                        <th scope="col">單位</th>
                        <th scope="col">單價</th>
                        <th scope="col">合計</th>
                        <th scope="col">主技師</th>
                        <th scope="col">副技師</th>
                        <th scope="col">備註</th>
                        <th scope="col">不請款原因</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wo_detail as $k => $v)
                        <tr>
                            <input type="hidden" name="ids[]" value='{{ $v->id }}'>
                            <td>
                                {{-- <a href="{{ route('WODetailDelete', ['data' => Crypt::encryptString($v->id)]) }}"
                                    class="btn btn-danger">X</a> --}}
                                <input type="checkbox" class="btn-check" name="delete_datas[]" id="btn_delete{{$k}}" autocomplete="off" value="{{Crypt::encryptString($v->id)}}">
                                <label class="btn btn-outline-danger h1 text-start fw-bold" for="btn_delete{{$k}}">X</label>
                            </td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_type[]'
                                    list='dl_wod_type' value="{{ $v->wod_type }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_fault[]'
                                    list='dl_wod_fault' value="{{ $v->wod_fault }}"></td>
                            <td><input type='text'
                                    class='form-control form-control-sm bg-primary-subtle change_wod_part_id'
                                    name='wod_part_id[]' value="{{ $v->wod_part_id }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_part_name[]'
                                    value="{{ $v->wod_part_name }}"></td>
                            <td><input type='number' class='form-control form-control-sm' name='wod_part_number[]'
                                    value="{{ $v->wod_part_number }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_part_unit[]'
                                    value="{{ $v->wod_part_unit }}"></td>
                            <td><input type='number' class='form-control form-control-sm' name='wod_port_money[]'
                                    value="{{ $v->wod_port_money }}"></td>
                            <td><input type='number' class='form-control form-control-sm' name='wod_money_total[]'
                                    value="{{ $v->wod_money_total }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_technician_1[]'
                                    list='dl_wod_technician' value="{{ $v->wod_technician_1 }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_technician_2[]'
                                    list='dl_wod_technician' value="{{ $v->wod_technician_2 }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='wod_remark[]'
                                    value="{{ $v->wod_remark }}"></td>
                            <td><input type='text' class='form-control form-control-sm' name='no_money_remark[]'
                                    list='dl_no_money_remark' value="{{ $v->no_money_remark }}"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class='btn btn-primary'>修改</button>
            <a href='{{ route('MemberWorkOrderList') }}' type="submit" class='btn btn-secondary'>返回清單</a>
        </div>
    </form>

    {{-- datalist --}}
    <datalist id="dl_wod_type">
        @foreach ($DB_set__wod_type as $v)
            <option value="{{ $v->s_name }}">
        @endforeach
    </datalist>
    <datalist id="dl_wod_fault">
        @foreach ($DB_set__wod_fault as $v)
            <option value="{{ $v->s_name }}">
        @endforeach
    </datalist>
    <datalist id="dl_wod_technician">
        @foreach ($DB_s_technician as $v)
            <option value="{{ $v->s_name }}">
        @endforeach
    </datalist>
    <datalist id="dl_no_money_remark">
        @foreach ($DB_set__no_money_remark as $v)
            <option value="{{ $v->s_name }}">
        @endforeach
    </datalist>

    {{-- Modal --}}
    @include('modals.modal_part_information')
    @include('modals.modal_tire_information')

    <script>
        //增加明細清單 (空的)
        function tr_wo_detail_add(in_type = 0, partid = null, part_type = null) {
            // var tr_num = $('#table_wo_detail tbody tr').length;
            var vehicle_area_type = $("#vehicle_area_type").val();
            var wod_type = $('input[name="wod_type[]"]').val(); //維修類別
            var wod_fault = $('input[name="wod_fault[]"]').val(); //維修類別
            $.ajax({
                type: 'get',
                url: '{!! URL::route('tr_wo_detail_add') !!}',
                data: {
                    'in_type': in_type,
                    'partid': partid,
                    'part_type': part_type,
                    'vehicle_area_type': vehicle_area_type,
                    'wod_type': wod_type,
                    'wod_fault': wod_fault,
                },
                success: function(data) {
                    $('#table_wo_detail tbody').prepend(data.tr); // 上方插入
                    // $('#table_wo_detail tbody').append(data.tr); //  下方插入
                },
                error: function() {
                    console.log('error');
                }
            });
        }
        $("#tr_wo_detail_add").on("click", function() {
            tr_wo_detail_add()
        })
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //維修時數
        $('#wo_in_time, #wo_out_time').on("change", function() {
            var wo_in_time = $('#wo_in_time').val();
            var wo_out_time = $('#wo_out_time').val();
            var time1 = new Date('1970-01-01T' + wo_in_time);
            var time2 = new Date('1970-01-01T' + wo_out_time);
            var timeDiff = time1.getTime() - time2.getTime();
            var diffHours = Math.abs(timeDiff / (1000 * 60 * 60)).toFixed(4);;
            if (isNaN(diffHours)) diffHours = 0;
            $("#wo_m_hours").val(diffHours)
        });

        //入出廠
        $("#wo_in_date").on("change", function() {
            $('#wo_out_date').val($(this).val()).trigger("change");
        })
        $("#wo_out_date").on("change", function() {
            $('#wo_in_date_si').val($(this).val()).trigger("change");
        })
        $("#wo_in_date_si").on("change", function() {
            $('#wo_out_date_si').val($(this).val());
        })

        //汽車
        function vehicle_data() {
            var vehicle_number = $('#vehicle_number').val();
            $.ajax({
                type: 'post',
                url: '{!! URL::route('vehicle_data') !!}',
                data: {
                    'vehicle_number': vehicle_number,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // 附加CSRF令牌到標頭中
                },
                success: function(data) {
                    $.each(data.vi, function(key, value) {
                        $('#' + key).val(value);
                    });
                    select_wo_money_tax_type();
                },
                error: function() {
                    console.log('error');
                }
            });
        }
        vehicle_data()
        $("#vehicle_number").on("keyup change", function() {
            vehicle_data()
        })

        function select_wo_money_tax_type() { //判斷稅額別
            var vehicle_tonnes = $('#vehicle_tonnes').val();
            if (vehicle_tonnes != "") {
                $('#wo_money_tax_type').val('含稅')
            }
            input_wo_money_tax()
        }
        $("#wo_money_tax_type").on("change", function() {
            input_wo_money_tax()
        })

        function input_wo_money_tax() { //稅金計算
            var wo_money_tax_type = $('#wo_money_tax_type').val();
            var wo_money = $('#wo_money').val();
            var wo_money_tax = 0;
            if (wo_money_tax_type == "外加" || wo_money_tax_type == "含稅") {
                wo_money_tax = Math.round(wo_money * 0.05);
            } else {
                wo_money_tax = 0;
            }

            $('#wo_money_tax').val(wo_money_tax)
            input_sugggest_money()
        }

        function input_sugggest_money() { //應收
            var wo_money_tax_type = $('#wo_money_tax_type').val();
            var sugggest_money = 0
            sugggest_money = sugggest_money + parseInt($('#wo_money').val() || 0) + parseInt($('#last_owe').val() || 0);

            if (wo_money_tax_type == '外加') {
                sugggest_money = sugggest_money + parseInt($('#wo_money_tax').val() || 0);
            }
            $('#sugggest_money').val(sugggest_money);
        }

        //金額
        function wo_money() {
            var sum = 0;
            $('input[name="wod_money_total[]"]').each(function() {
                if ($.isEmptyObject($(this).closest('tr').find('input[name="no_money_remark[]"]').val())) {
                    sum += parseInt($(this).val() || 0);
                }
            });
            $("#wo_money").val(sum);
            input_wo_money_tax()
        }
        wo_money()
        $(document).on("change", 'input[name="wod_money_total[]"], input[name="no_money_remark[]"]', function() {
            wo_money();
        });
        //工單號碼


        //零件編號
        // $(document).on("change", ".change_wod_part_id", function() { //document 動態的添加事件觸發
        //     var vehicle_area_type = $("#vehicle_area_type").val();
        //     var wod_part_id = $(this).val();
        //     var $this = $(this);
        //     $.ajax({
        //         type: 'post',
        //         url: 'vehicle_part_data', //被取代
        //         data: {
        //             'vehicle_area_type': vehicle_area_type,
        //             'wod_part_id': wod_part_id,
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken // 附加CSRF令牌到標頭中
        //         },
        //         success: function(data) {
        //             // console.log(data);
        //             if (!$.isEmptyObject(data.pi)) {
        //                 $this.closest('tr').find('input[name="wod_part_name[]"]').val(data.pi.s_name);
        //                 $this.closest('tr').find('input[name="wod_part_number[]"]').val(1).trigger(
        //                     "change");
        //                 $this.closest('tr').find('input[name="wod_part_unit[]"]').val(data.pi.s_unit);
        //                 $this.closest('tr').find('input[name="wod_port_money[]"]').val(data.pi.s_money)
        //                     .trigger("change");
        //             }
        //         },
        //         error: function() {
        //             console.log('error');
        //         }
        //     });
        // });
        //單零件總金額
        $(document).on("change", 'input[name="wod_part_number[]"], input[name="wod_port_money[]"]', function() {
            var sum = $(this).closest('tr').find('input[name="wod_part_number[]"]').val() * $(this).closest('tr')
                .find('input[name="wod_port_money[]"]').val();
            var sum = sum.toFixed(0); // 四捨五入到第幾位
            $(this).closest('tr').find('input[name="wod_money_total[]"]').val(sum).trigger("change");
        });
    </script>

@endsection
